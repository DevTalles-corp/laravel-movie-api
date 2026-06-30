<?php

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns all genres on index', function () {
    Genre::factory()->count(3)->create();
    
    $response = $this->get('api/genres');

    $response->assertStatus(200)->assertJsonCount(3,'data');
});
it('returns a single genre', function () {
    $genre = Genre::factory()->create();
    $response = $this->get("api/genres/{$genre->id}");
    $response->assertStatus(200)->assertJsonPath('data.id',$genre->id);
});
