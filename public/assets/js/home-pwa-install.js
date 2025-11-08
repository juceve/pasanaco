// PWA Install Button específico para Home Dashboard
// Este script solo se carga en la página home.blade.php

let homeDeferredPrompt;
let homeInstallButton = null;
let homeIsInstallable = false;

// Detectar evento de instalación disponible
window.addEventListener('beforeinstallprompt', (e) => {
    console.log('PWA: Instalación disponible en Home Dashboard');
    e.preventDefault();
    homeDeferredPrompt = e;
    homeIsInstallable = true;
    showHomeInstallButton();
});

// Verificar si está en modo standalone
function isHomeStandalone() {
    return window.matchMedia('(display-mode: standalone)').matches || 
           window.navigator.standalone === true;
}

// Crear botón de instalación específico para Home
function showHomeInstallButton() {
    if (isHomeStandalone() || homeInstallButton) {
        return;
    }

    homeInstallButton = document.createElement('button');
    homeInstallButton.innerHTML = `
        <i class="fas fa-mobile-alt me-2"></i>
        <span>Instalar App</span>
    `;
    homeInstallButton.className = 'btn position-fixed shadow-lg';
    homeInstallButton.style.cssText = `
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
        animation: home-pulse-install 2s infinite;
    `;
    
    // Efectos hover y click
    homeInstallButton.addEventListener('mouseenter', () => {
        homeInstallButton.style.transform = 'scale(1.05)';
        homeInstallButton.style.boxShadow = '0 8px 25px rgba(26, 188, 156, 0.6)';
    });
    
    homeInstallButton.addEventListener('mouseleave', () => {
        homeInstallButton.style.transform = 'scale(1)';
        homeInstallButton.style.boxShadow = '0 6px 20px rgba(26, 188, 156, 0.4)';
    });

    homeInstallButton.addEventListener('click', installHomeApp);
    document.body.appendChild(homeInstallButton);

    // Agregar animación CSS específica para Home
    if (!document.getElementById('home-pwa-install-styles')) {
        const style = document.createElement('style');
        style.id = 'home-pwa-install-styles';
        style.textContent = `
            @keyframes home-pulse-install {
                0% { box-shadow: 0 6px 20px rgba(26, 188, 156, 0.4); }
                50% { box-shadow: 0 6px 30px rgba(26, 188, 156, 0.8); }
                100% { box-shadow: 0 6px 20px rgba(26, 188, 156, 0.4); }
            }
        `;
        document.head.appendChild(style);
    }

    console.log('PWA: Botón de instalación mostrado en Home');
}

// Función para instalar desde Home
function installHomeApp() {
    if (homeDeferredPrompt) {
        console.log('PWA: Iniciando instalación desde Home...');
        
        homeInstallButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Instalando...';
        homeInstallButton.disabled = true;
        
        homeDeferredPrompt.prompt();
        
        homeDeferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === 'accepted') {
                console.log('PWA: Usuario aceptó la instalación desde Home');
                hideHomeInstallButton();
                showHomeInstallSuccess();
            } else {
                console.log('PWA: Usuario rechazó la instalación desde Home');
                homeInstallButton.innerHTML = '<i class="fas fa-mobile-alt me-2"></i>Instalar App';
                homeInstallButton.disabled = false;
            }
            homeDeferredPrompt = null;
        });
    }
}

// Ocultar botón de instalación
function hideHomeInstallButton() {
    if (homeInstallButton) {
        homeInstallButton.style.opacity = '0';
        homeInstallButton.style.transform = 'scale(0.8)';
        setTimeout(() => {
            if (homeInstallButton && homeInstallButton.parentNode) {
                homeInstallButton.parentNode.removeChild(homeInstallButton);
                homeInstallButton = null;
            }
        }, 300);
    }
}

// Mostrar mensaje de éxito
function showHomeInstallSuccess() {
    const successMsg = document.createElement('div');
    successMsg.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>
        ¡App instalada correctamente!
    `;
    successMsg.className = 'position-fixed alert shadow-lg';
    successMsg.style.cssText = `
        bottom: 20px; 
        right: 20px; 
        z-index: 10000; 
        border-radius: 25px; 
        padding: 15px 20px;
        border: none;
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
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

// Detectar cuando la app se instala
window.addEventListener('appinstalled', (evt) => {
    console.log('PWA: Aplicación instalada desde Home Dashboard');
    hideHomeInstallButton();
    showHomeInstallSuccess();
});

// Verificar estado inicial - solo en Home
document.addEventListener('DOMContentLoaded', () => {
    if (!isHomeStandalone()) {
        console.log('PWA: Verificando instalabilidad en Home Dashboard');
        setTimeout(() => {
            if (homeIsInstallable && !isHomeStandalone()) {
                showHomeInstallButton();
            }
        }, 2000);
    } else {
        console.log('PWA: Ya ejecutándose en modo standalone en Home');
    }
});