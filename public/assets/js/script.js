
// Registrar Service Worker para PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/sw.js', {
            scope: '/'
        })
            .then(function (registration) {
                console.log('Service Worker registrado con éxito:', registration.scope);

                // Verificar actualizaciones
                registration.addEventListener('updatefound', () => {
                    console.log('Service Worker: Nueva versión disponible');
                });
            })
            .catch(function (error) {
                console.error('Error al registrar Service Worker:', error);
            });
    });
}

// PWA Install Prompt para Welcome
let deferredPrompt;
let installButton = null;
let isInstallable = false;

// Detectar evento de instalación disponible
window.addEventListener('beforeinstallprompt', (e) => {
    console.log('PWA: Instalación disponible en Welcome');
    e.preventDefault();
    deferredPrompt = e;
    isInstallable = true;
    showWelcomeInstallButton();
});

// Verificar si está en modo standalone
function isStandalone() {
    return window.matchMedia('(display-mode: standalone)').matches ||
        window.navigator.standalone === true;
}

// Crear botón de instalación específico para Welcome
function showWelcomeInstallButton() {
    if (isStandalone() || installButton) {
        return;
    }

    installButton = document.createElement('button');
    installButton.innerHTML = `
                <span style="font-size: 16px;">📱</span>
                <span style="margin-left: 8px;">Instalar App</span>
            `;
    installButton.style.cssText = `
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 10000;
                background: linear-gradient(90deg, #00d2ff, #3a7bd5);
                border: none;
                color: white;
                padding: 12px 25px;
                border-radius: 50px;
                font-family: 'Poppins', sans-serif;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                box-shadow: 0 6px 20px rgba(0, 210, 255, 0.4);
                transition: all 0.3s ease;
                animation: welcome-pulse 2s infinite;
            `;

    installButton.addEventListener('mouseenter', () => {
        installButton.style.transform = 'translateX(-50%) scale(1.05)';
        installButton.style.boxShadow = '0 8px 25px rgba(0, 210, 255, 0.6)';
    });

    installButton.addEventListener('mouseleave', () => {
        installButton.style.transform = 'translateX(-50%) scale(1)';
        installButton.style.boxShadow = '0 6px 20px rgba(0, 210, 255, 0.4)';
    });

    installButton.addEventListener('click', installWelcomeApp);
    document.body.appendChild(installButton);

    // Agregar animación específica
    if (!document.getElementById('welcome-install-styles')) {
        const style = document.createElement('style');
        style.id = 'welcome-install-styles';
        style.textContent = `
                    @keyframes welcome-pulse {
                        0% { box-shadow: 0 6px 20px rgba(0, 210, 255, 0.4); }
                        50% { box-shadow: 0 6px 30px rgba(0, 210, 255, 0.8); }
                        100% { box-shadow: 0 6px 20px rgba(0, 210, 255, 0.4); }
                    }
                `;
        document.head.appendChild(style);
    }
}

// Función para instalar desde Welcome
function installWelcomeApp() {
    if (deferredPrompt) {
        installButton.innerHTML = `
                    <span style="font-size: 16px;">⏳</span>
                    <span style="margin-left: 8px;">Instalando...</span>
                `;
        installButton.disabled = true;

        deferredPrompt.prompt();

        deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('PWA: Usuario aceptó la instalación desde Welcome');
                hideWelcomeInstallButton();
                showWelcomeInstallSuccess();
            } else {
                console.log('PWA: Usuario rechazó la instalación desde Welcome');
                installButton.innerHTML = `
                            <span style="font-size: 16px;">📱</span>
                            <span style="margin-left: 8px;">Instalar App</span>
                        `;
                installButton.disabled = false;
            }
            deferredPrompt = null;
        });
    }
}

// Ocultar botón de instalación
function hideWelcomeInstallButton() {
    if (installButton) {
        installButton.style.opacity = '0';
        installButton.style.transform = 'translateX(-50%) scale(0.8)';
        setTimeout(() => {
            if (installButton && installButton.parentNode) {
                installButton.parentNode.removeChild(installButton);
                installButton = null;
            }
        }, 300);
    }
}

// Mostrar mensaje de éxito
function showWelcomeInstallSuccess() {
    const successMsg = document.createElement('div');
    successMsg.innerHTML = `
                <span style="font-size: 20px;">✅</span>
                <span style="margin-left: 10px;">¡App instalada correctamente!</span>
            `;
    successMsg.style.cssText = `
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 10000;
                background: linear-gradient(90deg, #00d084, #00d2ff);
                color: white;
                padding: 15px 25px;
                border-radius: 50px;
                font-family: 'Poppins', sans-serif;
                font-size: 14px;
                font-weight: 600;
                box-shadow: 0 6px 20px rgba(0, 208, 132, 0.4);
                animation: slideUp 0.5s ease;
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

// Función para limpiar cache desde Welcome
function clearWelcomeCache() {
    if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
        const messageChannel = new MessageChannel();
        messageChannel.port1.onmessage = function (event) {
            if (event.data.success) {
                alert('Cache PWA limpiado. La página se recargará.');
                window.location.reload();
            }
        };
        navigator.serviceWorker.controller.postMessage({
            type: 'CLEAR_CACHE'
        },
            [messageChannel.port2]
        );
    } else {
        if ('caches' in window) {
            caches.keys().then(names => {
                names.forEach(name => caches.delete(name));
            }).then(() => {
                alert('Cache limpiado. La página se recargará.');
                window.location.reload();
            });
        }
    }
}

// Detectar instalación
window.addEventListener('appinstalled', (evt) => {
    console.log('PWA: Aplicación instalada desde Welcome');
    hideWelcomeInstallButton();
    showWelcomeInstallSuccess();
});

// Verificar estado inicial después de carga
document.addEventListener('DOMContentLoaded', () => {
    if (!isStandalone()) {
        setTimeout(() => {
            if (isInstallable) {
                showWelcomeInstallButton();
            }
        }, 3000); // Mostrar después de 3 segundos para no interferir con la experiencia inicial
    }
});
