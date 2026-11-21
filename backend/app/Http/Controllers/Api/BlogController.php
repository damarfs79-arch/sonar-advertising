<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogController extends Controller
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['status', 'category', 'search']);
        $perPage = $request->input('per_page', 15);
        
        $blogs = $this->blogService->getAll($filters, $perPage);
        
        return BlogResource::collection($blogs);
    }

    public function store(StoreBlogRequest $request): BlogResource
    {
        $blog = $this->blogService->createBlog($request->validated());

        return new BlogResource($blog);
    }

    public function show(string|int $id): BlogResource
    {
        $blog = $this->blogService->getBySlugOrId($id);
        return new BlogResource($blog);
    }

    public function update(UpdateBlogRequest $request, int $id): BlogResource
    {
        $blog = $this->blogService->updateBlog($id, $request->validated());

        return new BlogResource($blog);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->blogService->deleteBlog($id);
        
        return response()->json(['message' => 'Blog post deleted successfully']);
    }
}
