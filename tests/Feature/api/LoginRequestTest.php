<?php

namespace Tests\Unit\Http\Requests;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use PHPUnit\Framework\Attributes\Test;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function email_is_required(): void
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $userRequest = [
            'email' => null,
            'password' => 'password'
        ];

        $this->postJson(
            route('api.login'),
            $userRequest
        )->assertJsonValidationErrors('email');
    }

    #[Test]
    public function password_is_required(): void
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $userRequest = [
            'email' => 'test@test.com',
            'password' => null
        ];

        $this->postJson(
            route('api.login'),
            $userRequest
        )->assertJsonValidationErrors('password');
    }
}
