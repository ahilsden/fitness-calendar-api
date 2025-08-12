<?php

namespace Tests\Feature\api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_login_a_user_with_correct_credentials(): void
    {
        $user = User::factory()->create(
            [
                'email' => 'test@test.com',
                'password' => bcrypt('Password@1')
            ]
        );

        $this->postJson(route('api.login'), [
            'email' => 'test@test.com',
            'password' => 'Password@1',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function can_register_a_new_user(): void
    {
        $newUser = [
            'name' => 'new user',
            'email' => 'test@test.com',
            'password' => 'Password@1'
        ];

        $newUserMinusPassword = [
            'name' => 'new user',
            'email' => 'test@test.com',
        ];

        $response = $this->postJson(route('api.register'), $newUser);

        $response->assertCreated();
        $this->assertDatabaseHas(
            'users',
            $newUserMinusPassword
        );
        $response->assertJson(['user' => $newUserMinusPassword]);
    }
}
