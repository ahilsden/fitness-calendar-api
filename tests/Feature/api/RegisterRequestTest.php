<?php

namespace Tests\Unit\Http\Requests;

use App\Models\User;
use Tests\TestCase;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function name_is_required(): void
    {
        $userRequest = [
            'name' => null,
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $this->postJson(
            route('api.register'),
            $userRequest
        )->assertJsonValidationErrors('name');
    }

    #[Test]
    #[DataProvider('nameDataProvider')]
    public function name_must_be_between_2_and_20_characters(string $invalidRule): void
    {
        $userRequest = [
            'name' => $invalidRule,
            'email' => 'test@test.com',
            'password' => 'password',
        ];

        $this->postJson(
            route('api.register'),
            $userRequest
        )->assertJsonValidationErrors('name');
    }

    public static function nameDataProvider(): Generator
    {
        yield 'oneCharLength' => ['a'];
        yield 'twentyOneCharLength' => [Str::random(21)];
    }

    #[Test]
    public function email_is_required(): void
    {
        $userRequest = [
            'name' => 'Test User',
            'email' => null,
            'password' => 'password',
        ];

        $this->postJson(
            route('api.register'),
            $userRequest
        )->assertJsonValidationErrors('email');
    }

    #[Test]
    public function email_should_be_unique(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $userRequest = [
            'name' => 'Test User 2',
            'email' => 'test@test.com',
            'password' => 'password'
        ];

        $this->postJson(
            route('api.register'),
            $userRequest
        )->assertJsonValidationErrors('email');
    }

    #[Test]
    public function password_is_required(): void
    {
        $userRequest = [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => null
        ];

        $this->postJson(
            route('api.register'),
            $userRequest
        )->assertJsonValidationErrors('password');
    }

    #[Test]
    #[DataProvider('passwordDataProvider')]
    public function password_should_adhere_to_min_security(string $invalidRule): void
    {
        $userRequest = [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => $invalidRule
        ];

        $this->postJson(
            route('api.register'),
            $userRequest
        )->assertJsonValidationErrors('password');
    }

    public static function passwordDataProvider(): Generator
    {
        yield 'sevenCharsLength' => ["Pass@1"];
        yield 'noUpperCaseLetter' => ["password@1"];
        yield 'noLowerCaseLetter' => ["PASSWORD@1"];
        yield 'noNumber' => ["Password@"];
        yield 'noSymbol' => ["Password1"];
    }
}
