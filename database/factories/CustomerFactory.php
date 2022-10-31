<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'dni' => $this->faker->unique()->randomNumber(8),
            'id_reg' => $this->faker->numberBetween(1, 15),
            'id_com' => $this->faker->numberBetween(1, 15),
            'email' => $this->faker->unique()->safeEmail,
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'address' => $this->faker->address,
            'status' => $this->faker->randomElement(['A', 'I', 'Trash']),
        ];
    }
}
