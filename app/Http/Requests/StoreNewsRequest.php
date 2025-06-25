<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'content' => 'required|string',
            'slug' => 'string|unique:news,slug|max:150',
            'image' => 'required|file|mimes:webp|max:2048',
            'is_active' => 'boolean',
            'published_at' => 'nullable|date',
        ];
    }
}
