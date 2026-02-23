<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id'       => Invoice::factory(),
            'amount'           => $this->faker->randomFloat(2, 500, 2000),
            'payment_method'   => $this->faker->randomElement([
                'cash',
                'bank_transfer',
                'credit_card',
            ]),
            'reference_number' => $this->faker->uuid,
            'paid_at'          => now(),
        ];
    }
}
