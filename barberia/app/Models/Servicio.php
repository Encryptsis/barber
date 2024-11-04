<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nombre_servicio',
        'descripcion_servicio',
        'precio',
        'duracion'
    ];

    // Especifica el nombre exacto de la tabla y la clave primaria
    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';

    // Relación muchos a muchos con Cita a través de cita_servicio
    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'cita_servicio', 'id_servicio', 'id_cita')
                    ->withPivot('cantidad', 'costo', 'duracion');
    }

    // Relación muchos a muchos con Usuario a través de barbero_servicio
    public function barberos()
    {
        return $this->belongsToMany(Usuario::class, 'barbero_servicio', 'id_servicio', 'id_usuario_barbero');
    }
}
