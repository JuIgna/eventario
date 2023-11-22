<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Iniciar sesión - Eventario</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <script src="script.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>

  <header>

    <h1> Eventario </h1>
    <a href="../index.html" id="home-button">Volver al Inicio</a>

  </header>

  <main>
    <section>
      <form form action="login.php" method="POST">
        <h2 class="title-eventos">Iniciar sesión</h2>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Contraseña:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
          <label for="admin">Soy administrador:</label>
          <input type="checkbox" id="admin" name="admin">
        </div>
        <div class="form-group">
          <button id="login-submit-button" type="submit">Iniciar sesión </button>
          <a href="registro.php" id="register-submit-button">Registrarse</a>
        </div>
      </form>
    </section>
  </main>

</body>

</html>

<?php
// Establecer la conexión con la base de datos
$servername = "localhost"; // Cambia esto si tu servidor MySQL está en un host diferente
$username = "eventario_juan";
$password_db = "juan$2023";
$dbname = "eventario_db";
// hola flaco

$conn = new mysqli($servername, $username, $password_db, $dbname);

// Verificar si hubo un error en la conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se enviaron datos del formulario
if (isset($_POST['email']) && isset($_POST['password'])) {
  // Recuperar los datos enviados desde el formulario
  $email = $_POST['email'];
  $contrasena = $_POST['password'];

  // Verificar si el usuario marcó la casilla "Soy administrador"
  $esAdmin = isset($_POST['admin']) ? 1 : 0;

  if ($esAdmin) {
    // Si es administrador, buscar en la tabla "Organizador"
    $sql = "SELECT * FROM organizador WHERE correo = ? AND contrasena = ?";
  } else {
    // Si no es administrador, buscar en la tabla "Usuarios"
    $sql = "SELECT * FROM usuarios WHERE email = ? AND contrasena = ?";
  }

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $email, $contrasena);
  $stmt->execute();
  $result = $stmt->get_result();

  // Verificación del login
  if ($result->num_rows === 1) {
    // Inicio de sesión exitoso
    // Obtener los datos del usuario
    $row = $result->fetch_assoc();

    // Guardar el nombre de usuario y el ID de usuario en la sesión 
    $_SESSION['username'] = $row['nombre'];
    $_SESSION['IDusuario'] = $row['IDusuario'];
    $_SESSION['esAdmin'] = $esAdmin; // Establecer la variable de sesión "esAdmin"

    $_SESSION['username'] = $row['nombre'];
    $_SESSION['IDorganizador'] = $row['IDorganizador'];
    

    // Redirigir al usuario a la página de inicio o realizar otras acciones necesarias
    if ($esAdmin) {
      // Si es administrador, redirige a panel.php
      header('Location: ../PanelOrganizador/panel.php');
  } else {
      // Si no es administrador, redirige a listaEventos.php
      header('Location: ../ListadoDeEventos/listaEventos.php');
  }
  exit(); // Asegurar que el script se detenga después de la redirección
  } else {
    // Credenciales incorrectas
    $_SESSION['message'] = "Email o contraseña incorrectos";
  }
} else {
  // No se enviaron datos del formulario
  // $_SESSION['message'] = "Por favor, ingresa un email y una contraseña.";
}

// Mostrar mensaje de error (si corresponde). Verificar si hay un mensaje de error en la sesión
if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
  unset($_SESSION['message']); // Eliminar el mensaje de error de la sesión
  echo "<script>
    swal({
      title: 'Error',
      text: '$message',
      icon: 'error',
      button: 'Aceptar'
    });
  </script>";
}

// Cerrar la conexión y liberar los recursos
// $stmt->close();
// $conn->close();
?>
