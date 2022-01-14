<?php

namespace Tests\Feature\Api;

use App\Models\Item;
use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_add_stock_with_invalid_request()
    {
        $createItem = Item::factory()->create();

        $request = [
            'item_id' => '',
            'qty' => '',
            'tipe' => '',
            'keterangan' => ''
        ];

        $response = $this->postJson(route('api.stocks.store', $createItem->id), $request);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_add_stock_with_negative_qty()
    {
        $createItem = Item::factory()->create();

        $request = [
            'item_id' => $createItem->id,
            'qty' => -2,
            'tipe' => Stock::TIPE_IN,
            'keterangan' => ''
        ];

        $response = $this->postJson(route('api.stocks.store', $createItem->id), $request);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_add_stock_successful()
    {
        $createItem = Item::factory()->create();

        $request = [
            'item_id' => $createItem->id,
            'qty' => rand(1, 10),
            'tipe' => Stock::TIPE_IN,
            'keterangan' => 'PERMINTAAN-001'
        ];

        $response = $this->postJson(route('api.stocks.store', $createItem->id), $request);

        $response->assertCreated();

        $this->assertDatabaseHas('stocks', $request);
    }

    public function test_get_stock_history()
    {
        $response = $this->getJson(route('api.stocks.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data'
        ]);
    }
}
