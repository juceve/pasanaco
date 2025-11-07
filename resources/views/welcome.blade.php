@extends('layouts.app')
@section('content')
    <div class="container">
        <!-- Portfolio Section Heading-->
        <h5 class="text-center text-uppercase text-secondary mb-0">Sesiones Activas</h5>       
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped" style="font-size: 12px;">
                <thead class="bg-primary text-white">
                    <tr class="text-center">
                        <th>Nombre de la Sesión</th>
                       <th>Inicio</th>
                        <th>Cant. Participantes</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
