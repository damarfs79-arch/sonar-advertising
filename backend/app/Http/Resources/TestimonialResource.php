<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $screenshot = $this->screenshot_path ?: $this->photo;
        $clientName = $this->client_name ?: $this->name;
        $projectType = $this->project_type ?: $this->company;
        $caption = $this->caption ?: $this->content;
        $isFeatured = $this->is_featured !== null ? (bool) $this->is_featured : (bool) ($this->is_active ?? true);

        return [
            'id' => $this->id,
            'client_name' => $clientName,
            'name' => $clientName,
            'project_type' => $projectType,
            'company' => $projectType,
            'screenshot_path' => $screenshot,
            'photo' => $screenshot,
            'caption' => $caption,
            'content' => $caption,
            'platform' => $this->platform ?: 'whatsapp',
            'is_featured' => $isFeatured,
            'is_active' => $isFeatured,
            'sort_order' => (int) ($this->sort_order ?? 0),
            'rating' => (int) ($this->rating ?? 5),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
