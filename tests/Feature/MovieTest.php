<?php

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns all movies on index', function () {
    Movie::factory()->count(3)->create();
    
    $response = $this->getJson('api/movies');

    $response->assertStatus(200)->assertJsonCount(3,'data');
});

it('returns a single movie on show', function () {
    $movie = Movie::factory()->create();
    $response = $this->getJson("api/movies/{$movie->id}");
    $response->assertStatus(200)->assertJsonPath('data.id',$movie->id);
});

it('creates a movie with auto slug on store', function () {
    $payload = ['title'=> 'Chucky', 'year' => 1988, 'rating'=>8];

    $response = $this->postJson("api/movies", $payload);
    $response->assertStatus(201)
    ->assertJsonPath('data.title','Chucky')
    ->assertJsonPath('data.slug','chucky');

    $this->assertDatabaseHas('movies', ['slug' => 'chucky']);
});


it('modifies a movie with auto slug on update', function () {
    $movie = movie::factory()->create(['title'=> 'Chucky', 'year' => 1988, 'rating'=>8]);

    $response = $this->putJson("api/movies/{$movie->id}", ["title" => 'Child\'s Play']);
    // dd($response->content());
    $response->assertStatus(200)
    ->assertJsonPath('data.title','Child\'s Play')
    ->assertJsonPath('data.slug','childs-play')
    ->assertJsonPath('data.year',1988);
});

it('soft deletes a movie on destroy', function () {
    $movie = Movie::factory()->create();

    $this->deleteJson("api/movies/{$movie->id}");
    
    $this->assertSoftDeleted('movies', ['id' => $movie->id]);
});