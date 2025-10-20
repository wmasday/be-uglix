## Movie API (Laravel 12)

Backend API for users, genres, movies, episodes, actors, and movie casts using Laravel Sanctum bearer tokens.

### Requirements
- PHP 8.2+
- Composer

### Setup
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan vendor:publish --provider="Laravel\\Sanctum\\SanctumServiceProvider"
```

### Database
By default, a SQLite database file is included at `database/database.sqlite`. You can switch to MySQL/PostgreSQL by editing `.env`.

Run migrations and seeders:
```bash
php artisan migrate:fresh --seed
```

### Run the server
```bash
php artisan serve
# http://127.0.0.1:8000
```

### Authentication (Sanctum)
- Register: `POST /api/auth/register` with `username`, `email`, `password`, `full_name?`.
- Login: `POST /api/auth/login` returns `{ token }`.
- Send header: `Authorization: Bearer <token>` on protected endpoints.
- Me: `GET /api/auth/me`
- Logout: `POST /api/auth/logout` (revokes current token).

### Endpoints
- Genres: `GET/POST/GET{id}/PUT{id}/DELETE{id}` at `/api/genres`
- Movies: `GET/POST/GET{id}/PUT{id}/DELETE{id}` at `/api/movies`
- Episodes: `GET/POST/GET{id}/PUT{id}/DELETE{id}` at `/api/episodes`
- Actors: `GET/POST/GET{id}/PUT{id}/DELETE{id}` at `/api/actors`
- Movie Casts: `/api/movie-casts` (GET, POST), `/api/movie-casts/{movie_id}/{actor_id}` (GET, PUT, DELETE)

All CRUD routes (except auth register/login) require the bearer token.

### Quick start (cURL)
```bash
# Login (uses seeded admin@example.com / admin123)
curl -s -X POST http://127.0.0.1:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"admin123"}'

# Replace <TOKEN> below with the returned token
curl -H "Authorization: Bearer <TOKEN>" http://127.0.0.1:8000/api/auth/me

# Create a genre
curl -s -X POST http://127.0.0.1:8000/api/genres \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer <TOKEN>" \
  -d '{"name":"Thriller","description":"Edge of your seat"}'
```

### Notes
- Tokens are stored in `personal_access_tokens` (Sanctum) and can be revoked.
- Seeders create base users, genres, actors, movies, episodes, and casts.
- See `routes/api.php` for the full list of routes.


