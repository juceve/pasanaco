<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

 
    public function index()
    {
        // Obtener estadísticas para el dashboard
        $participantes = \App\Models\Participante::count();
        $sesiones = \App\Models\Sesion::where('estado', '!=', 'ANULADO')->count();
         $sesionesActivas = \App\Models\Sesion::whereIn('estado', ['SORTEADO', 'EN_PROGRESO', 'CREADO'])->count();
        $totalUsuarios = \App\Models\User::count();

        // Sesiones recientes
        $sesionesRecientes = \App\Models\Sesion::where([['estado', '!=', 'ANULADO'], ['estado', '!=', 'CREADO'], ['estado', '!=', 'FINALIZADO']])
            ->orderBy('id', 'asc')            
            ->get();

        // Próximos sorteos (sesiones activas sin sorteo realizado)
        $proximosSorteos = \App\Models\Sesion::where('estado', 'CREADO')                      
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

    public function descargarQr($sesion_id) {
        $sesion = Sesion::find($sesion_id);
        return view('qr-sesion',compact('sesion'));
    }
}
