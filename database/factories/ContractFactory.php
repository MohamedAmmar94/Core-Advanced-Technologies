<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id'     => $this->faker->numberBetween(1, 10),
            'unit_name'     => $this->faker->word,
            'customer_name' => $this->faker->name,
            'rent_amount'   => $this->faker->randomFloat(2, 1000, 10000),
            'start_date'    => now(),
            'end_date'      => now()->addYear(),
            'status'        => 'draft',
        ];
    }
}
