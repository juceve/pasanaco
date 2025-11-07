<?php

namespace App\Http\Controllers;

use App\Models\Sesionparticipante;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SesionparticipanteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SesionparticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sesionparticipantes = Sesionparticipante::paginate();

        return view('sesionparticipante.index', compact('sesionparticipantes'))
            ->with('i', ($request->input('page', 1) - 1) * $sesionparticipantes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $sesionparticipante = new Sesionparticipante();

        return view('sesionparticipante.create', compact('sesionparticipante'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SesionparticipanteRequest $request): RedirectResponse
    {
        Sesionparticipante::create($request->validated());

        return Redirect::route('sesionparticipantes.index')
            ->with('success', 'Sesionparticipante created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $sesionparticipante = Sesionparticipante::find($id);

        return view('sesionparticipante.show', compact('sesionparticipante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $sesionparticipante = Sesionparticipante::find($id);

        return view('sesionparticipante.edit', compact('sesionparticipante'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SesionparticipanteRequest $request, Sesionparticipante $sesionparticipante): RedirectResponse
    {
        $sesionparticipante->update($request->validated());

        return Redirect::route('sesionparticipantes.index')
            ->with('success', 'Sesionparticipante updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Sesionparticipante::find($id)->delete();

        return Redirect::route('sesionparticipantes.index')
            ->with('success', 'Sesionparticipante deleted successfully');
    }
}
