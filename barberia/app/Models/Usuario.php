<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario',
        'clave',
        'nombre_completo',
        'telefono',
        'correo_cliente',
        'foto_perfil',
        'activo',
        'id_rol'
    ];
    
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function citasCliente()
    {
        return $this->hasMany(Cita::class, 'id_usuario_cliente');
    }

    public function citasBarbero()
    {
        return $this->hasMany(Cita::class, 'id_usuario_barbero');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'barbero_servicio', 'id_usuario_barbero', 'id_servicio');
    }

    public function logs()
    {
        return $this->hasMany(Logs::class, 'usuario', 'usuario');
    }

    // En el modelo Usuario.php
    public function asignarServicios(array $servicios)
    {
        // Obtener el rol del usuario
        $rol = $this->rol->nombre_rol;

        // Verificar si el rol es "Barbero" o "Administrador"
        if ($rol !== 'Barbero' && $rol !== 'Administrador') {
            throw new \Exception("Solo los roles de Barbero o Administrador pueden tener servicios.");
        }

        // Si el rol es válido, asignar los servicios
        $this->servicios()->attach($servicios);
    }



}
