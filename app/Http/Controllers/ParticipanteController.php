<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ParticipanteRequest;
use Illuminate\Support\Facades\Redirect;
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
            'nombre' => 'required|string|max:255',
            'celular' => 'required|string|max:20',
            'email' => 'nullable|email|unique:participantes,email',
            
        ]);
        Participante::create($request->all());

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
        $participante->update($request->validated());

        return Redirect::route('participantes.index')
            ->with('success', 'Participante updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Participante::find($id)->delete();

        return Redirect::route('participantes.index')
            ->with('success', 'Participante deleted successfully');
    }
}
