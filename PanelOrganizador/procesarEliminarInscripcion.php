<?php
include "panelAdminLogica.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["IDusuario"]) && isset($_GET["IDevento"])) {
    $IDusuario = $_GET["IDusuario"];
    $IDevento = $_GET["IDevento"];

    // Realizar la eliminación de la inscripción
    $query = "DELETE FROM inscripciones WHERE IDusuario = $IDusuario AND IDeventos = $IDevento";

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
