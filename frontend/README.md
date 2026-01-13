# QUPO - Frontend

Frontend de QUPO (React + Vite + PWA). Este directorio contendrá la aplicación PWA orientada mobile-first.

Pasos iniciales (manual):
1. Instalar Node 18+
2. Ejecutar: `npm init @vitejs/app` o `npm create vite@latest` y escoger React
3. Instalar dependencias: `npm install`
4. Configurar `vite-plugin-pwa` y `@stripe/react-stripe-js` para pagos

Docker: habrá un `Dockerfile` para build y servir con `nginx` en producción.
