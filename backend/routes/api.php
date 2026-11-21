<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\DashboardController;

// 1. PUBLIC ROUTES (No Token Required)
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

// Public Resources (Read-Only)
Route::get('services', [ServiceController::class, 'index']);
Route::get('services/{service}', [ServiceController::class, 'show']);

Route::get('portfolio', [PortfolioController::class, 'index']);
Route::get('portfolio/{portfolio}', [PortfolioController::class, 'show']);

Route::get('blog', [BlogController::class, 'index']);
Route::get('blog/{blog}', [BlogController::class, 'show']);

Route::get('testimonials', [TestimonialController::class, 'index']);
Route::get('testimonials/{testimonial}', [TestimonialController::class, 'show']);

Route::get('gallery', [GalleryController::class, 'index']);
Route::get('gallery/{gallery}', [GalleryController::class, 'show']);

// Public Messages (Create Only)
Route::post('messages', [MessageController::class, 'store']);

// Public Settings
Route::get('/settings', [SettingController::class, 'index']);


// 2. PROTECTED ROUTES (Sanctum Token Required)
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);

    // Protected Resources (Create, Update, Delete)
    Route::apiResource('services', ServiceController::class)->except(['index', 'show']);
    Route::apiResource('portfolio', PortfolioController::class)->except(['index', 'show']);
    Route::apiResource('blog', BlogController::class)->except(['index', 'show']);
    Route::apiResource('testimonials', TestimonialController::class)->except(['index', 'show']);
    Route::patch('testimonials/{id}/toggle-featured', [TestimonialController::class, 'toggleFeatured']);
    Route::apiResource('gallery', GalleryController::class)->except(['index', 'show']);
    
    // Messages Management
    Route::apiResource('messages', MessageController::class)->except(['store']);
    Route::put('messages/{message}/read', [MessageController::class, 'markAsRead']);
    
    // Settings & Uploads
    Route::put('/settings', [SettingController::class, 'update']);
    Route::post('/settings/upload', [SettingController::class, 'uploadFile']);
    Route::post('/upload', [UploadController::class, 'upload']);
    
    // Dashboard Analytics
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/recent-activity', [DashboardController::class, 'recentActivity']);
});