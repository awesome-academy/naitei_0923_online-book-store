<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginScreenCanBeRendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testUsersCanAuthenticateUsingTheLoginScreen()
    {
        $role = Role::create([
            'id' => 2,
            'name' => 'user',
        ]);
        $user = User::factory()->create();

        $response = $this->withHeaders(['accept' => 'application/json'])->post('/login', [
            'email' => $user->email,
            'password' => '123456789',
        ]);

        $response->dump();

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testUsersCanNotAuthenticateWithInvalidPassword()
    {
        $role = Role::create([
            'id' => 1,
            'name' => 'admin',
        ]);
        $role = Role::create([
            'id' => 2,
            'name' => 'user',
        ]);
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
