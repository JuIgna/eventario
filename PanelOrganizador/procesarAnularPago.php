<?php
include "panelAdminLogica.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["IDusuario"])) {
    $IDusuario = $_GET["IDusuario"];

    // Actualizar el campo 'pago' a 0 para anular el pago
    $query = "UPDATE inscripciones SET pago = 0 WHERE IDusuario = $IDusuario";

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
