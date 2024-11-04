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
