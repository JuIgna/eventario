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
  <link rel="stylesheet" type="text/css" href="css/estilosOrganizador.css">
<!--  <script src="scripts/panelOrganizador.js"></script> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
<!--  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script> -->



</head>

<body>
  <header>
    <h1><a href="../index.html" class="logo-link"> Eventario </a> </h1>

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
    $IDorganizador = $_SESSION['IDorganizador']; // Obten el ID del organizador desde la sesión
    $IDeventos = null;
    
    echo "<div class='button-container'>";
    echo "<a id='logout-button' href='cerrarSesion.php'>Cerrar sesión</a>";
    echo "</div>";
    
    ?>
  </header>

  <main>
    <?php
    
    if (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin'] == 1) {
      // Si el usuario es un organizador, mostrar el botón para agregar eventos
      echo "<section>";
      echo "<button id='add-event-button' >Agregar Evento</button>";
      echo "<button id='view-events-button' >Ver mis eventos</button>";
      echo "</section>";

      echo "<div id='add-event-modal' class='modal'>";
      echo "<div class='modal-content'>";
      echo "<span id='close-modal-button' class='close'>&times;</span>";

      echo "<h3>Agregar Evento</h3>";
      echo "<form id='add-event-form' action='panel.php' method='POST' enctype='multipart/form-data'>";
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


      echo "<script>
      document.getElementById('view-events-button').addEventListener('click', function() {
        
        // Realiza una petición AJAX para obtener los eventos del organizador
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'obtenerEventos.php', true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            // Manejar la respuesta y mostrar los eventos en la página
            const events = JSON.parse(xhr.responseText);
            mostrarEventos(events);
          }
        };
        xhr.send();
      });
      
      function mostrarEventos(eventos) {
        const eventosContainer = document.getElementById('eventos-container');
        eventosContainer.innerHTML = ''; // Limpiar el contenedor
      
        // Crea una lista no ordenada (ul)
        const eventList = document.createElement('ul');
        eventList.id = 'event-list';
      
        eventos.forEach(evento => {
          // Para cada evento, crea un elemento de lista (li)
          const eventoItem = document.createElement('li');
          eventoItem.classList.add('event-item'); // Agregar la clase 'event-item'
      
          // Crea una imagen (img) para el evento
          const eventoImage = document.createElement('img');
          eventoImage.classList.add('event-image'); // Agregar la clase 'event-image'
          eventoImage.src = evento.imagen;
          eventoImage.alt = evento.evento;
          eventoImage.style.maxWidth = '250x';
          eventoImage.style.maxHeight = '250px'
      
          // Crea un contenedor de detalles para el evento
          const eventoDetails = document.createElement('div');
          eventoDetails.classList.add('event-details'); // Agregar la clase 'event-details'
          eventoDetails.innerHTML = '<h4>' + evento.evento + '</h4>' +
            '<p>Fecha: ' + evento.fecha + '</p>' +
            '<p>Lugar: ' + evento.lugar + '</p>' +
            '<p>Descripción: ' + evento.descripcion + '</p>' +
            '<p>Hora de inicio: ' + evento.hora + '</p>' +
            '<p>Hora de finalización: ' + evento.hora_fin + '</p>' +
            '<p>ID: ' + evento.IDeventos + '</p>' +
            '<p>Límite de inscripciones: ' + evento.limite_inscritos + '</p>';
      
          // Agrega la imagen y los detalles al elemento de lista
          eventoItem.appendChild(eventoImage);
          eventoItem.appendChild(eventoDetails);
      
          const detalleEventoButton = document.createElement('button');
          detalleEventoButton.innerText = 'Ver detalle';
          detalleEventoButton.classList.add('detail-event-button');
          detalleEventoButton.addEventListener('click', () => {
            // Obtén el ID del evento que se va a editar
            let numeroIDeventos = evento.IDeventos;
          
            // Convierte IDeventos a un número entero
           // const IDevento = parseInt(numeroIDeventos);
          
            console.log('evento.IDeventos:', numeroIDeventos);
          
            console.log('Redirigiendo a la página de detalleEvento.php');
            // window.location.href = `detalleEvento.php?IDeventos=37`; Se pasa correctamente
             window.location.href = 'detalleEvento.php?IDeventos='+ numeroIDeventos; // No se pasa correctamente
            
          });
          
          // Agrega el botón 'Detalle Evento' al elemento de detalles
          eventoDetails.appendChild(detalleEventoButton);
      
          // Agregar el elemento de lista (li) a la lista (ul)
          eventList.appendChild(eventoItem);

        });
      
        // Agrega la lista completa al contenedor de eventos
        eventosContainer.appendChild(eventList);
      }
      </script>";
      
      echo "<div id='eventos-container' class='eventos-container'></div>";
       
      
      // Codigo para agregar eventos
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
        $limiteInscripciones = $_POST["limite-inscriptos"];


        // Verificar que hora final sea mayor que la hora. Caso contrario no se agrega el evento
        if (strtotime($horaEventoFin) <= strtotime($horaEvento)) {
          echo "<script>
          Swal.fire({
              title: 'Error',
              text: 'La hora de finalizacion debe ser mayor que la hora de inicio ',
              icon: 'error',
              confirmButtonText: 'Aceptar'
              }).then(function() {
                 window.location.href = 'panel.php';
             });
          </script>";
          exit;
        }

        // Mover la imagen cargada al directorio deseado
        $destination = "images/" . $imagenEvento;
        move_uploaded_file($imagenEventoTmp, $destination);

        // Mover la imagen cargada al directorio deseado
        $destination = "images/" . $imagenEvento;
        move_uploaded_file($imagenEventoTmp, $destination);

        // Insertar el evento en la base de datos
        $query = "INSERT INTO eventos (evento, fecha, lugar, imagen, descripcion, hora, limite_inscritos,hora_fin) VALUES ('$nombreEvento', '$fechaEvento', '$lugarEvento', '$destination','$descripcionEvento','$horaEvento', '$limiteInscripciones','$horaEventoFin')";
        

        if ($connection->query($query) === true) {
          $IDeventos = $connection->insert_id;

          $query = "INSERT INTO eventosorganizador (IDorganizador, IDeventos) VALUES ('$IDorganizador', '$IDeventos')";

          if ($connection->query($query) === true) {
            header("Location: panel.php");
            exit;
          }
        } else {
          echo "Error al agregar el evento: " . $connection->error;
        }
      }
    } else {
      echo "<script>alert('Debes iniciar sesión como organizador. Serás redirigido a la página de inicio de sesión.'); window.location.href = '../login/login.php';</script>";
      // header ("Location: ../login/login.php");
    }
    ?>
  </main>

</body>

</html>