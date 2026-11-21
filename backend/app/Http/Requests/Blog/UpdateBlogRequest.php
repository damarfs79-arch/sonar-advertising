<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->published_at === '') {
            $this->merge(['published_at' => null]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'status' => 'nullable|in:draft,published',
            'published_at' => 'nullable|date',
            'tags' => 'nullable'
        ];
    }
}
