<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    public $timestamps = false; // Desactiva las marcas de tiempo
    protected $table = 'rol'; // Nombre exacto de la tabla
    protected $primaryKey = 'id_rol'; // Nombre correcto de la clave primaria

    protected $fillable = [
        'nombre_rol',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_rol');
    }
}
