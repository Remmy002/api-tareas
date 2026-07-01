# api-tareas — GL10 & GL11 INF560

API REST construida con Laravel 13 y PostgreSQL, asegurada con autenticación por tokens (Laravel Sanctum).

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

## Autenticación (Laravel Sanctum)

La API usa **tokens de acceso personal** (Bearer Token). Cada tarea pertenece a un usuario autenticado; no es posible ver, editar o borrar tareas de otro usuario (403 Forbidden).

### Endpoints de autenticación

| Método | Ruta          | Descripción                                  | Protegida |
|--------|---------------|-----------------------------------------------|-----------|
| POST   | /api/register | Registrar usuario y obtener token             | No        |
| POST   | /api/login    | Iniciar sesión y obtener token                | No        |
| POST   | /api/logout   | Cerrar sesión (revoca el token actual)        | Sí        |
| GET    | /api/user     | Obtener el usuario autenticado                | Sí        |

**Parámetros de registro/login:** `email`, `password`, `password_confirmation` (solo registro), `device_name`.

### Uso del token

Todas las rutas protegidas requieren la cabecera:

Authorization: Bearer {token}

### Habilidades del token (abilities)

Cada token se emite con las siguientes habilidades: `tareas:leer`, `tareas:crear`, `tareas:editar`, `tareas:borrar`. Se verifican con `tokenCan()` en el controlador antes de ejecutar la acción.

## Endpoints de tareas (requieren token)

| Método | Ruta              | Descripción                          |
|--------|-------------------|---------------------------------------|
| GET    | /api/tareas       | Listar mis tareas                    |
| POST   | /api/tareas       | Crear una tarea (asociada a mi usuario) |
| GET    | /api/tareas/{id}  | Ver una tarea (solo si es mía)       |
| PUT    | /api/tareas/{id}  | Actualizar una tarea (solo si es mía)|
| DELETE | /api/tareas/{id}  | Eliminar una tarea (solo si es mía)  |

Intentar acceder a una tarea de otro usuario responde `403 Forbidden`. Peticiones sin token válido responden `401 Unauthorized`.

## Ejemplo de flujo con cURL

```bash
# Registro
curl -X POST http://127.0.0.1:8000/api/register \
 -H "Accept: application/json" \
 -d "name=Ana" -d "email=ana@uatf.edu.bo" \
 -d "password=secret123" -d "password_confirmation=secret123" \
 -d "device_name=postman"

# Crear tarea (usando el token recibido)
curl -X POST http://127.0.0.1:8000/api/tareas \
 -H "Accept: application/json" \
 -H "Authorization: Bearer {token}" \
 -d "titulo=Preparar laboratorio"

# Cerrar sesión
curl -X POST http://127.0.0.1:8000/api/logout \
 -H "Accept: application/json" \
 -H "Authorization: Bearer {token}"
```