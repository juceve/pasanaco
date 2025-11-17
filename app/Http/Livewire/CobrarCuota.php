<?php

namespace App\Http\Livewire;

use App\Models\Participante;
use App\Models\Sesion;
use App\Models\Sesioncronograma;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

class CobrarCuota extends Component
{
    use WithFileUploads;

    public $sesion, $procesando = false, $cronogramaSel, $qrcobro, $sesion_id;

    public function mount($id)
    {
        $this->sesion_id = $id;
        $this->sesion = Sesion::findOrFail($id);
        if ($this->sesion->estado === 'CREADO' || $this->sesion->estado === 'ANULADO') {
            return redirect()->route('sesiones.listado')->with('error', 'La sesión se encuentra en estado No Valido.');
        }
    }

    public function render()
    {
        return view('livewire.cobrar-cuota')->extends('layouts.app');
    }

    public function openModalCobros(Sesioncronograma $cronograma, $i)
    {
        $this->cronogramaSel = $cronograma;
        // dd($cronograma->sesion->sesionparticipantes);
        $this->emit('openModalCobros', $i);
    }

    public function uploadQr()
    {
        $this->validate([
            'qrcobro' => 'required'
        ]);
        DB::beginTransaction();
        try {
            // Obtener la extensión original
            $extension = $this->qrcobro->getClientOriginalExtension();

            // Crear nombre único: id + timestamp
            $filename = auth()->id() . '_' . now()->format('Ymd_His') . '.' . $extension;

            // Guardar en storage/app/public/qr_cobros
            $path = $this->qrcobro->storeAs('qr_cobros', $filename, 'public');

            if ($this->sesion) {
                $this->sesion->qrcobro = $path;
                $this->sesion->save();
            }
            DB::commit();
            // $this->emit('success', 'Qr subido con exito!');
            return redirect()->route('sesiones.cobrarcuota',$this->sesion->id)->with('success','Qr subido con exito');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->emit('error', 'Ha ocurrido un error.');
        }
    }
}
