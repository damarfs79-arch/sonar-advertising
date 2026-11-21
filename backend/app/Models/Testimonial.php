<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_name',
        'project_type',
        'screenshot_path',
        'caption',
        'platform',
        'is_featured',
        'sort_order',
        'name',
        'position',
        'company',
        'content',
        'photo',
        'rating',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'rating' => 'integer',
    ];

    public function getClientNameAttribute($value): ?string
    {
        return $value ?: $this->attributes['name'] ?? null;
    }

    public function getScreenshotPathAttribute($value): ?string
    {
        return $value ?: $this->attributes['photo'] ?? null;
    }

    public function getCaptionAttribute($value): ?string
    {
        return $value ?: $this->attributes['content'] ?? null;
    }

    public function getProjectTypeAttribute($value): ?string
    {
        return $value ?: $this->attributes['company'] ?? null;
    }

    public function getIsFeaturedAttribute($value): bool
    {
        if ($value !== null) {
            return (bool) $value;
        }
        return (bool) ($this->attributes['is_active'] ?? true);
    }
}
