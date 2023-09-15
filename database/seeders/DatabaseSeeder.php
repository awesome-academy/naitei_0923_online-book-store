<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            CreateInitialAdminAccount::class,
            UserSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
            CategoryBookSeeder::class,
            ReviewSeeder::class,
            CartSeeder::class,
            OrderSeeder::class,
            MediaSeeder::class,
        ]);
    }
}
