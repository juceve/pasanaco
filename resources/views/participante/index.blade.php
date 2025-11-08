@extends('layouts.app')

@section('template_title')
    Participantes
@endsection

@section('content')
    <div class="container fluid mb-3">
        <h5>Participantes</h5>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Listado de participantes
                            </span>

                            <div class="float-right">
                                <a href="{{ route('participantes.create') }}" class="btn btn-primary btn-sm float-right"
                                    data-placement="left">
                                    Nuevo <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover dataTable nowrap">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

                                        <th>Nombre</th>
                                        <th>Celular</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($participantes as $participante)
                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $participante->nombre }}</td>
                                            <td>{{ $participante->celular }}</td>

                                            <td class="text-end">
                                                <form action="{{ route('participantes.destroy', $participante->id) }}"
                                                    method="POST" class="delete" onsubmit="return false">
                                                    <a class="btn btn-sm btn-info "
                                                        href="{{ route('participantes.show', $participante->id) }}"
                                                        title="Ver Detalles">
                                                        <i class="fa fa-fw fa-eye"></i> </a>
                                                    <a class="btn btn-sm btn-warning"
                                                        href="{{ route('participantes.edit', $participante->id) }}"
                                                        title="Editar">
                                                        <i class="fa fa-fw fa-edit"></i> </a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete"
                                                        title="Eliminar">
                                                        <i class="fa fa-fw fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
