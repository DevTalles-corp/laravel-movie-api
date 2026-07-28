<?php

namespace App\Services\AI;

use Anthropic\Client;
use App\Models\Movie;

class MovieAIService
{
    private Client $client;
    private string $model;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->client = new Client(apiKey: config('services.anthropic.api_key'));
        $this->model = config('services.anthropic.model');
    }

    public function generateSynopsis(Movie $movie): string
    {
        $prompt = $this->buildSypnosisPrompt($movie);
        $response = $this->client->messages->create(
            maxTokens: 300,
            messages: [['role' => 'user', 'content' => $prompt]],
            model: $this->model
        );

        return trim($response->content[0]->text);
    }

    private function buildSypnosisPrompt(Movie $movie): string
    {
        $genres = $movie->genres->pluck('name')->join(', ');

        return <<<PROMPT
Eres un experto en cine.
Escribe una sinopsis atractiva y concisa, máximo de tres oraciones, para la siguiente película.
No incluyas frases como "sinopsis" ni comillas. 

Título:{$movie->title}
Año: {$movie->year}
Géneros: {$genres}
PROMPT;
    }
}
