<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Enrollment\EnrollmentController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\user\UserController;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Rotas para user
Route::controller(UserController::class)
    ->prefix('user')
    ->group(function () {
        Route::get('index', 'index')->name('index-user');
        Route::post('store', 'store')->name('store-user');
        Route::get('show/{user_id}', 'show')->name('show-user');
        Route::put('update/{user_id}', 'update')->middleware('auth:sanctum')->name('update-user');
        Route::delete('destroy/{user_id}', 'destroy')->middleware('auth:sanctum')->name('destroy-user');
    });

// Rotas pra login
Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('login', 'login')->name('login-auth');
        Route::post('logout', 'logout')->name('logout-auth')->middleware('auth:sanctum');
    });

// Rotas para Event
Route::controller(EventController::class)
    ->prefix('event')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('index', 'index')->name('index-event')
            ->withoutMiddleware('auth:sanctum');
        Route::post('store', 'store')->name('store-event');
        Route::get('show/{id}', 'show')->name('show-event')
            ->withoutMiddleware('auth:sanctum');
        Route::patch('update/{id}', 'update')->name('update-event');
        Route::delete('destroy/{id}', 'destroy')->name('destroy-event');
    });

// Rotas pra Enrollment
Route::controller(EnrollmentController::class)
    ->prefix('enrollment')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('index', 'index')->name('index-enrollment');
        Route::post('store', 'store')->name('store-enrollment');
        Route::get('show-participants/{event_id}', 'showParticipants')->name('showParticipants-enrollment');
        Route::delete('destroy/{event_id}', 'destroy')->name('destroy-enrollment');
    });
