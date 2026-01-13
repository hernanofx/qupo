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
   - `npm ci`
   - `npm run dev`

Notas:
- Para desarrollo en host puede preferirse `docker-compose` con volúmenes montados.
- Los tests usan SQLite en memoria cuando se ejecutan en CI/local.
