<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener estadísticas para el dashboard
        $participantes = \App\Models\Participante::count();
        $sesiones = \App\Models\Sesion::count();
        $sesionesActivas = \App\Models\Sesion::where('estado', 1)->count();
        $totalUsuarios = \App\Models\User::count();
        
        // Sesiones recientes
        $sesionesRecientes = \App\Models\Sesion::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Próximos sorteos (sesiones activas sin sorteo realizado)
        $proximosSorteos = \App\Models\Sesion::where('estado', 1)
            ->whereDoesntHave('sesioncronogramas')
            ->take(3)
            ->get();

        return view('home', compact(
            'participantes', 
            'sesiones', 
            'sesionesActivas', 
            'totalUsuarios',
            'sesionesRecientes',
            'proximosSorteos'
        ));
    }
}
