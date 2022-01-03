<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $item = Item::first() ?: Item::factory()->create();

        return [
            'item_id' => $item->id,
            'qty' => rand(1, 20),
            'tipe' => $this->faker->randomElement(Stock::getTipe()),
            'keterangan' => $this->faker->sentences(4),
        ];
    }
}
