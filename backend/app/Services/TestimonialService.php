<?php

namespace App\Services;

use App\Models\Testimonial;
use App\Repositories\TestimonialRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialService
{
    protected TestimonialRepository $testimonialRepository;

    public function __construct(TestimonialRepository $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    public function getAll(array $filters, int $perPage = 15)
    {
        return $this->testimonialRepository->getPaginated($filters, $perPage);
    }

    public function getById(int $id): Testimonial
    {
        return $this->testimonialRepository->findById($id);
    }

    public function createTestimonial(array $data): Testimonial
    {
        $data = $this->handleFileUploadAndSync($data);

        $data['is_featured'] = isset($data['is_featured']) ? (bool) $data['is_featured'] : (isset($data['is_active']) ? (bool) $data['is_active'] : true);
        $data['is_active'] = $data['is_featured'];
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['platform'] = $data['platform'] ?? 'whatsapp';

        return $this->testimonialRepository->create($data);
    }

    public function updateTestimonial(int $id, array $data): Testimonial
    {
        $testimonial = $this->testimonialRepository->findById($id);
        $oldScreenshot = $testimonial->screenshot_path ?: $testimonial->photo;

        $data = $this->handleFileUploadAndSync($data);

        if (isset($data['screenshot_path']) && $oldScreenshot && $oldScreenshot !== $data['screenshot_path']) {
            $this->deleteFileFromStorage($oldScreenshot);
        }

        if (isset($data['is_featured'])) {
            $data['is_active'] = (bool) $data['is_featured'];
        } elseif (isset($data['is_active'])) {
            $data['is_featured'] = (bool) $data['is_active'];
        }

        $this->testimonialRepository->update($testimonial, $data);
        
        return $testimonial->fresh();
    }

    public function toggleFeatured(int $id): Testimonial
    {
        $testimonial = $this->testimonialRepository->findById($id);
        $current = $testimonial->is_featured !== null ? (bool)$testimonial->is_featured : (bool)$testimonial->is_active;
        $newStatus = !$current;

        $testimonial->update([
            'is_featured' => $newStatus,
            'is_active' => $newStatus,
        ]);

        return $testimonial->fresh();
    }

    public function deleteTestimonial(int $id): bool
    {
        $testimonial = $this->testimonialRepository->findById($id);
        
        $screenshot = $testimonial->screenshot_path ?: $testimonial->photo;
        if ($screenshot) {
            $this->deleteFileFromStorage($screenshot);
        }
        
        return $this->testimonialRepository->delete($testimonial);
    }

    protected function handleFileUploadAndSync(array $data): array
    {
        if (isset($data['screenshot']) && $data['screenshot'] instanceof UploadedFile) {
            $file = $data['screenshot'];
            $uuid = Str::uuid();
            $ext = $file->getClientOriginalExtension() ?: 'webp';
            $filename = $uuid . '.' . $ext;
            $path = $file->storeAs('uploads/testimonials', $filename, 'public');
            $url = '/storage/' . $path;
            
            $data['screenshot_path'] = $url;
            $data['photo'] = $url;
            unset($data['screenshot']);
        } elseif (isset($data['photo']) && !isset($data['screenshot_path'])) {
            $data['screenshot_path'] = $data['photo'];
        } elseif (isset($data['screenshot_path'])) {
            $data['photo'] = $data['screenshot_path'];
        }

        if (isset($data['client_name']) && !isset($data['name'])) {
            $data['name'] = $data['client_name'];
        } elseif (isset($data['name']) && !isset($data['client_name'])) {
            $data['client_name'] = $data['name'];
        }

        if (isset($data['project_type']) && !isset($data['company'])) {
            $data['company'] = $data['project_type'];
        } elseif (isset($data['company']) && !isset($data['project_type'])) {
            $data['project_type'] = $data['company'];
        }

        if (isset($data['caption']) && !isset($data['content'])) {
            $data['content'] = $data['caption'];
        } elseif (isset($data['content']) && !isset($data['caption'])) {
            $data['caption'] = $data['content'];
        }

        return $data;
    }

    protected function deleteFileFromStorage(?string $path): void
    {
        if (!$path) return;
        $relative = str_replace('/storage/', '', $path);
        $relative = ltrim($relative, '/');
        if (Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
        }
    }
}
