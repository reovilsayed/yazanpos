<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = ['Male', 'Female'][rand(0, 1)];
        return [
            'name' => fake()->name($gender),
            'email' => fake()->safeEmail(),
            'phone' => '01' . rand(3, 9) . rand(100000000, 999999999),
            'gender' => $gender,
            'address' => fake()->address(),
            'discount' => rand(0, 15)
        ];
    }
}
