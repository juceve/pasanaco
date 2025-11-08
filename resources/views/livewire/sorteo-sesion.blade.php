<div>
    @section('template_title')
        Sorteo de Participantes
    @endsection
    <div class="container-fluid mb-3">
        <p class="d-flex align-items-center justify-content-between">
           <span style="font-size: 18px;"> Sorteo de Participantes</span>
            @if ($sesion->estado != 'CREADO')
            <span class="badge rounded-pill text-bg-success" style="font-size: 10px;">Finalizado</span>
        @endif
        </p>
        
    </div>

    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12 d-grid">
                @if ($sesion->estado === 'CREADO')
                    <button class="btn btn-success mb-3" wire:click="realizarSorteo">
                        Sortear Números <i class="fas fa-dice"></i>
                    </button>
                @endif

                <div class="card card-default">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" style="font-size: 10px;">
                                <thead>
                                    <tr class="text-center bg-primary text-white">
                                        <th>Nro.</th>
                                        <th>Fecha</th>
                                        <th>Participante</th>
                                        @if (count($matrizNumeros) > 0)
                                            <th>Reordenar</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($matrizNumeros as $index => $item)
                                        <tr>
                                            <td class="text-center align-middle">
                                                <span class="badge bg-primary fs-6">{{ $item[0] }}</span>
                                            </td>
                                            <td class="text-center align-middle"> {{ $item[2] }} </td>
                                            <td class="align-middle">
                                                {{ $item[3] }}
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    @if ($index > 0)
                                                        <button class="btn btn-outline-primary btn-sm"
                                                            wire:click="intercambiarPosiciones({{ $index }}, {{ $index - 1 }})"
                                                            title="Mover arriba">
                                                            <i class="fas fa-arrow-up"></i>
                                                        </button>
                                                    @endif
                                                    @if ($index < count($matrizNumeros) - 1)
                                                        <button class="btn btn-outline-primary btn-sm"
                                                            wire:click="intercambiarPosiciones({{ $index }}, {{ $index + 1 }})"
                                                            title="Mover abajo">
                                                            <i class="fas fa-arrow-down"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="mt-1">
                                                    <select class="form-select form-select-sm"
                                                        wire:change="moverParticipante({{ $index }}, $event.target.value)"
                                                        title="Mover a posición específica">
                                                        <option value="">Mover a...</option>
                                                        @for ($i = 1; $i <= count($matrizNumeros); $i++)
                                                            <option value="{{ $i }}"
                                                                {{ $item[0] == $i ? 'selected' : '' }}>
                                                                Pos. {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if ($sesion->estado === 'CREADO')
                                            @foreach ($cronograma as $fecha)
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-primary fs-6">{{ $i++ }}</span>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ $fecha }}
                                                    </td>
                                                    <td class="text-center align-middle">--</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach ($participantes->sortBy('sesioncronograma_id') as $participante)
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-primary fs-6">{{ $i++ }}</span>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ $participante->sesioncronograma->fecha ?? '--' }}
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        {{ $participante->participante->nombre ?? '--' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="d-grid">
                    @if ($matrizNumeros && $sesion->estado === 'CREADO')
                        <button class="btn btn-primary mt-2 py-2" onclick="guardarSorteo()">Guardar Sorteo <i
                                class="fas fa-save"></i></button>
                    @endif
                    <a class="btn btn-secondary py-2 mt-2" href="{{ route('sesiones.listado') }}"><i
                            class="fas fa-arrow-left"></i> Volver</a>
                </div>


            </div>
        </div>
    </section>
</div>
@section('js')
    <script>
        function guardarSorteo() {
            Swal.fire({
                title: "REGISTRAR SORTEO",
                text: "¿Está seguro de realizar esta operación?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, registrar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('guardarSorteo');
                }
            });
        }
    </script>
@endsection
