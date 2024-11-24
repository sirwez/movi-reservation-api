<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShowTimeController;
use App\Http\Controllers\TesteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

// Autenticação
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Teste
Route::get('/test', [TesteController::class, 'index'])->middleware('auth:sanctum', 'abilities:manager');

// Filmes
Route::group(['prefix' => 'movies'], function () {
    Route::get('/', [MovieController::class, 'index']);
    Route::post('/create', [MovieController::class, 'create']);
    Route::get('/list', [MovieController::class, 'list']);
    Route::get('/show/{id}', [MovieController::class, 'showById']);
    Route::get('/search', [MovieController::class, 'showByName']);
    Route::get('/genre', [MovieController::class, 'showByGenre']);
    Route::get('/date', [ShowTimeController::class, 'showByDate']);
    Route::put('/update/{id}', [MovieController::class, 'update']);
    Route::delete('/delete/{id}', [MovieController::class, 'delete']);
});
// Horários de exibição
Route::group(['prefix' => 'showtimes'], function () {
    Route::get('/', [ShowTimeController::class, 'index']);
    Route::post('/create', [ShowTimeController::class, 'create']);
    Route::post('/update/{id}', [ShowTimeController::class, 'update']);
    Route::get('/seats/{id}', [ShowTimeController::class, 'seats']);

});

Route::group(['prefix' => 'reservation'], function () {
    Route::post('/create', [ReservationController::class, 'create']);
    Route::get('/list', [ReservationController::class, 'list']);
    Route::delete('/cancel/{id}', [ReservationController::class, 'cancel']);
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/listByMovie', [AdminPanelController::class, 'listByMovie']);
    Route::get('/list', [AdminPanelController::class, 'list']);
    Route::get('/capacity/{id}', [AdminPanelController::class, 'capacity']);
    Route::get('/reservations', [AdminPanelController::class, 'reservations']);
    Route::get('/reservationsByMovie', [AdminPanelController::class, 'reservationsByMovie']);

});

