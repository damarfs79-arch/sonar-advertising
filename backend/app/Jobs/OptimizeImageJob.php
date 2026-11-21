<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class OptimizeImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $originalPath;
    public $targetPath;
    public $thumbnailPath;

    /**
     * Create a new job instance.
     */
    public function __construct(string $originalPath, string $targetPath, string $thumbnailPath)
    {
        $this->originalPath = $originalPath;
        $this->targetPath = $targetPath;
        $this->thumbnailPath = $thumbnailPath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!Storage::disk('public')->exists($this->originalPath)) {
            return;
        }

        $manager = new ImageManager(new Driver());
        $imagePath = Storage::disk('public')->path($this->originalPath);
        
        try {
            $image = $manager->read($imagePath);

            // Resize if width > 2560px
            if ($image->width() > 2560) {
                $image->scaleDown(width: 2560);
            }

            // Encode to WebP with 85% quality
            $encoded = $image->toWebp(85);
            Storage::disk('public')->put($this->targetPath, (string) $encoded);

            // Generate thumbnail
            $thumbnail = $manager->read($imagePath);
            $thumbnail->scaleDown(width: 400);
            $encodedThumb = $thumbnail->toWebp(80);
            Storage::disk('public')->put($this->thumbnailPath, (string) $encodedThumb);

            // Delete original file if target is different
            if ($this->originalPath !== $this->targetPath) {
                Storage::disk('public')->delete($this->originalPath);
            }
        } catch (\Exception $e) {
            \Log::error('Image optimization failed: ' . $e->getMessage());
        }
    }
}
