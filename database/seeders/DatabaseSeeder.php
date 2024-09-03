<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Constant\Dataset;
use App\Models\Category;
use App\Models\Generic;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\User;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'dsiplay_name' => 'Admin'
        ]);

        User::create([
            'name' => 'Kazi Rayhan Reza',
            'email' => 'thisiskazi@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => 1 // admin
        ]);

        // foreach (Dataset::CATEGORIES as $category) {
        //     Category::create([
        //         'name' => $category,
        //     ]);
        // }


        // foreach (Dataset::SUPPLIER as $supplier) {
        //     Supplier::create([
        //         'name' => $supplier,
        //         'registration_number' => fake()->numerify('##########'),
        //         'vat_number' => fake()->numerify('##########'),
        //         'industry_type' => fake()->word,
        //         'contact_person' => fake()->name,
        //         'contact_person_designation' => fake()->word,
        //         'contact_person_email' => fake()->email,
        //         'contact_person_phone' => fake()->phoneNumber,
        //         'company_email' => fake()->companyEmail,
        //         'company_phone' => fake()->phoneNumber,
        //         'address' => fake()->address,
        //         'city' => 'Barishal',
        //         'country' => 'Bangladesh',
        //         'website' => fake()->url,
        //         'logo' => "supplier/" . $supplier . ".jpg",
        //     ]);
        // }

        // foreach (Dataset::GENERIC as $generic) {
        //     Generic::create([
        //         'name' => $generic
        //     ]);
        // }

        // foreach (Dataset::UNIT as $key => $quantity) {
        //     Unit::create([
        //         'name' => $key,
        //         'quantity' => $quantity
        //     ]);
        // }

        // foreach (Dataset::MEDICINES as $medicine) {
        //     Product::create([
        //         'name' => $medicine['name'],
        //         'image' => "products/" . rand(1, 23) . ".jpg",
        //         'sku'  => 'MED-' . rand(1000, 9999),
        //         'barcode'  => rand(10000000000, 99999999999),
        //         'price' => rand(1, 30),
        //         'strip_price' => rand(30, 300),
        //         'box_price' => rand(300, 600),
        //         'price' => rand(50, 400),
        //         'featured' => rand(0, 1),
        //         'quantity' => rand(10, 80),

        //         'category_id' => Category::where('name', $medicine['category'])->first()->id,
        //         'supplier_id' => rand(1, 5),
        //         'generic_id' => rand(1, 29)
        //     ]);
        // }

        User::factory(100)->create();

        $orders = Order::factory(2000)->create();
        $purchases = Purchase::factory(2000)->create();
        foreach ($purchases as $purchase) {
            $data = [];
            $products = Product::where('supplier_id', $purchase->supplier_id)->inRandomOrder()->take(rand(3, 10))->get();
            foreach ($products as $product) {
                $data[$product->id] = [
                    'manufacture_date' => fake()->dateTimeBetween('-1 years', '- 3 months'),
                    'expiry_date' => fake()->dateTimeBetween('-3 months', '2 years'),
                    'purchased_unit' => rand(1, 7),
                    'purchase_unit_quantity' => rand(10, 50),
                    'purchase_quantity' => rand(50, 500),
                    'remaining_quantity' => rand(50, 500),
                    'supplier_rate' => rand(10, 80),
                    'total' => rand(1000, 5000)
                ];
            }
            $purchase->products()->attach($data);
        }

        foreach ($orders as $order) {
            $data = [];
            $products = Product::inRandomOrder()->take(rand(3, 10))->get();
            foreach ($products as $product) {
                $data[$product->id] = [
                    'quantity' => rand(1, 50),
                    'price' => rand(10, 500),
                    'profit' => rand(20, 40)
                ];
            }
            $order->products()->attach($data);
        }
    }
}
