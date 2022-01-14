<?php

namespace App\Actions\Preorder;

use App\Models\Preorder;
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
            $preorder->items()->createMany($request['items']);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Create preorder error .' . $e->getMessage());

            return ['error' => $e->getMessage()];
        }

        $preorder->load(['items']);

        return $preorder->toArray();
    }

    private function validate(array $request)
    {
        $input = Validator::make($request, [
            'partner_id' => 'required|exists:partners,id',
            'tanggal' => 'required|date',
            'items' => 'required|array',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.user_id' => 'required|exists:users,id',
            'items.*.quantity' => 'required|integer',
        ]);

        return $input->validate();
    }
}

// Nggawe manajemen projek e nda
// clickup ta
// seng todo done wkwk
// trello , clickup
// ok
