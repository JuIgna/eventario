<?php
include "panelAdminLogica.php";

// Obtener ID del usuario y del evento desde la URL

$IDevento = $_GET['IDevento'];

// Actualizar el valor de activo en la tabla inscripciones
$queryAceptarInscripcion = "UPDATE inscripciones SET activo = 1 WHERE IDeventos = '$IDevento'";
$resultAceptarInscripcion = $connection->query($queryAceptarInscripcion);

if ($resultAceptarInscripcion === true) {
    // Redireccionar al detalle del evento
    $_SESSION['preinscripcionesExito'] = "Todas las preinscripiones fueron aceptadas con exito";
    header("Location: eventoDetalle.php?ID=$IDevento");
    exit();
} else {
    // Manejar el error según sea necesario
    $_SESSION['error_message'] = "Error al aceptar la inscripción: " . $connection->error;
    header("Location: eventoDetalle.php?ID=$IDevento");
    exit();
}
?>
