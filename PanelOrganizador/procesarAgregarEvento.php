<?php
session_start();

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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombreEvento = $_POST["nombreEvento"];
    $fechaEvento = $_POST["fechaEvento"];
    $lugarEvento = $_POST["lugarEvento"];
    $descripcionEvento = $_POST["descripcionEvento"];
    $horaInicio = $_POST["horaInicio"];
    $limiteInscriptos = $_POST["limiteInscriptos"];
    $horaFin = $_POST["horaFin"];
    $duracionEvento = $_POST["duracionEvento"];
    $costoEvento = $_POST["costoEvento"];
    $imagenEvento = $_FILES["imagenEvento"]["name"];
    $imagenEventoTmp = $_FILES["imagenEvento"]["tmp_name"];
    $categoriaEvento = $_POST["categoriaEvento"];

    // Mover la imagen cargada al directorio deseado (ajusta la ruta según tu estructura de carpetas)
    $destination = "images/" . $imagenEvento;
    move_uploaded_file($imagenEventoTmp, $destination);

    // Insertar el evento en la base de datos
    $query = "INSERT INTO eventos (evento, fecha, lugar, descripcion, hora, limite_inscritos, hora_fin, duracion, costo, imagen, IDcategoria)
              VALUES ('$nombreEvento', '$fechaEvento', '$lugarEvento', '$descripcionEvento', '$horaInicio', '$limiteInscriptos', '$horaFin', '$duracionEvento', '$costoEvento', '$destination', '$categoriaEvento')";

    if ($connection->query($query) === true) {
        // Redirigir a la página de éxito o a donde sea necesario
        header("Location: panelAdmin.php");
        exit;
    } else {
        // Manejar el error de la inserción en la base de datos
        echo "Error al agregar el evento: " . $connection->error;
    }
} else {
    // Manejar el caso en que no se ha enviado el formulario
    echo "El formulario no ha sido enviado correctamente.";
}

// Cerrar la conexión a la base de datos al finalizar
$connection->close();
?>