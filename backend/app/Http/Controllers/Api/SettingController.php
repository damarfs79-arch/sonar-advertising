<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index(): JsonResponse
    {
        $settings = Cache::remember('public_settings', 86400, function () {
            return $this->settingService->getAll();
        });

        return response()->json($settings);
    }

    public function update(Request $request): JsonResponse
    {
        Cache::forget('public_settings');
        $this->settingService->updateSettings($request->all());

        return response()->json(['message' => 'Settings updated successfully']);
    }

    public function uploadFile(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp',
            'key' => 'required|string|max:100'
        ]);

        Cache::forget('public_settings');
        $path = $this->settingService->uploadFile($request->file('file'), $request->key);

        return response()->json([
            'url' => $path,
            'key' => $request->key,
            'message' => 'File uploaded successfully'
        ]);
    }
}
