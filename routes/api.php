<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Rutas para hoteles
Route::get('/hotels', [HotelController::class, 'index']);
// guardar registro
Route::post('/hotels', [HotelController::class, 'store']);
// listar habitaciones
Route::get('/hotels/room', [HotelController::class, 'getRoomType']);
// listar acomodaciones
Route::get('/hotels/accommodation', [HotelController::class, 'getAccommodation']);
