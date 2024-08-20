<?php

namespace Tests\Unit;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_login_without_identifiers(): void
    {
        $response = $this->postJson('/api/login');
        $response->assertStatus(422);
        $response->assertExactJson([
            'message' => 'The email field is required. (and 1 more error)',
            'errors' => [
                'email' => [
                    'The email field is required.',
                ],
                'password' => [
                    'The password field is required.',
                ],
            ],
        ]);
    }

    public function test_login_only_with_email_field(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'john@doe.com',
        ]);

        $response->assertStatus(422);
        $response->assertExactJson([
            'message' => 'The password field is required.',
            'errors' => [
                'password' => [
                    'The password field is required.',
                ],
            ],
        ]);
    }

    public function test_login_only_with_password_field(): void
    {
        $response = $this->postJson('/api/login', [
            'password' => 'password',
        ]);

        $response->assertStatus(422);
        $response->assertExactJson([
            'message' => 'The email field is required.',
            'errors' => [
                'email' => [
                    'The email field is required.',
                ],
            ],
        ]);
    }

    public function test_login_with_only_correct_email(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'zgibson@example.com',
            'password' => 'passwordd',
        ]);

        $response->assertStatus(401)
            ->assertExactJson(['message' => 'Login failed, unauthorized']);
    }

    public function test_login_with_only_correct_password(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'zgibson422@example.com',
            'password' => 'password',
        ]);
        $response->assertStatus(401)
            ->assertExactJson(['message' => 'Login failed, unauthorized']);
    }

    public function test_login_with_right_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'zgibson@example.com',
            'password' => 'password', ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'additional',
                'data',
            ]);
    }
}
