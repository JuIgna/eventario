<?php
session_start();

// Verificar si el usuario ha iniciado sesión como administrador
if (!isset($_SESSION['esAdmin']) || $_SESSION['esAdmin'] != 1) {
    echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión como administrador.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegúrate de tener la conexión a la base de datos configurada
    $host = "localhost"; // Cambiar si es necesario
    $username = "eventario_juan"; // Cambiar por tu nombre de usuario de la base de datos
    $password = "juan$2023"; // Cambiar por tu contraseña de la base de datos
    $database = "eventario_db"; // Cambiar por el nombre de tu base de datos

    // Crear la conexión a la base de datos
    $connection = new mysqli($host, $username, $password, $database);

    // Verificar si hay errores en la conexión
    if ($connection->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Error en la conexión a la base de datos: ' . $connection->connect_error]);
        exit;
    }

    // Obtén los datos del formulario
    $IDusuario = $_POST['IDusuario'];
    $IDeventos = $_POST['IDeventos'];

    // Verificar si el usuario tiene asistió y pago igual a 0
    $queryVerificarUsuario = "SELECT asistio, pago FROM inscripciones WHERE IDusuario = '$IDusuario' AND IDeventos = '$IDeventos'";
    $resultVerificarUsuario = $connection->query($queryVerificarUsuario);

    if ($resultVerificarUsuario) {
        $usuario = $resultVerificarUsuario->fetch_assoc();

        if ($usuario['asistio'] == 0 && $usuario['pago'] == 0) {
            // Actualizar el campo activo a 0 (cancelado) en la tabla de inscripciones
            $queryCancelarInscripcion = "UPDATE inscripciones SET activo = 0 WHERE IDusuario = '$IDusuario' AND IDeventos = '$IDeventos'";
            $resultCancelarInscripcion = $connection->query($queryCancelarInscripcion);

            /*
            if ($resultCancelarInscripcion) {
                echo json_encode(['status' => 'success', 'message' => 'Inscripción cancelada correctamente.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al cancelar la inscripción: ' . $connection->error]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: El usuario tiene asistió o pago diferente de 0.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al verificar el usuario: ' . $connection->error]);
    }*/

    // Cierra la conexión a la base de datos
    $connection->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido.']);
}
}
}
?>
