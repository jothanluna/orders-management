<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

session_start();

// Manejar logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: ' . BASE_URL . '/public/');
    exit;
}

// Detectar si la solicitud es para un archivo dentro de src/Controllers
$requestUri = $_SERVER['REQUEST_URI'];
if (preg_match('/\/src\/Controllers\//', $requestUri)) {
    // Cargar directamente el archivo solicitado
    $filePath = BASE_PATH . parse_url($requestUri, PHP_URL_PATH);
    if (file_exists($filePath)) {
        require_once $filePath;
        exit;
    } else {
        http_response_code(404);
        echo 'Archivo no encontrado';
        exit;
    }
}

// Verificar autenticación
if (!isset($_SESSION['role'])) {
    require_once BASE_PATH . '/src/Views/auth/login.php';
    exit;
}

// Enrutamiento básico
$route = $_GET['route'] ?? '';

switch ($route) {
    case '':
    case 'dashboard':
        switch ($_SESSION['role']) {
            case 'admin':
                require_once BASE_PATH . '/src/Views/dashboard/admin.php';
                break;
            case 'ejido':
                require_once BASE_PATH . '/src/Views/dashboard/sucursal_ejido.php';
                break;
            case 'palmeras':
                require_once BASE_PATH . '/src/Views/dashboard/sucursal_palmeras.php';
                break;
            default:
                header('Location: ' . BASE_URL . '/src/Views/auth/logout.php');
                exit;
        }
        break;
    case 'logout':
        require_once BASE_PATH . '/src/Views/auth/logout.php';
        break;
    default:
        // Manejar 404
        http_response_code(404);
        echo "Página no encontrada";
        break;
}
