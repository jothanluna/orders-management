<?php
date_default_timezone_set('America/Mexico_City');
// En config/config.php

// Define la ruta base del proyecto
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

// Define la URL base del proyecto
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost:8001'); // Cambia esta URL si migras a producción
}

// Configuración de la base de datos
return [
    'host' => 'localhost', // Servidor de la base de datos
    'username' => 'root', // Usuario de la base de datos
    'password' => 'Oasisliam1!', // Contraseña de la base de datos
    'database' => 'orders_management', // Nombre de la base de datos
];
