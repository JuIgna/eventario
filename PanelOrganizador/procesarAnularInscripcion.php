<?php
include "panelAdminLogica.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["IDusuario"])) {
    $IDusuario = $_GET["IDusuario"];

    // Actualizar el campo 'activo' a 0 para anular la inscripción
    $query = "UPDATE inscripciones SET activo = 0 WHERE IDusuario = $IDusuario";

    if ($connection->query($query) === TRUE) {
        // Redirigir a la página de detalles del evento
        header("Location: eventoDetalle.php?ID=$IDevento");
        exit();
    } else {
        echo "Error al procesar la solicitud: " . $connection->error;
    }
} else {
    echo "Solicitud no válida";
}
?>
