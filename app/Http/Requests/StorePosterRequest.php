<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StorePosterRequest extends FormRequest
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
            'poster' => [
                'required',
                'image',
                'mimes:jpeg,png,webp',
                'max:2048'
            ]
        ];
    }

    public function messages()
    {
        return [
            'poster.required' => 'El archivo de imagen es obligatorio.',
            'poster.image' => 'El archivo debe ser una imagen. ',
            'poster.mimes' => 'La imagen debe ser del tipo JPEG, PNG o WebP. ',
            'poster.max' => 'La imagen no puede superar los 2 MB.'
        ];
    }
}