<?php

namespace App\Http\Requests\Testimonial;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'project_type' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'screenshot' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:3072',
            'screenshot_path' => 'nullable|string',
            'photo' => 'nullable|string',
            'caption' => 'nullable|string',
            'content' => 'nullable|string',
            'platform' => 'nullable|string|max:50',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'rating' => 'nullable|integer|between:1,5',
        ];
    }
}
