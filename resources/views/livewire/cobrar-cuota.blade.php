<div>
    @section('template_title')
        Cobrar Cuotas
    @endsection
    <div class="container fluid mb-3">
        <h5>Cobrar Cuotas</h5>
    </div>

    @if (!$sesion->qrcobro)
        <div class="card">
            <div class="card-body">
                <label for="">Adjuntar Qr de Cobro</label>
                <input type="file" class="form-control" wire:model='qrcobro' accept="image/*">
                @if ($qrcobro)
                    <small>Vista previa:</small>
                    <img src="{{ $qrcobro->temporaryUrl() }}" alt="Qr_image" class="img-fluid">
                @endif
                <button class="btn btn-success col-12 col-md-4 mt-2" wire:click="uploadQr" wire:loading.attr="disabled">

                    <span wire:loading.remove>
                        Subir Qr <i class="fas fa-upload"></i>
                    </span>

                    <span wire:loading>
                        Cargando...
                        <span class="spinner-border spinner-border-sm ms-2" role="status"></span>
                    </span>
                </button>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="text-center">CRONOGRAMA</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover nowrap">
                    <thead>
                        <tr class="text-center bg-primary">
                            <th class="align-middle">Nro</th>
                            <th class="align-middle">Fecha</th>
                            <th class="align-middle">Monto</th>

                            <th class="align-middle"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($sesion->sesioncronogramas as $cronograma)
                            <tr class="text-center">
                                <td class="align-middle">{{ ++$i }}</td>
                                <td class="align-middle">{{ $cronograma->fecha }}</td>
                                <td class="align-middle">
                                    {{ number_format($cronograma->sesion->cuota * $cronograma->sesion->sesionparticipantes->count(), 2) }}
                                </td>

                                <td class="align-middle text-end">
                                    @if ($cronograma->procesado)
                                        <span class="badge rounded-pill text-bg-warning">Entregado!</span>
                                    @else
                                        <button class="btn btn-danger"
                                            wire:click="openModalCobros({{ $cronograma->id }},{{ $i }})">Cobros</button>
                                    @endif


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-grid mb-2">
            <a class="btn btn-secondary py-2" href="{{ route('sesiones.listado') }}"> <i class="fas fa-arrow-left"></i>
                Volver</a>
        </div>
        <div class="col-12 col-md-6 d-grid mb-2">
            <a class="btn btn-success py-2" href="{{ route('sesiones.operativa', $sesion->id) }}">
                Entregar Pasanaco <i class="fas fa-comment-dollar"></i>
            </a>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalCobros" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalCobrosLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCobrosLabel">Cobros de Cuota - Nro.: <span
                            id="nrocuota"></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr class="bg-primary">
                                <th>#</th>
                                <th>Participante</th>
                                <th class="text-center">Cuota</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($cronograma->sesion->sesionparticipantes as $sesionparticipante)
                                <tr>
                                    <td class="align-middle">{{ ++$i }}</td>
                                    <td class="align-middle">{{ $sesionparticipante->participante->nombre }}</td>
                                    <td class="align-middle text-center">{{ $cronograma->sesion->cuota }}</td>
                                    <td class="align-middle text-end">
                                        <button class="btn btn-sm btn-success"
                                            onclick="javascript:enviarWhatsapp({{ $i }},'{{ $sesionparticipante->participante->nombre }}','{{ $sesionparticipante->participante->celular }}',{{ $cronograma->sesion->cuota }});"><i
                                                class="fab fa-whatsapp"></i> Cobrar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-ban"></i>
                        Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        Livewire.on('openModalCobros', nro => {
            document.getElementById('nrocuota').textContent = nro;
            const modal = new bootstrap.Modal(document.getElementById('modalCobros'));
            modal.show();

        });
    </script>

    <script>
        function enviarWhatsapp(nro, nombre, celular, monto) {

            const img = '{{ $sesion->qrcobro }}';
            let imgUrl = '';
            // URL pública de la imagen almacenada
            if (img != '') {
                // imgUrl += `${window.location.origin}/storage/${img}`;
                imgUrl += `
Puedes ver o descargar el QR aquí: 
`+'{{ route('sesiones.descargaqr', $sesion->id) }}';
            }


            // Armamos el mensaje dinámicamente
            const mensaje = `Hola! *${nombre}*, te envío la siguiente información:

*COBRO DE PASANACO*
Número: *${nro}*
Sesión: {{ $sesion->nombre_sesion }}
Monto Bs.: *${monto}*
${imgUrl}

Gracias por tu pago`;

            // Convertimos para URL
            const mensajeCodificado = encodeURIComponent(mensaje);

            // Número al que quieres enviar (incluye código de país)
            const telefono = "591" + celular;

            // API pública de WhatsApp
            const url = `https://wa.me/${telefono}?text=${mensajeCodificado}`;

            // Abrir WhatsApp
            window.open(url, "_blank");
        }
    </script>
@endsection
