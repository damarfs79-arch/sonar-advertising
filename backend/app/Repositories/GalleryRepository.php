<?php

namespace App\Repositories;

use App\Models\Gallery;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class GalleryRepository
{
    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Gallery::query();
        
        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        
        if (isset($filters['search'])) {
            $query->where(function(Builder $q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        return $query->orderBy('sort_order', 'asc')->paginate($perPage);
    }

    public function findById(int $id): Gallery
    {
        return Gallery::findOrFail($id);
    }

    public function create(array $data): Gallery
    {
        return Gallery::create($data);
    }

    public function update(Gallery $gallery, array $data): bool
    {
        return $gallery->update($data);
    }

    public function delete(Gallery $gallery): bool
    {
        return $gallery->delete();
    }
}
