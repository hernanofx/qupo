# Backlog MVP (borrador)

## Epics
- Onboarding merchants
- Gestión de servicios y disponibilidades
- Reserva y pagos
- PWA y QR check-in
- Panel Merchant

### Historias (detalladas, MVP)

- **Como** merchant quiero crear mi cuenta y completar mi perfil para poder publicar servicios.
  - Criterios de aceptación: formulario completado, merchant creado con `active=false` hasta verificación; correo de confirmación enviado. (Complejidad: Media, Prioridad: P0)

- **Como** merchant quiero definir servicios (titulo, duración, precio, descripción) y publicarlos.
  - Criterios: CRUD de servicios accesible, servicios visibles en catálogo público, validaciones. (Complejidad: Media, P0)

- **Como** merchant quiero definir disponibilidad recurrente (dias/hora) y excepciones para gestionar turnos.
  - Criterios: creación de slots recurrentes y bloqueos, vista calendario en panel merchant. (Complejidad: Alta, P0)

- **Como** usuario quiero buscar servicios por ubicación y ver disponibilidad para reservar.
  - Criterios: búsqueda por radio, lista de servicios con próximas disponibilidades. (Complejidad: Media, P0)

- **Como** usuario quiero reservar un turno y pagarlo (pago único o suscripción) con Stripe.
  - Criterios: reserva creada con estado `pending` y confirmación al recibir webhook de pago. (Complejidad: Media, P0)

- **Como** merchant quiero ver mi agenda (día/semana) y detalles de reservas.
  - Criterios: vista agenda con filtros por estado, export simple CSV. (Complejidad: Media, P1)

- **Como** usuario quiero ver y gestionar mis suscripciones (activar, renovar, cancelar).
  - Criterios: lista de suscripciones activas, cancelación y webhook handling. (Complejidad: Media, P1)

- **Como** usuario quiero usar QR para check-in en el local usando la reserva.
  - Criterios: QR generado por reserva, escaneo valida reserva y registra check-in. (Complejidad: Baja, P0)

- **Como** equipo quiero métricas básicas en el dashboard (nuevos merchants, reservas, ingresos) para medir la operativa.
  - Criterios: dashboard con gráficos simples y export CSV. (Complejidad: Media, P1)

---

Cada historia debe incluir criterios de aceptación concretos y estimación en Story Points durante el workshop de priorización.
