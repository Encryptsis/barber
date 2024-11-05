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
            'usuario' => 'required|unique:usuario,usuario',
            'clave' => 'required|min:8',
            'nombre_completo' => 'required',
            'telefono' => 'required|unique:usuario,telefono',
            'correo_cliente' => 'required|email|unique:usuario,correo_cliente'
        ]);

        // Crear el usuario y guardar en la base de datos
        Usuario::create([
            'usuario' => $request->usuario,
            'clave' => Hash::make($request->clave),
            'nombre_completo' => $request->nombre_completo,
            'telefono' => $request->telefono,
            'correo_cliente' => $request->correo_cliente,
            'activo' => true, // o el valor que prefieras
            'id_rol' => 4 // Asegúrate de asignar un rol válido
        ]);

        return redirect('/')->with('success', 'Usuario registrado con éxito');
    }

}
