<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\Gallery;
use App\Models\Message;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'total_services' => Service::count(),
            'total_portfolio' => Portfolio::count(),
            'total_blog_posts' => BlogPost::count(),
            'total_testimonials' => Testimonial::count(),
            'total_messages' => Message::count(),
            'total_unread_messages' => Message::where('is_read', false)->count(),
            'total_gallery' => Gallery::count(),
        ];
    }

    public function getRecentActivity(): array
    {
        return [
            'recent_services' => Service::withTrashed()
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'updated_at', 'deleted_at']),
                
            'recent_portfolio' => Portfolio::withTrashed()
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'updated_at', 'deleted_at']),
                
            'recent_blog_posts' => BlogPost::withTrashed()
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get(['id', 'title', 'updated_at', 'deleted_at']),
                
            'recent_testimonials' => Testimonial::withTrashed()
                ->orderBy('updated_at', 'desc')
                ->limit(5)
                ->get(['id', 'name', 'updated_at', 'deleted_at']),
                
            'recent_messages' => Message::withTrashed()
                ->orderBy('updated_at', 'desc')
                ->limit(10)
                ->get(['id', 'name', 'email', 'subject', 'updated_at', 'deleted_at']),
        ];
    }
}
