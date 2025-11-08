<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Pasanaco Digital – Tu comunidad financiera inteligente</title>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#1abc9c" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="apple-mobile-web-app-title" content="Pasanaco" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="application-name" content="Pasanaco" />

    <!-- PWA Icons -->
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-192x192.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/icons/icon-152x152.png') }}" />
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('images/icons/icon-192x192.png') }}" />

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
</head>

<body>

    <div class="container">
        <div class="bg-tech"></div>
        <header>
            <img src="{{ asset('images/logo.png') }}" alt="Logo Pasanaco Digital" />
            <h1>Pasanaco Digital</h1>
            <p>La evolución de la confianza y el ahorro colectivo 💎</p>
        </header>

        <section class="features">
            <h2>Tu nueva forma de cooperar</h2>
            <ul>
                <li>Digitaliza el clásico PASANACO con transparencia y agilidad.</li>
                <li>Recibe notificaciones, controla tus turnos y pagos fácilmente.</li>
                <li>Seguridad blockchain y respaldo financiero automatizado.</li>
                <li>Comparte el progreso con tu comunidad y crezcan juntos.</li>
            </ul>
            <div class="cta">
                <a
                    @auth
                      href="{{ route('home') }}"
                    @else    
                      href="{{ route('login') }}" @endauth>
                    Comienza ahora 🚀
                </a>
            </div>
        </section>
        <footer>© 2025 Pasanaco Digital – Impulsando el ahorro del futuro.</footer>
    </div>

    <!-- PWA Service Worker y botón de instalación -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

</html>
