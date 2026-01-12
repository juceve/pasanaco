<?php

use App\Http\Controllers\DescargasController;
use App\Http\Controllers\HomeController;
use App\Models\Sesion;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes(['register' => false]);
Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('participantes', App\Http\Controllers\ParticipanteController::class)->names('participantes');
    // Route::resource('users', App\Http\Controllers\UserController::class)->names('users');
    // Route::resource('modos', App\Http\Controllers\ModoController::class)->names('modos');

    Route::get('sesiones/listado', App\Http\Livewire\ListadoSesiones::class)->name('sesiones.listado');
    Route::get('sesiones/form/{id?}', App\Http\Livewire\FormSesion::class)->name('sesiones.form');
    Route::get('sesiones/sorteo/{id}', App\Http\Livewire\SorteoSesion::class)->name('sesiones.sorteo');
    Route::get('sesiones/operativa/{id}', App\Http\Livewire\OperativaSesion::class)->name('sesiones.operativa');
    Route::get('sesiones/cobrar-cuota/{id}', App\Http\Livewire\CobrarCuota::class)->name('sesiones.cobrarcuota');



    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
Route::get('descarga-qr/{sesion_id}',[DescargasController::class,"descargarQr"])->name('sesiones.descargaqr');
