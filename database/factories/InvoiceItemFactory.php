<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::inRandomOrder()->first()->id,
            'item_name' => fake()->words(fake()->numberBetween(2, 5), true),
            'description' => fake()->paragraph(),
            'quantity' => fake()->numberBetween(1, 5),
            'price' => fake()->numberBetween(10, 50),
            'sub_total' => fake()->numberBetween(100, 500),
        ];
    }
}
