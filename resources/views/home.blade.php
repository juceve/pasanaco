@extends('layouts.app')
@section('css')
    <style>
        /* ===========================
                           BASE STYLES
                        ============================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f2027, #203a43 60%, #2c5364 100%);
            color: #fff;
            overflow-x: hidden;
        }

        .dashboard-container {
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        /* ===========================
                           HEADER
                        ============================ */
        .dashboard-header {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 20px;
            padding: 25px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 32px rgba(0, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .header-left img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .header-info h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
            background: linear-gradient(45deg, #00d2ff, #3a7bd5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-info p {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        .header-actions {
            display: flex;
            gap: 15px;
        }

        .btn-header {
            padding: 10px 20px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #00d2ff, #3a7bd5);
            color: white;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 210, 255, 0.3);
        }

        /* ===========================
                           STATS CARDS
                        ============================ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #00d2ff, #3a7bd5);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 255, 255, 0.15);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            background: linear-gradient(45deg, #00d2ff, #3a7bd5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #fff;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ===========================
                           ACTION BUTTONS
                        ============================ */
        .actions-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #00d2ff;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 16px;
            padding: 20px;
            text-decoration: none;
            color: white;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.2);
            color: white;
            text-decoration: none;
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            background: linear-gradient(45deg, #00d2ff, #3a7bd5);
        }

        .action-info h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .action-info p {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* ===========================
                           RECENT ACTIVITY
                        ============================ */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            flex: 1;
        }

        .content-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 18px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: #00d2ff;
        }

        .recent-item {
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .recent-item:last-child {
            border-bottom: none;
        }

        .item-info h4 {
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .item-info p {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .item-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background: rgba(0, 255, 127, 0.2);
            color: #00ff7f;
            border: 1px solid rgba(0, 255, 127, 0.3);
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        /* ===========================
                           RESPONSIVE
                        ============================ */
        @media (max-width: 768px) {
            .dashboard-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .header-actions {
                width: 100%;
                justify-content: center;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .dashboard-container {
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===========================
                           LOGOUT MODAL
                        ============================ */
        .logout-btn {
            background: rgba(255, 71, 87, 0.2);
            border: 1px solid rgba(255, 71, 87, 0.3);
            color: #ff4757;
        }

        .logout-btn:hover {
            background: rgba(255, 71, 87, 0.3);
            box-shadow: 0 8px 25px rgba(255, 71, 87, 0.3);
        }
    </style>
@endsection
@section('content')
    <div class="dashboard-container">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-left">

                <div class="header-info">
                    <h1>Dashboard</h1>
                    <p>¡Hola {{ Auth::user()->name }}! Bienvenido a tu Pasanaco Digital</p>
                </div>
            </div>

        </header>

        <!-- Recent Activity and Upcoming Sorteos -->
        <div class="content-grid">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i>
                        Sesiones Iniciadas
                    </h3>
                </div>
                @if ($sesionesRecientes->count() > 0)
                    @foreach ($sesionesRecientes as $sesion)
                        <div class="recent-item">
                            <div class="item-info">
                                <h4>{{ $sesion->nombre_sesion }}</h4>
                                <p>Cuota: ${{ number_format($sesion->cuota ?? 0) }} •
                                    {{ $sesion->estado }}</p>
                            </div>
                            <a href="{{ route('sesiones.operativa', $sesion->id) }}" class="btn btn-primary">Gestionar</a>
                        </div>
                    @endforeach
                @else
                    <div class="recent-item">
                        <div class="item-info">
                            <h4>No hay sesiones recientes</h4>
                            <p>Crea tu primera sesión para comenzar</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number">{{ $participantes }}</div>
                    <div class="stat-label">Participantes</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-circle-play"></i>
                    </div>
                    <div class="stat-number">{{ $sesionesActivas }}</div>
                    <div class="stat-label">Sesiones Activas</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-number">{{ $sesiones }}</div>
                    <div class="stat-label">Total Sesiones Creadas</div>
                </div>


            </div>


            <!-- Quick Actions -->
            <div class="actions-section">
                <h2 class="section-title">
                    <i class="fas fa-bolt"></i>
                    Acciones Rápidas
                </h2>
                <div class="actions-grid">
                    <a href="{{ route('sesiones.form') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="action-info">
                            <h3>Crear Sesión</h3>
                            <p>Inicia un nuevo ciclo de Pasanaco</p>
                        </div>
                    </a>

                    <a href="{{ route('participantes.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="action-info">
                            <h3>Gestionar Participantes</h3>
                            <p>Administra tu comunidad</p>
                        </div>
                    </a>

                    {{-- <a href="{{ route('sesiones.listado') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-dice"></i>
                    </div>
                    <div class="action-info">
                        <h3>Realizar Sorteos</h3>
                        <p>Determina el orden de cobro</p>
                    </div>
                </a> --}}

                    {{-- <a href="{{ route('modos.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="action-info">
                        <h3>Configurar Modos</h3>
                        <p>Personaliza las modalidades</p>
                    </div>
                </a> --}}
                </div>
            </div>



            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-trophy"></i>
                        Próximos Sorteos
                    </h3>
                </div>
                @if ($proximosSorteos->count() > 0)
                    @foreach ($proximosSorteos as $sorteo)
                        <div class="recent-item">
                            <div class="item-info">
                                <h4>{{ $sorteo->nombre_sesion }}</h4>
                                <p>Cuota: ${{ number_format($sorteo->cuota ?? 0) }} • Listo para sorteo</p>
                            </div>
                            <a href="{{ route('sesiones.sorteo', $sorteo->id) }}" class="item-status status-pending"
                                style="text-decoration: none;">
                                Sortear
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="recent-item">
                        <div class="item-info">
                            <h4>No hay sorteos pendientes</h4>
                            <p>Todas las sesiones activas ya tienen sorteo</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- PWA Service Worker -->

@endsection
@section('js')
    <script>
        // Registrar Service Worker para PWA
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js', {
                        scope: '/'
                    })
                    .then(function(registration) {
                        console.log('Service Worker registrado con éxito:', registration.scope);
                    })
                    .catch(function(error) {
                        console.error('Error al registrar Service Worker:', error);
                    });
            });
        }

        // Confirmación de logout
        document.querySelector('.logout-btn').addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
                e.preventDefault();
            }
        });
    </script>

    <!-- PWA Install Button específico para Home Dashboard -->
    <script src="{{ asset('assets/js/home-pwa-install.js') }}"></script>
@endsection
