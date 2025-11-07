@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Participante
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('New') }} Participante</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('participantes.index') }}"><i class="fas fa-arrow-left"></i> Volver</a>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('participantes.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('participante.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
