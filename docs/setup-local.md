# Setup local (desarrollo)

Requisitos:
- Docker & Docker Compose
- Node 18+
- Composer 2+

Arrancar el entorno de desarrollo (docker-compose - desarrollo simple):

1. Copiar env examples:

   - `cp backend/.env.example backend/.env`
   - `cp frontend/.env.example frontend/.env` (si aplica)

2. Levantar servicios:

   - `docker-compose up -d`

3. Backend:

   - `cd backend`
   - `composer install`
   - `php artisan key:generate`
   - `php artisan migrate`
   - `php artisan test` (ejecutar tests)

4. Frontend:

   - `cd frontend`
   - `npm install` (instalará TypeScript y tipos dev; or `npm ci` if you prefer reproducible installs and have a lockfile)
   - `npm run dev`
   - Optional: `npm run type-check` to run `tsc --noEmit` for type checks

Icon / UX notes:
- A minimalist favicon (`/favicon.svg`) is now included to avoid 404 noise in dev tools.
- The frontend features a minimal, high-quality style (`src/styles.css`) and simple auth persistence (token stored in `localStorage`).

Backend seeding:
- To create the local dev user run:

  - `php artisan db:seed --class=HernanUserSeeder`

  Credentials: `hernan@hernan.com` / `12345678`

Notas:
- Para desarrollo en host puede preferirse `docker-compose` con volúmenes montados.
- Los tests usan SQLite en memoria cuando se ejecutan en CI/local.
- The frontend was migrated to TypeScript (.tsx) — ensure your editor supports TS/TSX.
