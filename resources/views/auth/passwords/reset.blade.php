<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>{{ __('Restablecer Contraseña') }} - Pasanaco Digital</title>

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
       RESET + BASE
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

        .reset-container {
            position: relative;
            width: 100%;
            max-width: 480px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border-radius: 22px;
            box-shadow: 0 10px 40px rgba(0, 255, 255, 0.15);
            text-align: center;
            overflow: hidden;
            animation: fadeIn 1s ease-in-out;
            transition: all 0.4s ease;
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
        .reset-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 40px 20px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .reset-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.6), transparent);
        }

        .reset-header img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 50%;
            margin-bottom: 12px;
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.3);
            transition: transform 0.4s ease;
        }

        .reset-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 0 15px rgba(102, 126, 234, 0.3);
        }

        .reset-header p {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.5;
        }

        /* ===========================
       FORM
    ============================ */
        .reset-form {
            padding: 30px 25px;
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #a78bfa;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: #a78bfa;
            box-shadow: 0 0 15px rgba(167, 139, 250, 0.3);
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
            font-size: 0.85rem;
            margin-top: 6px;
            font-weight: 500;
        }

        .password-hint {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 5px;
        }

        /* ===========================
       BUTTONS
    ============================ */
        .submit-button {
            width: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border: none;
            padding: 14px 40px;
            color: #fff;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.25);
            margin-bottom: 15px;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 25px rgba(102, 126, 234, 0.5);
        }

        .back-login {
            display: inline-block;
            color: #a78bfa;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .back-login:hover {
            color: #c4b5fd;
            text-shadow: 0 0 8px rgba(167, 139, 250, 0.5);
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
                padding-top: calc(env(safe-area-inset-top, 20px) + 10px);
            }

            .reset-container {
                margin-top: 10px;
                margin-bottom: 15px;
                border-radius: 20px;
            }

            .reset-header {
                padding: 35px 20px 25px;
            }

            .reset-header img {
                width: 75px;
                height: 75px;
            }

            .reset-header h1 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="reset-container">
        <div class="bg-tech"></div>
        
        <div class="reset-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Pasanaco Digital" />
            <h1>Restablecer Contraseña</h1>
            <p>Ingresa tu nueva contraseña segura</p>
        </div>

        <div class="reset-form">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input 
                        id="email" 
                        type="email" 
                        class="form-input @error('email') is-invalid @enderror" 
                        name="email" 
                        value="{{ $email ?? old('email') }}" 
                        required 
                        autocomplete="email" 
                        autofocus
                        placeholder="tu@email.com"
                    >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                    <input 
                        id="password" 
                        type="password" 
                        class="form-input @error('password') is-invalid @enderror" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••"
                    >
                    <div class="password-hint">Mínimo 8 caracteres</div>
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

                <button type="submit" class="submit-button">
                    {{ __('Restablecer Contraseña') }} 🔐
                </button>

                <div style="text-align: center;">
                    <a class="back-login" href="{{ route('login') }}">
                        ← Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- PWA Service Worker -->
    <script>
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
