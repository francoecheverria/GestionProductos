CREATE DATABASE IF NOT EXISTS productos_db;

USE productos_db;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO productos (nombre, descripcion, precio) VALUES
('Producto 1', 'Descripcion del producto 1', 10000.00),
('Producto 2', 'Descripcion del producto 2', 20000.00),
('Producto 3', 'Descripcion del producto 3', 30000.00);