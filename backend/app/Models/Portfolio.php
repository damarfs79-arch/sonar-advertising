<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'portfolio';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'main_image',
        'gallery_images',
        'client',
        'project_date',
        'is_active',
        'sort_order',
        'link'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'gallery_images' => 'array',
        'project_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
