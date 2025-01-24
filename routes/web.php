<?php

use App\Events\HelloEvent;
use App\Http\Controllers\AstronomisController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\CentxtController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DispalyAdzanController;
use App\Http\Controllers\DisplayIqomahController;
use App\Http\Controllers\DisUtamaController;
use App\Http\Controllers\JadwalKajianController;
use App\Http\Controllers\JadwalSholatController;
use App\Http\Controllers\MasjidController;
use App\Http\Controllers\MuharramController;
use App\Http\Controllers\PrimarydisController;
use App\Http\Controllers\RuntxtController;
use App\Http\Controllers\UlamaController;
use App\Http\Controllers\WaitingRtcController;
use App\Http\Middleware\CheckPostedTime;
use Illuminate\Support\Carbon;
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

Route::get('/waiting-rtc', [WaitingRtcController::class, 'index'])
    ->name('waiting-rtc.index');

        Route::middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified'
        //    'check.time' // Tambahkan middleware Anda
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

        Route::resource('/primarydisplay', PrimarydisController::class)
        ->names([
            'index' => 'primarydisplay.index',
            'create' => 'primarydisplay.create',
            'store' => 'primarydisplay.store',
            'show' => 'primarydisplay.show',
            'edit' => 'primarydisplay.edit',
            'update' => 'primarydisplay.update',
            'destroy' => 'primarydisplay.destroy',
        ]);

        Route::resource('/centxt', CentxtController::class)
        ->names([
            'index' => 'centxt.index',
            'create' => 'centxt.create',
            'store' => 'centxt.store',
            'show' => 'centxt.show',
            'edit' => 'centxt.edit',
            'update' => 'centxt.update',
            'destroy' => 'centxt.destroy',
        ]);

        Route::resource('/runtxt', RuntxtController::class)
        ->names([
            'index' => 'runtxt.index',
            'create' => 'runtxt.create',
            'store' => 'runtxt.store',
            'show' => 'runtxt.show',
            'edit' => 'runtxt.edit',
            'update' => 'runtxt.update',
            'destroy' => 'runtxt.destroy',
        ]);
        Route::resource('/masjid',MasjidController::class)
        ->names([
            'index' => 'masjid.index',
            'create' => 'masjid.create',
            'store' => 'masjid.store',
            'show' => 'masjid.show',
            'edit' => 'masjid.edit',
            'update' => 'masjid.update',
            'destroy' => 'masjid.destroy',
        ]);

        Route::resource('/astronomis',AstronomisController::class)
        ->names([
            'index' => 'astronomis.index',
            'create' => 'astronomis.create',
            'store' => 'astronomis.store',
            'show' => 'astronomis.show',
            'edit' => 'astronomis.edit',
            'update' => 'astronomis.update',
            'destroy' => 'astronomis.destroy',
        ]);
    });
    Route::resource('/displayutama',DisUtamaController::class)
    ->names([
        'index' => 'displayutama.index',
        'create' => 'displayutama.create',
        'store' => 'displayutama.store',
        'show' => 'displayutama.show',
        'edit' => 'displayutama.edit',
        'update' => 'displayutama.update',
        'destroy' => 'displayutama.destroy',
    ]);
    // Route::resource('/displayadzan',DispalyAdzanController::class)
    // ->names([
    //     'index' => 'displayadzan.index',
    //     'create' => 'displayadzan.create',
    //     'store' => 'displayadzan.store',
    //     'show' => 'displayadzan.show',
    //     'edit' => 'displayadzan.edit',
    //     'update' => 'displayadzan.update',
    //     'destroy' => 'displayadzan.destroy',
    // ]);
    Route::get('/displayadzan', [DispalyAdzanController::class, 'displayAdzan'])->name('display.adzan');
    Route::get('/displayiqomah', [DisplayIqomahController::class, 'displayIqomah'])->name('display.iqomah');

