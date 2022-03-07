<?php

namespace Tests\Feature\Api;

use App\Models\Item;
use Database\Seeders\ItemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_items()
    {
        $this->seed([ItemSeeder::class]);

        $response = $this->getJson(route('api.items.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data'
        ]);
    }

    public function test_create_item_invalid_request()
    {
        $request = [
            'nama' => '',
            'tipe' => '',
            'tipe_aset' => '',

        ];

        $response = $this->postJson(route('api.items.store'), $request);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_item_valid_request()
    {
        $nama = 'Kertas HVS A4';
        $tipeAset = Item::TIPE_ASET_LANCAR;
        $tipe = Item::TIPE_KIB_B;

        $request = [
            'nama' => $nama,
            'tipe_aset' => $tipeAset,
            'tipe' => $tipe,
        ];

        $response = $this->postJson(route('api.items.store'), $request);
        $response->assertOk();

        $this->assertDatabaseHas('items', [
            'nama' => $nama,
            'tipe_aset' => $tipeAset,
            'tipe' => $tipe,
        ]);
    }

    public function test_update_item_valid_request()
    {
        $createItem = Item::factory()->create();

        $nama = 'Kertas HVS A4';
        $tipeAset = Item::TIPE_ASET_LANCAR;
        $tipe = Item::TIPE_KIB_B;

        $request = [
            'nama' => $nama,
            'tipe_aset' => $tipeAset,
            'tipe' => $tipe,
        ];

        $response = $this->putJson(route('api.items.update', $createItem->id), $request);
        $response->assertOk();

        $this->assertDatabaseHas('items', [
            'id' => $createItem->id,
            'nama' => $nama,
            'tipe_aset' => $tipeAset,
            'tipe' => $tipe,
        ]);
    }

    public function test_destroy_item()
    {
        $createItem = Item::factory()->create();

        $response = $this->deleteJson(route('api.items.destroy', $createItem->id));
        $response->assertOk();

        $this->assertSoftDeleted('items', [
            'id' => $createItem->id,
        ]);
    }
}
