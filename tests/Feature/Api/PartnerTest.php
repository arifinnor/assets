<?php

namespace Tests\Feature\Api;

use App\Models\Partner;
use Database\Seeders\PartnerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_partners()
    {
        $createPartner = $this->seed([PartnerSeeder::class]);
        $response = $this->getJson(route('api.partners.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'data'
        ]);
    }

    public function test_create_partner_successful()
    {
        $name = "PT. ABCD";
        $request = [
            'nama' => $name
        ];

        $response = $this->postJson(route('api.partners.store'), $request);
        $response->assertSuccessful();

        $this->assertDatabaseHas('partners', [
            'nama' => $name,
        ]);
    }

    public function test_create_partner_invalid_request()
    {
        $request = [
            'nama' => null
        ];

        $response = $this->postJson(route('api.partners.store'), $request);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
