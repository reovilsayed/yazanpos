<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = rand(1000, 20000);
        $vat = rand(100, 2000);
        $discount = rand(0, 500);

        return [
            'supplier_id' => rand(1, 5),
            'invoice' => rand(10000000000, 99999999999),
            'payment_type' => 'Cash',
            'batch_name' => 'BATCH-' . rand(100, 999),
            'purcahsed_at' => fake()->dateTimeBetween('-10 months'),
            'details' => fake()->sentence(),
            'subtotal' => $subtotal,
            'vat' => $vat,
            'discount' => $discount,
            'grand_total' => ($subtotal + $vat) - $discount,
            'paid_amount'=> ($subtotal + $vat) - $discount,
            'status'=>'PAID'
        ];
    }
}
