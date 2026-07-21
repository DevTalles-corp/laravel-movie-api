<?php

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns all genres on index', function () {
    Genre::factory()->count(3)->create();

    $response = $this->getJson('api/genres');

    $response->assertStatus(200)->assertJsonCount(3, 'data');
});
it('returns a single genre on show', function () {
    $genre = Genre::factory()->create();
    $response = $this->getJson("api/genres/{$genre->id}");
    $response->assertStatus(200)->assertJsonPath('data.id', $genre->id);
});

it('creates a genre with auto slug on store', function () {
    $payload = ['name' => 'Comedia', 'description' => 'Son para reir'];

    $response = $this->actingAs(editor(), 'api')->postJson('api/genres', $payload);
    $response
        ->assertStatus(201)
        ->assertJsonPath('data.name', 'Comedia')
        ->assertJsonPath('data.slug', 'comedia');

    $this->assertDatabaseHas('genres', ['slug' => 'comedia']);
});

it('modifies a genre with auto slug on update', function () {
    $genre = Genre::factory()->create(['name' => 'Terror']);

    $response = $this->actingAs(editor(), 'api')->putJson("api/genres/{$genre->id}", ['name' => 'Horror clásico']);
    $response
        ->assertStatus(200)
        ->assertJsonPath('data.name', 'Horror clásico')
        ->assertJsonPath('data.slug', 'horror-clasico');
});

it('soft deletes a genre on destroy', function () {
    $genre = Genre::factory()->create();

    $this->actingAs(admin(), 'api')->deleteJson("api/genres/{$genre->id}");

    $this->assertSoftDeleted('genres', ['id' => $genre->id]);
});