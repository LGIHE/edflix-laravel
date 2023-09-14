var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/assets/css/nucleo-svg.css',
    '/assets/css/nucleo-icons.css',
    '/assets/img/logos/edflix-favicon.png',
    '/assets/css/material-dashboard.css?v=3.0.0',
    '/assets/img/logos/actnow_logo.png',

    'https://kit.fontawesome.com/42d5adcbca.js',
    'https://code.jquery.com/jquery-3.3.1.min.js',
    'https://fonts.googleapis.com/icon?family=Material+Icons+Round',
    'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
    'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700',

    'https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css',
    'https://cdn.datatables.net/buttons/2.3.5/css/buttons.bootstrap4.min.css',
    'https://cdn.datatables.net/colreorder/1.6.1/css/colReorder.bootstrap4.min.css',
    'https://cdn.datatables.net/fixedcolumns/4.2.1/css/fixedColumns.dataTables.min.css',
    'https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css',

    '/assets/js/core/popper.min.js',
    '/assets/js/core/bootstrap.min.js',
    '/assets/js/plugins/perfect-scrollbar.min.js',
    '/assets/js/plugins/smooth-scrollbar.min.js',
    '/assets/js/material-dashboard.min.js?v=3.0.0',

    'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.min.js',
    'https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js',
    'https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js',
    'https://cdn.datatables.net/buttons/2.3.5/js/buttons.bootstrap4.min.js',
    'https://cdn.datatables.net/buttons/2.3.5/js/buttons.colVis.min.js',
    'https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js',
    'https://cdn.datatables.net/buttons/2.3.5/js/buttons.print.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js',
    'https://cdn.datatables.net/colreorder/1.6.1/js/dataTables.colReorder.min.js',
    'https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js',
    'https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js',

    '/offline',
    '/dashboard',
    '/lesson-plans',
    '/create-lesson-plan',


    '/images/icons/icon-72.png',
    '/images/icons/icon-96.png',
    '/images/icons/icon-128.png',
    '/images/icons/icon-144.png',
    '/images/icons/icon-152.png',
    '/images/icons/icon-192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512.png',

];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});
