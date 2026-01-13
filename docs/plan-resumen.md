# Plan Inicial - QUPO (Resumen)

Este documento contiene los puntos clave para el inicio del desarrollo de QUPO: objetivos del MVP, arquitectura propuesta y backlog inicial.

## Objetivos MVP
- Onboarding de comercios
- Gestión de servicios, disponibilidad y turnos
- Reserva y pago de servicios (Stripe)
- Panel básico para merchants
- PWA mobile-first con QR check-in

## Arquitectura (resumen)
- API: REST (Laravel)
- DB: PostgreSQL (+ PostGIS)
- Cache/Queues: Redis
- Storage: S3
- Infra: AWS (EKS/RDS/CloudFront) o DigitalOcean para MVP económico

## Backlog inicial
Ver `docs/backlog-mvp.md` para stories detalladas.
