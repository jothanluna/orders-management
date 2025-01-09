<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use App\Controllers\DashboardController;

header('Content-Type: application/json');

try {
    $sucursal = $_GET['sucursal'] ?? 'ejido';
    $lastUpdate = $_GET['last_update'] ?? null;
    $day = $_GET['day'] ?? 0;

    if (!$lastUpdate) {
        throw new \Exception('El parámetro `last_update` es obligatorio.');
    }

    $fecha = date('Y_m_d', strtotime("-$day days"));
    $tabla = "orders_{$sucursal}_{$fecha}";

    $db = Database::getInstance();

    // Verificar si hay cambios desde la última actualización
    $stmt = $db->prepare("SELECT COUNT(*) as changes FROM `$tabla` WHERE `last_updated` > FROM_UNIXTIME(?)");
    if (!$stmt) {
        throw new \Exception("Error preparando la consulta: " . $db->getConnection()->error);
    }

    $stmt->bind_param('i', $lastUpdate);
    $stmt->execute();
    $result = $stmt->get_result();
    $changes = $result->fetch_assoc()['changes'];

    if ($changes > 0) {
        // Si hay cambios, obtener datos actualizados
        $controller = new DashboardController();
        $stats = $controller->getStats($sucursal, 'dia', $day);
        $orders = $controller->getOrders($sucursal, $day);

        echo json_encode([
            'success' => true,
            'hasChanges' => true,
            'stats' => $stats['data'],
            'orders' => $orders['data'],
            'timestamp' => time(),
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'hasChanges' => false,
            'timestamp' => time(),
        ]);
    }
} catch (\Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ]);
}
