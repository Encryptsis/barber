<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function facial() {
        return view('paginas.agenda_Facial');
    }

    public function administrador() {
        return view('paginas.agenda_Administrador');
    }

    public function barbero() {
        return view('paginas.agenda_barbero');
    }

    public function cliente() {
        return view('paginas.agenda_cliente');
    }
}
