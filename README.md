# EPOD Store Visit – Admin

- `backend/`  Laravel 11 API (Models, Repositories, Controllers, token auth, admin-only routes)
- `frontend/` React web app (Vite), one stylesheet: `src/styles/styles.css`

## Requirements
PHP 8.2+ (with `pdo_sqlite`), Composer, Node.js 18+

## Run the backend
```
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve --port=4000
```

## Run the frontend (second terminal)
```
cd frontend
npm install
npm run dev
```
Open http://localhost:5173 and sign in with **admin / admin123**.

## Backend structure
```
app/Http/Controllers/Controller.php        base Laravel controller
app/Http/Controllers/Controller.php  sendResponse() / sendError() - one response format
app/Http/Controllers/*Controller.php   Auth, Store, User - extend Controller
app/Http/Requests/API/                     validation: CreateStoreRequest (POST), UpdateStoreRequest (PUT), CreateUserRequest (POST), LoginRequest
app/Http/Resources/API/                    StoreResource, UserResource - shape the JSON output
app/Repositories/                          StoreRepository, UserRepository - database functions and conditions
app/Models/                                User, Store
app/Http/Middleware/                       AuthenticateToken, EnsureAdmin
routes/api.php                             all API routes
database/migrations, seeders               tables and starter data
```
Flow: Route -> Request (validates) -> API Controller -> Repository -> Model -> Resource -> BaseController response.

Response format:
```
success: { "success": true,  "data": ..., "message": "Store created." }
error:   { "success": false, "message": "Store not found." }
```
