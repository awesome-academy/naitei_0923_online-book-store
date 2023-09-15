<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->text(200),
            'rating' => $this->faker->numberBetween(1, 5),
            'book_id' => Book::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
