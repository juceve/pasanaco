<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SesionRequest;
use App\Models\Modo;
use App\Models\Participante;
use App\Models\Sesioncronograma;
use App\Models\Sesionparticipante;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Carbon\Carbon;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sesions = Sesion::where('estado', '!=', 'ANULADO')->get();

        return view('sesion.index', compact('sesions'))
            ->with('i', 0);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $sesion = new Sesion();
        $modos = Modo::all();
        $estados = Sesion::getEstados();
        $participantes = Participante::where('estado', 1)->get();
        return view('sesion.create', compact('sesion', 'modos', 'estados', 'participantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SesionRequest $request): RedirectResponse
    {
        $request->validate([
            "nombre_sesion" => 'required|string',
            "fecha_inicio" => 'required|date',
            "modo_id" => 'required|exists:modos,id',
            "cuota" => 'required|numeric',
            "participantes" => 'array',
            "participantes.*" => 'exists:participantes,id',
        ]);

        $sesion = Sesion::create([
            'nombre_sesion' => $request->nombre_sesion,
            'fecha_inicio' => $request->fecha_inicio,
            'cuota' => $request->cuota,
            'modo_id' => $request->modo_id,
        ]);

        $modo = Modo::find($sesion->modo_id);
        $cantParticipantes = count($request->participantes ?? []);

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

        foreach ($cronograma as $fecha) {
            Sesioncronograma::create([
                'sesion_id' => $sesion->id,
                'fecha' => $fecha,
            ]);
        }

        // Guardar los participantes seleccionados
        if ($request->has('participantes') && is_array($request->participantes)) {
            foreach ($request->participantes as $participanteId) {
                Sesionparticipante::create([
                    'sesion_id' => $sesion->id,
                    'participante_id' => $participanteId,
                ]);
            }
        }

        return Redirect::route('sesions.index')
            ->with('success', 'Sesion creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $sesion = Sesion::find($id);

        return view('sesion.show', compact('sesion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $sesion = Sesion::find($id);
        $modos = Modo::all();
        $estados = Sesion::getEstados();
        $participantes = Participante::where('estado', 1)->get();

        // Obtener los participantes actualmente seleccionados para esta sesión
        $sesionParticipantes = $sesion->sesionparticipantes()->pluck('participante_id')->toArray();

        return view('sesion.edit', compact('sesion', 'modos', 'estados', 'participantes', 'sesionParticipantes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SesionRequest $request, Sesion $sesion): RedirectResponse
    {
        $sesion->update($request->validated());

        // Actualizar los participantes
        // Primero eliminar los participantes actuales
        Sesionparticipante::where('sesion_id', $sesion->id)->delete();

        // Luego agregar los nuevos participantes seleccionados
        if ($request->has('participantes') && is_array($request->participantes)) {
            foreach ($request->participantes as $participanteId) {
                Sesionparticipante::create([
                    'sesion_id' => $sesion->id,
                    'participante_id' => $participanteId,
                ]);
            }
        }

        return Redirect::route('sesions.index')
            ->with('success', 'Sesion updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Sesion::find($id)->delete();

        return Redirect::route('sesions.index')
            ->with('success', 'Sesion deleted successfully');
    }

    /**
     * Genera un cronograma de fechas basado en el modo y fecha inicial
     */
    private function generarCronograma($fechaInicial, $modoId, $cantidadFechas = 5)
    {
        $modo = Modo::find($modoId);
        if (!$modo) {
            return [];
        }

        $cronograma = [];
        $fechaActual = Carbon::parse($fechaInicial);

        for ($i = 0; $i < $cantidadFechas; $i++) {
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

    /**
     * Guarda el cronograma en la tabla sesioncronogramas
     */
    private function guardarCronograma($sesionId, $cronograma)
    {
        foreach ($cronograma as $fecha) {
            Sesioncronograma::create([
                'sesion_id' => $sesionId,
                'fecha' => $fecha,
                'procesado' => false
            ]);
        }
    }

    /**
     * Obtiene el cronograma de una sesión específica
     */
    public function obtenerCronograma($sesionId)
    {
        return Sesioncronograma::where('sesion_id', $sesionId)
            ->orderBy('fecha', 'asc')
            ->get();
    }

    /**
     * Función pública para generar cronograma (útil para testing o uso externo)
     */
    public function generarCronogramaPublico($fechaInicial, $modoId, $cantidadFechas = 5)
    {
        return $this->generarCronograma($fechaInicial, $modoId, $cantidadFechas);
    }
}
