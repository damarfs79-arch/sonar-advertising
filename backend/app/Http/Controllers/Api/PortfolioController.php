<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portfolio\StorePortfolioRequest;
use App\Http\Requests\Portfolio\UpdatePortfolioRequest;
use App\Http\Resources\PortfolioResource;
use App\Services\PortfolioService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortfolioController extends Controller
{
    protected PortfolioService $portfolioService;

    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['category', 'search']);
        $perPage = $request->input('per_page', 15);
        
        $portfolios = $this->portfolioService->getAll($filters, $perPage);
        
        return PortfolioResource::collection($portfolios);
    }

    public function store(StorePortfolioRequest $request): PortfolioResource
    {
        $portfolio = $this->portfolioService->createPortfolio($request->validated());

        return new PortfolioResource($portfolio);
    }

    public function show(int $id): PortfolioResource
    {
        $portfolio = $this->portfolioService->getById($id);
        return new PortfolioResource($portfolio);
    }

    public function update(UpdatePortfolioRequest $request, int $id): PortfolioResource
    {
        $portfolio = $this->portfolioService->updatePortfolio($id, $request->validated());

        return new PortfolioResource($portfolio);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->portfolioService->deletePortfolio($id);
        
        return response()->json(['message' => 'Portfolio item deleted successfully']);
    }
}
