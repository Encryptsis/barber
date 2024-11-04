<?php

use Illuminate\Support\Facades\Route;

// Ruta para la página de inicio
Route::get('/', function () {
    return view('paginas.index'); // Apunta a 'paginas.index'
});


// Rutas para las diferentes agendas
Route::get('/agenda/facial', function () {
    return view('paginas.agenda_Facial');
});

Route::get('/agenda/administrador', function () {
    return view('paginas.agenda_Administrador');
});

Route::get('/agenda/barbero', function () {
    return view('paginas.agenda_barbero');
});

Route::get('/agenda/cliente', function () {
    return view('paginas.agenda_cliente');
});
// Rutas para las páginas de perfiles
Route::get('/perfil/administrador', function () {
    return view('paginas.perfil_administrador');
});

Route::get('/perfil/barbero', function () {
    return view('paginas.perfil_barbero');
});

Route::get('/perfil/cliente', function () {
    return view('paginas.perfil_cliente');
});

Route::get('/perfil/faciales', function () {
    return view('paginas.perfil_faciales');
});

// Otras páginas como registro y login
Route::get('/registro', function () {
    return view('paginas.registro');
});

Route::get('/login', function () {
    return view('paginas.login');
});

// Página para agendar citas
Route::get('/agendar/cita', function () {
    return view('paginas.agendar_cita');
});