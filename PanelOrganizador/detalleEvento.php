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

    <script>

        function verificarYEliminarEvento(activo, eventoID) {
            if (activo == 1) {
                // El evento está activo, muestra un mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: 'No se puede eliminar',
                    text: 'No se puede eliminar un evento activo o con inscriptos.'
                });
            } else {
                // El evento no está activo, verifica inscripciones
                $.ajax({
                    type: "POST",
                    url: "verificarInscripciones.php", // Crea un archivo PHP para manejar esta acción
                    data: { eventID: eventoID },
                    success: function (response) {
                        if (response === "inscripciones") {
                            // El evento tiene inscritos, muestra un mensaje de error
                            Swal.fire({
                                icon: 'error',
                                title: 'No se puede eliminar',
                                text: 'No se puede eliminar un evento con inscriptos.'
                            });
                        } else {
                            // El evento no tiene inscritos, muestra un mensaje de confirmación
                            Swal.fire({
                                icon: 'warning',
                                title: '¿Estás seguro?',
                                text: '¿Deseas eliminar este evento?',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Realiza la eliminación del evento si no tiene inscritos
                                    $.ajax({
                                        type: "POST",
                                        url: "eliminarEvento.php", // Crea un archivo PHP para manejar la eliminación
                                        data: { eventID: eventoID },
                                        success: function (response) {
                                            if (response === "success") {
                                                //Solucionar el problema de que aca no entre por aca
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Éxito',
                                                    text: 'El evento se ha eliminado correctamente.',
                                                    confirmButtonText: 'Continuar'
                                                }).then(() => {
                                                    // Redirige al usuario a la página panel.organizador.php
                                                    window.location.href = 'panel.php';
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Éxito',
                                                    text: 'El evento se ha eliminado correctamente.',
                                                    confirmButtonText: 'Continuar'
                                                }).then(() => {
                                                    // Redirige al usuario a la página panel.organizador.php
                                                    window.location.href = 'panel.php';
                                                });
                                            }
                                        },
                                    });
                                }
                            });
                        }
                    },
                    error: function (error) {
                        // Maneja errores aquí si es necesario
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al verificar las inscripciones.'
                        });
                    }
                });
            }
        }
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
                <form id="edit-event-form" action="guardarCambiosCampo.php" method="post">
                    <p>Nombre del Evento:
                        <span id="evento-evento-text">
                            <?php echo $evento['evento']; ?>
                        </span>
                        <input type="text" id="evento-evento-input" name="evento-evento" class="edit-input"
                            value="<?php echo $evento['evento']; ?>" required>
                        <button type="button" id="edit-evento-evento-button" class="edit-button">✏️</button>
                        <button type="button" id="save-evento-evento-button" class="save-button"
                            style="display: none">✔️</button>

                    </p>
                    <p>Fecha:
                        <span id="fecha-evento-text">
                            <?php echo $evento['fecha']; ?>
                        </span>
                        <input type="date" id="fecha-evento-input" name="fecha-evento" class="edit-input"
                            value="<?php echo $evento['evento']; ?>" required>
                        <button type="button" id="edit-fecha-evento-button" class="edit-button">✏️</button>
                        <button type="button" id="save-fecha-evento-button" class="save-button"
                            style="display: none">✔️</button>

                    </p>
                    <p>Lugar:
                        <span id="lugar-evento-text">
                            <?php echo $evento['lugar']; ?>
                        </span>
                        <input type="text" id="lugar-evento-input" name="lugar-evento" class="edit-input"
                            value="<?php echo $evento['lugar']; ?>" required>
                        <button type="button" id="edit-lugar-evento-button" class="edit-button">✏️</button>
                        <button type="button" id="save-lugar-evento-button" class="save-button"
                            style="display: none">✔️</button>


                    </p>
                    <p>Descripción:
                        <span id="descripcion-evento-text">
                            <?php echo $evento['descripcion']; ?>
                        </span>
                        <input type="text" id="descripcion-evento-input" name="descripcion-evento" class="edit-input"
                            value="<?php echo $evento['descripcion']; ?>" required>
                        <button type="button" id="edit-descripcion-evento-button" class="edit-button">✏️</button>
                        <button type="button" id="save-descripcion-evento-button" class="save-button"
                            style="display: none">✔️</button>


                    </p>
                    <p>Hora de inicio:
                        <span id="hora-evento-text">
                            <?php echo $evento['hora']; ?>
                        </span>
                        <input type="time" id="hora-evento-input" name="hora-evento" class="edit-input"
                            value="<?php echo $evento['hora']; ?>" required>
                        <button type="button" id="edit-hora-evento-button" class="edit-button">✏️</button>
                        <button type="button" id="save-hora-evento-button" class="save-button"
                            style="display: none">✔️</button>

                    </p>
                    <p>Hora de finalización:
                        <span id="hora_fin-evento-text">
                            <?php echo $evento['hora_fin']; ?>
                        </span>
                        <input type="time" id="hora_fin-evento-input" name="hora_fin-evento" class="edit-input"
                            value="<?php echo $evento['hora_fin']; ?>" required>
                        <button type="button" id="edit-hora_fin-evento-button" class="edit-button">✏️</button>
                        <button type="button" id="save-hora_fin-evento-button" class="save-button"
                            style="display: none">✔️</button>

                    </p>
                    <p>Límite de inscripciones:
                        <span id="limite_inscritos-evento-text">
                            <?php echo $evento['limite_inscritos']; ?>
                        </span>
                        <input type="text" id="limite_inscritos-evento-input" name="limite_inscritos-evento"
                            class="edit-input" value="<?php echo $evento['limite_inscritos']; ?>" required>
                        <button type="button" id="edit-limite_inscritos-evento-button" class="edit-button">✏️</button>
                        <button type="button" id="save-limite_inscritos-evento-button" class="save-button"
                            style="display: none">✔️</button>

                    </p>
                    <p>El evento
                        <?php echo $evento['activo'] ? 'está activo' : 'no está activado'; ?>
                    </p>
                </form>

                <div class="event-buttons">
                    <?php
                    $activo = $evento['activo'];
                    $accion = $activo ? 'Desactivar' : 'Activar';
                    $nuevoValor = $activo ? 0 : 1;
                    ?>
                    <button id="toggle-event-button" data-eventid="<?php echo $IDeventos; ?>"
                        data-nuevo-valor="<?php echo $nuevoValor; ?>">
                        <?php echo $accion; ?> Evento
                    </button>

                    <button id="edit-event-button">Editar Evento</button>
                    <button id="delete-event-button"
                        onclick="verificarYEliminarEvento(<?php echo $evento['activo']; ?>, <?php echo $IDeventos; ?>)">Eliminar
                        Evento</button>

                </div>
            </div>


        </section>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const activo = <?php echo $evento['activo']; ?>;

                function toggleEditMode(fieldId) {
                    const textElement = document.getElementById(fieldId + "-text");
                    const inputElement = document.getElementById(fieldId + "-input");
                    const editButton = document.getElementById("edit-" + fieldId + "-button");
                    const saveButton = document.getElementById("save-" + fieldId + "-button");

                    if (activo === 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'No se puede editar',
                            text: 'El evento está activo y no se puede editar.',
                        });
                        return;
                    }

                    if (textElement.style.display !== "none") {
                        textElement.style.display = "none";
                        inputElement.style.display = "inline";
                        editButton.style.display = "none";
                        saveButton.style.display = "inline";
                    } else {
                        textElement.style.display = "inline";
                        inputElement.style.display = "none";
                        editButton.style.display = "inline";
                        saveButton.style.display = "none";
                    }
                }

                // Agrega event listeners a los botones de edición y guardar
                const fieldsToEdit = ["evento-evento", "fecha-evento", "lugar-evento", "descripcion-evento", "hora-evento", "hora_fin-evento", "limite_inscritos-evento"];

                fieldsToEdit.forEach(function (fieldId) {
                    console.log (fieldId)
                    const editButton = document.getElementById("edit-" + fieldId + "-button");
                    const saveButton = document.getElementById("save-" + fieldId + "-button");

                    editButton.addEventListener("click", function () {
                        toggleEditMode(fieldId);
                    });

                    saveButton.addEventListener("click", function () {
                        const editedValue = document.getElementById(fieldId + "-input").value;
                        const fieldToUpdate = fieldId.replace("-evento", ""); // Quita el sufijo "-evento" para obtener el nombre del campo en la base de datos
                        const eventId = <?php echo $IDeventos; ?>;

                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "guardarCambiosCampo.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    if (xhr.responseText === "success") {
                                        // La actualización fue exitosa, puedes manejar la respuesta aquí si es necesario
                                    } else {
                                        // Ocurrió un error durante la actualización, maneja el error si es necesario
                                    }
                                }
                            }
                        };

                        xhr.send("fieldToUpdate=" + fieldToUpdate + "&editedValue=" + editedValue + "&eventId=" + eventId);
                    });
                });
            });
        </script>




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
                <button id="save-user-changes-button" type="submit" name="guardarCambios">Guardar Cambios de
                    Usuarios</button>
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