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
    <h1><a href = "../index.html" class="logo-link"> Eventario </a> </h1>

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
      <?php
if ($valorEsAdmin !== NULL) {
        echo "<section>";
        echo "<button id='add-event-button' >Agregar Evento</button>";
        echo "</section>";

        echo "<div id='add-event-modal' class='modal'>";
        echo "<div class='modal-content'>";
        echo "<span id='close-modal-button' class='close'>&times;</span>";

        echo "<h3>Agregar Evento</h3>";
        echo "<form id='add-event-form' action='listaEventos.php' method='POST' enctype='multipart/form-data'>";
        echo "<label for='nombre-evento'>Nombre del Evento:</label>";
        echo "<input type='text' id='nombre-evento' name='nombre-evento' required>";

        echo "<label for='fecha-evento'>Fecha:</label>";
        echo "<input type='date' id='fecha-evento' name='fecha-evento' required>";

        echo "<label for='lugar-evento'>Lugar:</label>";
        echo "<input type='text' id='lugar-evento' name='lugar-evento' required>";

        echo "<label for='descripcion-evento'>Descripcion:</label>";
        echo "<input type='text' id='descripcion-evento' name='descripcion-evento' required>";

        echo "<label for='hora-evento'>Hora:</label>";
        echo "<input type='time' id='hora-evento' name='hora-evento' required>";

        echo "<label for='hora-evento-fin'>Hora Fin:</label>";
        echo "<input type='time' id='hora-evento-fin' name='hora-evento-fin' required>";

        echo "<label for='limite-inscriptos'>Limite Inscripciones:</label>";
        echo "<input type='number' id='limite-inscriptos' name='limite-inscriptos' max=200 required>";
        
        echo "<label for='imagen-evento'>Imagen:</label>";
        echo "<input type='file' id='imagen-evento' name='imagen-evento' accept='image/*' required>";

        echo "<button type='submit' >Agregar</button>";
        echo "</form>";

        echo "</div>";
        echo "</div>";

        echo "<script>";
        echo "document.getElementById('add-event-button').addEventListener('click', function() {";
        echo "document.getElementById('add-event-modal').style.display = 'block';";
        echo "});";
        echo "document.getElementById('close-modal-button').addEventListener('click', function() {";
        echo "document.getElementById('add-event-modal').style.display = 'none';";
        echo "});";
        echo "</script>";
}

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los valores del formulario
        $nombreEvento = $_POST["nombre-evento"];
        $fechaEvento = $_POST["fecha-evento"];
        $lugarEvento = $_POST["lugar-evento"];
        $imagenEvento = $_FILES["imagen-evento"]["name"];
        $imagenEventoTmp = $_FILES["imagen-evento"]["tmp_name"];
        $descripcionEvento = $_POST["descripcion-evento"];
        $horaEvento = $_POST["hora-evento"];
        $horaEventoFin = $_POST["hora-evento-fin"];
        $limiteInscripciones = $_POST ["limite-inscriptos"];

        
        // Verificar que hora final sea mayor que la hora. Caso contrario no se agrega el evento
        if (strtotime($horaEventoFin) <= strtotime($horaEvento)) {
          echo "<script>
          Swal.fire({
              title: 'Error',
              text: 'La hora de finalizacion debe ser mayor que la hora de inicio ',
              icon: 'error',
              confirmButtonText: 'Aceptar'
              }).then(function() {
                 window.location.href = 'listaEventos.php';
             });
          </script>";
          exit;
      }
  
      // Mover la imagen cargada al directorio deseado
      $destination = "images/" . $imagenEvento;
      move_uploaded_file($imagenEventoTmp, $destination);
  
      // Insertar el evento en la base de datos
      $query = "INSERT INTO eventos (evento, fecha, lugar, imagen, descripcion, hora, hora_fin, limite_inscritos) 
                VALUES ('$nombreEvento', '$fechaEvento', '$lugarEvento', '$destination', '$descripcionEvento', '$horaEvento', '$horaEventoFin', '$limiteInscripciones','$horaEventoFin')";
  
  

        // Mover la imagen cargada al directorio deseado
        $destination = "images/" . $imagenEvento;
        move_uploaded_file($imagenEventoTmp, $destination);

        // Insertar el evento en la base de datos
        $query = "INSERT INTO eventos (evento, fecha, lugar, imagen, descripcion, hora, limite_inscritos,hora_fin) VALUES ('$nombreEvento', '$fechaEvento', '$lugarEvento', '$destination','$descripcionEvento','$horaEvento', '$limiteInscripciones','$horaEventoFin')";
        if ($connection->query($query) === true) {
          header("Location: listaEventos.php");
          echo "Evento agregado correctamente.";
          exit;
        } else {
          echo "Error al agregar el evento: " . $connection->error;
        }
      }

                      
      ?>

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
        $query = "SELECT * FROM eventos ORDER BY fecha ASC" ;
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
            $descripcion = $row ['descripcion'];
            $hora = $row ['hora'];
            $horaEventoFin = $row['hora_fin'];
            $cant_inscripciones = $row['limite_inscritos'];


            // Consultar la cantidad de inscripciones realizadas
            $inscripcionesQuery = "SELECT COUNT(*) AS cantidad FROM inscripciones WHERE IDeventos = '$IDevento'";
            $inscripcionesResult = $connection->query($inscripcionesQuery);
            $cantidadInscripciones = $inscripcionesResult->fetch_assoc()['cantidad'];


            $cantidadRestante = $cant_inscripciones - $cantidadInscripciones;


            // Calcular los días restantes para el evento
            $dias_restantes = ceil((strtotime($fecha) - time()) / (60 * 60 * 24));

            // Verificar si el evento ya ha terminado
            $evento_terminado = strtotime($fecha) < time();


            // Calcular los días restantes para el evento
            $fecha_actual = new DateTime();
            $fecha_evento = new DateTime($fecha);
            // $diferencia = date_diff($fecha_actual, $fecha_evento);
            // $dias_restantes = $diferencia->days;
            // $horas_restantes = $diferencia->format('%h');


            $intervalo = $fecha_actual->diff($fecha_evento);
            $dias_restantes = $intervalo->format('%a');
            $horas_restantes = $intervalo->format('%h');


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
                  <img class="event-image__img" src="<?php echo $imagen; ?>" alt="Imagen del evento">
                </div>
                <div class="event-details">
                  <h4><?php echo $evento; ?></h4>
                  <p> <?php echo $descripcion; ?> </p>        
                  <p>Fecha: <?php echo $fecha; ?></p>
                  <p>Lugar: <?php echo $lugar; ?></p>
                  <p>Hora: <?php echo $hora . ' -- ' . $horaEventoFin; ?> </p>
                  <p>Inscripciones: <?php echo $cantidadInscripciones . ' / ' . $cant_inscripciones; ?></p>
                  
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


                  <?php if ($inscrito) { ?>
                        <form action="cancelarRegistro.php" method="POST">
                            <input type="hidden" name="IDeventos" value="<?php echo $IDevento; ?>">
                            <button type="submit" class="cancel-button">Cancelar Registro</button>
                        </form>
                    <?php } else if (isset($_SESSION['username'])) { ?>
                        <?php if ($cantidadRestante > 0) { ?>
                            <form action="inscribirEvento.php" method="POST">
                                <input type="hidden" name="IDeventos" value="<?php echo $IDevento; ?>">
                                <button type="submit" class="register-button">Registrarse</button>
                            </form>
                        <?php } else { ?>
                            <p>El evento ha alcanzado el límite de inscripciones.</p>
                        <?php }
                    } ?>
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