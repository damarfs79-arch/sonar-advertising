<?php

namespace App\Repositories;

use App\Models\BlogPost;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class BlogRepository
{
    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = BlogPost::query()->select([
            'id', 'user_id', 'title', 'slug', 'summary', 'thumbnail', 'category', 'tags', 'status', 'published_at', 'views', 'created_at', 'updated_at'
        ]);
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        
        if (isset($filters['search'])) {
            $query->where(function(Builder $q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('summary', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        return $query->orderBy('published_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): BlogPost
    {
        return BlogPost::findOrFail($id);
    }

    public function findBySlugOrId(string|int $identifier): BlogPost
    {
        if (is_numeric($identifier)) {
            $post = BlogPost::where('id', $identifier)->first();
            if ($post) return $post;
        }
        return BlogPost::where('slug', $identifier)->firstOrFail();
    }

    public function create(array $data): BlogPost
    {
        return BlogPost::create($data);
    }

    public function update(BlogPost $blog, array $data): bool
    {
        return $blog->update($data);
    }

    public function delete(BlogPost $blog): bool
    {
        return $blog->delete();
    }

    public function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = BlogPost::where('slug', $slug);
        
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }
        
        return $query->exists();
    }
}
