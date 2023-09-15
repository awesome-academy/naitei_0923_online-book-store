<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::all()->random()->id,
            'book_id' => Book::all()->random()->id,
            'price' => $this->faker->numberBetween(1, 1000) * 10000,
        ];
    }
}
