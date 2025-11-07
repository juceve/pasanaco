<?php

namespace App\Http\Livewire;

use App\Models\Participante;
use App\Models\Sesion;
use App\Models\Sesionparticipante;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SorteoSesion extends Component
{
    public $matrizNumeros = [], $participantes, $sesion, $cronograma, $procesando = false;

    protected $listeners = ['guardarSorteo'];

    public function mount($id)
    {
        $this->sesion = Sesion::find($id);
        $this->participantes = $this->sesion->sesionparticipantes;
        $this->cronograma = $this->sesion->sesioncronogramas->pluck('fecha');
    }

    public function render()
    {
        return view('livewire.sorteo-sesion')->extends('layouts.app');
    }

    public function realizarSorteo()
    {
        $this->reset('matrizNumeros');
        // Crear array de números disponibles para el sorteo
        $numerosDisponibles = range(1, $this->participantes->count());

        // Cargar la matriz con los datos solicitados
        foreach ($this->participantes as $participante) {
            // Seleccionar un número aleatorio de los disponibles
            $indiceAleatorio = array_rand($numerosDisponibles);
            $numeroSorteado = $numerosDisponibles[$indiceAleatorio];

            // Remover el número ya sorteado para evitar repeticiones
            unset($numerosDisponibles[$indiceAleatorio]);
            $numerosDisponibles = array_values($numerosDisponibles); // Reindexar array

            $this->matrizNumeros[] = [
                0 => $numeroSorteado, // número aleatorio único sorteado
                1 => $participante->participante->id,
                2 => $this->cronograma[$numeroSorteado - 1] ?? null,
                3 => $participante->participante->nombre // nombre del participante
            ];
        }

        // Ordenar la matriz por el número sorteado (índice 0) en orden ascendente
        usort($this->matrizNumeros, function ($a, $b) {
            return $a[0] <=> $b[0];
        });
    }

    public function intercambiarPosiciones($indice1, $indice2)
    {
        if (isset($this->matrizNumeros[$indice1]) && isset($this->matrizNumeros[$indice2])) {
            // Intercambiar solo los números de posición (índice 0) y las fechas (índice 2)
            $numeroTemp = $this->matrizNumeros[$indice1][0];
            $fechaTemp = $this->matrizNumeros[$indice1][2];

            $this->matrizNumeros[$indice1][0] = $this->matrizNumeros[$indice2][0];
            $this->matrizNumeros[$indice1][2] = $this->matrizNumeros[$indice2][2];

            $this->matrizNumeros[$indice2][0] = $numeroTemp;
            $this->matrizNumeros[$indice2][2] = $fechaTemp;

            // Reordenar por número después del intercambio
            usort($this->matrizNumeros, function ($a, $b) {
                return $a[0] <=> $b[0];
            });
        }
    }

    public function moverParticipante($participanteIndex, $nuevaPosicion)
    {
        if (isset($this->matrizNumeros[$participanteIndex]) && $nuevaPosicion >= 1 && $nuevaPosicion <= count($this->matrizNumeros)) {
            $posicionActual = $this->matrizNumeros[$participanteIndex][0];

            // Si la nueva posición es la misma que la actual, no hacer nada
            if ($posicionActual == $nuevaPosicion) {
                return;
            }

            // Buscar el participante que ocupa la nueva posición
            $indiceOcupante = null;
            foreach ($this->matrizNumeros as $index => $fila) {
                if ($fila[0] == $nuevaPosicion) {
                    $indiceOcupante = $index;
                    break;
                }
            }

            // Intercambiar posiciones y fechas
            if ($indiceOcupante !== null) {
                // El participante que se mueve toma la nueva posición
                $this->matrizNumeros[$participanteIndex][0] = $nuevaPosicion;
                $this->matrizNumeros[$participanteIndex][2] = $this->cronograma[$nuevaPosicion - 1] ?? null;

                // El participante que ocupaba esa posición toma la posición anterior
                $this->matrizNumeros[$indiceOcupante][0] = $posicionActual;
                $this->matrizNumeros[$indiceOcupante][2] = $this->cronograma[$posicionActual - 1] ?? null;
            }

            // Reordenar la matriz por número de posición
            usort($this->matrizNumeros, function ($a, $b) {
                return $a[0] <=> $b[0];
            });
        }
    }

    public function guardarSorteo()
    {
        if ($this->procesando) {
            return;
        }

        $this->procesando = true;
        DB::beginTransaction();
        try {
            // Obtener todos los cronogramas de la sesión ordenados por fecha
            $cronogramas = $this->sesion->sesioncronogramas()->orderBy('fecha')->get();
            
            foreach ($this->matrizNumeros as $fila) {
                $numeroSorteado = $fila[0];      // Posición en el sorteo
                $participanteId = $fila[1];      // ID del participante
                
                // Buscar el cronograma correspondiente a la posición sorteada
                $cronogramaCorrespondiente = $cronogramas->get($numeroSorteado - 1);
                
                if ($cronogramaCorrespondiente) {
                    // Buscar los registros de sesionparticipantes para este participante en esta sesión
                    $sesionparticipantes = $this->sesion->sesionparticipantes()
                        ->where('participante_id', $participanteId)
                        ->whereNull('sesioncronograma_id') // Solo los que no tienen cronograma asignado
                        ->orderBy('id')
                        ->get();
                    
                    // Si hay registros disponibles, actualizar el primero encontrado
                    if ($sesionparticipantes->count() > 0) {
                        $sesionparticipantes->first()->update([
                            'sesioncronograma_id' => $cronogramaCorrespondiente->id
                        ]);
                    } else {
                        // Si no hay registros sin asignar, buscar cualquier registro para actualizarlo
                        $sesionparticipante = $this->sesion->sesionparticipantes()
                            ->where('participante_id', $participanteId)
                            ->first();
                        
                        if ($sesionparticipante) {
                            $sesionparticipante->update([
                                'sesioncronograma_id' => $cronogramaCorrespondiente->id
                            ]);
                        }
                    }
                }
            }
            $this->sesion->estado = 'SORTEADO';
            $this->sesion->save();
            
            DB::commit();
            $this->procesando = false;
            return redirect()->route('sesiones.sorteo', $this->sesion->id)->with('success', 'Sorteo guardado exitosamente.');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->procesando = false;
            $this->emit('error', 'Error al guardar el sorteo: ' . $th->getMessage());
        }
    }
}
