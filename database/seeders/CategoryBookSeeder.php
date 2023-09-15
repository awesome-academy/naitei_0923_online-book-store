<?php

namespace Database\Seeders;

use App\Models\CategoryBook;
use Illuminate\Database\Seeder;

class CategoryBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryBook::factory(200)->create();
    }
}
