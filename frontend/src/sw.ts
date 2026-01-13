/// <reference lib="webworker" />
// Service worker stub - use Workbox or vite-plugin-pwa for production
// Kept minimal and typed for TypeScript
/* eslint-disable @typescript-eslint/no-explicit-any */

const sw: any = self;

sw.addEventListener('install', (event: any) => {
  event.waitUntil(sw.skipWaiting())
})

sw.addEventListener('activate', (event: any) => {
  event.waitUntil(sw.clients.claim())
})

sw.addEventListener('fetch', () => {
  // Implement caching strategies (Stale-While-Revalidate)
})
