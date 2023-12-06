<?php
session_start()
  ?>


<!DOCTYPE html>
<!--
Archivo plantilla base, compartida para mostrar el sidebar, navbar.
En la parte central esta lo dinamico que cambiara con cada funcionalidad.
-->
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Administrador</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="shortcut icon" href="assets/dist/img/AdminLTELogo.png" type="image/x-icon">

  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include "assets/modulos/navbar.php" ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "assets/modulos/aside.php" ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <?php include "dashboard.php" ?>

    </div>


    <!-- /.content-wrapper -->



    <!-- Main Footer -->
    <?php include "assets/modulos/footer.php" ?>
    <!-- ./wrapper -->



  </div>

  <script>

    function cargarContenido(paginaPhp, contenedor) {
      $("." + contenedor).load(paginaPhp);
    }

  </script>

</body>


<?php
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

$IDadministrador = $_SESSION['IDadministrador']; // Obten el ID del organizador desde la sesión
$IDeventos = null;

if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] == 1) {




} else {
  echo "<script>alert('Debes iniciar sesión como administrador. Serás redirigido a la página de inicio de sesión para administradores.'); window.location.href = '../login/loginAdmin.php';</script>";
}


?>

</html>