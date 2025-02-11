<?php

use App\Http\Controllers\PrayerTimeController;
use App\Http\Controllers\WaktuCarbonContoller;
use App\Http\Controllers\WaktuRealController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/waktu', WaktuRealController::class)
        ->names([
            'index' => 'waktu.index',
            'create' => 'waktu.create',
            'store' => 'waktu.store',
            'show' => 'waktu.show',
            'edit' => 'waktu.edit',
            'update' => 'waktu.update',
            'destroy' => 'waktu.destroy',
        ]);
Route::resource('/prayer', PrayerTimeController::class)
        ->names([
            'index' => 'prayer.index',
            'create' => 'prayer.create',
            'store' => 'prayer.store',
            'show' => 'prayer.show',
            'edit' => 'prayer.edit',
            'update' => 'prayer.update',
            'destroy' => 'prayer.destroy',
        ]);

Route::post('/waktucarbon', [WaktuCarbonContoller::class, 'store']);
Route::get('/waktucarbon', [WaktuCarbonContoller::class, 'getTime']);
