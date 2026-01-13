// Service worker stub - use Workbox or vite-plugin-pwa for production
self.addEventListener('install', event => {
  self.skipWaiting()
})

self.addEventListener('activate', event => {
  clients.claim()
})

self.addEventListener('fetch', event => {
  // Implement caching strategies (Stale-While-Revalidate)
})
