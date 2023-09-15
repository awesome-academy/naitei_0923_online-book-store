<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistrationScreenCanBeRendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewUsersCanRegister()
    {
        $role = Role::create([
            'id' => 1,
            'name' => 'admin',
        ]);
        $role = Role::create([
            'id' => 2,
            'name' => 'user',
        ]);
        $response = $this->withHeaders(['accept' => 'application/json'])->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'phone' => '1111111111',
            'address' => '1234 ABC Street',
            'is_active' => 1,
            'role_id' => 2,
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->dump();

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
