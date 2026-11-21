<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class SettingService
{
    public function getAll()
    {
        return Setting::pluck('value', 'key');
    }

    public function updateSettings(array $data): void
    {
        foreach ($data as $key => $value) {
            $setting = Setting::firstOrNew(['key' => $key]);
            $setting->value = $value;
            $setting->save();
        }
    }

    public function uploadFile(UploadedFile $file, string $key): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads/settings', $filename, 'public');
        $path = '/storage/uploads/settings/' . $filename;

        // Delete old file if exists
        $setting = Setting::where('key', $key)->first();
        if ($setting && $setting->value && Storage::disk('public')->exists(str_replace('/storage/', '', $setting->value))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $setting->value));
        }

        $setting = Setting::firstOrNew(['key' => $key]);
        $setting->value = $path;
        $setting->save();

        return $path;
    }
}
