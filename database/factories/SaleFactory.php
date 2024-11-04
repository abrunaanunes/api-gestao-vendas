<?php

namespace Database\Factories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'seller_id' => Seller::firstOrCreate([], Seller::factory()->raw())->id,
            'sold_at' => $this->faker->date(),
            'value' => $this->faker->numberBetween(100, 5000),
        ];
    }
}
