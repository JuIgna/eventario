<?php
// Configuración de la conexión a la base de datos (similar a tu archivo actual)
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['esAdmin']) || $_SESSION['esAdmin'] != 1) {
    echo "<script>alert('Debes iniciar sesión como administrador.'); window.location.href = '../login/loginAdmin.php';</script>";
    exit;
}

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
    $IDadministrador = $_SESSION['IDadministrador']; // Obten el ID del administrador desde la sesión
    


if (isset($_POST['eventID']) && isset($_POST['nuevoValor'])) {
    $eventID = $_POST['eventID'];
    $nuevoValor = $_POST['nuevoValor'];

    // Realiza la actualización en la base de datos
    $query = "UPDATE eventos SET activo = $nuevoValor WHERE IDeventos = $eventID";
    $result = $connection->query($query);

    if ($result) {
        echo "El evento ha sido " . ($nuevoValor ? "activado" : "desactivado") . " exitosamente.";
    } else {
        echo "Error al actualizar el evento: " . $connection->error;
    }
} else {
    echo "Parámetros incorrectos.";
}
?>