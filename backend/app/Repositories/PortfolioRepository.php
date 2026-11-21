<?php

namespace App\Repositories;

use App\Models\Portfolio;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PortfolioRepository
{
    public function getPaginated(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Portfolio::query();
        
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

    public function findById(int $id): Portfolio
    {
        return Portfolio::findOrFail($id);
    }

    public function create(array $data): Portfolio
    {
        return Portfolio::create($data);
    }

    public function update(Portfolio $portfolio, array $data): bool
    {
        return $portfolio->update($data);
    }

    public function delete(Portfolio $portfolio): bool
    {
        return $portfolio->delete();
    }
}
