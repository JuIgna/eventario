<?php
include "panelAdminLogica.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["IDusuario"])) {
    $IDusuario = $_GET["IDusuario"];
    $IDevento = $_GET['IDevento'];

    // Actualizar el campo 'asistio' a 0 para anular la asistencia
    $query = "UPDATE inscripciones SET asistio = 0 WHERE IDusuario = $IDusuario AND IDeventos = $IDevento";

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
