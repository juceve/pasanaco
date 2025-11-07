<?php

namespace App\Http\Controllers;

use App\Models\Modo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ModoRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ModoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $modos = Modo::paginate();

        return view('modo.index', compact('modos'))
            ->with('i', ($request->input('page', 1) - 1) * $modos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $modo = new Modo();

        return view('modo.create', compact('modo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ModoRequest $request): RedirectResponse
    {
        Modo::create($request->validated());

        return Redirect::route('modos.index')
            ->with('success', 'Modo created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $modo = Modo::find($id);

        return view('modo.show', compact('modo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $modo = Modo::find($id);

        return view('modo.edit', compact('modo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModoRequest $request, Modo $modo): RedirectResponse
    {
        $modo->update($request->validated());

        return Redirect::route('modos.index')
            ->with('success', 'Modo updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Modo::find($id)->delete();

        return Redirect::route('modos.index')
            ->with('success', 'Modo deleted successfully');
    }
}
