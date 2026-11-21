<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Services\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    protected ServiceService $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['is_active', 'search']);
        $perPage = $request->input('per_page', 15);
        
        if (empty($filters['search']) && empty($filters['is_active']) && $perPage == 15) {
            $services = Cache::remember('public_services_default', 3600, function () use ($filters, $perPage) {
                return $this->serviceService->getAll($filters, $perPage);
            });
        } else {
            $services = $this->serviceService->getAll($filters, $perPage);
        }
        
        return ServiceResource::collection($services);
    }

    public function store(StoreServiceRequest $request): ServiceResource
    {
        Cache::forget('public_services_default');
        $service = $this->serviceService->createService(
            $request->validated(),
            $request->file('image')
        );

        return new ServiceResource($service);
    }

    public function show(int $id): ServiceResource
    {
        $service = $this->serviceService->getById($id);
        return new ServiceResource($service);
    }

    public function update(UpdateServiceRequest $request, int $id): ServiceResource
    {
        Cache::forget('public_services_default');
        $service = $this->serviceService->updateService(
            $id,
            $request->validated(),
            $request->file('image')
        );

        return new ServiceResource($service);
    }

    public function destroy(int $id): JsonResponse
    {
        Cache::forget('public_services_default');
        $this->serviceService->deleteService($id);
        
        return response()->json(['message' => 'Service deleted successfully']);
    }
}
