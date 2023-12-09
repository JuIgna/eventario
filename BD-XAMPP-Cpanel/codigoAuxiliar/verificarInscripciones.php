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

    // Consulta para verificar si existen inscripciones relacionadas con el evento
    $query = "SELECT * FROM inscripciones WHERE IDeventos = $IDeventos";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        // Hay inscripciones relacionadas con el evento
        echo "inscripciones";
    } else {
        // No hay inscripciones relacionadas con el evento
        echo "no_inscripciones";
    }

    // Cierra la conexión a la base de datos
    $connection->close();
}
?>