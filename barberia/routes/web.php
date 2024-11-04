<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PerfilController;

// Página de inicio
Route::get('/', function () {
    return view('paginas.index');
});

// Agrupación de rutas de agenda
Route::prefix('agenda')->group(function () {
    Route::get('/facial', [AgendaController::class, 'facial']);
    Route::get('/administrador', [AgendaController::class, 'administrador']);
    Route::get('/barbero', [AgendaController::class, 'barbero']);
    Route::get('/cliente', [AgendaController::class, 'cliente']);
});


// Agrupación de rutas de perfil
Route::prefix('perfil')->group(function () {
    Route::get('/administrador', [PerfilController::class, 'administrador']);
    Route::get('/barbero', [PerfilController::class, 'barbero']);
    Route::get('/cliente', [PerfilController::class, 'cliente']);
    Route::get('/faciales', [PerfilController::class, 'faciales']);
});


// Rutas para registro y login
Route::get('/registro', function () {
    return view('paginas.registro');
});

Route::get('/login', function () {
    return view('paginas.login');
});
?>