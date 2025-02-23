<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

// Public Routes (Anyone can view albums & artists)
Route::post('/login', [AuthController::class, 'login']);
Route::get('/artists', [ArtistController::class, 'index']);
Route::get('/artists/{id}', [ArtistController::class, 'show']);
Route::get('/albums', [AlbumController::class, 'index']);
Route::get('/albums/{id}', [AlbumController::class, 'show']);
Route::get('/dashboard/search-albums', [DashboardController::class, 'searchAlbums']);
Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

// Admin Routes (Require Authentication)
Route::middleware(['auth:sanctum'])->group(function () {
  Route::post('/logout', [AuthController::class, 'logout']);
  
  // Get authenticated user details
  Route::get('/user', function (Request $request) {
    return response()->json($request->user());
  });

  // Dashboard (Authenticated Users Only)
  Route::prefix('dashboard')->group(function () {
    Route::get('/total-albums', [DashboardController::class, 'totalAlbumsPerArtist']);
    Route::get('/combined-sales', [DashboardController::class, 'combinedSalesPerArtist']);
    Route::get('/top-artist', [DashboardController::class, 'topSellingArtist']);
  });

  // Manage Artists (Only Admins)
  Route::apiResource('artists', ArtistController::class)->except(['index', 'show']);

  // Manage Albums (Only Admins)
  Route::apiResource('albums', AlbumController::class)->except(['index', 'show']);
  Route::post('/albums/{id}/upload-cover', [AlbumController::class, 'uploadCover']);
});
