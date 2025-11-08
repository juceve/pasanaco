const CACHE_NAME = 'pasanaco-v1.1.0';
const urlsToCache = [
  // Solo recursos estáticos - NO rutas dinámicas
  '/css/toastcolor.css',
  '/assets/template/css/styles.css',
  '/assets/template/js/bootstrap.bundle.min.js',
  '/assets/template/js/scripts.js',
  '/assets/template/js/all.js',
  '/assets/template/js/jquery.min.js',
  '/assets/sweetalert2/sweetalert2@11.js',
  '/assets/datatables/dataTables.js',
  '/assets/datatables/dataTables.dataTables.css',
  '/images/logo.png',
  '/images/icons/icon-192x192.png',
  '/images/icons/icon-512x512.png',
  '/manifest.json',
  // Fonts de Google (críticos para offline)
  'https://fonts.googleapis.com/css?family=Montserrat:400,700',
  'https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic'
  // REMOVED: Select2 CDN - se cargará dinámicamente
  // REMOVED: Rutas de aplicación - requieren autenticación
];

// Instalación del Service Worker
self.addEventListener('install', event => {
  console.log('Service Worker: Installing...');
  self.skipWaiting(); // Forzar activación inmediata
  
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Service Worker: Caching files');
        // Cachear archivos uno por uno para manejar errores individualmente
        return Promise.allSettled(
          urlsToCache.map(url => 
            cache.add(url).catch(err => {
              console.log(`Service Worker: Failed to cache ${url}:`, err);
              return null; // Continuar con otros archivos
            })
          )
        );
      })
      .then(results => {
        const successful = results.filter(result => result.status === 'fulfilled').length;
        const failed = results.filter(result => result.status === 'rejected').length;
        console.log(`Service Worker: Cached ${successful} files, ${failed} failed`);
      })
      .catch(err => {
        console.log('Service Worker: Cache setup failed', err);
      })
  );
});

// Activación del Service Worker
self.addEventListener('activate', event => {
  console.log('Service Worker: Activating...');
  
  event.waitUntil(
    Promise.all([
      // Limpiar caches antiguos
      caches.keys().then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            if (cacheName !== CACHE_NAME) {
              console.log('Service Worker: Deleting old cache', cacheName);
              return caches.delete(cacheName);
            }
          })
        );
      }),
      // Tomar control de todas las pestañas abiertas
      self.clients.claim()
    ]).then(() => {
      console.log('Service Worker: Activated and ready');
    })
  );
});

// Intercepción de peticiones - Estrategia Selectiva
self.addEventListener('fetch', event => {
  const requestUrl = new URL(event.request.url);
  
  // Solo procesar peticiones GET
  if (event.request.method !== 'GET') {
    return;
  }

  // Filtrar esquemas no soportados
  if (requestUrl.protocol !== 'http:' && requestUrl.protocol !== 'https:') {
    return;
  }

  // Ignorar completamente URLs dinámicas que requieren autenticación o lógica del servidor
  const dynamicPaths = [
    '/livewire/',
    '/api/',
    '/broadcasting/',
    '/login',
    '/logout', 
    '/register',
    '/sesiones',
    '/participantes',
    '/dashboard',
    '/home',
    '/users',
    '/modos',
    '_token',
    'socket.io',
    'XSRF-TOKEN'
  ];

  if (dynamicPaths.some(path => event.request.url.includes(path))) {
    return; // Dejar que Laravel maneje completamente
  }

  // Solo permitir hosts conocidos
  const allowedHosts = [
    location.hostname,
    'fonts.googleapis.com',
    'fonts.gstatic.com'
  ];

  if (!allowedHosts.includes(requestUrl.hostname)) {
    return;
  }

  // Determinar estrategia según el tipo de recurso
  const isStaticAsset = /\.(css|js|png|jpg|jpeg|gif|svg|ico|woff|woff2|ttf|eot)$/i.test(requestUrl.pathname) ||
                      requestUrl.pathname.startsWith('/assets/') ||
                      requestUrl.pathname.startsWith('/images/') ||
                      requestUrl.pathname.startsWith('/css/') ||
                      requestUrl.hostname === 'fonts.googleapis.com' ||
                      requestUrl.hostname === 'fonts.gstatic.com';

  if (isStaticAsset) {
    // CACHE FIRST para recursos estáticos
    event.respondWith(
      caches.match(event.request)
        .then(response => {
          if (response) {
            console.log('Service Worker: Serving static asset from cache', event.request.url);
            return response;
          }

          return fetch(event.request)
            .then(response => {
              if (response && response.status === 200) {
                const responseToCache = response.clone();
                caches.open(CACHE_NAME)
                  .then(cache => {
                    cache.put(event.request, responseToCache).catch(err => {
                      console.log('Service Worker: Error caching static asset', err);
                    });
                  });
              }
              return response;
            })
            .catch(err => {
              console.log('Service Worker: Failed to fetch static asset', event.request.url);
              return caches.match(event.request);
            });
        })
    );
  } else {
    // NETWORK FIRST para páginas HTML (mantiene autenticación)
    event.respondWith(
      fetch(event.request)
        .then(response => {
          console.log('Service Worker: Serving page from network', event.request.url);
          return response;
        })
        .catch(err => {
          console.log('Service Worker: Network failed for page', event.request.url);
          // Solo como último recurso, mostrar página offline simple
          if (event.request.destination === 'document') {
            return new Response(`
              <!DOCTYPE html>
              <html>
                <head>
                  <title>Sin Conexión - Pasanaco</title>
                  <style>
                    body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                    .offline { color: #666; }
                  </style>
                </head>
                <body>
                  <div class="offline">
                    <h1>Sin Conexión</h1>
                    <p>Por favor, verifica tu conexión a internet e intenta nuevamente.</p>
                    <button onclick="window.location.reload()">Reintentar</button>
                  </div>
                </body>
              </html>
            `, {
              headers: { 'Content-Type': 'text/html' }
            });
          }
          throw err;
        })
    );
  }
});

// Escuchar mensajes para limpiar cache
self.addEventListener('message', event => {
  if (event.data && event.data.type === 'CLEAR_CACHE') {
    console.log('Service Worker: Clearing all caches');
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          console.log('Service Worker: Deleting cache', cacheName);
          return caches.delete(cacheName);
        })
      );
    }).then(() => {
      console.log('Service Worker: All caches cleared');
      event.ports[0].postMessage({success: true});
    });
  }
});

// Push notifications (para futuras implementaciones)
self.addEventListener('push', event => {
  console.log('Service Worker: Push received');
  
  const options = {
    body: event.data ? event.data.text() : 'Nueva notificación de Pasanaco',
    icon: '/images/icons/icon-192x192.png',
    badge: '/images/icons/icon-72x72.png',
    vibrate: [200, 100, 200],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: '1'
    },
    actions: [
      {
        action: 'explore',
        title: 'Ver detalles',
        icon: '/images/icons/icon-192x192.png'
      },
      {
        action: 'close',
        title: 'Cerrar',
        icon: '/images/icons/icon-192x192.png'
      }
    ]
  };

  event.waitUntil(
    self.registration.showNotification('Pasanaco', options)
  );
});

// Manejo de clicks en notificaciones
self.addEventListener('notificationclick', event => {
  console.log('Service Worker: Notification clicked');
  event.notification.close();

  if (event.action === 'explore') {
    // Abrir la aplicación
    event.waitUntil(
      clients.openWindow('/')
    );
  }
});