<?php

namespace App\Repositories;

use App\Models\Testimonial;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class TestimonialRepository
{
    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Testimonial::query();
        
        if (isset($filters['is_featured'])) {
            $isFeatured = filter_var($filters['is_featured'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($isFeatured !== null) {
                $query->where(function(Builder $q) use ($isFeatured) {
                    $q->where('is_featured', $isFeatured)
                      ->orWhere('is_active', $isFeatured);
                });
            }
        } elseif (isset($filters['is_active'])) {
            $isActive = filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($isActive !== null) {
                $query->where(function(Builder $q) use ($isActive) {
                    $q->where('is_featured', $isActive)
                      ->orWhere('is_active', $isActive);
                });
            }
        }
        
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function(Builder $q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('project_type', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('caption', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): Testimonial
    {
        return Testimonial::findOrFail($id);
    }

    public function create(array $data): Testimonial
    {
        return Testimonial::create($data);
    }

    public function update(Testimonial $testimonial, array $data): bool
    {
        return $testimonial->update($data);
    }

    public function delete(Testimonial $testimonial): bool
    {
        return $testimonial->delete();
    }
}
