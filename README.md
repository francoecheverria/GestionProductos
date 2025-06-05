# Gestión de Productos - API REST

Este proyecto implementa una API REST para gestionar productos con un frontend para interactuar con ella.

## Requisitos

- Docker
- Docker Compose
- PHP 8.2

## Configuración

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/francoecheverria/GestionProductos.git
   cd GestionProductos

2. Iniciar servicios:
   docker-compose up -d --build

3. Acceder a la aplicacion:
   http://localhost:8000

## Informacion sobre la Api

Endpoints de la API:

| Método   | Endpoint            | Descripción                 | Body Request (Ejemplo)               |
|----------|---------------------|-----------------------------|--------------------------------------|
| `GET`    | `/productos`        | Listado de productos        | -                                    |
| `GET`    | `/productos/{id}`   | Obtener un producto         | -                                    |
| `POST`   | `/productos`        | Crear un nuevo producto     | `{"nombre":"Product","precio":1000}` |
| `PUT`    | `/productos/{id}`   | Editar un producto          | `{"nombre":"Updated Product"}`       |
| `DELETE` | `/productos/{id}`   | Borrar un producto          | -                                    |

Servicios de Docker:

| Servicio    | Puerto | Descripción                 |
|-------------|--------|-----------------------------|
| `php`       | 8000   | Backend API en PHP          |
| `mysql`     | 3306   | Base de datos MySQL         |
| `frontend`  | 8080   | Servidor web Nginx          |
