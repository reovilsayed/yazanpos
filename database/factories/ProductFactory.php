<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $units = ['Kg', 'L', 'm', 'piece'];
        return [
            'name' => fake()->words(3, true),
            'image' => "products/" . rand(1, 7) . ".jpg",
            'sku'  => uniqid(),
            'barcode'  => rand(10000000000, 99999999999),
            'price' => rand(100, 2000),
            'featured' => rand(0, 1),
            'quantity' => rand(10, 80),
            'unit' => 'piece'
        ];
    }
}
