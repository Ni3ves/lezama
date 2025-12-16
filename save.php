<?php
// CONEXIÓN A LA BASE DE DATOS
$conexion = new mysqli("localhost", "root", "nieves0899", "veterinaria");
$conexion->set_charset("utf8"); // evitar problemas con acentos

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos del formulario (limpios)
$nombre = trim($_POST['nombre']);
$mascota = trim($_POST['mascota']);
$tipo = trim($_POST['tipo']);
$servicio = trim($_POST['servicio']);
$fecha = trim($_POST['fecha']);
$hora = trim($_POST['hora']);
$mensaje = trim($_POST['mensaje']);

// Verificar si la hora ya está ocupada
$consulta = $conexion->prepare("SELECT id FROM citas WHERE fecha = ? AND hora = ?");
$consulta->bind_param("ss", $fecha, $hora);
$consulta->execute();
$resultado = $consulta->get_result();

if ($resultado->num_rows > 0) {
    echo "ocupado";
    exit;
}

// Insertar la nueva cita
$insert = $conexion->prepare("INSERT INTO citas (nombre, mascota, tipo_mascota, servicio, fecha, hora, mensaje) 
VALUES (?, ?, ?, ?, ?, ?, ?)");
$insert->bind_param("sssssss", $nombre, $mascota, $tipo, $servicio, $fecha, $hora, $mensaje);
$insert->execute();

// Todo salió bien
echo "ok";
?>