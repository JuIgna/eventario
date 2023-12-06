<?php
if (isset($_POST['eventID'])) {
    // Obten el ID del evento desde la solicitud AJAX
    $IDeventos = $_POST['eventID'];
    
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
    
    // Comienza una transacción para asegurar la eliminación en ambas tablas
    $connection->begin_transaction();
    
    // Intenta eliminar las entradas en 'eventosadministrador' relacionadas con el evento
    $queryEliminarEventosAdministrador = "DELETE FROM eventosadministrador WHERE IDeventos = $IDeventos";
    $queryEliminarEvento = "DELETE FROM eventos WHERE IDeventos = $IDeventos";

    if ($connection->query($queryEliminarEventosAdministrador) === TRUE) {
        // Ahora intenta eliminar el evento de la tabla 'eventos'
        if ($connection->query($queryEliminarEvento) === TRUE) {
            // Si ambas eliminaciones son exitosas, confirma la transacción
            $connection->commit();
            echo "success";
             // Éxito en la eliminación
        } else {
            // Si hay un error al eliminar en 'eventos', revierte la transacción
            $connection->rollback();
            echo "error"; // Error en la eliminación
        }
    } else {
        // Si hay un error al eliminar en 'eventosadministrador', revierte la transacción
        $connection->rollback();
        echo "error"; // Error en la eliminación
    }
    
    // Cierra la conexión a la base de datos
    $connection->close();
}
?>

