<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'usuario' => 'required|unique:usuario',
            'clave' => 'required|min:8',
            'nombre_cliente' => 'required',
            'numero_cliente' => 'required',
            'correo_cliente' => 'required|email|unique:usuario'
        ]);

        // Crear el usuario y guardar en la base de datos
        Usuario::create([
            'usuario' => $request->usuario,
            'clave' => Hash::make($request->clave),
            'nombre_cliente' => $request->nombre_cliente,
            'numero_cliente' => $request->numero_cliente,
            'correo_cliente' => $request->correo_cliente,
            'activo' => true // o el valor que prefieras
        ]);

        return redirect('/')->with('success', 'Usuario registrado con éxito');
    }
}
