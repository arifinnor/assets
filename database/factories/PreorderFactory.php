<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PreorderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $partner = Partner::first() ?: Partner::factory()->create();

        return [
            'tanggal' => now(),
            'partner_id' => $partner->id,
        ];
    }
}
