<?php

namespace App\Repositories;

use App\Models\Service;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ServiceRepository
{
    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Service::query();
        
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }
        
        if (isset($filters['search'])) {
            $query->where(function(Builder $q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        return $query->orderBy('sort_order', 'asc')->paginate($perPage);
    }

    public function findById(int $id): Service
    {
        return Service::findOrFail($id);
    }

    public function create(array $data): Service
    {
        return Service::create($data);
    }

    public function update(Service $service, array $data): bool
    {
        return $service->update($data);
    }

    public function delete(Service $service): bool
    {
        return $service->delete();
    }
}
