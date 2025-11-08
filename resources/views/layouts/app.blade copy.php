<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Aplicación para gestión de sorteos y participantes en pasanacos" />
    <meta name="author" content="Pasanaco App" />
    <title>@yield('template_title') | {{ config('app.name') }}</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#1abc9c" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="apple-mobile-web-app-title" content="Pasanaco" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="application-name" content="Pasanaco" />
    
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/icons/icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('images/icons/icon-192x192.png') }}" />
    
    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="{{ asset('assets/template/js/all.js') }}" crossorigin="anonymous"></script>

    <script src="{{ asset('assets/template/js/jquery.min.js') }}"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="{{ asset('assets/datatables/dataTables.dataTables.css') }}">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('assets/template/css/styles.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/toastcolor.css') }}">

    @yield('css')

    @livewireStyles

</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <img src="{{ asset('images/logo.png') }}" style="width: 50px;">
            <a class="navbar-brand" href="#page-top">{{ config('app.name') }}</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse " id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="/">Inicio</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="{{ route('sesiones.listado') }}">Sesiones</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="{{ route('participantes.index') }}">Participantes</a></li>
                    {{-- <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="#contact">Contact</a></li> --}}
                </ul>
            </div>
        </div>
    </nav>
    <section class="page-section portfolio mt-md-4" id="main-content">
        @yield('content')
    </section>

    @livewireScripts
    <!-- Bootstrap core JS-->
    <script src="{{ asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('assets/template/js/scripts.js') }}"></script>
    {{-- <script src="{{ asset('assets/template/js/sb-forms-0.4.1.js') }}"></script> --}}

    <script src="{{ asset('assets/sweetalert2/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('assets/datatables/dataTables.js') }}"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        const esp = {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "loadingRecords": "Cargando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad",
                "collection": "Colección",
                "colvisRestore": "Restaurar visibilidad",
                "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                "copySuccess": {
                    "1": "Copiada 1 fila al portapapeles",
                    "_": "Copiadas %ds fila al portapapeles"
                },
                "copyTitle": "Copiar al portapapeles",
                "csv": "CSV",
                "excel": "Excel",
                "pageLength": {
                    "-1": "Mostrar todas las filas",
                    "_": "Mostrar %d filas"
                },
                "pdf": "PDF",
                "print": "Imprimir",
                "renameState": "Cambiar nombre",
                "updateState": "Actualizar",
                "createState": "Crear Estado",
                "removeAllStates": "Remover Estados",
                "removeState": "Remover",
                "savedStates": "Estados Guardados",
                "stateRestore": "Estado %d"
            },
            "autoFill": {
                "cancel": "Cancelar",
                "fill": "Rellene todas las celdas con <i>%d<\/i>",
                "fillHorizontal": "Rellenar celdas horizontalmente",
                "fillVertical": "Rellenar celdas verticalmente"
            },
            "decimal": ",",
            "searchBuilder": {
                "add": "Añadir condición",
                "button": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "clearAll": "Borrar todo",
                "condition": "Condición",
                "conditions": {
                    "date": {
                        "before": "Antes",
                        "between": "Entre",
                        "empty": "Vacío",
                        "equals": "Igual a",
                        "notBetween": "No entre",
                        "not": "Diferente de",
                        "after": "Después",
                        "notEmpty": "No Vacío"
                    },
                    "number": {
                        "between": "Entre",
                        "equals": "Igual a",
                        "gt": "Mayor a",
                        "gte": "Mayor o igual a",
                        "lt": "Menor que",
                        "lte": "Menor o igual que",
                        "notBetween": "No entre",
                        "notEmpty": "No vacío",
                        "not": "Diferente de",
                        "empty": "Vacío"
                    },
                    "string": {
                        "contains": "Contiene",
                        "empty": "Vacío",
                        "endsWith": "Termina en",
                        "equals": "Igual a",
                        "startsWith": "Empieza con",
                        "not": "Diferente de",
                        "notContains": "No Contiene",
                        "notStartsWith": "No empieza con",
                        "notEndsWith": "No termina con",
                        "notEmpty": "No Vacío"
                    },
                    "array": {
                        "not": "Diferente de",
                        "equals": "Igual",
                        "empty": "Vacío",
                        "contains": "Contiene",
                        "notEmpty": "No Vacío",
                        "without": "Sin"
                    }
                },
                "data": "Data",
                "deleteTitle": "Eliminar regla de filtrado",
                "leftTitle": "Criterios anulados",
                "logicAnd": "Y",
                "logicOr": "O",
                "rightTitle": "Criterios de sangría",
                "title": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "value": "Valor"
            },
            "searchPanes": {
                "clearMessage": "Borrar todo",
                "collapse": {
                    "0": "Paneles de búsqueda",
                    "_": "Paneles de búsqueda (%d)"
                },
                "count": "{total}",
                "countFiltered": "{shown} ({total})",
                "emptyPanes": "Sin paneles de búsqueda",
                "loadMessage": "Cargando paneles de búsqueda",
                "title": "Filtros Activos - %d",
                "showMessage": "Mostrar Todo",
                "collapseMessage": "Colapsar Todo"
            },
            "select": {
                "cells": {
                    "1": "1 celda seleccionada",
                    "_": "%d celdas seleccionadas"
                },
                "columns": {
                    "1": "1 columna seleccionada",
                    "_": "%d columnas seleccionadas"
                },
                "rows": {
                    "1": "1 fila seleccionada",
                    "_": "%d filas seleccionadas"
                }
            },
            "thousands": ".",
            "datetime": {
                "previous": "Anterior",
                "hours": "Horas",
                "minutes": "Minutos",
                "seconds": "Segundos",
                "unknown": "-",
                "amPm": [
                    "AM",
                    "PM"
                ],
                "months": {
                    "0": "Enero",
                    "1": "Febrero",
                    "10": "Noviembre",
                    "11": "Diciembre",
                    "2": "Marzo",
                    "3": "Abril",
                    "4": "Mayo",
                    "5": "Junio",
                    "6": "Julio",
                    "7": "Agosto",
                    "8": "Septiembre",
                    "9": "Octubre"
                },
                "weekdays": {
                    "0": "Dom",
                    "1": "Lun",
                    "2": "Mar",
                    "4": "Jue",
                    "5": "Vie",
                    "3": "Mié",
                    "6": "Sáb"
                },
                "next": "Próximo"
            },
            "editor": {
                "close": "Cerrar",
                "create": {
                    "button": "Nuevo",
                    "title": "Crear Nuevo Registro",
                    "submit": "Crear"
                },
                "edit": {
                    "button": "Editar",
                    "title": "Editar Registro",
                    "submit": "Actualizar"
                },
                "remove": {
                    "button": "Eliminar",
                    "title": "Eliminar Registro",
                    "submit": "Eliminar",
                    "confirm": {
                        "_": "¿Está seguro de que desea eliminar %d filas?",
                        "1": "¿Está seguro de que desea eliminar 1 fila?"
                    }
                },
                "error": {
                    "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                },
                "multi": {
                    "title": "Múltiples Valores",
                    "restore": "Deshacer Cambios",
                    "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo.",
                    "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, haga clic o pulse aquí, de lo contrario conservarán sus valores individuales."
                }
            },
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "stateRestore": {
                "creationModal": {
                    "button": "Crear",
                    "name": "Nombre:",
                    "order": "Clasificación",
                    "paging": "Paginación",
                    "select": "Seleccionar",
                    "columns": {
                        "search": "Búsqueda de Columna",
                        "visible": "Visibilidad de Columna"
                    },
                    "title": "Crear Nuevo Estado",
                    "toggleLabel": "Incluir:",
                    "scroller": "Posición de desplazamiento",
                    "search": "Búsqueda",
                    "searchBuilder": "Búsqueda avanzada"
                },
                "removeJoiner": "y",
                "removeSubmit": "Eliminar",
                "renameButton": "Cambiar Nombre",
                "duplicateError": "Ya existe un Estado con este nombre.",
                "emptyStates": "No hay Estados guardados",
                "removeTitle": "Remover Estado",
                "renameTitle": "Cambiar Nombre Estado",
                "emptyError": "El nombre no puede estar vacío.",
                "removeConfirm": "¿Seguro que quiere eliminar %s?",
                "removeError": "Error al eliminar el Estado",
                "renameLabel": "Nuevo nombre para %s:"
            },
            "infoThousands": "."
        };

        $('.dataTable').DataTable({
            "destroy": true,
            order: [[0, 'desc']],
            language: esp,
        });
        $('.dataTableAsc').DataTable({
            "destroy": true,            
            language: esp,
        });
    </script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end', // o 'center' si preferís
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });

            // ✅ Éxito
            Livewire.on('success', msg => {
                Toast.fire({
                    icon: 'success',
                    title: msg || 'Operación exitosa',
                });
            });

            // ❌ Error
            Livewire.on('error', msg => {
                Toast.fire({
                    icon: 'error',
                    title: msg || 'Ocurrió un error',
                });
            });

            // ℹ️ Información / Alerta
            Livewire.on('info', msg => {
                Toast.fire({
                    icon: 'info',
                    title: msg || 'Información importante',
                });
            });

        });
    </script>


    <script>
        $('.delete').submit(function(e) {
            Swal.fire({
                title: 'Eliminar el Registro de la BD',
                text: "Esta seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1abc9c',
                cancelButtonColor: '#2c3e50',
                confirmButtonText: 'Si, continuar!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        $('.anular').submit(function(e) {
            Swal.fire({
                title: 'Anular Venta',
                text: "Esta seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1abc9c',
                cancelButtonColor: '#2c3e50',
                confirmButtonText: 'Si, continuar!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        $('.reset').submit(function(e) {
            Swal.fire({
                title: 'RESET PASSWORD',
                text: "Esta seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1abc9c',
                cancelButtonColor: '#2c3e50',
                confirmButtonText: 'Si, continuar!',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>

    @yield('js')

    <!-- PWA Service Worker Registration -->
    <script>
        // Registrar Service Worker para PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js', {
                    scope: '/'
                })
                .then(function(registration) {
                    console.log('Service Worker registrado con éxito:', registration.scope);
                    
                    // Verificar actualizaciones
                    registration.addEventListener('updatefound', () => {
                        console.log('Service Worker: Nueva versión disponible');
                        const newWorker = registration.installing;
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                console.log('Service Worker: Actualización lista');
                            }
                        });
                    });
                })
                .catch(function(error) {
                    console.error('Error al registrar Service Worker:', error);
                });
            });
        }

        // PWA Install Prompt - Versión Mejorada
        let deferredPrompt;
        let installButton = null;
        let isInstallable = false;

        // Detectar evento de instalación disponible
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('PWA: Instalación disponible');
            e.preventDefault(); // Prevenir prompt automático
            deferredPrompt = e;
            isInstallable = true;
            showInstallButton();
        });

        // Crear y mostrar botón de instalación
        function showInstallButton() {
            // No mostrar si ya está instalada o en modo standalone
            if (isStandalone()) {
                console.log('PWA: Ya está instalada o en modo standalone');
                return;
            }

            if (!installButton && isInstallable) {
                installButton = document.createElement('button');
                installButton.innerHTML = `
                    <i class="fas fa-mobile-alt me-2"></i>
                    <span>Instalar App</span>
                `;
                installButton.className = 'btn btn-success position-fixed shadow-lg';
                installButton.style.cssText = `
                    bottom: 20px; 
                    right: 20px; 
                    z-index: 10000; 
                    border-radius: 50px; 
                    padding: 12px 20px; 
                    font-size: 14px;
                    font-weight: 600;
                    border: none;
                    background: linear-gradient(45deg, #1abc9c, #16a085);
                    color: white;
                    box-shadow: 0 6px 20px rgba(26, 188, 156, 0.4);
                    transition: all 0.3s ease;
                    animation: pulse-install 2s infinite;
                `;
                
                // Efectos hover y click
                installButton.addEventListener('mouseenter', () => {
                    installButton.style.transform = 'scale(1.05)';
                    installButton.style.boxShadow = '0 8px 25px rgba(26, 188, 156, 0.6)';
                });
                
                installButton.addEventListener('mouseleave', () => {
                    installButton.style.transform = 'scale(1)';
                    installButton.style.boxShadow = '0 6px 20px rgba(26, 188, 156, 0.4)';
                });

                installButton.addEventListener('click', installApp);
                document.body.appendChild(installButton);

                // Agregar animación CSS
                if (!document.getElementById('pwa-install-styles')) {
                    const style = document.createElement('style');
                    style.id = 'pwa-install-styles';
                    style.textContent = `
                        @keyframes pulse-install {
                            0% { box-shadow: 0 6px 20px rgba(26, 188, 156, 0.4); }
                            50% { box-shadow: 0 6px 30px rgba(26, 188, 156, 0.8); }
                            100% { box-shadow: 0 6px 20px rgba(26, 188, 156, 0.4); }
                        }
                    `;
                    document.head.appendChild(style);
                }

                console.log('PWA: Botón de instalación mostrado');
            }
        }

        // Función para instalar la app
        function installApp() {
            if (deferredPrompt) {
                console.log('PWA: Iniciando instalación...');
                
                // Cambiar texto del botón
                installButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Instalando...';
                installButton.disabled = true;
                
                deferredPrompt.prompt();
                
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('PWA: Usuario aceptó la instalación');
                        hideInstallButton();
                        showInstallSuccess();
                    } else {
                        console.log('PWA: Usuario rechazó la instalación');
                        // Restaurar botón
                        installButton.innerHTML = '<i class="fas fa-mobile-alt me-2"></i>Instalar App';
                        installButton.disabled = false;
                    }
                    deferredPrompt = null;
                });
            }
        }

        // Ocultar botón de instalación
        function hideInstallButton() {
            if (installButton) {
                installButton.style.opacity = '0';
                installButton.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    if (installButton && installButton.parentNode) {
                        installButton.parentNode.removeChild(installButton);
                        installButton = null;
                    }
                }, 300);
            }
        }

        // Mostrar mensaje de éxito
        function showInstallSuccess() {
            const successMsg = document.createElement('div');
            successMsg.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                ¡App instalada correctamente!
            `;
            successMsg.className = 'position-fixed alert alert-success shadow-lg';
            successMsg.style.cssText = `
                bottom: 20px; 
                right: 20px; 
                z-index: 10000; 
                border-radius: 25px; 
                padding: 15px 20px;
                border: none;
                animation: slideIn 0.5s ease;
            `;
            
            document.body.appendChild(successMsg);
            
            setTimeout(() => {
                successMsg.style.opacity = '0';
                setTimeout(() => {
                    if (successMsg.parentNode) {
                        successMsg.parentNode.removeChild(successMsg);
                    }
                }, 300);
            }, 3000);
        }

        // Verificar si está en modo standalone
        function isStandalone() {
            return window.matchMedia('(display-mode: standalone)').matches || 
                   window.navigator.standalone === true;
        }

        // Detectar cuando la app se instala
        window.addEventListener('appinstalled', (evt) => {
            console.log('PWA: Aplicación instalada exitosamente');
            hideInstallButton();
            showInstallSuccess();
        });

        // Verificar estado inicial
        document.addEventListener('DOMContentLoaded', () => {
            if (isStandalone()) {
                console.log('PWA: Ejecutándose en modo standalone');
            } else {
                console.log('PWA: Ejecutándose en navegador');
                // Mostrar botón si es instalable después de un breve delay
                setTimeout(() => {
                    if (isInstallable && !isStandalone()) {
                        showInstallButton();
                    } else if (!isStandalone()) {
                        // Fallback: mostrar botón informativo si no se detecta instalabilidad automática
                        showFallbackButton();
                    }
                }, 2000);
            }
        });

        // Botón alternativo para navegadores que no disparan beforeinstallprompt
        function showFallbackButton() {
            // Solo mostrar en navegadores compatibles
            if (!('serviceWorker' in navigator) || isStandalone()) {
                return;
            }

            const fallbackButton = document.createElement('button');
            fallbackButton.innerHTML = `
                <i class="fas fa-info-circle me-2"></i>
                <span>¿Instalar App?</span>
            `;
            fallbackButton.className = 'btn btn-outline-success position-fixed shadow';
            fallbackButton.style.cssText = `
                bottom: 20px; 
                right: 20px; 
                z-index: 10000; 
                border-radius: 50px; 
                padding: 10px 18px; 
                font-size: 13px;
                font-weight: 500;
                border: 2px solid #1abc9c;
                background: rgba(255, 255, 255, 0.95);
                color: #1abc9c;
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            `;
            
            fallbackButton.addEventListener('click', () => {
                // Mostrar instrucciones de instalación manual
                showInstallInstructions();
                fallbackButton.remove();
            });

            document.body.appendChild(fallbackButton);
        }

        // Mostrar instrucciones de instalación manual
        function showInstallInstructions() {
            const isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
            const isFirefox = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
            const isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
            
            let instructions = '';
            
            if (isChrome) {
                instructions = `
                    <strong>Chrome/Edge:</strong><br>
                    1. Haz clic en el menú (⋮)<br>
                    2. Selecciona "Instalar Pasanaco..."<br>
                    3. O busca el ícono de instalación (+) en la barra de direcciones
                `;
            } else if (isFirefox) {
                instructions = `
                    <strong>Firefox:</strong><br>
                    1. Haz clic en el menú (☰)<br>
                    2. Selecciona "Instalar esta aplicación"<br>
                    3. O busca el ícono de instalación en la barra de direcciones
                `;
            } else if (isSafari) {
                instructions = `
                    <strong>Safari (iOS):</strong><br>
                    1. Toca el botón Compartir (□↗)<br>
                    2. Selecciona "Agregar a pantalla de inicio"<br>
                    3. Toca "Agregar"
                `;
            } else {
                instructions = `
                    <strong>Para instalar:</strong><br>
                    1. Busca la opción "Instalar app" en el menú del navegador<br>
                    2. O busca el ícono de instalación (+) en la barra de direcciones
                `;
            }

            Swal.fire({
                title: '📱 Instalar Pasanaco',
                html: `
                    <div style="text-align: left; line-height: 1.6;">
                        <p style="margin-bottom: 15px; color: #666;">
                            ¡Instala Pasanaco como una aplicación nativa en tu dispositivo!
                        </p>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin: 15px 0;">
                            ${instructions}
                        </div>
                        <p style="margin-top: 15px; font-size: 14px; color: #888;">
                            <i class="fas fa-star text-warning"></i> 
                            La app funcionará sin conexión y tendrá su propio ícono.
                        </p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#1abc9c',
                width: '500px'
            });
        }
    </script>
</body>

</html>
