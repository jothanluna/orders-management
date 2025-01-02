<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

echo "<h1>Bienvenido Administrador</h1>";
echo "<p>Desde aquí puedes gestionar ambas sucursales.</p>";
?>