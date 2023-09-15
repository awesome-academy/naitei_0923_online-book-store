<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function testConfirmPasswordScreenCanBeRendered()
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

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    public function testPasswordCanBeConfirmed()
    {
        $role = Role::create([
            'id' => 2,
            'name' => 'user',
        ]);
        $user = User::factory()->create();

        $response = $this->withHeaders(['accept' => 'application/json'])->actingAs($user)->post('/confirm-password', [
            'password' => '123456789',
        ]);
        $response->dump();

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function testPasswordIsNotConfirmedWithInvalidPassword()
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

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
