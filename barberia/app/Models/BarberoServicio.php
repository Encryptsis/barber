<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberoServicio extends Model
{
    use HasFactory;

    // Nombre explícito de la tabla
    protected $table = 'barbero_servicio';

    // Desactivar timestamps
    public $timestamps = false;

     // Definir clave primaria compuesta
     protected $primaryKey = ['id_usuario_barbero', 'id_servicio'];
     public $incrementing = false;
     
    // Especifica los atributos que pueden ser asignados masivamente, si es necesario
    protected $fillable = [
        'id_usuario_barbero',
        'id_servicio'
    ];
}
