<?php
$conexion = new mysqli("localhost", "root", "nieves0899", "veterinaria");
$conexion->set_charset("utf8");

// Validar fecha
if (!isset($_GET['fecha']) || empty($_GET['fecha'])) {
    echo json_encode([]);
    exit;
}

$fecha = $_GET['fecha'];

// Consulta horas ocupadas
$resultado = $conexion->query("SELECT hora FROM citas WHERE fecha = '$fecha'");

$ocupadas = [];

while ($row = $resultado->fetch_assoc()) {
    // Convertir a formato HH:MM
    $ocupadas[] = substr($row['hora'], 0, 5);
}

echo json_encode($ocupadas);
?>