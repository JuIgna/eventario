<?php
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['esAdmin']) || $_SESSION['esAdmin'] != 1) {
    echo "<script>alert('Debes iniciar sesión como administrador.'); window.location.href = '../login/login.php';</script>";
    exit;
}

if (isset($_POST['guardarCambios'])) {
    // Asegúrate de que IDeventos provenga del formulario (no del parámetro GET)
    if (isset($_POST['IDeventos'])) {
        $IDeventos = $_POST['IDeventos'];
    } else {
        echo "ID de evento no proporcionado en el formulario.";
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

    if (isset($_POST['asistio'])) {
        foreach ($_POST['asistio'] as $userID) {
            // Marcar asistio para el usuario con $userID en la base de datos
            $queryUpdateAsistio = "UPDATE inscripciones SET asistio = 1 WHERE IDusuario = '$userID' AND IDeventos = '$IDeventos'";
            $connection->query($queryUpdateAsistio);
        }
    } else {
        // Si ninguna casilla de asistio está marcada, desmarcar todas las asistencias
        $queryUpdateAsistio = "UPDATE inscripciones SET asistio = 0 WHERE IDeventos = '$IDeventos'";
        $connection->query($queryUpdateAsistio);
    }

    if (isset($_POST['pago'])) {
        foreach ($_POST['pago'] as $userID) {
            // Marcar pago para el usuario con $userID en la base de datos
            $queryUpdatePago = "UPDATE inscripciones SET pago = 1 WHERE IDusuario = '$userID' AND IDeventos = '$IDeventos'";
            $connection->query($queryUpdatePago);
        }
    } else {
        // Si ninguna casilla de pago está marcada, desmarcar todos los pagos
        $queryUpdatePago = "UPDATE inscripciones SET pago = 0 WHERE IDeventos = '$IDeventos'";
        $connection->query($queryUpdatePago);
    }

    // Redirigir a la página de detalle del evento después de guardar cambios
    header("Location: detalleEvento.php?IDeventos=" . $IDeventos);
} else {
    // Si no se ha enviado el formulario, redirigir a alguna página apropiada
    header("Location: alguna_pagina.php");
}
?>
