<?php

namespace App\Services;

use App\Models\Gallery;
use App\Repositories\GalleryRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class GalleryService
{
    protected GalleryRepository $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }

    public function getAll(array $filters, int $perPage = 15)
    {
        return $this->galleryRepository->getPaginated($filters, $perPage);
    }

    public function getById(int $id): Gallery
    {
        return $this->galleryRepository->findById($id);
    }

    public function createGallery(array $data, ?UploadedFile $imageFile): Gallery
    {
        $data['image'] = null;
        if ($imageFile) {
            $data['image'] = $this->uploadImage($imageFile);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $this->galleryRepository->create($data);
    }

    public function updateGallery(int $id, array $data, ?UploadedFile $imageFile): Gallery
    {
        $gallery = $this->galleryRepository->findById($id);

        if ($imageFile) {
            if ($gallery->image && Storage::disk('public')->exists(ltrim($gallery->image, '/'))) {
                Storage::disk('public')->delete(ltrim($gallery->image, '/'));
            }
            $data['image'] = $this->uploadImage($imageFile);
        } else {
            unset($data['image']);
        }

        $this->galleryRepository->update($gallery, $data);
        
        return $gallery->fresh();
    }

    public function deleteGallery(int $id): bool
    {
        $gallery = $this->galleryRepository->findById($id);
        
        if ($gallery->image && Storage::disk('public')->exists(ltrim($gallery->image, '/'))) {
            Storage::disk('public')->delete(ltrim($gallery->image, '/'));
        }
        
        return $this->galleryRepository->delete($gallery);
    }

    private function uploadImage(UploadedFile $file): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads/gallery', $filename, 'public');
        return '/storage/uploads/gallery/' . $filename;
    }
}
