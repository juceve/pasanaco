<div>
    @section('template_title')
        Formulario de Sesiones
    @endsection
    <div class="container fluid mb-3">
        <h5>Formulario de Sesiones</h5>
    </div>
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-body">
                        <div class="form-group mb-2 mb20">
                            <label for="nombre_sesion" class="form-label">{{ __('Nombre Sesión') }}</label>
                            <input type="text" name="nombre_sesion"
                                class="form-control text-uppercase @error('nombre_sesion') is-invalid @enderror"
                                wire:model.defer='nombre_sesion' id="nombre_sesion" placeholder="Nombre de Sesión"
                                oninput="this.value = this.value.toUpperCase()">
                            @error('nombre_sesion')
                                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                            @enderror

                        </div>
                        <div class="form-group mb-2 mb20">
                            <label for="fecha_inicio" class="form-label">{{ __('Fecha Inicio') }}</label>
                            <input type="date" name="fecha_inicio"
                                class="form-control @error('fecha_inicio') is-invalid @enderror"
                                wire:model.defer='fecha_inicio' id="fecha_inicio" placeholder="Fecha Inicio">
                            @error('fecha_inicio')
                                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                            @enderror
                        </div>
                        <div class="form-group mb-2 mb20">
                            <label for="cuota" class="form-label">{{ __('Cuota') }}</label>
                            <input type="number" name="cuota" step="any"
                                class="form-control @error('cuota') is-invalid @enderror" wire:model.defer='cuota'
                                id="cuota" placeholder="0.00">
                            @error('cuota')
                                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                            @enderror
                        </div>
                        <div class="form-group mb-2 mb20">
                            <label for="modo_id" class="form-label">Modalidad</label>
                            <select name="modo_id" id="modo_id" wire:model.defer='modo_id'
                                class="form-select @error('modo_id') is-invalid @enderror">
                                @foreach ($modos as $modo)
                                    <option value="{{ $modo->id }}">
                                        {{ $modo->nombre }}
                                    </option>
                                @endforeach
                            </select>

                            @error('modo_id')
                                <div class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="text-center">Adiciona Participantes</h5>
                        <div class="row g-2">
                            <div class="col-12 col-md-6 col-xl-7 mb-2">
                                <select wire:model="participanteId" class="form-select">
                                    <option value="">Seleccione un Participante</option>
                                    @foreach ($participantes as $participante)
                                        <option value="{{ $participante->id }}">
                                            {{ $participante->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-7 col-md-3 col-xl-5 mb-2">
                                <div class="input-group">
                                    <button class="btn btn-outline-secondary" type="button" id="btn-plus">+</button>
                                    <input type="number" class="form-control text-center" id="cantidad" min="0"
                                        max="100" value="1" wire:model="cantidad">
                                    <button class="btn btn-outline-secondary" type="button" id="btn-minus">−</button>

                                </div>
                            </div>
                            <div class="col-5 col-md-3 col-xl-7 d-grid mb-2">
                                <button class="btn btn-info" wire:click="addParticipante()">Agregar <i
                                        class="fas fa-arrow-down"></i></button>

                            </div>
                            <div class="col-12 col-xl-5 d-grid mb-2">
                                <button class="btn btn-outline-success" wire:click="addTodosParticipantes()">
                                    Agregar todos <i class="fas fa-check-double"></i>
                                    </button>

                            </div>
                            
                        </div>
                        
                        <div class="table-responsive mt-1">
                            @error('arrayParticipantes')
                                <small class="text-danger"><i class="fas fa-exclamation-circle"></i> Debe seleccionar al menos un participante.</small>
                            @enderror
                            @if (count($arrayParticipantes))
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Participantes Agregados</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($arrayParticipantes as $item)
                                            <tr>
                                                <td class="align-middle">{{ $loop->iteration }}</td>
                                                <td class="align-middle">{{ $item['nombre'] }}</td>
                                                <td class="align-middle">
                                                    <button class="btn btn-sm btn-danger" title="Quitar"
                                                        wire:click="removeParticipante({{ $loop->index }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="row">
                    <div class="col-12 col-md-6 d-grid mb-2">
                        <button onclick="registrarSesion()" class="btn btn-primary py-2">Guardar <i
                                class="fas fa-save"></i></button>
                    </div>
                    <div class="col-12 col-md-6 d-grid mb-2">
                        <a class="btn btn-secondary py-2" href="{{ route('sesiones.listado') }}"> <i
                                class="fas fa-arrow-left"></i> Volver</a>
                    </div>


                </div>



            </div>
        </div>
    </section>
</div>
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const minusBtn = document.getElementById('btn-minus');
            const plusBtn = document.getElementById('btn-plus');
            const input = document.getElementById('cantidad');

            minusBtn.addEventListener('click', () => {
                let value = parseInt(input.value) || 0;
                if (value > parseInt(input.min)) input.value = value - 1;
                @this.set('cantidad', input.value);
            });

            plusBtn.addEventListener('click', () => {
                let value = parseInt(input.value) || 0;
                if (value < parseInt(input.max)) input.value = value + 1;
                @this.set('cantidad', input.value);
            });
        });
    </script>
    <script>
        function registrarSesion() {
            Swal.fire({
                title: "REGISTRAR SESIÓN",
                text: "¿Está seguro de realizar esta operación?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, registrar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('save');
                }
            });
        }
    </script>
@endsection
