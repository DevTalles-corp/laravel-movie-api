<?php

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('includes meta and links on movies index', function () {
    Movie::factory(5)->create();
    $this
        ->getJson('/api/v1/movies')
        ->assertOk()
        ->assertJsonStructure([
            'data',
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total']
        ]);
});

it('allows configurable per_page on movies index', function () {
    Movie::factory(10)->create();
    $this
        ->getJson('/api/v1/movies?per_page=4')
        ->assertOk()
        ->assertJsonPath('meta.per_page', 4)
        ->assertJsonCount(4, 'data');
});

it('allows configurable per_page on movies index V2', function () {
    Movie::factory(10)->create();
    $this
        ->getJson('/api/v2/movies?per_page=10')
        ->assertOk()
        ->assertJsonPath('meta.per_page', 10)
        ->assertJsonCount(10, 'data');
});
