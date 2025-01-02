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
$sucursal = $_POST['sucursal'] ?? null;
$date = $_POST['date'] ?? null;
$field = $_POST['field'] ?? null;
$id = $_POST['id'] ?? null;
$value = $_POST['value'] ?? null;

if (!$sucursal || !$date || !$field || !$id) {
    http_response_code(400);
    echo json_encode(["error" => "Parámetros incompletos"]);
    exit;
}

// Nombre de la tabla basada en la sucursal y la fecha
$table = "orders_{$sucursal}_$date";

// Verificar si la tabla existe
$checkTable = $mysqli->query("SHOW TABLES LIKE '$table'");
if ($checkTable->num_rows === 0) {
    http_response_code(404);
    echo json_encode(["error" => "No hay datos para la sucursal y fecha proporcionadas"]);
    exit;
}

// Actualizar el campo
$query = "UPDATE $table SET $field = ? WHERE id = ?";
$stmt = $mysqli->prepare($query);
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Error al preparar la consulta"]);
    exit;
}

$stmt->bind_param('si', $value, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => "Orden actualizada correctamente"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Error al actualizar la orden"]);
}

$stmt->close();
?>
