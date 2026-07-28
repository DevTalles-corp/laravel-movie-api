<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RecommendationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'genres' => ['required', 'array', 'min:1', 'max:5'],
            'genres.*' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'genres.required' => 'Debes indicar al menos un género.',
            'genres.array' => 'El campo géneros debe ser un arreglo.',
            'genres.min' => 'Debes indicar al menos un género.',
            'genres.max' => 'No puedes indicar más de 5 géneros.',
            'genres.*.string' => 'Cada género debe ser texto.',
            'genres.*.max' => 'Cada género no puede superar los 100 caracteres.'
        ];
    }
}
