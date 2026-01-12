<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>Descarga de Qr</title>


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
            <img src="{{Storage::url($sesion->qrcobro)}}" alt="Qr Image" style="max-width: 300px;">
        </section>
        <div class="cta">
                <a href="{{Storage::url($sesion->qrcobro)}}" download>
                    Descargar 📥
                </a>
            </div>
        <footer>© 2025 Pasanaco Digital – Impulsando el ahorro del futuro.</footer>
    </div>

    <!-- PWA Service Worker y botón de instalación -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

</html>
