<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RegionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Public Routes
Route::post('/login', [AuthController::class, 'login']);

// Region Routes (Public)

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/regions', [RegionController::class, 'index']);

    // Admin Routes
    Route::middleware('role:admin_pusat')->group(function () {
        Route::get('/admin/laporan', [AdminLaporanController::class, 'index']);
        Route::put('/admin/laporan/{id}', [AdminLaporanController::class, 'update']);
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'stats']);
    });

    // Pengguna Daerah Routes
    Route::middleware('role:pengguna_daerah')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'getLaporan']);
        Route::post('/laporan', [LaporanController::class, 'store']);
        Route::put('/laporan/{id}', [LaporanController::class, 'update']);
        Route::delete('/laporan/{id}', [LaporanController::class, 'destroy']);
    });
});
