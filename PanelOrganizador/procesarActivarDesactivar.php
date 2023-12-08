<?php
include "panelAdminLogica.php";

$IDevento = $_GET['IDevento'];

// Verificar si hay preinscripciones o inscripciones
$queryVerificar = "SELECT COUNT(*) as total FROM inscripciones WHERE IDeventos = '$IDevento'";
$resultVerificar = $connection->query($queryVerificar);

if ($resultVerificar && $resultVerificar->num_rows > 0) {
    $totalInscripciones = $resultVerificar->fetch_assoc()['total'];

    if ($totalInscripciones > 0) {
        $_SESSION['error_message'] = "No se puede desactivar el evento porque ya posee preinscripciones o inscripciones.";
        header("Location: eventoDetalle.php?ID=$IDevento");
        // Mostrar mensaje de error si hay inscripciones activas
        
    }
}

// Actualizar el campo activo del evento
$queryActualizar = "UPDATE eventos SET activo = NOT activo WHERE IDeventos = '$IDevento'";
$resultActualizar = $connection->query($queryActualizar);

if ($resultActualizar) {
    
} else {
    die("Error al procesar la solicitud.");
}
?>
