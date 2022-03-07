<?php

namespace App\Actions\Variant;

use App\Models\Item;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AddNewVariant
{
    public function execute(array $request): array
    {
        $this->validate($request);

        try {
            // DB::beginTransaction();
            $item = Item::find($request['item_id']);
            $request['register'] = Variant::register($request['item_id']);

            $variant = Variant::create($request);

            // $preorder = Preorder::create($request);
            // $variant->item()->createMany($request['items']);

            // DB::commit();
        } catch (Throwable $e) {
            // DB::rollBack();
            Log::error('Create preorder error .' . $e->getMessage());

            return ['error' => $e->getMessage()];
        }

        $variant->load(['item']);

        return $variant->toArray();
    }


    private function validate(array $request)
    {
        $input = Validator::make($request, [
            'item_id' => 'required|exists:items,id',
            'collection' => 'sometimes|array'
        ]);

        return $input->validate();
    }
}
