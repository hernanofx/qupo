# Implementation log

Registro de acciones realizadas por el asistente al iniciar el proyecto QUPO.

- Inicializada estructura del repo y archivos base (README, .gitignore, .editorconfig).
- Agregado CI stub en `.github/workflows/ci.yml`.
- Scaffolding frontend (Vite/React): `frontend/` con `src/`, `index.html`, `package.json`, PWA stubs. Migrated frontend to TypeScript (.tsx) and added `tsconfig.json`; updated `package.json` to include `typescript` and `@types/*` dev dependencies.
- Scaffolding backend: `backend/` con `Dockerfile`, `.env.example`, `docker-compose.yml`.
- Añadido `infra/docker-compose.yml` y `docs/` con plan y backlog inicial.

Siguientes pasos:
- Instalar Laravel en `backend/` (composer) y configurar conexión a DB. ✅ (instalado)
- Implementar primera API (auth + merchant onboarding).
- Configurar GitHub Actions con jobs de build/test. ✅ (actualizado para ejecutar tests de backend)

Cambios recientes:
- Laravel instalado en `backend/` y archivos base añadidos.
- Ruta `/health` añadida en `routes/web.php` y prueba `HealthTest` creada y pasada localmente.
- CI actualizado para habilitar `pdo_sqlite` y ejecutar `php artisan test` en el job de backend.
- Sprint 1 añadido en `docs/sprint-1.md`.
- Documento `docs/setup-local.md` añadido con pasos para levantar el entorno local.
- Repositorio remoto añadido: `https://github.com/hernanofx/qupo.git` y rama `master` empujada al remoto (tracking configurado).
- Implementada autenticación básica con Sanctum, migraciones y tabla `personal_access_tokens`.
- Creado modelo `Merchant` con migration y CRUD básico y pruebas (`MerchantAuthTest`).
- Añadido endpoint de pago (Stripe Checkout session) y SDK (`stripe/stripe-php`).
