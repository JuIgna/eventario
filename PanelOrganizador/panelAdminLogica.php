<?php
session_start();

// Configuración de la conexión a la base de datos
$host = "localhost"; // Cambiar si es necesario
$username = "eventario_juan"; // Cambiar por tu nombre de usuario de la base de datos
$password = "juan$2023"; // Cambiar por tu contraseña de la base de datos
$database = "eventario_db"; // Cambiar por el nombre de tu base de datos

// Crear la conexión a la base de datos
$connection = new mysqli($host, $username, $password, $database);

// Verificar si hay errores en la conexión
if ($connection->connect_error) {
  die("Error en la conexión a la base de datos: " . $connection->connect_error);
}

$IDadministrador = $_SESSION['IDadministrador']; // Obten el ID del organizador desde la sesión
$IDeventos = null;


if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] == 1) {




} else {
  echo "<script>alert('Debes iniciar sesión como administrador. Serás redirigido a la página de inicio de sesión para administradores.'); window.location.href = '../login/loginAdmin.php';</script>";
}


?>