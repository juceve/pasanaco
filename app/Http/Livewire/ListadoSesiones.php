<?php

namespace App\Http\Livewire;

use App\Models\Modo;
use App\Models\Sesion;
use App\Models\Sesioncronograma;
use App\Models\Sesionparticipante;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ListadoSesiones extends Component
{
    public function render()
    {
        $sesions = Sesion::where('estado', '!=', 'ANULADO')->get();
        return view('livewire.listado-sesiones', compact('sesions'))->extends('layouts.app');
    }

    protected $listeners = ['anularSesion' => 'anular','clonarSesion' => 'clonar'];

    public function anular($id)
    {
        $sesion = Sesion::find($id);
        if ($sesion && $sesion->estado !== 'ANULADO') {
            $sesion->estado = 'ANULADO';
            $sesion->save();
            return redirect()->route('sesiones.listado')->with('success', 'Sesión anulada exitosamente.');
            //
        } else {
            $this->emit('error', 'La sesión ya está anulada o no existe.');
        }
    }

    public function clonar($id, $nuevoNombre, $nuevaFecha)
    {
        $sesion = Sesion::find($id);
        if (!$sesion) {
            $this->emit('error', 'La sesión no existe.');
            return;
        }

        DB::beginTransaction();
        try {
            // Crear la nueva sesión
            $nuevaSesion = $sesion->replicate();
            $nuevaSesion->nombre_sesion = $nuevoNombre;
            $nuevaSesion->fecha_inicio = $nuevaFecha;
            $nuevaSesion->estado = 'CREADO';
            $nuevaSesion->save();

            // Clonar participantes
            foreach ($sesion->sesionparticipantes as $participante) {
                Sesionparticipante::create([
                    'sesion_id' => $nuevaSesion->id,
                    'participante_id' => $participante->participante_id,
                    'sesioncronograma_id' => null // Se asignará después del sorteo
                ]);
            }

            // Generar cronograma con la nueva fecha
            $cronogramaFechas = $this->generarCronograma($nuevaSesion);
            
            foreach ($cronogramaFechas as $fecha) {
                Sesioncronograma::create([
                    'sesion_id' => $nuevaSesion->id,
                    'fecha' => $fecha,
                ]);
            }

            DB::commit();
            return redirect()->route('sesiones.listado')->with('success', 'Sesión clonada exitosamente con el nombre: ' . $nuevoNombre);
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('error', 'Error al clonar la sesión: ' . $e->getMessage());
        }
    }

    private function generarCronograma($sesion)
    {
        $modo = Modo::find($sesion->modo_id);
        $cantParticipantes = $sesion->sesionparticipantes()->count();

        $cronograma = [];
        $fechaActual = Carbon::parse($sesion->fecha_inicio);

        for ($i = 0; $i < $cantParticipantes; $i++) {
            $cronograma[] = $fechaActual->format('Y-m-d');

            // Calcular la siguiente fecha basada en el intervalo del modo
            switch ($modo->intervalo) {
                case 'days':
                    $fechaActual->addDays($modo->cantidad_intervalo);
                    break;
                case 'weeks':
                    $fechaActual->addWeeks($modo->cantidad_intervalo);
                    break;
                case 'months':
                    $fechaActual->addMonths($modo->cantidad_intervalo);
                    break;
                case 'years':
                    $fechaActual->addYears($modo->cantidad_intervalo);
                    break;
            }
        }

        return $cronograma;
    }
}
