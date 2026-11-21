<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\StoreGalleryRequest;
use App\Http\Requests\Gallery\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Services\GalleryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GalleryController extends Controller
{
    protected GalleryService $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['category', 'search']);
        $perPage = $request->input('per_page', 15);
        
        $galleries = $this->galleryService->getAll($filters, $perPage);
        
        return GalleryResource::collection($galleries);
    }

    public function store(StoreGalleryRequest $request): GalleryResource
    {
        $gallery = $this->galleryService->createGallery(
            $request->validated(),
            $request->file('image')
        );

        return new GalleryResource($gallery);
    }

    public function show(int $id): GalleryResource
    {
        $gallery = $this->galleryService->getById($id);
        return new GalleryResource($gallery);
    }

    public function update(UpdateGalleryRequest $request, int $id): GalleryResource
    {
        $gallery = $this->galleryService->updateGallery(
            $id,
            $request->validated(),
            $request->file('image')
        );

        return new GalleryResource($gallery);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->galleryService->deleteGallery($id);
        
        return response()->json(['message' => 'Gallery item deleted successfully']);
    }
}
