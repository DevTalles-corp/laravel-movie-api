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