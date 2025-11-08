<?php

namespace App\Http\Livewire;

use App\Models\Sesion;
use App\Models\Sesioncronograma;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OperativaSesion extends Component
{
    public $sesion, $procesando = false;

    public function mount($id)
    {
        $this->sesion = Sesion::findOrFail($id);
        if ($this->sesion->estado === 'CREADO' || $this->sesion->estado === 'FINALIZADO' || $this->sesion->estado === 'ANULADO') {
            return redirect()->route('sesiones.listado')->with('error', 'La sesión se encuentra en estado No Valido.');
        }
    }
    public function render()
    {
        return view('livewire.operativa-sesion')->extends('layouts.app');
    }

    protected $listeners = [
        'entregarPasanaco',
    ];

    public function entregarPasanaco($cronogramaId, $montoEntregado, $fechaPago, $observaciones)
    {
        if ($this->procesando) {
            return;
        }
        $this->procesando = true;
        DB::beginTransaction();
        try {
            $cronograma = Sesioncronograma::find($cronogramaId);
            if ($cronograma && !$cronograma->procesado) {
                $cronograma->monto_entregado = $montoEntregado;
                $cronograma->observaciones = (!empty(trim($observaciones))) ? trim($observaciones) : null;
                $cronograma->fecha_pago = $fechaPago;
                $cronograma->procesado = true;
                $cronograma->save();
                $this->sesion->refresh();
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'ENTREGA EXITOSA',
                    'text' => 'El monto ha sido entregado correctamente.',
                    'icon' => 'success',
                ]);
            } else {
                $this->emit('error', "Ha ocurrido un error.");
                return;
            }
            DB::commit();
            $this->procesando = false;
            $this->emit('success', 'Entrega registrada con exito.');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->procesando = false;
            $this->emit('error', "Ha ocurrido un error: " . $th->getMessage());
        }
    }
}
