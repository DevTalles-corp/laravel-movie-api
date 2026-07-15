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

it('returns token for valid credentials on login', function () {
    User::factory()->create(['email' => 'test@mail.com', 'password' => bcrypt('password123')]);
    $response = $this->post('/api/auth/login', [
        'email' => 'test@mail.com',
        'password' => 'password123'
    ]);

    $response
        ->assertStatus(200)
        ->assertJsonStructure(['data' => ['access_token', 'token_type', 'expires_in', 'user']]);
});

it('returns user with valid token on me', function () {
    $user = User::factory()->create();
    $this
        ->actingAs($user, 'api')
        ->getJson('/api/auth:api/me')
        ->assertStatus(200)
        ->assertJsonPath('data.email', $user->email);
});

it('succeeds with valid token on logout', function () {
    $user = User::factory()->create();
    $this
        ->actingAs($user, 'api')
        ->postJson('/api/auth:api/logout')
        ->assertStatus(200);
});