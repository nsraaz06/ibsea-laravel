const CACHE_NAME = 'ibsea-v1';
const ASSETS = [
    '/',
    '/?utm_source=pwa',
    '/css/global.css',
    '/ibsea-text-33w-600x83.png.webp',
    '/pwa-192x192.png',
    '/pwa-512x512.png'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
