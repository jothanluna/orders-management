<?php
namespace App\Controllers;
use App\Core\Database;

class DashboardController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    private function tableExists($tableName) {
        $result = $this->db->query("SHOW TABLES LIKE '{$tableName}'");
        return $result && $result->num_rows > 0;
    }

    private function createDailyTable($sucursal, $fecha) {
        try {
            $tableName = "orders_{$sucursal}_{$fecha}";
            error_log("Creando tabla: $tableName");
            
            $query = "CREATE TABLE IF NOT EXISTS `$tableName` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `nombre` VARCHAR(100) DEFAULT NULL,
                `ordenes` INT DEFAULT 0,
                `burritos` INT DEFAULT 0,
                `bebidas` INT DEFAULT 0,
                `total` DECIMAL(10,2) DEFAULT 0.00,
                `paga_con` DECIMAL(10,2) DEFAULT 0.00,
                `metodo_pago` ENUM('Efectivo','Transferencia','Tarjeta') DEFAULT NULL,
                `cambio` DECIMAL(10,2) GENERATED ALWAYS AS (paga_con - total) STORED,
                `envio` DECIMAL(10,2) DEFAULT 0.00,
                `repartidor` ENUM('Joys','Pickup','Interno') DEFAULT NULL,
                `dinero_recibido` TINYINT(1) DEFAULT 0,
                `nombre_repartidor` VARCHAR(100) DEFAULT NULL,
                PRIMARY KEY (`id`)
            )";
            
            $result = $this->db->query($query);
            if (!$result) {
                throw new \Exception("Error creando tabla: " . $this->db->error);
            }
            return true;
        } catch (\Exception $e) {
            error_log("Error en createDailyTable: " . $e->getMessage());
            throw $e;
        }
    }

    public function getStats($sucursal, $periodo, $day = 0) {
        try {
            $fecha = date('Y_m_d', strtotime("-$day days"));
            $tabla = "orders_{$sucursal}_{$fecha}";
    
            if (!$this->tableExists($tabla)) {
                $this->createDailyTable($sucursal, $fecha);
            }
    
            $query = "SELECT 
                    metodo_pago,
                    SUM(total) as monto_total
                FROM $tabla
                GROUP BY metodo_pago";

                $queryEnvios = "SELECT SUM(envio) as total_envios FROM $tabla";

                $result = $this->db->query($query);
                $resultEnvios = $this->db->query($queryEnvios);

                if (!$result) {
                    throw new \Exception("Error en la consulta SQL: " . $this->db->error);
                }

                $data = [];
                $enviosTotales = $resultEnvios->fetch_assoc()['total_envios'] ?? 0;

                while ($row = $result->fetch_assoc()) {
                    $data[] = [
                        'metodo_pago' => $row['metodo_pago'],
                        'monto' => floatval($row['monto_total'])
                    ];
                }

                $efectivoNeto = array_reduce($data, function ($carry, $item) {
                    return $item['metodo_pago'] === 'Efectivo' ? $item['monto'] : $carry;
                }, 0) - floatval($enviosTotales);
    
            return [
                'success' => true,
                'data' => [
                    'stats' => $data,
                    'envios' => $enviosTotales,
                    'efectivo_neto' => $efectivoNeto
                ]
            ];
        } catch (\Exception $e) {
            error_log("Error en getStats: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function getOrders($sucursal, $day = 0, $metodo_pago = null) {
        try {
            $fecha = date('Y_m_d', strtotime("-$day days"));
            $tabla = "orders_{$sucursal}_{$fecha}";

            if (!$this->tableExists($tabla)) {
                $this->createDailyTable($sucursal, $fecha);
            }

            $query = "SELECT * FROM $tabla";
            if ($metodo_pago) {
                $query .= " WHERE metodo_pago = ?";
                $stmt = $this->db->prepare($query);
                $stmt->bind_param('s', $metodo_pago);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $this->db->query($query);
            }

            if (!$result) {
                throw new \Exception("Error en la consulta SQL: " . $this->db->error);
            }

            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }

            return ['success' => true, 'data' => $orders];
        } catch (\Exception $e) {
            error_log("Error en getOrders: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function updateOrder($sucursal, $day, $id, $field, $value) {
        try {
            error_log("Actualizando orden: sucursal=$sucursal, day=$day, id=$id, field=$field, value=$value");
            
            $fecha = date('Y_m_d', strtotime("-$day days"));
            $tabla = "orders_{$sucursal}_{$fecha}";
    
            if (!$this->tableExists($tabla)) {
                $this->createDailyTable($sucursal, $fecha);
            }
    
            // Sanitizar el campo para prevenir SQL injection
            $allowedFields = ['nombre', 'ordenes', 'burritos', 'bebidas', 'total', 
                             'paga_con', 'metodo_pago', 'envio', 'repartidor', 
                             'dinero_recibido', 'nombre_repartidor'];
            
            if (!in_array($field, $allowedFields)) {
                throw new \Exception("Campo no válido: $field");
            }
    
            $sql = "UPDATE `$tabla` SET `$field` = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            
            // Procesar el valor según el tipo de campo
            if ($field === 'dinero_recibido') {
                $value = (bool)$value ? 1 : 0;
                $stmt->bind_param('ii', $value, $id);
            } 
            elseif (in_array($field, ['ordenes', 'burritos', 'bebidas'])) {
                $value = (int)$value;
                $stmt->bind_param('ii', $value, $id);
            }
            elseif (in_array($field, ['total', 'paga_con', 'envio'])) {
                $value = (float)str_replace(['$', ','], '', $value);
                $stmt->bind_param('di', $value, $id);
            }
            else {
                $stmt->bind_param('si', $value, $id);
            }
    
            if (!$stmt->execute()) {
                throw new \Exception("Error ejecutando update: " . $stmt->error);
            }
    
            return ['success' => true];
        } catch (\Exception $e) {
            error_log("Error en updateOrder: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function addOrder($sucursal, $day, $nombre) {
        try {
            $fecha = date('Y_m_d', strtotime("-$day days"));
            $tabla = "orders_{$sucursal}_{$fecha}";
    
            if (!$this->tableExists($tabla)) {
                $this->createDailyTable($sucursal, $fecha);
            }
    
            $query = "INSERT INTO $tabla (nombre, metodo_pago) VALUES (?, 'Efectivo')";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $nombre);
    
            if (!$stmt->execute()) {
                throw new \Exception("Error al insertar orden");
            }
    
            // Obtener las estadísticas actualizadas después de agregar la orden
            $stats = $this->getStats($sucursal, 'dia', $day);
    
            return [
                'success' => true,
                'id' => $stmt->insert_id,
                'stats' => $stats['data']
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    

    public function deleteOrder($sucursal, $day, $id) {
        try {
            $fecha = date('Y_m_d', strtotime("-$day days"));
            $tabla = "orders_{$sucursal}_{$fecha}";
            
            $query = "DELETE FROM $tabla WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $id);
            
            if (!$stmt->execute()) {
                throw new \Exception("Error al eliminar orden");
            }
     
            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
     }

    public function handleManyChatWebhook() {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($data['nombre']) || !isset($data['tag'])) {
                throw new \Exception("Datos incompletos. Se requiere 'nombre' y 'tag'.");
            }
    
            $sucursal = null;
            if ($data['tag'] === 'Cliente_Ejido') {
                $sucursal = 'ejido';
            } elseif ($data['tag'] === 'Cliente_Palmeras') {
                $sucursal = 'palmeras';
            }
    
            if (!$sucursal) {
                throw new \Exception("Tag no válido.");
            }
    
            return $this->addOrder($sucursal, 0, $data['nombre']);
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

}





// Manejador de solicitudes AJAX
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    $controller = new DashboardController();

    try {
        switch ($_GET['action']) {
            case 'stats':
                echo json_encode($controller->getStats(
                    $_GET['sucursal'],
                    $_GET['periodo'],
                    $_GET['day'] ?? 0
                ));
                break;

            case 'orders':
                echo json_encode($controller->getOrders(
                    $_GET['sucursal'],
                    $_GET['day'] ?? 0,
                    $_GET['metodo_pago'] ?? null
                ));
                break;

            case 'update':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($controller->updateOrder(
                    $data['sucursal'],
                    $data['day'],
                    $data['id'],
                    $data['field'],
                    $data['value']
                ));
                break;

            case 'add':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($controller->addOrder(
                    $data['sucursal'],
                    $data['day'] ?? 0,
                    $data['nombre']
                ));
                break;

            case 'delete':
                $data = json_decode(file_get_contents('php://input'), true);
                echo json_encode($controller->deleteOrder(
                    $data['sucursal'],
                    $data['day'],
                    $data['id']
                ));
                break;            
            

            case 'manychat-webhook':
                echo json_encode($controller->handleManyChatWebhook());
                break;

            default:
                echo json_encode(['success' => false, 'error' => 'Acción no válida']);
                break;
        }
    } catch (\Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}
?>