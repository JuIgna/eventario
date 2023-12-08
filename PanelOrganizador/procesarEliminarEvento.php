<?php
include "panelAdminLogica.php";

$IDevento = $_GET['IDevento'];

// Verificar si el evento está activo
$queryVerificar = "SELECT activo FROM eventos WHERE IDeventos = '$IDevento'";
$resultVerificar = $connection->query($queryVerificar);

if ($resultVerificar && $resultVerificar->num_rows > 0) {
    $evento = $resultVerificar->fetch_assoc();
    $activo = $evento['activo'];

    if ($activo == 0) {
        // Eliminar el evento
        $queryEliminar = "DELETE FROM eventos WHERE IDeventos = '$IDevento'";
        $resultEliminar = $connection->query($queryEliminar);

        if ($resultEliminar) {
            // Mensaje de éxito
            $_SESSION['success_message'] = "El evento se ha eliminado con éxito.";

            // Redireccionar a la página principal u otra ubicación después de eliminar
            header("Location: panelAdmin.php");
            
            exit();
        } else {
            die("Error al eliminar el evento.");
        }
    } else {
        $_SESSION['error_message'] = "No se puede eliminar un evento activo.";
        header("Location: eventoDetalle.php?ID=$IDevento");
        exit();
    }
} else {
    die("Error al verificar el estado del evento.");
}
?>
