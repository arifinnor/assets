<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VariantTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_variant_succesful()
    {
        $item = Item::factory()->create([
            'tipe' => Item::TIPE_KIB_B,
        ]);

        $merk = "LENOVO";
        $bahan = "Plastik";

        $request = [
            [
                'item_id' => $item->id,
                'collection' => [
                    'merk' => $merk,
                    'bahan' => $bahan,
                ],

            ],

        ];

        $response = $this->postJson(route('api.variants.store'), $request);
        dd($response->json());
        $response->assertCreated();

        $this->assertDatabaseHas('variants', [
            'item_id' => $request['item_id'],
        ]);
    }
}
