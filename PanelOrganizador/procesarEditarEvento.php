<?php
include "panelAdminLogica.php";

// Recibir datos del formulario
$IDevento = $_POST['IDevento']; // Asegúrate de tener este campo en tu formulario, no parece estar presente en el código proporcionado

$nombreEvento = $_POST['nombreEvento'];
$descripcionEvento = $_POST['descripcionEvento'];
$categoriaEvento = $_POST['categoriaEvento'];
$fechaEvento = $_POST['fechaEvento'];
$horaEvento = $_POST['horaEvento'];
$horaFinEvento = $_POST['horaFinEvento'];
$duracionEvento = $_POST['duracionEvento'];
$lugarEvento = $_POST['lugarEvento'];
$costoEvento = $_POST['costoEvento'];
$limiteInscritosEvento = $_POST['limiteInscritosEvento'];
$organizadorEvento = $_POST['organizadorEvento'];

$imagenEventoTmp = $_FILES["imagenEvento"]["tmp_name"];
$imagenEvento = $_FILES["imagenEvento"]["name"];

// Validar los datos (puedes agregar más validaciones según tus necesidades)

// Obtén la fecha actual
// Obtén la fecha actual
$fechaActual = date('Y-m-d');

// Obtén la nueva fecha del formulario
$nuevaFecha = $_POST['fechaEvento'];

// Compara las fechas
if (strtotime($nuevaFecha) <= strtotime($fechaActual)) {
    // La nueva fecha es menor que la fecha actual, muestra un mensaje de error
    $_SESSION['errorEditarFecha'] = "Error: La nueva fecha no puede ser menor o igual que la fecha actual.";
    header("Location: eventoDetalle.php?ID=$IDevento");
    exit();
}


// Verifica si se ha enviado un archivo
if ($_FILES['imagenEvento']['size'] > 0) {
    // Configura la carpeta de destino para guardar la imagen
    $destination = "images/" . basename($_FILES["imagenEvento"]["name"]);

    // Obtén el nombre y la ubicación del archivo temporal
    $imagenEventoTmp = $_FILES["imagenEvento"]["tmp_name"];
    $imagenEvento = $_FILES["imagenEvento"]["name"];

    // Mueve el archivo al directorio de destino
    if (move_uploaded_file($imagenEventoTmp, $destination)) {
        // Actualiza la base de datos con la nueva ubicación de la imagen
        $queryActualizarImagen = "UPDATE eventos SET imagen = '$destination' WHERE IDeventos = $IDevento";
        $resultActualizarImagen = $connection->query($queryActualizarImagen);

        if ($resultActualizarImagen === false) {
            $_SESSION['errorEditarImagen'] = "Error al actualizar la imagen del evento.";
            header("Location: eventoDetalle.php?ID=$IDevento");
            exit();
        }
    } else {
        // Maneja el error si no se pudo mover el archivo
        $_SESSION['errorEditarImagen'] = "Error al mover el archivo de imagen.";
        error_log("Error al mover el archivo de imagen: " . $imagenEventoTmp . " a " . $destination);
        header("Location: eventoDetalle.php?ID=$IDevento");
        exit();
    }
}




// Construir la consulta de actualización
$queryUpdate = "UPDATE eventos SET
    evento = '$nombreEvento',
    descripcion = '$descripcionEvento',
    IDcategoria = '$categoriaEvento',
    fecha = '$fechaEvento',
    hora = '$horaEvento',
    hora_fin = '$horaFinEvento',
    duracion = '$duracionEvento',
    lugar = '$lugarEvento',
    Costo = '$costoEvento',
    limite_inscritos = '$limiteInscritosEvento',
    organizador = '$organizadorEvento'
    WHERE IDeventos = '$IDevento'";

// Ejecutar la consulta
$resultUpdate = $connection->query($queryUpdate);

if ($resultUpdate === false) {
    // Manejar el error en caso de fallo
    echo "Error al actualizar el evento: " . $connection->error;
} else {
    // Redirigir o mostrar mensaje de éxito
    $_SESSION['editarEventoExito'] = "Los datos del evento han sido actualizados con exito";
    header("Location: eventoDetalle.php?ID=$IDevento");
    exit();
}

?>