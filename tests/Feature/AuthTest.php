<?php
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates user and returns token on register', function () {
    $payload = [
        'name' => 'Teddy Test',
        'email' => 'teddy@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->post('/api/auth/register', $payload);

    $response
        ->assertStatus(201)
        ->assertJsonStructure(['data' => ['access_token', 'token_type', 'expires_in', 'user']])
        ->assertJsonPath('data.user.email', 'teddy@test.com');
});

it('does not expose password on register', function () {
    $payload = [
        'name' => 'Teddy Test',
        'email' => 'teddy@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->post('/api/auth/register', $payload);

    expect($response->json('data.user'))->not->toHavekey('password');
});

it('requires all fields on register', function () {
    $response = $this->post('/api/auth/register', []);

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'email', 'password']);
});
