<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\BookingController;


Route::post('/admin/login', [AdminController::class, 'login']);


Route::get('/services', [ServiceController::class, 'index']);
Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/blogs', [BlogController::class, 'index']);


Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/bookings/search/{email}', [BookingController::class, 'searchByEmail']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::put('/galleries/{id}', [GalleryController::class, 'update']);
    Route::delete('/galleries/{id}', [GalleryController::class, 'destroy']);

    Route::post('/blogs', [BlogController::class, 'store']);
    Route::put('/blogs/{id}', [BlogController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);

    Route::get('/bookings', [BookingController::class, 'adminIndex']);
    Route::get('/bookings/status/{status}', [BookingController::class, 'listByStatus']);

    Route::put('/bookings/{id}/approve', [BookingController::class, 'approveBooking']);
    Route::put('/bookings/{id}/decline', [BookingController::class, 'declineBooking']);
});

