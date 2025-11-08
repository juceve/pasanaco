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
                            <th class="align-middle">Monto</th>
                            <th class="align-middle">Qr Code</th>
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
                                <td class="align-middle">{{ $cronograma->sesionparticipantes->participante->nombre }}
                                </td>
                                <td class="align-middle">{{ $cronograma->fecha }}</td>
                                <td class="align-middle">
                                    {{ number_format($cronograma->sesion->cuota * $cronograma->sesion->sesionparticipantes->count(), 2) }}
                                </td>
                                <td class="align-middle">
                                    @php
                                        $qrPath = $cronograma->sesionparticipantes->participante->qr;
                                    @endphp
                                    @if ($qrPath)
                                        <button class="btn btn-sm btn-outline-primary"
                                            onclick="mostrarQR('{{ asset('storage/' . $qrPath) }}', '{{ $cronograma->sesionparticipantes->participante->nombre }}')"
                                            title="Ver QR">
                                            <i class="fas fa-qrcode"></i>
                                        </button>
                                    @else
                                        <span class="">--</span>
                                    @endif
                                </td>
                                <td class="align-middle text-end">
                                    @if ($cronograma->procesado)
                                        <span class="badge bg-info">Entregado</span>
                                        @php
                                            $participante = $cronograma->sesionparticipantes->participante;
                                            $celular = preg_replace('/[^0-9]/', '', $participante->celular ?? '');
                                            $monto = number_format($cronograma->monto_entregado, 2);

                                            // Mensaje sin emojis complejos, solo texto
                                            $mensaje = "Hola *{$participante->nombre}*!\n\n";
                                            $mensaje .= "Te confirmamos que tu pasanaco Nro. *{$i}* ha sido entregado.\n\n";
                                            $mensaje .= "*Monto entregado:* Bs. {$monto}\n";
                                            $mensaje .=
                                                '*Fecha:* ' .
                                                \Carbon\Carbon::parse($cronograma->fecha_pago)->format('d/m/Y') .
                                                "\n";
                                            $mensaje .= "*Sesión:* {$sesion->nombre_sesion}\n\n";
                                            $mensaje .= 'Felicidades!';

                                            $urlWhatsApp = "https://wa.me/591{$celular}?text=" . rawurlencode($mensaje);
                                        @endphp
                                        <a class="btn btn-success btn-sm" title="Notificar por WhatsApp"
                                            href="{{ $urlWhatsApp }}" target="_blank">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-warning"
                                            onclick="entrega({{ $cronograma->id }},{{ number_format($cronograma->sesion->cuota * $cronograma->sesion->sesionparticipantes->count(), 2) }},{{ $i }})">Entregar</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if ($sesion->estado === 'FINALIZADO')
        <div class="d-grid mb-3">
            <button class="btn btn-info" wire:click="generarReporte">
                @if($mostrarReporte)
                    <i class="fas fa-eye-slash"></i> Ocultar Reporte
                @else
                    <i class="fas fa-file-alt"></i> Generar Reporte
                @endif
            </button>
        </div>

        @if($mostrarReporte)
            <div class="card mb-3" id="reporteSesion">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0 text-center">
                        <i class="fas fa-flag-checkered"></i> REPORTE DE SESIÓN FINALIZADA
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Información General de la Sesión -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información General</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <strong><i class="fas fa-tag"></i> Nombre de Sesión:</strong>
                                            <span class="ms-2">{{ $sesion->nombre_sesion }}</span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong><i class="fas fa-calendar-check"></i> Fecha Inicio:</strong>
                                            <span class="ms-2">{{ \Carbon\Carbon::parse($sesion->fecha_inicio)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong><i class="fas fa-calendar-times"></i> Fecha Fin:</strong>
                                            <span class="ms-2">{{ \Carbon\Carbon::parse($sesion->fecha_fin)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong><i class="fas fa-coins"></i> Cuota:</strong>
                                            <span class="ms-2">Bs. {{ number_format($sesion->cuota, 2) }}</span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong><i class="fas fa-users"></i> Total Participantes:</strong>
                                            <span class="ms-2 badge bg-info">{{ $sesion->sesionparticipantes->count() }}</span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong><i class="fas fa-clipboard-list"></i> Modalidad:</strong>
                                            <span class="ms-2">{{ $sesion->modo->nombre ?? 'N/A' }}</span>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <strong><i class="fas fa-check-circle"></i> Estado:</strong>
                                            <span class="ms-2 badge bg-success">{{ $sesion->estado }}</span>
                                        </div>
                                        @if($sesion->observaciones)
                                        <div class="col-12 mb-2">
                                            <strong><i class="fas fa-sticky-note"></i> Observaciones:</strong>
                                            <p class="ms-2 mb-0">{{ $sesion->observaciones }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estadísticas -->
                    @php
                        $totalEntregado = $sesion->sesioncronogramas->sum('monto_entregado');
                        $totalEsperado = $sesion->sesioncronogramas->count() * ($sesion->cuota * $sesion->sesionparticipantes->count());
                        $promedioEntrega = $sesion->sesioncronogramas->count() > 0 ? $totalEntregado / $sesion->sesioncronogramas->count() : 0;
                    @endphp
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="card text-white bg-success h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-title"><i class="fas fa-money-bill-wave"></i> Total Entregado</h6>
                                    <h3 class="mb-0">Bs. {{ number_format($totalEntregado, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card text-white bg-info h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-title"><i class="fas fa-hand-holding-usd"></i> Total Esperado</h6>
                                    <h3 class="mb-0">Bs. {{ number_format($totalEsperado, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card text-white bg-warning h-100">
                                <div class="card-body text-center">
                                    <h6 class="card-title"><i class="fas fa-chart-line"></i> Promedio por Entrega</h6>
                                    <h3 class="mb-0">Bs. {{ number_format($promedioEntrega, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Participantes -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="fas fa-users"></i> Participantes de la Sesión</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-hover">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nombre</th>
                                                    <th>Celular</th>
                                                    <th>Email</th>
                                                    <th class="text-center">Turno Asignado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($sesion->sesionparticipantes as $index => $sp)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $sp->participante->nombre }}</td>
                                                    <td>{{ $sp->participante->celular ?? 'N/A' }}</td>
                                                    <td>{{ $sp->participante->email ?? 'N/A' }}</td>
                                                    <td class="text-center">
                                                        @if($sp->sesioncronograma_id)
                                                            <span class="badge bg-primary">Turno {{ $sesion->sesioncronogramas->search(function($item) use ($sp) { return $item->id === $sp->sesioncronograma_id; }) + 1 }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">No asignado</span>
                                                        @endif
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

                    <!-- Detalle del Cronograma -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Detalle del Cronograma de Entregas</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="table-dark">
                                                <tr class="text-center">
                                                    <th>Turno</th>
                                                    <th>Beneficiario</th>
                                                    <th>Fecha Programada</th>
                                                    <th>Fecha Entregada</th>
                                                    <th>Monto Esperado</th>
                                                    <th>Monto Entregado</th>
                                                    <th>Diferencia</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $totalDiferencia = 0; @endphp
                                                @foreach($sesion->sesioncronogramas as $index => $cronograma)
                                                    @php
                                                        $montoEsperado = $sesion->cuota * $sesion->sesionparticipantes->count();
                                                        $diferencia = $cronograma->monto_entregado - $montoEsperado;
                                                        $totalDiferencia += $diferencia;
                                                    @endphp
                                                    <tr class="text-center">
                                                        <td><strong>{{ $index + 1 }}</strong></td>
                                                        <td class="text-start">{{ $cronograma->sesionparticipantes->participante->nombre }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($cronograma->fecha)->format('d/m/Y') }}</td>
                                                        <td>
                                                            @if($cronograma->fecha_pago)
                                                                <span class="badge bg-success">{{ \Carbon\Carbon::parse($cronograma->fecha_pago)->format('d/m/Y') }}</span>
                                                            @else
                                                                <span class="badge bg-secondary">Pendiente</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-end">Bs. {{ number_format($montoEsperado, 2) }}</td>
                                                        <td class="text-end">
                                                            <strong class="text-success">Bs. {{ number_format($cronograma->monto_entregado, 2) }}</strong>
                                                        </td>
                                                        <td class="text-end">
                                                            <span class="badge {{ $diferencia >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                                Bs. {{ number_format($diferencia, 2) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-start">
                                                            {{ $cronograma->observaciones ?? '-' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-secondary">
                                                <tr>
                                                    <th colspan="4" class="text-end">TOTALES:</th>
                                                    <th class="text-end">Bs. {{ number_format($totalEsperado, 2) }}</th>
                                                    <th class="text-end text-success">Bs. {{ number_format($totalEntregado, 2) }}</th>
                                                    <th class="text-end">
                                                        <span class="badge {{ $totalDiferencia >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                            Bs. {{ number_format($totalDiferencia, 2) }}
                                                        </span>
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen Final -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Resumen Final</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h6 class="text-warning">Entregas Realizadas</h6>
                                                <h4 class="text-white">{{ $sesion->sesioncronogramas->where('procesado', true)->count() }} / {{ $sesion->sesioncronogramas->count() }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h6 class="text-warning">Porcentaje Completado</h6>
                                                <h4 class="text-info">100%</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h6 class="text-warning">Duración Total</h6>
                                                @php
                                                    $duracion = \Carbon\Carbon::parse($sesion->fecha_inicio)->diffInDays(\Carbon\Carbon::parse($sesion->fecha_fin));
                                                @endphp
                                                <h4 class="text-white">{{ $duracion }} días</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="p-3 border rounded">
                                                <h6 class="text-warning">Balance</h6>
                                                <h4 class="{{ $totalDiferencia >= 0 ? 'text-success' : 'text-danger' }}">
                                                    Bs. {{ number_format($totalDiferencia, 2) }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                {{-- <button class="btn btn-primary" onclick="window.print()">
                                    <i class="fas fa-print"></i> Imprimir Reporte
                                </button> --}}
                                <button class="btn btn-secondary" wire:click="generarReporte">
                                    <i class="fas fa-times"></i> Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-white text-center">
                    <small>Reporte generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</small>
                </div>
            </div>
        @endif
    @endif
    <div class="d-grid">
        <a href="javascript:history.back()" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>
@section('js')
    <script>
        function mostrarQR(imagenUrl, nombreParticipante) {
            Swal.fire({
                title: 'QR - ' + nombreParticipante,
                imageUrl: imagenUrl,
                imageAlt: 'Código QR',
                showCloseButton: true,
                showConfirmButton: true,
                confirmButtonText: '<i class="fas fa-download"></i> Descargar QR',
                width: 'auto',
                customClass: {
                    popup: 'swal2-qr-popup',
                    image: 'swal2-qr-image',
                    confirmButton: 'btn-download-qr'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    descargarImagen(imagenUrl, nombreParticipante);
                }
            });
        }

        function descargarImagen(url, nombre) {
            // Crear un elemento anchor temporal
            const link = document.createElement('a');
            link.href = url;
            link.download = 'QR_' + nombre.replace(/\s+/g, '_') + '.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

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
@endsection
@section('css')
    <style>
        /* Tabla nowrap para evitar saltos de línea */
        table.nowrap th,
        table.nowrap td {
            white-space: nowrap !important;
        }

        /* Estilos para el popup de QR */
        .swal2-qr-popup {
            background: rgba(30, 40, 50, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            border: 2px solid rgba(0, 210, 255, 0.3) !important;
            max-width: 600px !important;
        }

        .swal2-qr-popup .swal2-title {
            color: var(--accent-color) !important;
            font-size: 1.3rem !important;
        }

        .swal2-qr-image {
            border: 3px solid rgba(0, 210, 255, 0.4) !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 24px rgba(0, 210, 255, 0.3) !important;
            background: white !important;
            padding: 10px !important;
            max-width: 500px !important;
            width: 100% !important;
            height: auto !important;
            object-fit: contain !important;
        }

        .swal2-qr-popup .swal2-close {
            color: white !important;
            font-size: 2rem !important;
        }

        .swal2-qr-popup .swal2-close:hover {
            color: var(--accent-color) !important;
        }

        /* Botón de descarga del QR */
        .btn-download-qr {
            background: linear-gradient(135deg, #1abc9c, #16a085) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 0.75rem 2rem !important;
            font-weight: 600 !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(26, 188, 156, 0.4) !important;
            transition: all 0.3s ease !important;
        }

        .btn-download-qr:hover {
            background: linear-gradient(135deg, #16a085, #1abc9c) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(26, 188, 156, 0.6) !important;
        }

        .btn-download-qr i {
            margin-right: 0.5rem;
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
            .swal2-qr-popup {
                width: 95% !important;
                max-width: 95% !important;
            }

            .swal2-qr-image {
                max-width: 90% !important;
                width: 90% !important;
                height: auto !important;
                object-fit: contain !important;
            }

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

        /* Tablets y dispositivos medianos */
        @media (min-width: 577px) and (max-width: 768px) {
            .swal2-qr-popup {
                max-width: 500px !important;
            }

            .swal2-qr-image {
                max-width: 400px !important;
            }
        }

        /* Desktop */
        @media (min-width: 769px) {
            .swal2-qr-popup {
                max-width: 600px !important;
            }

            .swal2-qr-image {
                max-width: 500px !important;
            }
        }
    </style>
@endsection
