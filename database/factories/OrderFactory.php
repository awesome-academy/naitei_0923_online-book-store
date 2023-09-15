<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'status' => $this->faker->randomElement([0, 1]),
            'total' => $this->faker->numberBetween(10, 1000) * 10000,
        ];
    }
}
