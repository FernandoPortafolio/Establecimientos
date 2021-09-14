<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstablecimientoController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InicioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', InicioController::class)->name('inicio');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/establecimiento/create', [EstablecimientoController::class, 'create'])->name('establecimiento.create')->middleware('revisar');
    Route::post('/establecimiento/store', [EstablecimientoController::class, 'store'])->name('establecimiento.store');
    Route::get('/establecimiento/edit', [EstablecimientoController::class, 'edit'])->name('establecimiento.edit');
    Route::put('/establecimiento/{establecimiento}/update', [EstablecimientoController::class, 'update'])->name('establecimiento.update');

    Route::post('/images/store', [ImageController::class, 'store'])->name('images.store');
    Route::delete('/images/{image}/destroy', [ImageController::class, 'destroy'])->name('images.destroy');
});
