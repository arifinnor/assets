<?php

namespace Tests\Feature\Api;

use App\Models\Item;
use App\Models\Partner;
use App\Models\Preorder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PreorderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_preorder_successful()
    {
        $createPartner = Partner::factory()->create();

        $item1 = Item::factory()->create();
        $item2 = Item::factory()->create();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $variants = [];
        for ($i = 0; $i <= 1; $i++) {
            $variants[] = [
                'item_id' => $item1->id,
                'quantity' => 3,
                'ordered_for' => $user1->id,
                'collection' => [
                    'merk' => 'LENOVO',

                ],
            ];
        }

        $request = [
            'tanggal' => now(),
            'partner_id' => $createPartner->id,
            'variants' => $variants,
        ];

        $response = $this->postJson(route('api.preorders.store'), $request);
        $response->assertCreated();

        $findPreorder = Preorder::with([
            'preorderItems', 'partner'
        ])
            ->where('id', 1)
            ->first();

        dd($findPreorder->toArray());

        $this->assertDatabaseHas('preorders', [
            'tanggal' => $request['tanggal'],
            'partner_id' => $request['partner_id'],
        ]);
    }
}
