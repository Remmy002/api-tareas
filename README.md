# api-tareas — GL10 INF560

API REST construida con Laravel 13 y PostgreSQL.

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configura tu `.env` con los datos de PostgreSQL y luego:

```bash
php artisan migrate
php artisan serve
```

## Endpoints

| Método |       Ruta       |       Descripción       |
|--------|------------------|-------------------------|
| GET    | /api/tareas      | Listar todas las tareas |
| POST   | /api/tareas      | Crear una tarea         |
| GET    | /api/tareas/{id} | Ver una tarea           |
| PUT    | /api/tareas/{id} | Actualizar una tarea    |
| DELETE | /api/tareas/{id} | Eliminar una tarea      |