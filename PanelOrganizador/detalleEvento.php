<?php
session_start();

// Verificar si el usuario ha iniciado sesión como organizador
if (!isset($_SESSION['esAdmin']) || $_SESSION['esAdmin'] != 1) {
    echo "<script>alert('Debes iniciar sesión como organizador.'); window.location.href = '../login/login.php';</script>";
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
    $IDorganizador = $_SESSION['IDorganizador']; // Obten el ID del organizador desde la sesión
    
?>
<?php
    // Obtener el ID del evento de la URL
if (isset($_GET['IDeventos'])) {
    // echo "Valor de \$_GET['IDeventos']: " . $_GET['IDeventos'];
    // echo "Valor de \$IDeventos después de obtenerlo: " . $IDeventos;

    $IDeventos = $_GET['IDeventos'];

    

    // Consulta para obtener la información del evento
    $queryEvento = "SELECT * FROM eventos WHERE IDeventos = '$IDeventos'";
    $resultEvento = $connection->query($queryEvento);

    // Consulta para obtener la lista de usuarios inscritos en el evento
    $queryUsuariosInscritos = "SELECT u.IDusuario, u.nombre, u.apellido, u.email, u.celular, i.asistio, i.pago
    FROM usuarios u
    INNER JOIN inscripciones i ON u.IDusuario = i.IDusuario
    AND i.IDeventos = '$IDeventos'";

    $resultUsuariosInscritos = $connection->query($queryUsuariosInscritos);

    if ($resultEvento && $resultUsuariosInscritos) {
        // Mostrar la información del evento
        $evento = $resultEvento->fetch_assoc();
        //$usuario = $resultUsuariosInscritos->fetch_assoc ();

    } else {
        echo "Error al obtener la información del evento o la lista de usuarios inscritos.";
        echo "Error en la consulta del evento: " . $connection->error;
        echo "Error en la consulta de usuarios inscritos: " . $connection->error;
    }
} else {
    echo "ID de evento no proporcionado en la URL.";
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administracion</title>
  <link rel="stylesheet" type="text/css" href="css/estilosDetalleEvento.css">
  <script src="scripts/detalleEvento.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
        $("#toggle-event-button").on("click", function () {
            var eventID = $(this).data("eventid");
            var nuevoValor = $(this).data("nuevo-valor");

            $.ajax({
                type: "POST",
                url: "toggleEvento.php", // Crea un archivo PHP para manejar esta acción
                data: { eventID: eventID, nuevoValor: nuevoValor },
                success: function (response) {
                    // Puedes mostrar una confirmación si lo deseas
                    alert(response);
                    // Recarga la página para reflejar los cambios
                    location.reload();
                },
                error: function (error) {
                    // Maneja errores aquí si es necesario
                    alert("Error: " + error);
                }
            });
        });
    });
    </script>

<header>
    <h1><a href="../index.html" class="logo-link"> Eventario </a> </h1>

    <?php

    echo "<div class='button-container'>";
    echo "<a id='panel-button'href='panel.php'>Volver al panel</a>";
    echo "<a id='logout-button' href='cerrarSesion.php'>Cerrar sesión</a>";
    echo "</div>";
    
    ?>
  </header>    
    


  <main>
  <section class="event-item">
    <img class="event-image" src="<?php echo $evento['imagen']; ?>" alt="Imagen del evento">
    <div class="event-details">
        <h2>Descripción del Evento</h2>
        <p>Nombre del Evento: <?php echo $evento['evento']; ?></p>
        <p>Fecha: <?php echo $evento['fecha']; ?></p>
        <p>Lugar: <?php echo $evento['lugar']; ?></p>
        <p>Descripción: <?php echo $evento['descripcion']; ?></p>
        <p>Hora de inicio: <?php echo $evento['hora']; ?></p>
        <p>Hora de finalización: <?php echo $evento['hora_fin']; ?></p>
        <p>Límite de inscripciones: <?php echo $evento['limite_inscritos']; ?></p>
        <p>El evento <?php echo $evento['activo'] ? 'está activo' : 'no está activado'; ?></p>

        <div class="event-buttons">
            <?php
                $activo = $evento['activo'];
                $accion = $activo ? 'Desactivar' : 'Activar';
                $nuevoValor = $activo ? 0 : 1;
            ?>
            <button id="toggle-event-button" data-eventid="<?php echo $IDeventos; ?>" data-nuevo-valor="<?php echo $nuevoValor; ?>">
            <?php echo $accion; ?> Evento
            </button>

            <button id="edit-event-button">Editar Evento</button>
            <button id="delete-event-button">Eliminar Evento</button>
        </div>
    </div>






</section>

<section>
    <!-- Lista de Usuarios Inscritos -->
    <h2>Descripción de los Usuarios Inscritos</h2>
    <form action="guardarCambios.php" method="post">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Celular</th>
                <th>Asistió</th>
                <th>Pago</th>
            </tr>
            <?php
                while ($usuario = $resultUsuariosInscritos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $usuario['nombre'] . "</td>";
                    echo "<td>" . $usuario['apellido'] . "</td>";
                    echo "<td>" . $usuario['email'] . "</td>";
                    echo "<td>" . $usuario['celular'] . "</td>";
                    echo "<td>";
                    echo "<input type='checkbox' name='asistio[]' value='" . $usuario['IDusuario'] . "' " . ($usuario['asistio'] ? 'checked' : '') . ">";
                    echo "</td>";
                    echo "<td>";
                    echo "<input type='checkbox' name='pago[]' value='" . $usuario['IDusuario'] . "' " . ($usuario['pago'] ? 'checked' : '') . ">";
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <button id = "save-user-changes-button" type="submit" name="guardarCambios">Guardar Cambios de Usuarios</button>
        <input type="hidden" name="IDeventos" value="<?php echo $IDeventos; ?>">
    </form>
</section>
    </main>

</body>

</html>

<?php

// Cierra la conexión a la base de datos
$connection->close();
?>