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

if (isset($_SESSION['username'])) {
  // El usuario ha iniciado sesión, puedes acceder a la variable de sesión
  $username = $_SESSION['username'];

  // Obtener el ID del usuario desde la base de datos
  $query = "SELECT IDusuario FROM usuarios WHERE nombre_completo = '$username' ";
  $result = $connection->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $IDusuario = $row['IDusuario'];

    // Almacenar el ID del usuario en la sesión
    $_SESSION['IDusuario'] = $IDusuario;
  }
} else {
  // El usuario no ha iniciado sesión, redirigir o mostrar un mensaje de error
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener el ID del evento y el ID del usuario
  $IDevento = $_POST["IDeventos"];
  $IDusuario = $_SESSION['IDusuario']; // Asegúrate de tener el ID del usuario en la sesión

  // Verificar si el usuario ya está inscrito en el evento
  $query = "SELECT * FROM inscripciones WHERE IDeventos = $IDevento AND IDusuario = $IDusuario";
  $result = $connection->query($query);

  if ($result->num_rows > 0) {
    header("Location: listaEventos.php?inscripcion=duplicada");
    exit;
  } else {
    // Insertar la inscripción en la tabla de inscripciones
    $query = "INSERT INTO inscripciones (IDeventos, IDusuario) VALUES ($IDevento, $IDusuario)";

    if ($connection->query($query) === true) {
      header("Location: listaEventos.php?inscripcion=exitosa");
      exit;
    } else {
      echo "Error al inscribirse en el evento: " . $connection->error;
    }
  }
}

// Cerrar la conexión a la base de datos
$connection->close();
?>
