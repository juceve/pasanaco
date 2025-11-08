@extends('layouts.app')

@section('template_title')
    {{ $participante->name ?? __('Show') . ' ' . __('Participante') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Participante</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('participantes.index') }}"><i
                                    class="fas fa-arrow-left"></i> Volver</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">

                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $participante->nombre }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Celular:</strong>
                            {{ $participante->celular }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Email:</strong>
                            {{ $participante->email }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Estado:</strong>
                            @if ($participante->estado)
                                <span class="badge bg-primary rounded-pill">Activo</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Inactivo</span>
                            @endif
                        </div>
                        @if ($participante->qr)
                            <div class="form-group">
                                <strong>QR Code:</strong>
                                <br>
                                <img src="{{ asset('storage/' . $participante->qr) }}" alt="QR Code" class="img-fluid">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
