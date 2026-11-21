<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Testimonial\StoreTestimonialRequest;
use App\Http\Requests\Testimonial\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Services\TestimonialService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TestimonialController extends Controller
{
    protected TestimonialService $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['is_featured', 'is_active', 'search']);
        $perPage = (int) $request->input('per_page', 15);
        
        $testimonials = $this->testimonialService->getAll($filters, $perPage);
        
        return TestimonialResource::collection($testimonials);
    }

    public function store(StoreTestimonialRequest $request): TestimonialResource
    {
        $testimonial = $this->testimonialService->createTestimonial($request->validated() + $request->allFiles());

        return new TestimonialResource($testimonial);
    }

    public function show(int $id): TestimonialResource
    {
        $testimonial = $this->testimonialService->getById($id);
        return new TestimonialResource($testimonial);
    }

    public function update(UpdateTestimonialRequest $request, int $id): TestimonialResource
    {
        $testimonial = $this->testimonialService->updateTestimonial($id, $request->validated() + $request->allFiles());

        return new TestimonialResource($testimonial);
    }

    public function toggleFeatured(int $id): TestimonialResource
    {
        $testimonial = $this->testimonialService->toggleFeatured($id);

        return new TestimonialResource($testimonial);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->testimonialService->deleteTestimonial($id);
        
        return response()->json(['message' => 'Testimonial deleted successfully']);
    }
}
