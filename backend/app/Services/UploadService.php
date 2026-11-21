<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

use App\Jobs\OptimizeImageJob;

class UploadService
{
    public function uploadFile(UploadedFile $file, ?string $directory = 'general'): array
    {
        $uuid = Str::uuid();
        $originalExt = $file->getClientOriginalExtension();
        $originalFilename = $uuid . '_original.' . $originalExt;
        
        $finalFilename = $uuid . '.webp';
        $thumbFilename = $uuid . '_thumb.webp';
        
        $directoryPath = 'uploads/' . ($directory ?? 'general');
        
        $file->storeAs($directoryPath, $originalFilename, 'public');

        OptimizeImageJob::dispatch(
            $directoryPath . '/' . $originalFilename,
            $directoryPath . '/' . $finalFilename,
            $directoryPath . '/' . $thumbFilename
        );

        return [
            'url' => '/storage/' . $directoryPath . '/' . $finalFilename,
            'thumbnail_url' => '/storage/' . $directoryPath . '/' . $thumbFilename,
            'filename' => $finalFilename,
            'directory' => $directoryPath
        ];
    }
}
