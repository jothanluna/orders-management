CREATE DATABASE orders_management;

USE orders_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('ejido', 'palmeras', 'admin') NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE orders_ejido_2024_12_30 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ordenes INT DEFAULT 0,
    burritos INT DEFAULT 0,
    bebidas INT DEFAULT 0,
    total DECIMAL(10,2) DEFAULT 0.00,
    paga_con DECIMAL(10,2) DEFAULT 0.00,
    metodo_pago ENUM('Efectivo', 'Transferencia', 'Tarjeta'),
    cambio DECIMAL(10,2) GENERATED ALWAYS AS (paga_con - total) STORED,
    envio DECIMAL(10,2) DEFAULT 0.00,
    repartidor ENUM('Joys', 'Pickup', 'Interno'),
    dinero_recibido BOOLEAN DEFAULT 0,
    nombre_repartidor VARCHAR(100)
);
