<?php
include "panelAdminLogica.php";
include "assets/modulos/head.php";

// Obtener el ID del evento desde la URL
$IDevento = $_GET['ID'];

if (isset($_SESSION['error_message'])) {
    echo '<div id="errorMessage" class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Error</h5>
            ' . $_SESSION['error_message'] . '
          </div>';

    // Limpiar el mensaje de error después de mostrarlo
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['errorEditarFecha'])) {
    echo '<div id="errorMessage" class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Error</h5>
            ' . $_SESSION['errorEditarFecha'] . '
          </div>';

    // Limpiar el mensaje de error después de mostrarlo
    unset($_SESSION['errorEditarFecha']);
}

if (isset($_SESSION['errorEditarImagen'])) {
    echo '<div id="errorMessage" class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Error</h5>
            ' . $_SESSION['errorEditarImagen'] . '
          </div>';

    // Limpiar el mensaje de error después de mostrarlo
    unset($_SESSION['errorEditarImagen']);
}

if (isset($_SESSION['editarEventoExito'])) {
    echo '<div id="successMessage" class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Éxito</h5>
            ' . $_SESSION['editarEventoExito'] . '
          </div>';

    // Limpiar el mensaje de éxito después de mostrarlo
    unset($_SESSION['editarEventoExito']);
}

if (isset($_SESSION['preinscripcionesExito'])) {
    echo '<div id="successMessage" class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Éxito</h5>
            ' . $_SESSION['preinscripcionesExito'] . '
          </div>';

    // Limpiar el mensaje de éxito después de mostrarlo
    unset($_SESSION['preinscripcionesExito']);
}


// Consulta para obtener la información del evento
$queryEvento = "SELECT e.*, c.nombrecategoria
                FROM eventos e
                INNER JOIN categoriaevento c ON e.IDcategoria = c.IDcategoria
                WHERE e.IDeventos = $IDevento";
$resultEvento = $connection->query($queryEvento);

$queryPreinscritos = "SELECT u.IDusuario, u.nombre, u.apellido, u.email, u.celular
FROM usuarios u
INNER JOIN inscripciones i ON u.IDusuario = i.IDusuario
AND i.IDeventos = '$IDevento'
WHERE i.activo = 0";

$resultPreinscritos = $connection->query($queryPreinscritos);

// Consulta para obtener la lista de usuarios inscritos en el evento
$queryInscritos = "SELECT u.IDusuario, u.nombre, u.apellido, u.email, u.celular, i.asistio, i.pago, i.activo
    FROM usuarios u
    INNER JOIN inscripciones i ON u.IDusuario = i.IDusuario
    AND i.IDeventos = '$IDevento'
    WHERE i.activo = 1";

$resultInscritos = $connection->query($queryInscritos);

?>

