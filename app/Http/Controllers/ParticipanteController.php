<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ParticipanteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ParticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $participantes = Participante::all();

        return view('participante.index', compact('participantes'))
            ->with('i', 0);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $participante = new Participante();

        return view('participante.create', compact('participante'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParticipanteRequest $request)
    {
        $request->validate([
            'imagen_qr' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('imagen_qr');

        // Crear el participante primero para obtener su ID
        $participante = Participante::create($data);

        // Manejar la subida de la imagen QR
        if ($request->hasFile('imagen_qr')) {
            $imagen = $request->file('imagen_qr');
            $extension = $imagen->getClientOriginalExtension();
            
            // Codificar nombre: qr_ID_HASH(nombre+celular).extension
            $hash = substr(md5($participante->nombre . $participante->celular), 0, 8);
            $nombreImagen = 'qr_' . $participante->id . '_' . $hash . '.' . $extension;
            
            $ruta = $imagen->storeAs('qr_participantes', $nombreImagen, 'public');
            $participante->qr = $ruta;
            $participante->save();
        }

        return Redirect::route('participantes.index')
            ->with('success', 'Participante creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $participante = Participante::find($id);

        return view('participante.show', compact('participante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $participante = Participante::find($id);

        return view('participante.edit', compact('participante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParticipanteRequest $request, Participante $participante): RedirectResponse
    {
        $request->validate([
            'imagen_qr' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->validated();

        // Manejar la subida de la nueva imagen QR
        if ($request->hasFile('imagen_qr')) {
            // Eliminar la imagen anterior si existe
            if ($participante->qr && Storage::disk('public')->exists($participante->qr)) {
                Storage::disk('public')->delete($participante->qr);
            }

            $imagen = $request->file('imagen_qr');
            $extension = $imagen->getClientOriginalExtension();
            
            // Codificar nombre: qr_ID_HASH(nombre+celular).extension
            $nombre = $request->input('nombre', $participante->nombre);
            $celular = $request->input('celular', $participante->celular);
            $hash = substr(md5($nombre . $celular), 0, 8);
            $nombreImagen = 'qr_' . $participante->id . '_' . $hash . '.' . $extension;
            
            $ruta = $imagen->storeAs('qr_participantes', $nombreImagen, 'public');
            $data['qr'] = $ruta;
        }

        $participante->update($data);

        return Redirect::route('participantes.index')
            ->with('success', 'Participante actualizado correctamente');
    }

    public function destroy($id): RedirectResponse
    {
        $participante = Participante::find($id);
        
        // Eliminar la imagen QR si existe
        if ($participante->qr && Storage::disk('public')->exists($participante->qr)) {
            Storage::disk('public')->delete($participante->qr);
        }
        
        $participante->delete();

        return Redirect::route('participantes.index')
            ->with('success', 'Participante eliminado correctamente');
    }
}
