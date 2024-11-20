<?php

use App\Http\Controllers\DashboardController;
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
});
