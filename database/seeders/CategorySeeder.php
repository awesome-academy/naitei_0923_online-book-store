<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Business'],
            ['name' => 'Money'],
            ['name' => 'Design and Art'],
            ['name' => 'Personal Development'],
            ['name' => 'Software Development'],
            ['name' => 'Technology'],
            ['name' => 'Science and Math'],
            ['name' => 'Engineering'],
            ['name' => 'Entertainment'],
            ['name' => 'History'],
            ['name' => 'Biographies'],
            ['name' => 'Social Sciences'],
            ['name' => 'Law'],
            ['name' => 'Fitness and Wellbeing'],
            ['name' => 'Relationships and Family'],
            ['name' => 'Language and Writing'],
            ['name' => 'Hobbies and Recreation'],
            ['name' => 'Sports'],
            ['name' => 'Education and Tests'],
            ['name' => 'Fiction'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        };
    }
}
