<?php
session_start();
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Eventos</title>
  <link rel="stylesheet" type="text/css" href="css/listaEventos.css">
  <script src="scriptEventos.js"></script>
</head>

<body>
  <header>
    <h1><a href="../index.html" class="logo-link">Eventario</a></h1>

    <?php
     // session_start();

    if (isset($_SESSION['username'])) {
      $username = $_SESSION['username'];
      echo "<div class='button-container'>";
      echo "<a id='events-list' href='misEventos.php'>Mis eventos</a>";
      echo "<a id='logout-button' href='cerrarSesion.php'>Cerrar sesión</a>";
      echo "</div>";
    } else {
      echo "<button id='login-button' onclick='redirectToLogin()'>Iniciar sesión</button>";
    }
    ?>
  </header>

  <main>
    <h2 class="title-eventos">Mis Eventos</h2>
    <section>
      <h3 class="title-proximos-eventos">Eventos en los que estás inscripto</h3>
      <button onclick="redirectToEventList()" id="add-event-button"> Lista Eventos </button>

      


      <?php
      if (!isset($_SESSION['username'])) {
        echo "<p class='login-message'>Inicia sesión para ver tus eventos.</p>";
      } else {
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

        // Obtener el ID del usuario actual
        $userID = $_SESSION['IDusuario'];

        // Consulta para obtener los eventos en los que está inscrito el usuario
        $query = "SELECT e.evento, e.fecha, e.lugar, e.imagen, e.descripcion, e.hora, e.hora_fin
                  FROM eventos e 
                  INNER JOIN inscripciones i ON e.IDeventos = i.IDeventos 
                  WHERE i.IDusuario = '$userID'
                  ORDER BY e.fecha";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
          echo "<ul id='event-list'>";
          while ($row = $result->fetch_assoc()) {
            $evento = $row["evento"];
            $fecha = $row["fecha"];
            $lugar = $row["lugar"];
            $imagen = $row["imagen"];
            $descripcion = $row ["descripcion"];
            $hora = $row ["hora"];
            $hora_fin = $row ["hora_fin"];


            echo "<li>";
            echo "<div class='event-item'>";
            echo "<div class='event-image'>";
            echo "<img class='event-image__img' src='../PanelOrganizador/$imagen' alt='Imagen del evento'>";
            echo "</div>";
            echo "<div class='event-details'>";
            echo "<h4>$evento</h4>";
            echo "<p>Descripcion: $descripcion </p>";
            echo "<p>Fecha: $fecha</p>";
            echo "<p>Lugar: $lugar</p>";
            echo "<p>Hora: $hora</p>";
            echo "<p>Hora Fin: $hora_fin</p>";
            echo "</div>";
            echo "</div>";
            echo "</li>";
          }
          echo "</ul>";
        } else {
          echo "<p class='no-events-message'>No estás inscrito en ningún evento.</p>";
        }

        // Cerrar la conexión a la base de datos
        $connection->close();
      }
      ?>
    </section>
  </main>

</body>

</html>
