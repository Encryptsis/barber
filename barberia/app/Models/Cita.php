<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cita extends Model
{
    use HasFactory;

    // Especificar el nombre correcto de la tabla
    protected $primaryKey = 'id_cita';

    protected $table = 'cita';

    // Desactivar los timestamps automáticos
    public $timestamps = false;

    protected $fillable = [
        'id_usuario_cliente',
        'fecha',
        'hora_reserva',
        'hora_termino',
        'metodo_pago',
        'costo_total',
        'id_usuario_barbero',
        'anticipo',
    ];

    // Definimos la relación con el modelo Servicio
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cita_servicio', 'id_cita', 'id_servicio');
    }


    // Sobrescribimos el método save para ajustar los valores antes de guardar
    public function save(array $options = [])
    {
        // Calculamos `hora_termino` sumando una duración predeterminada a `hora_reserva`
        if (!$this->hora_termino && $this->hora_reserva) {
            $this->hora_termino = Carbon::parse($this->hora_reserva)->addMinutes($this->calculateDuration());
        }

        // Ajustamos `costo_total` y `anticipo` si no están establecidos
        if (!$this->costo_total) {
            $this->costo_total = $this->calculateCostoTotal();
        }
        if (!$this->anticipo) {
            $this->anticipo = $this->calculateAnticipo();
        }

        // Llamamos al método save del padre (Model) para guardar los cambios
        parent::save($options);
    }

    // Método para calcular la duración total de la cita (en minutos)
    private function calculateDuration()
    {
        // Verifica si la cita tiene servicios asociados, de ser así, calcula la duración total
        if ($this->servicios()->exists()) {
            return $this->servicios->sum(function ($servicio) {
                return $servicio->pivot->duracion * $servicio->pivot->cantidad;
            });
        }

        // Valor predeterminado en caso de que no tenga servicios
        return 30; // Puedes ajustar este valor según tus necesidades
    }

    // Método para calcular el costo total de la cita
    private function calculateCostoTotal()
    {
        // Si la cita tiene servicios, calcula el costo total sumando los costos de cada servicio
        if ($this->servicios()->exists()) {
            return $this->servicios->sum(function ($servicio) {
                return $servicio->pivot->costo * $servicio->pivot->cantidad;
            });
        }

        // Valor predeterminado en caso de que no tenga servicios
        return 50.00; // Ajusta este valor según tus necesidades
    }

    // Método para calcular el anticipo basado en el costo total
    private function calculateAnticipo()
    {
        // Calcula el anticipo como el 20% del costo total
        return $this->costo_total * 0.2;
    }
}
