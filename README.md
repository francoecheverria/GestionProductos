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

Endpoints:

GET	   /productos	      Listado de productos	-
GET	   /productos/{id}	Obtener un producto	-
POST	   /productos	      Crear un nuevo producto	{"nombre":"Product","precio":1000}
PUT	   /productos/{id}	editar un producto	{"nombre":"Updated Product"}
DELETE	/productos/{id}	borrar un producto -

Servicios de Docker:

php	   8000	PHP API backend
mysql	   3306	MySQL database
frontend	8080	Nginx web server
