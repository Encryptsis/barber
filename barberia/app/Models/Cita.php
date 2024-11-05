<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use Exception;
use Carbon\Carbon;

class Cita extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cita';
    protected $table = 'cita';
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

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'cita_servicio', 'id_cita', 'id_servicio')
                    ->withPivot('cantidad', 'costo', 'duracion');
    }

    // Método para agregar servicios automáticamente después de crear una cita
    public function asignarServicios(array $servicios)
    {
        $serviciosData = [];
        foreach ($servicios as $servicio) {
            $servicioInfo = Servicio::find($servicio['id_servicio']);
            $serviciosData[$servicio['id_servicio']] = [
                'cantidad' => $servicio['cantidad'],
                'costo' => $servicioInfo->precio,
                'duracion' => $servicioInfo->duracion,
            ];
        }
        // Asociar servicios a la cita
        $this->servicios()->attach($serviciosData);
    }

    public function save(array $options = [])
        {   
        // Verificar que el usuario que solicita la cita sea un cliente
        if ($this->id_usuario_cliente) {
            $cliente = Usuario::find($this->id_usuario_cliente);
            if (!$cliente || $cliente->rol->nombre_rol !== 'Cliente') {
                throw new Exception('Solo los usuarios con el rol de Cliente pueden crear citas.');
            }
        }

        // Verificar el rol del barbero antes de guardar
        if ($this->id_usuario_barbero) {
            $barbero = Usuario::find($this->id_usuario_barbero);
            if (!$barbero || !in_array($barbero->rol->nombre_rol, ['Barbero', 'Administrador'])) {
                throw new Exception('El usuario seleccionado no tiene el rol de Barbero o Administrador.');
            }
        }

        // Ajustar la hora_termino y otros cálculos necesarios
        if (!$this->hora_termino && $this->hora_reserva) {
            $this->hora_termino = Carbon::parse($this->hora_reserva)->addMinutes($this->calculateDuration());
        }
        if (!$this->costo_total) {
            $this->costo_total = $this->calculateCostoTotal();
        }
        if (!$this->anticipo) {
            $this->anticipo = $this->calculateAnticipo();
        }

        return parent::save($options);
    }

    private function calculateDuration()
    {
        if ($this->servicios()->exists()) {
            return $this->servicios->sum(function ($servicio) {
                return $servicio->pivot->duracion * $servicio->pivot->cantidad;
            });
        }
        return 30;
    }

    private function calculateCostoTotal()
    {
        if ($this->servicios()->exists()) {
            return $this->servicios->sum(function ($servicio) {
                return $servicio->pivot->costo * $servicio->pivot->cantidad;
            });
        }
        return 50.00;
    }

    private function calculateAnticipo()
    {
        return $this->costo_total * 0.2;
    }
}
