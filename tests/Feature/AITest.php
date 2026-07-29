<?php

use App\Models\Movie;
use App\Services\AI\MovieAIService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function mockAIService(string $method, mixed $returnValue): void
{
    $mock = Mockery::mock(MovieAIService::class);
    $mock->shouldReceive($method)->andReturn($returnValue);
    app()->instance(MovieAIService::class, $mock);
}

it('allows an editor to generate a synopsis', function () {
    mockAIService('generateSynopsis', 'Una película épica sobre el destino de la humanidad.');

    $movie = Movie::factory()->create();
    $this
        ->actingAs(editor(), 'api')
        ->postJson("/api/v1/movies/{$movie->id}/generate-synopsis")
        ->assertOk()
        ->assertJsonPath('message', 'Sinopsis generada exitosamente.')
        ->assertJsonPath('data.synopsis', 'Una película épica sobre el destino de la humanidad.');
});

it('allows an admin to generate a synopsis', function () {
    mockAIService('generateSynopsis', 'Una película épica sobre el destino de la humanidad.');

    $movie = Movie::factory()->create();
    $this
        ->actingAs(admin(), 'api')
        ->postJson("/api/v1/movies/{$movie->id}/generate-synopsis")
        ->assertOk();
});
