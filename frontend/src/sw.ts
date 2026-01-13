// Service worker stub - use Workbox or vite-plugin-pwa for production
// Kept minimal and typed for TypeScript
declare const self: ServiceWorkerGlobalScope;

self.addEventListener('install', (event: ExtendableEvent) => {
  self.skipWaiting()
})

self.addEventListener('activate', (event: ExtendableEvent) => {
  (self as any).clients.claim()
})

self.addEventListener('fetch', (event: FetchEvent) => {
  // Implement caching strategies (Stale-While-Revalidate)
})
