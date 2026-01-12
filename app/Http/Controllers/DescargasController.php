<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use Illuminate\Http\Request;

class DescargasController extends Controller
{     public function descargarQr($sesion_id) {
        $sesion = Sesion::find($sesion_id);
        return view('qr-sesion',compact('sesion'));
    }
}
