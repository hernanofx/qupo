# Sprint 1 - Reporte (Resumen y entregables)

Periodo: Sprint inicial (configuración y MVP backend + frontend shell)

## Objetivos del sprint
- Preparar el entorno y la infraestructura mínima. 
- Implementar autenticación (Sanctum) y onboarding de merchants.
- Implementar modelos clave: Merchant, Service, Availability, Booking, Payment.
- Implementar endpoint de pago (Stripe Checkout) y webhook para confirmar pagos.
- Scaffolding frontend (PWA) con páginas de registro y login.
- Tests de integración para flows críticos (registro, booking, webhook).

## Entregables completados ✅
- Repositorio inicial con estructura: `backend/`, `frontend/`, `infra/`, `docs/`.
- Backend:
  - Laravel instalado y configurado (Sanctum). 
  - Migrations: users (role/phone), personal_access_tokens, merchants, services, availabilities, bookings, payments.
  - Auth API: `/api/v1/merchant/register`, `/api/v1/merchant/login` (tokens via Sanctum).
  - Merchant CRUD protected y con políticas (`MerchantPolicy`).
  - Booking creation endpoint con verificación de solapamientos (`/api/v1/bookings`).
  - Stripe Checkout endpoint (`/api/v1/payments/checkout`) y webhook handler (`/api/v1/payments/webhook`).
  - Email verification dispatched on register; `Mail` settings documented in `.env.example` (Mailhog/log).
- Frontend:
  - React (Vite) scaffold con páginas: Register, Login, MerchantDashboard. Migrated to TypeScript (.tsx) and typed API helper.
  - `src/api.ts` helper for API calls; added `tsconfig.json` and TypeScript dev dependencies.
- Tests:
  - `MerchantAuthTest`, `MerchantVerificationTest`, `MerchantPolicyTest`, `BookingTest`, `PaymentsWebhookTest` (todos pasan localmente).

## Status actual
- Todos los endpoints mencionados funcionan y están cubiertos por tests automáticos en `backend/tests/Feature/`.
- CI stub actualizado para ejecutar tests de backend.
- Código push al repositorio remoto: `https://github.com/hernanofx/qupo.git`.

## Qué sigue (prioridades)
1. Configurar Mailhog en `docker-compose` de `infra/` para desarrollo y comprobar emails en entorno local. (P0)
2. Integrar Stripe en frontend con `stripe.js` y completar flujo de checkout y verificación (incluyendo seguridad de webhooks). (P0)
3. Crear UI para merchants: CRUD servicios, gestión de disponibilidades y visualizador de agenda (P0/P1).
4. Implementar E2E tests (Playwright) para flows críticos: registrar merchant → crear servicio → reservar → pagar → webhook confirma. (P1)
5. Infra: configurar staging (CI -> deploy a staging cluster), configurar secrets (Stripe webhook secret, etc.). (P1)

## Notas y recomendaciones
- Mantener `shared-schema` tenancy para MVP; considerar separate DB cuando clientes grandes lo requieran.
- Continuar añadiendo tests de autorización y contract tests para el API.

---

Archivo generado automáticamente y subido al repo `docs/sprint-1-report.md`.
