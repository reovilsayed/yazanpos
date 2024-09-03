<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'registration_number' => $this->faker->numerify('##########'),
            'vat_number' => $this->faker->numerify('##########'),
            'industry_type' => $this->faker->word,
            'contact_person' => $this->faker->name,
            'contact_person_designation' => $this->faker->word,
            'contact_person_email' => $this->faker->email,
            'contact_person_phone' => $this->faker->phoneNumber,
            'company_email' => $this->faker->companyEmail,
            'company_phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'website' => $this->faker->url,
            'logo' => "products/" . rand(1, 7) . ".jpg",
        ];
    }
}
