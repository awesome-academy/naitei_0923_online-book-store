<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateInitialAdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::unguard();
        $admin = User::create(
            [
                'email' => 'admin2@sun-asterisk.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'first_name' => 'admin1',
                'last_name' => 'account1',
                'phone' => '0999999998',
                'address' => 'Ha Noi',
                'is_active' => true,
                'role_id' => DB::table('roles')->where('name', 'admin')->first()->id,
            ]
        );
    }
}
