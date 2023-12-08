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


// Consulta para obtener la información del evento
$queryEvento = "SELECT * FROM eventos WHERE IDeventos = $IDevento";
$resultEvento = $connection->query($queryEvento);

$queryPreinscritos = "SELECT u.IDusuario, u.nombre, u.apellido, u.email
FROM usuarios u
INNER JOIN inscripciones i ON u.IDusuario = i.IDusuario
AND i.IDeventos = '$IDevento'
WHERE i.activo = 0";

$resultPreinscritos = $connection->query($queryPreinscritos);

// Consulta para obtener la lista de usuarios inscritos en el evento
$queryInscritos = "SELECT u.IDusuario, u.nombre, u.apellido, u.email, u.celular, i.asistio, i.pago
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
                                        <dt class="col-sm-4">Fecha:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['fecha'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Hora:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['hora'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Duración:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['duracion'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Lugar:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['lugar'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Costo:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['Costo'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Limite de inscritos:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['limite_inscritos'] ?>
                                        </dd>

                                        <dt class="col-sm-4">Organizador:</dt>
                                        <dd class="col-sm-8">
                                            <?= $evento['organizador'] ?>
                                        </dd>

                                        <!-- Estado del evento y botón para activar/desactivar -->
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <!-- Botón para activar/desactivar con confirmación -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#confirmacionModal">
                                                    <?php echo ($evento['activo'] == 1) ? "Desactivar evento" : "Activar evento"; ?>
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


                <!-- Lista de usuarios preinscritos -->
                <?php if ($resultPreinscritos === false): ?>
                    <p>Error en la consulta de usuarios preinscritos:
                        <?= $connection->error ?>
                    </p>
                <?php elseif ($resultPreinscritos->num_rows > 0): ?>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Usuarios Preinscritos</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Usuario</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($preinscrito = $resultPreinscritos->fetch_assoc()): ?>
                                        <!-- Recuerda ajustar los nombres de las columnas según tu esquema de base de datos -->
                                        <tr>
                                            <td>
                                                <?= $preinscrito['IDusuario'] ?>
                                            </td>
                                            <!-- Agrega aquí más detalles según tus campos -->
                                            <td>
                                                <?= $preinscrito['nombre'] ?>
                                            </td>
                                            <td>
                                                <?= $preinscrito['apellido'] ?>
                                            </td>
                                            <td>
                                                <?= $preinscrito['email'] ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
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
                            <h3 class="card-title">Usuarios Inscritos</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Usuario</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Email</th>
                                        <th>Celular</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($inscrito = $resultInscritos->fetch_assoc()): ?>
                                        <!-- Recuerda ajustar los nombres de las columnas según tu esquema de base de datos -->
                                        <tr>
                                            <td>
                                                <?= $inscrito['IDusuario'] ?>
                                            </td>
                                            <td>
                                                <?= $inscrito['nombre'] ?>
                                            </td>
                                            <td>
                                                <?= $inscrito['apellido'] ?>
                                            </td>
                                            <td>
                                                <?= $inscrito['email'] ?>
                                            </td>
                                            <td>
                                                <?= $inscrito['celular'] ?>
                                            </td>
                                        </tr>
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