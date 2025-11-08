<div>
    @section('template_title')
        Operativa de Sesión
    @endsection
    <div class="container-fluid mb-3">
        <p class="d-flex align-items-center justify-content-between">
            <span style="font-size: 18px;"> Operativa de Sesión - {{ $sesion->nombre_sesion }} </span>
        </p>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="text-center">CRONOGRAMA</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover nowrap">
                    <thead>
                        <tr class="text-center bg-primary">
                            <th class="align-middle">Nro</th>
                            <th class="align-middle">Participante</th>
                            <th class="align-middle">Fecha</th>
                            <th class="align-middle">Monto a Entregar</th>
                            <th class="align-middle">Procesar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($sesion->sesioncronogramas as $cronograma)
                            <tr class="text-center">
                                <td class="align-middle">{{ ++$i }}</td>
                                <td class="align-middle">{{ $cronograma->sesionparticipantes->participante->nombre }}</td>
                                <td class="align-middle">{{ $cronograma->fecha }}</td>
                                <td class="align-middle">
                                    {{ number_format($cronograma->sesion->cuota * $cronograma->sesion->sesionparticipantes->count(), 2) }}
                                </td>
                                <td class="align-middle">
                                    @if ($cronograma->procesado)
                                        <span class="badge bg-success">Entregado</span>
                                    @else
                                        <button class="btn btn-warning" onclick="entrega({{$cronograma->id}},{{ number_format($cronograma->sesion->cuota * $cronograma->sesion->sesionparticipantes->count(), 2) }},{{$i}})">Entregar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-grid">
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>
@section('js')
    <script>
        function entrega(cronograma_id, monto_entregado, i) {
            // Obtener la fecha actual en formato YYYY-MM-DD
            const fechaActual = "{{ date('Y-m-d') }}";
            
            Swal.fire({
                title: 'REGISTRAR ENTREGA <br> Pasanaco Nro. ' + i,
                html: `
                    <div class="mb-2 text-start">
                        <label for="fecha_entrega" class="form-label" style="font-size: 0.85rem; margin-bottom: 0.25rem;">Fecha de Entrega:</label>
                        <input type="date" id="fecha_entrega" class="swal2-input" style="width: 100%; padding: 0.5rem; font-size: 0.9rem; margin: 0;" value="${fechaActual}" required>
                    </div>
                    <div class="mb-2 text-start">
                        <label for="monto_entregado" class="form-label" style="font-size: 0.85rem; margin-bottom: 0.25rem;">Monto Entregado:</label>
                        <input type="number" id="monto_entregado" class="swal2-input" style="width: 100%; padding: 0.5rem; font-size: 0.9rem; margin: 0;" placeholder="Ingrese el monto" step="0.01" min="0" value="${monto_entregado}" required>
                    </div>
                    <div class="mb-2 text-start">
                        <label for="observaciones" class="form-label" style="font-size: 0.85rem; margin-bottom: 0.25rem;">Observaciones:</label>
                        <textarea id="observaciones" class="swal2-textarea" style="width: 100%; padding: 0.5rem; font-size: 0.9rem; margin: 0; min-height: 60px;" placeholder="Observaciones (opcional)" rows="2"></textarea>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Registrar',
                cancelButtonText: 'Cancelar',
                focusConfirm: false,
                width: '90%',
                padding: '1rem',
                customClass: {
                    popup: 'swal2-popup-custom',
                    title: 'swal2-title-small',
                    htmlContainer: 'swal2-html-small'
                },
                preConfirm: () => {
                    const fechaEntrega = document.getElementById('fecha_entrega').value;
                    const montoEntregado = document.getElementById('monto_entregado').value;
                    const observaciones = document.getElementById('observaciones').value;
                    
                    // Validaciones
                    if (!fechaEntrega) {
                        Swal.showValidationMessage('Por favor ingrese la fecha de entrega');
                        return false;
                    }
                    
                    if (!montoEntregado || montoEntregado <= 0) {
                        Swal.showValidationMessage('Por favor ingrese un monto válido');
                        return false;
                    }
                    
                    return {
                        cronograma_id: cronograma_id,
                        fecha_entrega: fechaEntrega,
                        monto_entregado: parseFloat(montoEntregado),
                        observaciones: observaciones || ''
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar datos a Livewire
                    Livewire.emit('entregarPasanaco', 
                        result.value.cronograma_id,
                        result.value.monto_entregado,
                        result.value.fecha_entrega,                        
                        result.value.observaciones
                    );
                }
            });
        }
    </script>
    <style>
        /* Tabla nowrap para evitar saltos de línea */
        table.nowrap th,
        table.nowrap td {
            white-space: nowrap !important;
        }
        
        .swal2-title-small {
            font-size: 1.2rem !important;
            padding: 0.5rem 0 !important;
        }
        
        .swal2-html-small {
            padding: 0.5rem 0 !important;
            margin: 0 !important;
        }
        
        @media (max-width: 576px) {
            .swal2-popup-custom {
                width: 95% !important;
                padding: 0.75rem !important;
            }
            
            .swal2-title-small {
                font-size: 1rem !important;
            }
            
            .swal2-popup-custom .swal2-actions {
                gap: 0.5rem !important;
            }
            
            .swal2-popup-custom .swal2-confirm,
            .swal2-popup-custom .swal2-cancel {
                font-size: 0.85rem !important;
                padding: 0.5rem 1rem !important;
            }
        }
    </style>
@endsection