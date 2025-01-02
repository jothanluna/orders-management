<?php
// Configuración de la base de datos
$config = include(__DIR__ . '/../config/config.php');
$mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['database']);

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la conexión: " . $mysqli->connect_error]);
    exit;
}

// Parámetros de entrada
$sucursal = $_GET['sucursal'] ?? null;
$date = $_GET['date'] ?? null;
$filter = $_GET['filter'] ?? null;

if (!$sucursal || !$date) {
    http_response_code(400);
    echo json_encode(["error" => "Sucursal y fecha son obligatorias"]);
    exit;
}

// Nombre de la tabla basada en la sucursal y la fecha
$table = "orders_{$sucursal}_$date";

// Verificar si la tabla existe
$checkTable = $mysqli->query("SHOW TABLES LIKE '$table'");
if ($checkTable->num_rows === 0) {
    echo json_encode([]); // Devuelve un JSON vacío si la tabla no existe
    exit;
}

// Consultar las órdenes
$query = "SELECT * FROM $table";
if ($filter) {
    $query .= " WHERE metodo_pago = '$filter'";
}

$result = $mysqli->query($query);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Error al consultar los datos"]);
    exit;
}

// Generar respuesta
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

header('Content-Type: application/json');
echo json_encode($orders);
?>
