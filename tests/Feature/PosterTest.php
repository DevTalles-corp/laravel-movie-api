<?php

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
});

it('allows an editor to upload a poster', function () {
    $movie = Movie::factory()->create();
    $file = UploadedFile::fake()->image('poster.jpg', 800, 600);
    $this
        ->actingAs(editor(), 'api')
        ->postJson("/api/v1/movies/{$movie->id}/poster", ['poster' => $file])
        ->assertOk()
        ->assertJsonPath('message', 'Póster actualizado exitosamente.')
        ->assertJsonStructure(['data' => ['poster_url']]);

    $path = $movie->refresh()->poster;
    expect($path)->not->toBeNull();
    expect(Storage::disk('public')->exists($path))->toBeTrue();
});