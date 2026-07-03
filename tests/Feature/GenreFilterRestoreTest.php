<?php

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('filters genres by search text', function () {
    Genre::factory()->create(['name' => 'Acción']);
    Genre::factory()->create(['name' => 'Drama']);
    
    $response = $this->getJson('api/genres?search=acc');
    $response->assertStatus(200)
             ->assertJsonCount(1,'data')
             ->assertJsonPath('data.0.name', 'Acción');
});

it('filters genres by is_active false', function () {
    Genre::factory()->create(['name' => 'Acción', 'is_active' => true]);
    Genre::factory()->create(['name' => 'Drama', 'is_active' => false]);
    
    $response = $this->getJson('api/genres?is_active=false');
    $response->assertStatus(200)
             ->assertJsonCount(1,'data')
             ->assertJsonPath('data.0.name', 'Drama');
});

it('orders genres by name in descending order', function () {
    Genre::factory()->create(['name' => 'Acción']);
    Genre::factory()->create(['name' => 'Drama']);
    
    $response = $this->getJson('api/genres?sort_by=name&order=desc');
    $names = collect($response->json('data'))->pluck(value: 'name')->values()->all();
    expect($names)->toBe(['Drama','Acción']);

    $response->assertStatus(200)
             ->assertJsonCount(2,'data');
});


it('ignores an invalid sort column', function () {
    Genre::factory()->create(['name' => 'Acción']);
    Genre::factory()->create(['name' => 'Drama']);
    
    $response = $this->getJson('api/genres?sort_by=password');

    $response->assertStatus(200)
             ->assertJsonCount(2,'data');
});