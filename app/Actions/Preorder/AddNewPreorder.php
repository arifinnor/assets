<?php

namespace App\Actions\Preorder;

use App\Models\Preorder;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AddNewPreorder
{
    public function create(array $request): array
    {
        $this->validate($request);

        try {
            DB::beginTransaction();

            $preorder = Preorder::create($request);

            foreach ($request['variants'] as $variant) {
                $variant['register'] = Variant::register($variant['item_id']);
                $createVariant = Variant::create($variant);
                $variant['variant_id'] = $createVariant->id;

                $preorder->preorderItems()->create($variant);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Create preorder error .' . $e->getMessage());

            return ['error' => $e->getMessage()];
        }

        return $preorder->toArray();
    }

    private function validate(array $request)
    {
        $input = Validator::make($request, [
            'partner_id' => 'required|exists:partners,id',
            'tanggal' => 'required|date',
            'variants' => 'required|array',
            'variants.*.item_id' => 'required|exists:items,id',
            'variants.*.ordered_for' => 'required|exists:users,id',
            'variants.*.quantity' => 'required|integer',
            'variants.*.collection' => 'sometimes|array',

        ]);

        return $input->validate();
    }
}

// Nggawe manajemen projek e nda
// clickup ta
// seng todo done wkwk
// trello , clickup
// ok
