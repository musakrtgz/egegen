<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|max:150',
            'content' => 'string',
            'slug' => 'unique:news,slug|max:150',
            'image' => 'file|mimes:webp|max:2048',
            'is_active' => 'boolean',
            'published_at' => 'date',
        ];
    }
}
