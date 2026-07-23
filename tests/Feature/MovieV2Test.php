<?php

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns all movies on index V2', function () {
    Movie::factory()->count(3)->create();

    $response = $this->getJson('api/v2/movies');

    $response->assertStatus(200)->assertJsonCount(3, 'data');
});

it('returns a single movie on show V2', function () {
    $movie = Movie::factory()->create();
    $response = $this->getJson("api/v2/movies/{$movie->id}");
    $response->assertStatus(200)->assertJsonPath('data.id', $movie->id);
});

it('returns a single movie with details on show V2', function () {
    $movie = Movie::factory()->create();
    $response = $this->getJson("api/v2/movies/{$movie->id}");
    $response
        ->assertStatus(200)
        ->assertJsonPath('data.details.year', $movie->year)
        ->assertJsonPath('data.details.rating', $movie->rating)
        ->assertJsonPath('data.details.director', $movie->director)
        ->assertJsonPath('data.details.duration', $movie->duration);
});
