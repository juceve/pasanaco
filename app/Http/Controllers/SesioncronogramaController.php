<?php

namespace App\Http\Controllers;

use App\Models\Sesioncronograma;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SesioncronogramaRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SesioncronogramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sesioncronogramas = Sesioncronograma::paginate();

        return view('sesioncronograma.index', compact('sesioncronogramas'))
            ->with('i', ($request->input('page', 1) - 1) * $sesioncronogramas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $sesioncronograma = new Sesioncronograma();

        return view('sesioncronograma.create', compact('sesioncronograma'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SesioncronogramaRequest $request): RedirectResponse
    {
        Sesioncronograma::create($request->validated());

        return Redirect::route('sesioncronogramas.index')
            ->with('success', 'Sesioncronograma created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $sesioncronograma = Sesioncronograma::find($id);

        return view('sesioncronograma.show', compact('sesioncronograma'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $sesioncronograma = Sesioncronograma::find($id);

        return view('sesioncronograma.edit', compact('sesioncronograma'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SesioncronogramaRequest $request, Sesioncronograma $sesioncronograma): RedirectResponse
    {
        $sesioncronograma->update($request->validated());

        return Redirect::route('sesioncronogramas.index')
            ->with('success', 'Sesioncronograma updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Sesioncronograma::find($id)->delete();

        return Redirect::route('sesioncronogramas.index')
            ->with('success', 'Sesioncronograma deleted successfully');
    }
}
