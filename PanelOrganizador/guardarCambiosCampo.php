<?php

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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $fieldToUpdate = $_POST["fieldToUpdate"];
        $editedValue = $_POST["editedValue"];
        $eventId = $_POST["eventId"];
    
        // Debugging: Imprime los valores
        echo "fieldToUpdate: " . $fieldToUpdate . "<br>";
        echo "editedValue: " . $editedValue . "<br>";
        echo "eventId: " . $eventId . "<br>";
    
        // Realiza la actualización en la base de datos
        $stmt = $connection->prepare("UPDATE eventos SET $fieldToUpdate = ? WHERE IDeventos = ?");
        $stmt->bind_param("si", $editedValue, $eventId);
    
        // Debugging: Imprime la consulta SQL
        echo "SQL: " . $stmt->sql . "<br>";
    
        if ($stmt->execute()) {
            echo "success"; // Envía una respuesta de éxito
        } else {
            echo "error: " . $stmt->error; // Envía una respuesta de error y muestra el mensaje de error
        }
    
        $stmt->close();
    }

// Cierra la conexión a la base de datos
$connection->close();

?>
