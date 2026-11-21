<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'main_image' => 'nullable|string',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'string',
            'client' => 'nullable|string|max:255',
            'link' => 'nullable|string|url|max:255',
            'project_date' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ];
    }
}
