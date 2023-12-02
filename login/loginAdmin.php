<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Iniciar sesión como Administrador - Eventario</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <script src="script.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/Index.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.html">Eventario</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
        aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link" href="../index.html">Volver a inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../ListadoDeEventos/listaEventos.php">Listado de Eventos</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>

    <section>
      <form class="form-signin" action="loginAdmin.php" method="POST">
        <h2 class="text-center mb-4">Iniciar sesión como Administrador</h2>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
          <label for="email">Email:</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
          <label for="password">Contraseña:</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar sesión como Administrador</button>
        <a href="registro.php" class="mt-3 d-block text-center">Registrarse</a>
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

  // Siempre buscar en la tabla "Organizador" para login de administradores
  $sql = "SELECT * FROM organizador WHERE correo = ? AND contrasena = ?";

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
    $_SESSION['IDorganizador'] = $row['IDorganizador'];
    $_SESSION['esAdmin'] = true; // Establecer la variable de sesión "esAdmin"

    // Redirigir al usuario a la página de inicio o realizar otras acciones necesarias
    header('Location: ../PanelOrganizador/panel.php');
    exit(); // Asegurar que el script se detenga después de la redirección
  } else {
    // Credenciales incorrectas
    $_SESSION['message'] = "Email o contraseña incorrectos para Administrador";
  }
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
//$stmt->close();
// $conn->close();
?>
