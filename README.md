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
   ```
   ```bash
   cd GestionProductos
   ```

2. Iniciar servicios:
```bash
   docker-compose up -d --build
```
4. Acceder a la aplicacion:

   http://localhost:8000

## Informacion sobre la Api

Endpoints de la API:

| Método   | Endpoint            | Descripción                 | Body Request (Ejemplo)               |
|----------|---------------------|-----------------------------|--------------------------------------|
| `GET`    | `/productos`        | Listado de productos        | `[{"id":1,"nombre":"Producto 1","descripcion":"Descripcion del producto 1","precio":"10000.00","created_at":"2025-06-05 15:53:49","updated_at":"2025-06-05 15:53:49","precio_usd":10},{"id":2,"nombre":"Producto 2","descripcion":"Descripcion del producto 2","precio":"20000.00","created_at":"2025-06-05 15:53:49","updated_at":"2025-06-05 15:53:49","precio_usd":20}]`                                    |
| `GET`    | `/productos/{id}`   | Obtener un producto         | `{"id":1,"nombre":"Producto 1","descripcion":"Descripcion del producto 1","precio":"10000.00","created_at":"2025-06-05 15:53:49","updated_at":"2025-06-05 15:53:49","precio_usd":10}`                                    |
| `POST`   | `/productos`        | Crear un nuevo producto     | `{"nombre":"Product","precio":1000}` |
| `PUT`    | `/productos/{id}`   | Editar un producto          | `{"nombre":"Updated Product"}`       |
| `DELETE` | `/productos/{id}`   | Borrar un producto          | -                                    |

Servicios de Docker:

| Servicio    | Puerto | Descripción                 |
|-------------|--------|-----------------------------|
| `php`       | 8000   | Backend API en PHP          |
| `mysql`     | 3306   | Base de datos MySQL         |
| `frontend`  | 8080   | Servidor web Nginx          |


Variable de Entorno:

En api/.env se encuentra la variable "PRECIO_USD" que es la que almacena el valor del dolar, para poder cambiar el valor de este hay que modificar dicho valor
PRECIO_USD=1000
