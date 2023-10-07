<?php
session_start();


if (!isset($_SESSION['username'])) {
  // Si el usuario no ha iniciado sesión, redirigir al formulario de inicio de sesión
  header("Location: iniciarSesion.php");
  exit;
}


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

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener el ID del evento a cancelar la inscripción
  $eventID = $_POST["IDeventos"];

  // Obtener el ID del usuario actual
  $userID = $_SESSION['IDusuario']; // Corregir la variable a $_SESSION['IDusuario']

  // Verificar si el usuario está inscrito en el evento
  $inscripcionQuery = "SELECT * FROM inscripciones WHERE IDusuario = '$userID' AND IDeventos = '$eventID'";
  $inscripcionResult = $connection->query($inscripcionQuery);

  if ($inscripcionResult->num_rows > 0) {
    // Eliminar la inscripción del usuario al evento
    $eliminarQuery = "DELETE FROM inscripciones WHERE IDusuario = '$userID' AND IDeventos = '$eventID'";

    
    if ($connection->query($eliminarQuery) === true) {
      // Redirigir de vuelta a la lista de eventos con un parámetro de éxito
      header("Location: listaEventos.php?cancelacion=exitosa");
      exit;
    } else {
      echo "Error al cancelar la inscripción: " . $connection->error;
    }
  } else {
    $_SESSION['username'] = $username;
    $_SESSION['IDusuario'] = $userID;
    // El usuario no está inscrito en el evento, redirigir de vuelta a la lista de eventos
    header("Location: listaEventos.php");
    exit;
  }
} else {
  $_SESSION['username'] = $username;
  $_SESSION['IDusuario'] = $userID;
  // Si no se ha enviado el formulario, redirigir de vuelta a la lista de eventos
  header("Location: listaEventos.php");
  exit;
}

// Cerrar la conexión a la base de datos
$connection->close();
?>
