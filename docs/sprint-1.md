# Sprint 1 - MVP (2 semanas)

Objetivo: Entregar la base del backend y frontend para onboarding de merchants y flujo básico de reservas y health checks.

Epics & Stories:

- Epic: Infra y herramientas
  - Setup GitHub Actions para frontend/backend — 1d
  - Docker compose local para dev — 1d

- Epic: Backend core
  - Instalar Laravel y configurar entorno de desarrollo — 1d
  - Endpoint health `/health` y test automático — 0.5d
  - Model `Merchant` (migrations + factory) y CRUD básico — 3d
  - Auth básico (Sanctum) y registro de merchants — 2d

- Epic: Frontend shell
  - Scaffolding React + PWA + componente de login — 2d
  - Página de listado de servicios (mock) — 1d

Criterios de aceptación: repos iniciados, tests ejecutables en CI, `GET /health` responde 200, merchant puede registrarse (mock), PWA instalable.
