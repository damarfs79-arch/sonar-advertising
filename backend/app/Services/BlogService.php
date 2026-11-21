<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Repositories\BlogRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogService
{
    protected BlogRepository $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getAll(array $filters, int $perPage = 15)
    {
        return $this->blogRepository->getPaginated($filters, $perPage);
    }

    public function getById(int $id): BlogPost
    {
        return $this->blogRepository->findById($id);
    }

    public function getBySlugOrId(string|int $idOrSlug): BlogPost
    {
        return $this->blogRepository->findBySlugOrId($idOrSlug);
    }

    public function createBlog(array $data): BlogPost
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = json_decode($data['tags'], true) ?? [];
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $this->blogRepository->create($data);
    }

    public function updateBlog(int $id, array $data): BlogPost
    {
        $blog = $this->blogRepository->findById($id);

        if (isset($data['title']) && $data['title'] !== $blog->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $id);
        }

        if (isset($data['tags']) && is_string($data['tags'])) {
            $data['tags'] = json_decode($data['tags'], true) ?? [];
        }

        $newStatus = $data['status'] ?? $blog->status;
        if ($newStatus === 'published' && empty($data['published_at']) && !$blog->published_at) {
            $data['published_at'] = now();
        }

        $this->blogRepository->update($blog, $data);
        
        return $blog->fresh();
    }

    public function deleteBlog(int $id): bool
    {
        $blog = $this->blogRepository->findById($id);
        
        if ($blog->thumbnail && Storage::disk('public')->exists(ltrim($blog->thumbnail, '/'))) {
            Storage::disk('public')->delete(ltrim($blog->thumbnail, '/'));
        }
        
        return $this->blogRepository->delete($blog);
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        
        if ($this->blogRepository->slugExists($slug, $ignoreId)) {
            $slug = $slug . '-' . Str::random(6);
        }
        
        return $slug;
    }
}
