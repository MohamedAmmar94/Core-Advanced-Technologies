<?php
namespace Database\Factories;

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
        $subtotal = $this->faker->randomFloat(2, 1000, 5000);
        $tax      = $subtotal * 0.15;

        return [
            'contract_id' => Contract::factory(),
            'subtotal'    => $subtotal,
            'tax_amount'  => $tax,
            'total'       => $subtotal + $tax,
            'status'      => 'pending',
            'due_date'    => now()->addMonth(),
        ];
    }
}
