<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $discountDice = rand(1, 6);

        $subTotal = rand(50, 1000);

        $discount = 0;
        if ($discountDice == 6) {
            $discount = $subTotal * (rand(1, 20) / 100);
        }
        $total = ($subTotal - $discount);
        return [
            'customer_id' => rand(1, 100),
            'sub_total' => $subTotal,

            'discount' => $discount,
            'total' => $total,
            'payment_method' => 'cash',
            'paid' => $total,
            'due' => 0,
            'profit' => $total * 0.10,
            'status' => "PAID",
            'created_at' => fake()->dateTimeBetween('-2 years')
        ];
    }
}
