<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listado de Eventos</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <script src="scriptEventos.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script>
</head>

<body>
  <header>
    <h1><a href="../index.html" class="logo-link"> Eventario </a> </h1>

    <?php
    // Iniciar la sesión en la página
    $valorEsAdmin = NULL;
    echo "<script>var valorEsAdmin = " . json_encode($valorEsAdmin) . ";</script>";


    //session_start();


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

    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['username'])) {
      // El usuario ha iniciado sesión, puedes acceder a la variable de sesión
      $username = $_SESSION['username'];
      $valorEsAdmin = $_SESSION['esAdmin'];


      echo "<div class='button-container'>";
      echo "<a href='misEventos.php'>Mis eventos</a>";
      echo "<a href='cerrarSesion.php'>Cerrar sesión</a>";
      echo "</div>";

    } else {
      // El usuario no ha iniciado sesión, mostrar el botón de inicio de sesión
      echo "<button id='login-button' onclick='redirectToLogin()'>Iniciar sesión </button>";
    }

    ?>
  </header>

  <main>
    <h2 class="title-eventos">Listado de Eventos</h2>
    <section>
      <h3 class="title-proximos-eventos">Próximos eventos</h3>


      <!-- Codigo para agregar eventos -->
      

      <!-- Mostrar listado de eventos -->
      <ul id="event-list">
        <?php

        if (!isset($_SESSION['username'])) {
          echo "<p class='login-message'>Inicia sesión para registrarte a los eventos.</p>";
        }

        // Verificar si se ha establecido el parámetro 'inscripcion'
        if (isset($_GET['inscripcion']) && $_GET['inscripcion'] === 'exitosa') {
          echo "<script>alert('Usuario inscrito correctamente.');</script>";
        }

        // Verificar si se ha establecido el parámetro 'cancelacion'
        if (isset($_GET['cancelacion']) && $_GET['cancelacion'] === 'exitosa') {
          echo "<script>alert('Registro cancelado correctamente.');</script>";
        }

        // Consulta para obtener los eventos de la base de datos
        $query = "SELECT * FROM eventos ORDER BY fecha ASC";
        $result = $connection->query($query);

        // Comprobar si hay eventos
        if ($result->num_rows > 0) {
          // Iterar sobre los resultados y mostrar los eventos
          while ($row = $result->fetch_assoc()) {
            $evento = $row["evento"];
            $fecha = $row["fecha"];
            $lugar = $row["lugar"];
            $imagen = $row["imagen"];
            $IDevento = $row['IDeventos'];
            $descripcion = $row['descripcion'];
            $hora = $row['hora'];
            $horaEventoFin = $row['hora_fin'];
            $cant_inscripciones = $row['limite_inscritos'];


            // Consultar la cantidad de inscripciones realizadas
            $inscripcionesQuery = "SELECT COUNT(*) AS cantidad FROM inscripciones WHERE IDeventos = '$IDevento'";
            $inscripcionesResult = $connection->query($inscripcionesQuery);
            $cantidadInscripciones = $inscripcionesResult->fetch_assoc()['cantidad'];


            $cantidadRestante = $cant_inscripciones - $cantidadInscripciones;

            // Calcular los días restantes para el evento
            $fecha_actual = new DateTime();
            $fecha_evento = new DateTime($fecha);
            $intervalo = $fecha_actual->diff($fecha_evento);
            $dias_restantes = $intervalo->format('%a');
            $horas_restantes = $intervalo->format('%h');

            // Verificar si el evento ya ha terminado
            $evento_terminado = strtotime($fecha) < time();

            // Verificar si el usuario está inscrito en el evento actual
            $inscrito = false; // Variable para almacenar el estado de inscripción
            if (isset($_SESSION['username']) && isset($_SESSION['IDusuario'])) {
              $userID = $_SESSION['IDusuario'];

              // Consultar la tabla de inscripciones para verificar la inscripción del usuario
              $inscripcionQuery = "SELECT * FROM inscripciones WHERE IDusuario = '$userID' AND IDeventos = '$IDevento'";
              $inscripcionResult = $connection->query($inscripcionQuery);

              if ($inscripcionResult->num_rows > 0) {
                $inscrito = true;
              }
            }
            ?>

            <li>
              <div class="event-item">
                <div class="event-image">
                  <img class="event-image__img" src="../PanelOrganizador/<?php echo $imagen; ?>" alt="Imagen del evento">
                </div>
                <div class="event-details">
                  <h4>
                    <?php echo $evento; ?>
                  </h4>
                  <p>
                    <?php echo $descripcion; ?>
                  </p>
                  <p>Fecha:
                    <?php echo $fecha; ?>
                  </p>
                  <p>Lugar:
                    <?php echo $lugar; ?>
                  </p>
                  <p>Hora:
                    <?php echo $hora . ' -- ' . $horaEventoFin; ?>
                  </p>
                  <p>Inscripciones:
                    <?php echo $cantidadInscripciones . ' / ' . $cant_inscripciones; ?>
                  </p>

                  <?php if ($evento_terminado) { ?>
                    <p>El evento ha terminado</p>
                  <?php } else if ($dias_restantes > 0 || $horas_restantes > 0) { ?>
                      <p>
                        <?php
                        if ($dias_restantes > 0) {
                          echo "Faltan $dias_restantes días";
                          if ($horas_restantes > 0) {
                            echo " y $horas_restantes horas";
                          }
                        } else {
                          echo "Faltan $horas_restantes horas";
                        }
                        ?>
                      </p>
                  <?php } else { ?>
                      <p>El evento está en curso</p>
                  <?php } ?>


                  <?php if (!$evento_terminado && !$inscrito && isset($_SESSION['username']) && $cantidadRestante > 0 && $valorEsAdmin == 0) { ?>
                    <form action="inscribirEvento.php" method="POST">
                      <input type="hidden" name="IDeventos" value="<?php echo $IDevento; ?>">
                      <button type="submit" class="register-button">Registrarse</button>
                    </form>
                  <?php } else if ($inscrito) { ?>
                    <form action="cancelarRegistro.php" method="POST">
                      <input type="hidden" name="IDeventos" value="<?php echo $IDevento; ?>">
                      <button type="submit" class="cancel-button">Cancelar Registro</button>
                    </form>
                  <?php } else if (!$evento_terminado && isset($_SESSION['username']) && $cantidadRestante <= 0) { ?>
                    <p>El evento ha alcanzado el límite de inscripciones.</p>
                  <?php } ?>

                </div>
              </div>
            </li>
            <?php
          }
        } else {
          echo "No se encontraron eventos.";
        }

        // Cerrar la conexión a la base de datos
        $connection->close();

        ?>

      </ul>

    </section>

  </main>


</body>

</html>
