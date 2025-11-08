<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>{{ __('Register') }} - Pasanaco Digital</title>

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

    <style>
        /* ===========================
       RESET + BASE (adaptado de welcome)
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
            scroll-behavior: smooth;
            transition: background 0.5s ease;
        }

        body {
            min-height: 100vh;
            min-height: -webkit-fill-available;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: env(safe-area-inset-top, 20px) 20px env(safe-area-inset-bottom, 20px);
        }

        .register-container {
            position: relative;
            width: 100%;
            max-width: 500px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 22px;
            box-shadow: 0 10px 40px rgba(0, 255, 255, 0.15);
            text-align: center;
            overflow: hidden;
            animation: fadeIn 1s ease-in-out;
            transition: all 0.4s ease;
            margin: 10px 0;
        }

        .bg-tech {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
            opacity: 0.25;
            filter: blur(4px);
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        /* ===========================
       HEADER
    ============================ */
        .register-header {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            padding: 35px 20px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .register-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 255, 0.6), transparent);
        }

        .register-header img {
            width: 75px;
            height: 75px;
            object-fit: contain;
            border-radius: 50%;
            margin-bottom: 10px;
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.3);
            transition: transform 0.4s ease;
        }

        .register-header h1 {
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 6px;
            text-shadow: 0 0 15px rgba(0, 255, 255, 0.3);
        }

        .register-header p {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        /* ===========================
       FORM
    ============================ */
        .register-form {
            padding: 25px 25px 30px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #00e5ff;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 11px 15px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: #00d2ff;
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Estados de error */
        .form-input.is-invalid {
            border-color: #ff4757;
            box-shadow: 0 0 15px rgba(255, 71, 87, 0.3);
        }

        .invalid-feedback {
            display: block;
            color: #ff6b7a;
            font-size: 0.8rem;
            margin-top: 5px;
            font-weight: 500;
        }

        /* ===========================
       BUTTONS
    ============================ */
        .register-button {
            width: 100%;
            background: linear-gradient(90deg, #00d2ff, #3a7bd5);
            border: none;
            padding: 13px 40px;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.25);
            margin: 15px 0;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.5);
        }

        .back-home {
            display: inline-block;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .back-home:hover {
            color: #fff;
        }

        .login-link {
            display: inline-block;
            color: #00e5ff;
            text-decoration: none;
            font-size: 0.9rem;
            margin-left: 10px;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            color: #00d2ff;
            text-shadow: 0 0 8px rgba(0, 210, 255, 0.5);
        }

        /* ===========================
       ANIMATIONS
    ============================ */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ===========================
       RESPONSIVE
    ============================ */
        @media (max-width: 430px) and (max-height: 900px) {
            body {
                align-items: flex-start;
                padding-top: calc(env(safe-area-inset-top, 20px) + 5px);
            }

            .register-container {
                margin-top: 5px;
                margin-bottom: 10px;
                border-radius: 20px;
                max-width: 95%;
            }

            .register-header {
                padding: 30px 20px 20px;
            }

            .register-header img {
                width: 70px;
                height: 70px;
            }

            .register-header h1 {
                font-size: 1.6rem;
            }

            .register-form {
                padding: 20px 20px 25px;
            }

            .form-group {
                margin-bottom: 15px;
            }
        }

        @media (max-height: 700px) {
            .register-header {
                padding: 25px 20px 20px;
            }

            .register-header img {
                width: 65px;
                height: 65px;
            }

            .register-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="bg-tech"></div>
        
        <div class="register-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Pasanaco Digital" />
            <h1>¡Únete a Nosotros!</h1>
            <p>Crea tu cuenta de Pasanaco Digital</p>
        </div>

        <div class="register-form">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">{{ __('Nombre Completo') }}</label>
                    <input 
                        id="name" 
                        type="text" 
                        class="form-input @error('name') is-invalid @enderror" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autocomplete="name" 
                        autofocus
                        placeholder="Tu nombre completo"
                    >
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input 
                        id="email" 
                        type="email" 
                        class="form-input @error('email') is-invalid @enderror" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="email"
                        placeholder="tu@email.com"
                    >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                    <input 
                        id="password" 
                        type="password" 
                        class="form-input @error('password') is-invalid @enderror" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                    <input 
                        id="password-confirm" 
                        type="password" 
                        class="form-input" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••"
                    >
                </div>

                <button type="submit" class="register-button">
                    {{ __('Crear Cuenta') }} 🎉
                </button>

                <div style="text-align: center;">
                    <a class="back-home" href="{{ url('/') }}">
                        ← Volver al inicio
                    </a>
                    <a class="login-link" href="{{ route('login') }}">
                        ¿Ya tienes cuenta? Inicia sesión
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- PWA Service Worker -->
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
    </script>

</body>

</html>
