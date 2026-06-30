const CACHE_NAME = 'minecart-cache-v1';
const OFFLINE_URL = '/offline';
const URLS_TO_CACHE = [
    '/',
    '/offline',
    '/css/style.css',
    '/css/seller.css',
    '/js/ui.js',
    '/js/auth.js',
    '/js/cart-actions.js',
    '/assets/logo-minecart.png',
    '/assets/logo-keranjang-terang.png',
    '/assets/logo-keranjang-gelap.png'
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(URLS_TO_CACHE);
        })
    );
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.filter(cacheName => cacheName !== CACHE_NAME)
                          .map(cacheName => caches.delete(cacheName))
            );
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', event => {
    // Only handle GET requests for PWA
    if (event.request.method !== 'GET') return;

    event.respondWith(
        fetch(event.request).catch(() => {
            return caches.match(event.request).then(response => {
                if (response) {
                    return response;
                }
                
                // If it's an HTML page request and it fails, return the offline page
                if (event.request.headers.get('accept').includes('text/html')) {
                    return caches.match(OFFLINE_URL);
                }
                
                return new Response('', { status: 404, statusText: 'Not Found' });
            });
        })
    );
});
