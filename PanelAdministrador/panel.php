<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administracion</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <script src="scriptEventos.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script>
</head>

<body>
  <header>
    <h1><a href="../index.html" class="logo-link"> Eventario </a> </h1>

    <?php
    if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] == 1) {
      // Si el usuario es un organizador, mostrar el botón para agregar eventos
      echo "<div class='button-container'>";
      echo "<a href='agregarEvento.php'>Agregar Evento</a>";
      echo "</div>";
    }

    // Resto del contenido del encabezado...
    ?>
  </header>

  <!-- Codigo para agregar eventos -->

  <!-- Resto del contenido de la página... -->

</body>

</html>
