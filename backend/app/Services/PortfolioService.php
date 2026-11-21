<?php

namespace App\Services;

use App\Models\Portfolio;
use App\Repositories\PortfolioRepository;
use Illuminate\Support\Facades\Storage;

class PortfolioService
{
    protected PortfolioRepository $portfolioRepository;

    public function __construct(PortfolioRepository $portfolioRepository)
    {
        $this->portfolioRepository = $portfolioRepository;
    }

    public function getAll(array $filters, int $perPage = 15)
    {
        return $this->portfolioRepository->getPaginated($filters, $perPage);
    }

    public function getById(int $id): Portfolio
    {
        return $this->portfolioRepository->findById($id);
    }

    public function createPortfolio(array $data): Portfolio
    {
        $data['gallery_images'] = $data['gallery_images'] ?? [];
        $data['is_active'] = $data['is_active'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $this->portfolioRepository->create($data);
    }

    public function updatePortfolio(int $id, array $data): Portfolio
    {
        $portfolio = $this->portfolioRepository->findById($id);

        $this->portfolioRepository->update($portfolio, $data);
        
        return $portfolio->fresh();
    }

    public function deletePortfolio(int $id): bool
    {
        $portfolio = $this->portfolioRepository->findById($id);
        
        if ($portfolio->main_image && Storage::disk('public')->exists(ltrim($portfolio->main_image, '/'))) {
            Storage::disk('public')->delete(ltrim($portfolio->main_image, '/'));
        }
        
        if ($portfolio->gallery_images) {
            foreach ($portfolio->gallery_images as $img) {
                if (Storage::disk('public')->exists(ltrim($img, '/'))) {
                    Storage::disk('public')->delete(ltrim($img, '/'));
                }
            }
        }
        
        return $this->portfolioRepository->delete($portfolio);
    }
}
