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

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['esAdmin']) || $_SESSION['esAdmin'] != 1) {
    echo "Error: Debes iniciar sesión como administrador.";
    exit;
}

// Verificar si se reciben los datos necesarios
if (isset($_POST['IDusuario']) && isset($_POST['IDeventos'])) {
    $IDusuario = $_POST['IDusuario'];
    $IDeventos = $_POST['IDeventos'];

    // Actualizar el campo activo a 1 (aceptado) en la tabla de inscripciones
    $queryAceptarInscripcion = "UPDATE inscripciones SET activo = 1 WHERE IDusuario = '$IDusuario' AND IDeventos = '$IDeventos'";
    $resultAceptarInscripcion = $connection->query($queryAceptarInscripcion);

    if ($resultAceptarInscripcion) {
        echo "success"; // Puedes enviar cualquier mensaje de éxito que desees
    } else {
        echo "Error al aceptar la inscripción: " . $connection->error;
    }
} else {
    echo "Error: Datos incompletos.";
}

// Cierra la conexión a la base de datos
$connection->close();
?>
