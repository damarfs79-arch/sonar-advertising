<?php

namespace App\Services;

use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class ServiceService
{
    protected ServiceRepository $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getAll(array $filters, int $perPage = 15)
    {
        return $this->serviceRepository->getPaginated($filters, $perPage);
    }

    public function getById(int $id): Service
    {
        return $this->serviceRepository->findById($id);
    }

    public function createService(array $data, ?UploadedFile $imageFile): Service
    {
        $data['image'] = null;
        if ($imageFile) {
            $data['image'] = $this->uploadImage($imageFile);
        }

        $data['is_active'] = $data['is_active'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $this->serviceRepository->create($data);
    }

    public function updateService(int $id, array $data, ?UploadedFile $imageFile): Service
    {
        $service = $this->serviceRepository->findById($id);

        if ($imageFile) {
            if ($service->image && Storage::disk('public')->exists(ltrim($service->image, '/'))) {
                Storage::disk('public')->delete(ltrim($service->image, '/'));
            }
            $data['image'] = $this->uploadImage($imageFile);
        }

        $this->serviceRepository->update($service, $data);
        
        return $service->fresh();
    }

    public function deleteService(int $id): bool
    {
        $service = $this->serviceRepository->findById($id);
        
        if ($service->image && Storage::disk('public')->exists(ltrim($service->image, '/'))) {
            Storage::disk('public')->delete(ltrim($service->image, '/'));
        }
        
        return $this->serviceRepository->delete($service);
    }

    private function uploadImage(UploadedFile $file): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads/services', $filename, 'public');
        return '/storage/uploads/services/' . $filename;
    }
}
