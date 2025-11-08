<div>
    @section('template_title')
        Sesiones
    @endsection
    <div class="container fluid mb-3">
        <h5>Sesiones</h5>
    </div>

    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Listado de Sesiones
                            </span>
                            <div class="float-right">
                                <a href="{{ route('sesiones.form') }}" class="btn btn-primary btn-sm">Nuevo <i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover dataTable nowrap" style="font-size: 14px;">
                                <thead class="thead ">
                                    <tr>
                                        <th class="align-middle text-center">ID</th>

                                        <th class="align-middle">Nombre <br> Sesion</th>
                                        <th class="align-middle text-center">Fecha <br> Inicio</th>
                                        <th class="align-middle text-center">Estado</th>

                                        <th class="align-middle text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sesions as $sesion)
                                        <tr>
                                            <td class="text-center align-middle">{{ $sesion->id }}</td>

                                            <td class="align-middle">{{ $sesion->nombre_sesion }}</td>
                                            <td class="text-center align-middle">{{ $sesion->fecha_inicio }}</td>
                                            <td class="text-center align-middle">{{ $sesion->estado }}</td>

                                            <td class="text-end align-middle">
                                                @if ($sesion->estado === 'CREADO')
                                                    <a class="btn btn-sm btn-warning"
                                                        href="{{ route('sesiones.form', $sesion->id) }}"
                                                        title="Editar"><i class="fa fa-fw fa-edit"></i> </a>
                                                @else
                                                    <a class="btn btn-sm btn-warning disabled" href="#"><i
                                                            class="fa fa-fw fa-edit"></i> </a>
                                                @endif
                                                <a class="btn btn-sm btn-info"
                                                    href="{{ route('sesiones.sorteo', $sesion->id) }}"
                                                    title="Sorteo de Numeros">
                                                    <i class="fas fa-sort-numeric-up"></i>
                                                </a>
                                                <button class="btn btn-secondary btn-sm"
                                                    onclick='clonarSesion({{ $sesion->id }})' title="Clonar Registro">
                                                    <i class="fas fa-clone"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm"
                                                    onclick='anular({{ $sesion->id }})'
                                                    @if ($sesion->estado !== 'ANULADO') title="Anular" @else disabled title="Sesión ya Anulada" @endif>
                                                    <i class="fa fa-fw fa-trash"></i>
                                                </button>

                                                {{-- <form action="{{ route('sesions.destroy', $sesion->id) }}" method="POST"
                                                    class="delete" onsubmit="return false">
                                                    <a class="btn btn-sm btn-info "
                                                        href="{{ route('sesions.show', $sesion->id) }}"><i
                                                            class="fa fa-fw fa-eye"></i></a>
                                                   
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fa fa-fw fa-trash"></i></button>
                                                </form> --}}
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
@section('js')
    <script>
        function anular(id) {
            Swal.fire({
                title: '¿Estás seguro de anular esta sesión?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, anular',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('anularSesion', id);
                }
            });
        }

        function clonarSesion(id) {
            Swal.fire({
                title: 'Clonar Sesión',
                html: `
                    <div class="mb-3">
                        <label for="nuevo-nombre" class="form-label">Nuevo nombre de la sesión:</label>
                        <input type="text" id="nuevo-nombre" class="form-control" placeholder="Nombre de la nueva sesión">
                    </div>
                    <div class="mb-3">
                        <label for="nueva-fecha" class="form-label">Nueva fecha de inicio:</label>
                        <input type="date" id="nueva-fecha" class="form-control">
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Clonar Sesión',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                preConfirm: () => {
                    const nuevoNombre = document.getElementById('nuevo-nombre').value;
                    const nuevaFecha = document.getElementById('nueva-fecha').value;

                    if (!nuevoNombre) {
                        Swal.showValidationMessage('Por favor ingrese el nombre de la nueva sesión');
                        return false;
                    }

                    if (!nuevaFecha) {
                        Swal.showValidationMessage('Por favor seleccione la fecha de inicio');
                        return false;
                    }

                    return {
                        nombre: nuevoNombre,
                        fecha: nuevaFecha
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('clonarSesion', id, result.value.nombre, result.value.fecha);
                }
            });
        }
    </script>
@endsection
