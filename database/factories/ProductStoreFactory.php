<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductStore;
class ProductStoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'store_id' => rand(1, 10), // Assuming you have 10 stores
            'product_id' => rand(1, 20), // Assuming you have 20 products
            'quantity' => $this->faker->numberBetween(1, 50),
        ];
    }
}
