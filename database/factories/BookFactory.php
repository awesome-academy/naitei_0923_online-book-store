<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(200),
            'price' => $this->faker->numberBetween(1, 1000) * 10000,
            'publisher' => $this->faker->username(),
            'publisher_year' => $this->faker->year('now'),
            'page_nums' => $this->faker->numberBetween(50, 2000),
            'author' => $this->faker->username(),
        ];
    }
}
