<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function administrador() {
        return view('paginas.perfil_administrador');
    }

    public function barbero() {
        return view('paginas.perfil_barbero');
    }

    public function cliente() {
        return view('paginas.perfil_cliente');
    }

    public function faciales() {
        return view('paginas.perfil_faciales');
    }
}
