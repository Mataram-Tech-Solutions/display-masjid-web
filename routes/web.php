<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalKajianController;
use App\Http\Controllers\JadwalSholatController;
use App\Http\Controllers\MuharramController;
use App\Http\Controllers\UlamaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('/', DashboardController::class)
        ->names([
            'index' => 'dashboard.index',
            'create' => 'dashboard.create',
            'store' => 'dashboard.store',
            'show' => 'dashboard.show',
            'edit' => 'dashboard.edit',
            'update' => 'dashboard.update',
            'destroy' => 'dashboard.destroy',
        ]);

        Route::resource('/jadwalsholat', JadwalSholatController::class)
        ->names([
            'index' => 'jadwalsholat.index',
            'create' => 'jadwalsholat.create',
            'store' => 'jadwalsholat.store',
            'show' => 'jadwalsholat.show',
            'edit' => 'jadwalsholat.edit',
            'update' => 'jadwalsholat.update',
            'destroy' => 'jadwalsholat.destroy',
        ]);

        Route::resource('/jadwalkajian', JadwalKajianController::class)
        ->names([
            'index' => 'jadwalkajian.index',
            'create' => 'jadwalkajian.create',
            'store' => 'jadwalkajian.store',
            'show' => 'jadwalkajian.show',
            'edit' => 'jadwalkajian.edit',
            'update' => 'jadwalkajian.update',
            'destroy' => 'jadwalkajian.destroy',
        ]);

        Route::resource('/ulama', UlamaController::class)
        ->names([
            'index' => 'ulama.index',
            'create' => 'ulama.create',
            'store' => 'ulama.store',
            'show' => 'ulama.show',
            'edit' => 'ulama.edit',
            'update' => 'ulama.update',
            'destroy' => 'ulama.destroy',
        ]);

        Route::resource('/muharram', MuharramController::class)
        ->names([
            'index' => 'muharram.index',
            'create' => 'muharram.create',
            'store' => 'muharram.store',
            'show' => 'muharram.show',
            'edit' => 'muharram.edit',
            'update' => 'muharram.update',
            'destroy' => 'muharram.destroy',
        ]);

        Route::resource('/audio', AudioController::class)
        ->names([
            'index' => 'audio.index',
            'create' => 'audio.create',
            'store' => 'audio.store',
            'show' => 'audio.show',
            'edit' => 'audio.edit',
            'update' => 'audio.update',
            'destroy' => 'audio.destroy',
        ]);

        Route::resource('/primarydisplay', AudioController::class)
        ->names([
            'index' => 'primarydisplay.index',
            'create' => 'primarydisplay.create',
            'store' => 'primarydisplay.store',
            'show' => 'primarydisplay.show',
            'edit' => 'primarydisplay.edit',
            'update' => 'primarydisplay.update',
            'destroy' => 'primarydisplay.destroy',
        ]);
});
