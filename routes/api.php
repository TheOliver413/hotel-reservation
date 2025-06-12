<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeasonRateController;
use App\Http\Controllers\RoomAvailabilityController;
use Illuminate\Support\Facades\Route;

// --- Hoteles ---
Route::get('/hotels', [HotelController::class, 'index']);
Route::get('/hotels/{id}', [HotelController::class, 'show']);
Route::post('/hotels', [HotelController::class, 'store']);
Route::put('/hotels/{id}', [HotelController::class, 'update']);
Route::delete('/hotels/{id}', [HotelController::class, 'destroy']);

// --- Habitaciones ---
Route::get('/rooms', [RoomController::class, 'index']);
Route::get('/rooms/{id}', [RoomController::class, 'show']);
Route::get('/rooms/hotel/{hotelId}', [RoomController::class, 'getByHotel']);
Route::post('/rooms', [RoomController::class, 'store']);
Route::put('/rooms/{id}', [RoomController::class, 'update']);
Route::delete('/rooms/{id}', [RoomController::class, 'destroy']);

// --- Disponibilidad de habitaciones ---
Route::get('/room-availabilities', [RoomAvailabilityController::class, 'index']);
Route::get('/room-availabilities/{id}', [RoomAvailabilityController::class, 'show']);
Route::get('/room-availability/room/{roomId}', [RoomAvailabilityController::class, 'getByRoom']);
Route::post('/room-availability', [RoomAvailabilityController::class, 'store']);
Route::put('/room-availability/{id}', [RoomAvailabilityController::class, 'update']);
Route::delete('/room-availability/{id}', [RoomAvailabilityController::class, 'destroy']);

// --- Tarifas por temporada ---
Route::get('/season-rates', [SeasonRateController::class, 'index']);
Route::get('/season-rates/{id}', [SeasonRateController::class, 'show']);
Route::get('/season-rates/hotel/{hotelId}', [SeasonRateController::class, 'getByHotel']);
Route::post('/season-rates', [SeasonRateController::class, 'store']);
Route::put('/season-rates/{id}', [SeasonRateController::class, 'update']);
Route::delete('/season-rates/{id}', [SeasonRateController::class, 'destroy']);
