<?php

namespace App\Http\Livewire;

use App\Models\Modo;
use App\Models\Participante;
use App\Models\Sesion;
use App\Models\Sesioncronograma;
use App\Models\Sesionparticipante;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormSesion extends Component
{
    use WithFileUploads;
    public $nombre_sesion = '', $fecha_inicio = '', $cuota = '', $modo_id = 1, $sesion = null, $sesion_id = null, $qrcobro;
    public $arrayParticipantes = [], $participanteId = '', $cantidad = 1;
    public $procesando = false;

    protected $listeners = ['save'];

    public function mount($id = null)
    {
        if ($id) {
            $this->sesion_id = $id;
            $this->sesion = Sesion::find($id);
            $this->nombre_sesion = $this->sesion->nombre_sesion;
            $this->fecha_inicio = $this->sesion->fecha_inicio;
            $this->cuota = $this->sesion->cuota;
            $this->modo_id = $this->sesion->modo_id;

            foreach ($this->sesion->sesionparticipantes as $item) {
                $this->arrayParticipantes[] = array("id" => $item->participante_id, "nombre" => $item->participante->nombre);
            }
        }
    }

    public function render()
    {
        $modos = \App\Models\Modo::all();
        $participantes = \App\Models\Participante::all();

        return view('livewire.form-sesion', compact('modos', 'participantes'))->extends('layouts.app');
    }

    public function save()
    {
        if ($this->procesando) {
            return;
        }

        $this->procesando = true;

        $validatedData = $this->validate([
            'nombre_sesion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'cuota' => 'required|numeric',
            'modo_id' => 'required|exists:modos,id',
            'arrayParticipantes' => 'required|array|min:1',
            'arrayParticipantes.*.id' => 'required|exists:participantes,id',
        ], [
            'arrayParticipantes.min' => 'Debe seleccionar al menos un participante.',
        ]);

        DB::beginTransaction();
        try {
            if ($this->sesion) {
                $this->sesion->update($validatedData);
                Sesionparticipante::where('sesion_id', $this->sesion->id)->delete();
                foreach ($this->arrayParticipantes as $item) {
                    Sesionparticipante::create([
                        'sesion_id' => $this->sesion->id,
                        'participante_id' => $item['id'],
                    ]);
                }
                $cronogramaFechas = $this->traeCronograma();
                Sesioncronograma::where('sesion_id', $this->sesion->id)->delete();
                foreach ($cronogramaFechas as $fecha) {
                    Sesioncronograma::create([
                        'sesion_id' => $this->sesion->id,
                        'fecha' => $fecha,
                    ]);
                }
            } else {
                $sesion = Sesion::create($validatedData);

                foreach ($this->arrayParticipantes as $item) {
                    Sesionparticipante::create([
                        'sesion_id' => $sesion->id,
                        'participante_id' => $item['id'],
                    ]);
                }

                $cronogramaFechas = $this->traeCronograma();

                foreach ($cronogramaFechas as $fecha) {
                    Sesioncronograma::create([
                        'sesion_id' => $sesion->id,
                        'fecha' => $fecha,
                    ]);
                }
            }

            if ($this->qrcobro) {
                // Obtener la extensión original
                $extension = $this->qrcobro->getClientOriginalExtension();

                // Crear nombre único: id + timestamp
                $filename = auth()->id() . '_' . now()->format('Ymd_His') . '.' . $extension;

                // Guardar en storage/app/public/qr_cobros
                $path = $this->qrcobro->storeAs('qr_cobros', $filename,'public');

                if ($this->sesion) {
                    $this->sesion->qrcobro = $path;
                    $this->sesion->save();
                } else {
                    $sesion->qrcobro=$path;
                    $sesion->save();
                }
                
            }

            DB::commit();
            return redirect()->route('sesiones.listado')->with('success', 'Sesión guardada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sesiones.form', ['id' => $this->sesion_id])->with('error', 'Error al guardar la sesión.');
        }
    }

    private function traeCronograma()
    {
        $modo = Modo::find($this->modo_id);
        // $cantParticipantes = count($request->participantes ?? []);
        $cantParticipantes = count($this->arrayParticipantes);

        $cronograma = [];
        $fechaActual = Carbon::parse($this->fecha_inicio);

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

    public function addParticipante()
    {
        if ($this->participanteId === '' || $this->cantidad < 1) {
            $this->emit('error', 'Seleccione un participante e ingrese una cantidad válida.');
            return;
        }

        $tempParticipante = Participante::find($this->participanteId);
        for ($i = 0; $i < $this->cantidad; $i++) {
            $this->arrayParticipantes[] = array("id" => $tempParticipante->id, "nombre" => $tempParticipante->nombre);
        }
        $this->reset(['participanteId', 'cantidad']);
    }

    public function addTodosParticipantes()
    {
        // Limpiar el array actual
        $this->arrayParticipantes = [];

        // Obtener todos los participantes
        $participantes = Participante::all();

        // Agregar cada participante una vez al array
        foreach ($participantes as $participante) {
            $this->arrayParticipantes[] = array(
                "id" => $participante->id,
                "nombre" => $participante->nombre
            );
        }

        // Limpiar las selecciones actuales
        $this->reset(['participanteId', 'cantidad']);

        // Emitir mensaje de éxito
        $this->emit('success', 'Se agregaron todos los participantes (' . count($participantes) . ' participantes).');
    }

    public function removeParticipante($index)
    {
        unset($this->arrayParticipantes[$index]);
        $this->arrayParticipantes = array_values($this->arrayParticipantes);
    }
}