<div class="wrapper">

    <!-- Navbar -->
    <?php include "assets/modulos/navbar.php" ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "assets/modulos/aside.php" ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detalle del Evento</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                            <li class="breadcrumb-item active">Detalle del Evento</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content">
            <div class="container-fluid">

                <!-- Detalles del evento -->
                <?php if ($resultEvento && $resultEvento->num_rows > 0): ?>
                    <?php $evento = $resultEvento->fetch_assoc(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <?= $evento['evento'] ?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Información principal del evento -->
                                    <dl class="row">
                                        <dt class="col-sm-4">Descripcion:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['descripcion'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Categoria del Evento:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['nombrecategoria'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Fecha:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['fecha'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Hora:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['hora'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Hora Finalizacion:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['hora_fin'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Duración:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['duracion'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Lugar:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['lugar'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Costo en ARS:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['Costo'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Limite de Inscripciones:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['limite_inscritos'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Organizador:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['organizador'] ?>
                                        </dd>

                                        <!-- Estado del evento y botón para activar/desactivar -->
                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-2">
                                                <!-- Botón para activar/desactivar con confirmación -->
                                                <button type="button" class="btn btn-primary btn-block" data-toggle="modal"
                                                    data-target="#confirmacionModal">
                                                    <?php echo ($evento['activo'] == 1) ? "Desactivar " : "Activar "; ?>
                                                </button>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <!-- Botón para eliminar evento con confirmación -->
                                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                                    data-target="#eliminarEventoModal" <?php echo ($evento['activo'] == 1) ? "disabled" : ""; ?>>
                                                    Eliminar Evento
                                                </button>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <button type="button" class="btn btn-warning btn-block" data-toggle="modal"
                                                    data-target="#editarEventoModal" <?php echo ($evento['activo'] == 1) ? "disabled" : ""; ?>>
                                                    Editar Evento
                                                </button>

                                            </div>
                                        </div>



                                    </dl>
                                </div>


                                <div class="col-md-6">
                                    <!-- Imagen del evento -->
                                    <img src="<?= $evento['imagen'] ?>" class="img-fluid mb-2" alt="Imagen del evento">
                                    <!-- Otras tarjetas o componentes aquí para detalles adicionales -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de confirmación -->
                    <div class="modal fade" id="confirmacionModal" tabindex="-1" role="dialog"
                        aria-labelledby="confirmacionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmacionModalLabel">Confirmación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php echo ($evento['activo'] == 1) ? "¿Estás seguro de que deseas desactivar este evento?" : "¿Estás seguro de que deseas activar este evento?"; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <a href="procesarActivarDesactivar.php?IDevento=<?= $IDevento ?>"
                                        class="btn btn-primary">Confirmar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No se encontró información del evento.</p>
                <?php endif; ?>

                <!-- Modal de confirmación para eliminar evento -->
                <div class="modal fade" id="eliminarEventoModal" tabindex="-1" role="dialog"
                    aria-labelledby="eliminarEventoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eliminarEventoModalLabel">Confirmación de eliminación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas eliminar este evento? Esta acción no se puede deshacer.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <a href="procesarEliminarEvento.php?IDevento=<?= $IDevento ?>"
                                    class="btn btn-danger">Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Modal de edición de evento -->
                <div class="modal fade" id="editarEventoModal" tabindex="-1" role="dialog"
                    aria-labelledby="editarEventoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarEventoModalLabel">Editar Evento</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de edición de evento -->
                                <form action="procesarEditarEvento.php" method="post">
                                    <input type="hidden" name="IDevento" value="<?= $evento['IDeventos'] ?>">

                                    <!-- Agrega aquí los campos que desees editar -->
                                    <div class="form-group">
                                        <label for="nombreEvento">Nombre del Evento:</label>
                                        <input type="text" class="form-control" id="nombreEvento" name="nombreEvento"
                                            value="<?= $evento['evento'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="descripcionEvento">Descripción del Evento:</label>
                                        <textarea class="form-control" id="descripcionEvento" name="descripcionEvento"
                                            required><?= $evento['descripcion'] ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="categoriaEvento">Categoría del Evento:</label>
                                        <select class="form-control" id="categoriaEvento" name="categoriaEvento"
                                            required>
                                            <?php
                                            // Consulta para obtener todas las categorías existentes
                                            $queryCategorias = "SELECT * FROM categoriaevento";
                                            $resultCategorias = $connection->query($queryCategorias);

                                            if ($resultCategorias === false) {
                                                echo "Error en la consulta de categorías: " . $connection->error;
                                            } else {
                                                while ($categoria = $resultCategorias->fetch_assoc()) {
                                                    // Marcamos la categoría actual como seleccionada
                                                    $selected = ($categoria['IDcategoria'] == $evento['IDcategoria']) ? 'selected' : '';

                                                    echo "<option value='{$categoria['IDcategoria']}' $selected>{$categoria['nombrecategoria']}</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="fechaEvento">Fecha del Evento:</label>
                                        <input type="date" class="form-control" id="fechaEvento" name="fechaEvento"
                                            value="<?= $evento['fecha'] ?>" required></input>
                                    </div>

                                    <div class="form-group">
                                        <label for="horaEvento">Hora de inicio del Evento:</label>
                                        <input type="time" class="form-control" id="horaEvento" name="horaEvento"
                                            value="<?= $evento['hora'] ?>" required></input>
                                    </div>

                                    <div class="form-group">
                                        <label for="horaFinEvento">Hora de finalizacion del Evento:</label>
                                        <input type="time" class="form-control" id="horaFinEvento" name="horaFinEvento"
                                            value="<?= $evento['hora_fin'] ?>" required></input>
                                    </div>

                                    <div class="form-group">
                                        <label for="duracionEvento">Duracion del Evento:</label>
                                        <input type="time" class="form-control" id="duracionEvento"
                                            name="duracionEvento" value="<?= $evento['duracion'] ?>" required></input>
                                    </div>

                                    <div class="form-group">
                                        <label for="lugarEvento">Lugar del Evento:</label>
                                        <input type="text" class="form-control" id="lugarEvento" name="lugarEvento"
                                            value="<?= $evento['lugar'] ?>" required></input>
                                    </div>

                                    <div class="form-group">
                                        <label for="costoEvento">Costo en pesos del Evento:</label>
                                        <input type="number" class="form-control" id="costoEvento" name="costoEvento"
                                            value="<?= $evento['Costo'] ?>" required></input>
                                    </div>

                                    <div class="form-group">
                                        <label for="limiteInscritosEvento">Limite de inscripciones del Evento:</label>
                                        <input type="number" class="form-control" id="limiteInscritosEvento"
                                            name="limiteInscritosEvento" value="<?= $evento['limite_inscritos'] ?>"
                                            required></input>
                                    </div>

                                    <div class="form-group">
                                        <label for="organizadorEvento">Organizador del Evento:</label>
                                        <input type="text" class="form-control" id="organizadorEvento"
                                            name="organizadorEvento" value="<?= $evento['organizador'] ?>"
                                            required></input>
                                    </div>

                                    <!--
                                    <div class="form-group">
                                        <label for="imagenEvento">Imagen del Evento:</label>
                                        <input type="file" class="form-control-file" id="imagenEvento"
                                            name="imagenEvento" accept="image/*">
                                        <?php // if ($evento['imagen']): ?>
                                            <img src="<? //= $evento['imagen'] ?>" class="img-thumbnail mt-2"
                                                alt="Imagen actual del evento">
                                        <?php //endif; ?>
                                    </div>
                                    -->
                                    <!-- Agrega más campos según la estructura de tu tabla -->

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de usuarios preinscritos -->
                <?php if ($resultPreinscritos === false): ?>
                    <p>Error en la consulta de usuarios preinscritos:
                        <?= $connection->error ?>
                    </p>
                <?php elseif ($resultPreinscritos->num_rows > 0): ?>


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Usuarios Preinscriptos al Evento</h3>

                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>

                                        <th>Nombre y Apellido</th>
                                        <th>Email</th>
                                        <th>Celular</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($preinscrito = $resultPreinscritos->fetch_assoc()): ?>
                                        <!-- Recuerda ajustar los nombres de las columnas según tu esquema de base de datos -->
                                        <tr>

                                            <!-- Agrega aquí más detalles según tus campos -->
                                            <td>
                                                <?= $preinscrito['nombre'] ?>
                                                <?= $preinscrito['apellido'] ?>
                                            </td>
                                            <td>
                                                <?= $preinscrito['email'] ?>
                                            </td>
                                            <td>
                                                <?= $preinscrito['celular'] ?>
                                            </td>
                                            <td>
                                                <!-- Agregar botón para aceptar inscripción -->
                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                    data-target="#confirmacionModal<?= $preinscrito['IDusuario'] ?>">
                                                    Aceptar Inscripción
                                                </button>

                                                <a href="procesarEliminarInscripcion.php?IDusuario=<?= $preinscrito['IDusuario'] ?>&IDevento=<?= $IDevento ?>"
                                                    class="btn btn-danger" data-toggle="modal"
                                                    data-target="#eliminarInscripcionModal<?= $preinscrito['IDusuario'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Modal de confirmación para cada usuario preinscrito -->
                                        <div class="modal fade" id="confirmacionModal<?= $preinscrito['IDusuario'] ?>"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="confirmacionModalLabel<?= $preinscrito['IDusuario'] ?>"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="confirmacionModalLabel<?= $preinscrito['IDusuario'] ?>">
                                                            Confirmación</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas aceptar la inscripción de
                                                        <?= $preinscrito['nombre'] ?>
                                                        <?= $preinscrito['apellido'] ?>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancelar</button>
                                                        <!-- Enlace a procesarAceptarInscripcion.php con parámetros -->
                                                        <a href="procesarAceptarInscripcion.php?IDusuario=<?= $preinscrito['IDusuario'] ?>&IDevento=<?= $IDevento ?>"
                                                            class="btn btn-primary">Aceptar Inscripción</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal de confirmación para eliminar la inscripción -->
                                        <div class="modal fade" id="eliminarInscripcionModal<?= $preinscrito['IDusuario'] ?>"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="eliminarInscripcionModalLabel<?= $preinscrito['IDusuario'] ?>"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="eliminarInscripcionModalLabel<?= $preinscrito['IDusuario'] ?>">
                                                            Confirmación de Eliminación</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas eliminar la inscripción de
                                                        <?= $preinscrito['nombre'] ?>
                                                        <?= $preinscrito['apellido'] ?>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancelar</button>
                                                        <!-- Enlace a procesarEliminarInscripcion.php con parámetros -->
                                                        <a href="procesarEliminarInscripcion.php?IDusuario=<?= $preinscrito['IDusuario'] ?>&IDevento=<?= $IDevento ?>"
                                                            class="btn btn-danger">Eliminar Inscripción</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Botón "Aceptar todas las preinscripciones" y su modal de confirmación -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#aceptarTodasModal">
                        Aceptar todas las preinscripciones
                    </button>

                    <!-- Modal de confirmación para aceptar todas las preinscripciones -->
                    <div class="modal fade" id="aceptarTodasModal" tabindex="-1" role="dialog"
                        aria-labelledby="aceptarTodasModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="aceptarTodasModalLabel">Confirmación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas aceptar todas las preinscripciones para este evento?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <!-- Enlace a procesarTodasPreinscripciones.php con parámetros -->
                                    <a href="procesarTodasPreinscripciones.php?IDevento=<?= $IDevento ?>"
                                        class="btn btn-primary">Aceptar Todas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No hay usuarios preinscritos.</p>
                <?php endif; ?>



                <!-- Lista de usuarios inscritos -->
                <?php if ($resultInscritos === false): ?>
                    <p>Error en la consulta de usuarios inscritos:
                        <?= $connection->error ?>
                    </p>
                <?php elseif ($resultInscritos->num_rows > 0): ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Usuarios Inscriptos al Evento</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>

                                        <th>Nombre y Apellido</th>
                                        <th>Email</th>
                                        <th>Celular</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($inscrito = $resultInscritos->fetch_assoc()): ?>
                                        <!-- Recuerda ajustar los nombres de las columnas según tu esquema de base de datos -->
                                        <tr>

                                            <td>
                                                <?= $inscrito['nombre'] ?>
                                                <?= $inscrito['apellido'] ?>
                                            </td>
                                            <td>
                                                <?= $inscrito['email'] ?>
                                            </td>
                                            <td>
                                                <?= $inscrito['celular'] ?>

                                            </td>


                                            <td>
                                                <?php if ($inscrito['asistio'] == 0): ?>
                                                    <a class="btn btn-success"
                                                        href="procesarAceptarAsistencia.php?IDusuario=<?= $inscrito['IDusuario'] ?>&IDevento=<?= $IDevento ?>">
                                                        Aceptar Asistencia
                                                    </a>
                                                <?php else: ?>
                                                    <a class="btn btn-danger"
                                                        href="procesarAnularAsistencia.php?IDusuario=<?= $inscrito['IDusuario'] ?>&IDevento=<?= $IDevento ?>">
                                                        Cancelar Asistencia
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($inscrito['pago'] == 0): ?>
                                                    <a class="btn btn-success"
                                                        href="procesarAceptarPago.php?IDusuario=<?= $inscrito['IDusuario'] ?>&IDevento=<?= $IDevento ?>">
                                                        Aceptar Pago
                                                    </a>
                                                <?php else: ?>
                                                    <a class="btn btn-danger"
                                                        href="procesarAnularPago.php?IDusuario=<?= $inscrito['IDusuario'] ?>&IDevento=<?= $IDevento ?>">
                                                        Cancelar Pago
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($inscrito['activo'] == 1): ?>
                                                    <a class="btn btn-danger"
                                                        href="procesarAnularInscripcion.php?IDusuario=<?= $inscrito['IDusuario'] ?>&IDevento=<?= $IDevento ?>">
                                                        Cancelar Inscripcion
                                                    </a>
                                                <?php endif; ?>
                                            </td>

                                        </tr>

                                        <!-- Modales para cada acción de anular -->



                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No hay usuarios inscritos.</p>
                <?php endif; ?>

            </div><!-- /.container-fluid -->
        </div><!-- /.content -->

    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php include "assets/modulos/footer.php" ?>
    <!-- ./wrapper -->

</div>
</body>


</html>