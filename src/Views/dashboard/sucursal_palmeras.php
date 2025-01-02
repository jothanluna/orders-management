<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'palmeras') {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Palmeras</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Dashboard - Sucursal Palmeras</h1>
    <div>
        <button onclick="loadChart('dashboard_data.php?sucursal=palmeras&periodo=dia', ctx)">Día</button>
        <button onclick="loadChart('dashboard_data.php?sucursal=palmeras&periodo=mes', ctx)">Mes</button>
        <button onclick="loadChart('dashboard_data.php?sucursal=palmeras&periodo=ano', ctx)">Año</button>
    </div>
    <div class="chart-container">
        <canvas id="chart"></canvas>
    </div>
    <script src="js/charts.js"></script>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        loadChart('dashboard_data.php?sucursal=palmeras&periodo=dia', ctx);
    </script>
</body>
</html>
