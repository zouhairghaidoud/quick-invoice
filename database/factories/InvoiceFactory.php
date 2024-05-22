<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $feesTypes = ['percentage', 'amount'];

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'logo' => fake()->imageUrl(),
            'seller_company' => fake()->company(),
            'seller_address' => fake()->address(),
            'seller_zip' => fake()->numberBetween(10000, 999999),
            'seller_city' => fake()->city(),
            'seller_state' => fake()->city(),
            'seller_country' => fake()->country(),
            'buyer_company' => fake()->company(),
            'buyer_address' => fake()->address(),
            'buyer_zip' => fake()->numberBetween(10000, 999999),
            'buyer_city' => fake()->city(),
            'buyer_state' => fake()->city(),
            'buyer_country' => fake()->country(),
            'invoice_no' => fake()->numberBetween(10000, 999999),
            'invoice_date' => now()->subDays(fake()->numberBetween(10, 50)),
            'due_date' => now()->subDays(fake()->numberBetween(10, 50)),
            'notes' => fake()->paragraph(),
            'terms' => fake()->paragraph(),
            'sub_total' => fake()->numberBetween(50, 1000),
            'has_discount' => fake()->numberBetween(0, 1),
            'discount_type' => $feesTypes[fake()->numberBetween(0, 1)],
            'discount_value' => fake()->numberBetween(0, 20),
            'has_tax' => fake()->numberBetween(0, 1),
            'tax_type' => $feesTypes[fake()->numberBetween(0, 1)],
            'tax_value' => fake()->numberBetween(0, 20),
            'has_shipping' => fake()->numberBetween(0, 1),
            'shipping_amount' => fake()->numberBetween(0, 50),
            'total_amount' => fake()->numberBetween(50, 1000),
        ];
    }
}
