<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->words(2, true),
            'tipe_aset' => $this->faker->randomElement(Item::getTipeAset()),
            'tipe' => $this->faker->randomElement(Item::getTipe()),
        ];
    }
}
