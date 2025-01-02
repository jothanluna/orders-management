<?php
namespace App\Core;

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            // Asegurémonos que BASE_PATH está definido
            if (!defined('BASE_PATH')) {
                throw new \Exception("BASE_PATH no está definido");
            }
            
            // Cargar configuración
            $config_file = BASE_PATH . '/config/config.php';
            if (!file_exists($config_file)) {
                throw new \Exception("Archivo de configuración no encontrado: $config_file");
            }
            
            $config = include($config_file);
            
            // Verificar que tenemos todas las configuraciones necesarias
            if (!isset($config['host']) || !isset($config['username']) || 
                !isset($config['password']) || !isset($config['database'])) {
                throw new \Exception("Configuración de base de datos incompleta");
            }

            // Crear conexión
            $this->connection = new \mysqli(
                $config['host'],
                $config['username'],
                $config['password'],
                $config['database']
            );

            if ($this->connection->connect_error) {
                throw new \Exception("Error de conexión: " . $this->connection->connect_error);
            }

            $this->connection->set_charset("utf8mb4");
            
        } catch (\Exception $e) {
            error_log("Error en Database::__construct: " . $e->getMessage());
            throw $e;
        }
    }
    
    public static function getInstance() {
        try {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        } catch (\Exception $e) {
            error_log("Error en Database::getInstance: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            if (empty($params)) {
                return $this->connection->query($sql);
            }
            
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new \Exception("Error preparando la consulta");
            }
            
            if (!empty($params)) {
                $types = '';
                foreach ($params as $param) {
                    if (is_int($param)) $types .= 'i';
                    elseif (is_float($param)) $types .= 'd';
                    elseif (is_string($param)) $types .= 's';
                    else $types .= 'b';
                }
                
                $stmt->bind_param($types, ...$params);
            }
            
            $stmt->execute();
            return $stmt;
            
        } catch (\Exception $e) {
            error_log($e->getMessage());
            throw new \Exception("Error ejecutando la consulta");
        }
    }
    
    public function createDailyTable($branch, $date) {
        $tableName = "orders_{$branch}_{$date}";
        
        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `nombre` VARCHAR(100) NOT NULL,
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
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        )";
        
        return $this->query($sql);
    }

    public function prepare($query) {
        try {
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new \Exception("Error preparando consulta: " . $this->connection->error);
            }
            return $stmt;
        } catch (\Exception $e) {
            error_log("Error en Database::prepare: " . $e->getMessage());
            throw $e;
        }
    }

    private function __clone() {}
    public function __wakeup() {}
}