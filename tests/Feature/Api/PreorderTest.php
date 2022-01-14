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

        $request = [
            'tanggal' => now(),
            'partner_id' => $createPartner->id,
            'items' => [
                [
                    'item_id' => $item1->id,
                    'quantity' => 1,
                    'user_id' => $user1->id,
                ],
                [
                    'item_id' => $item2->id,
                    'quantity' => 1,
                    'user_id' => $user2->id,
                ]

            ]
        ];

        $response = $this->postJson(route('api.preorders.store'), $request);
        $response->assertCreated();

        $this->assertDatabaseHas('preorders', [
            'tanggal' => $request['tanggal'],
            'partner_id' => $request['partner_id'],
        ]);
    }
}
