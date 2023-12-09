<?php
include "panelAdminLogica.php";

// Función para obtener la cantidad de usuarios registrados en un mes y año específicos
// Obtener la cantidad de usuarios registrados en el mes actual y año actual
$mesActual = date('m');
$anioActual = date('Y');
$cantidadUsuariosRegistrados = obtenerCantidadUsuariosRegistradosEnMes($mesActual, $anioActual);

// Obtener la cantidad de eventos registrados en el mes actual y año actual
$cantidadEventosRegistrados = obtenerCantidadEventosRegistradosEnMes($mesActual, $anioActual);

function obtenerCantidadUsuariosRegistradosEnMes($mes, $anio)
{
    global $connection; // Asegúrate de tener la conexión a la base de datos disponible

    $sql = "SELECT COUNT(*) AS cantidad FROM Usuarios WHERE MONTH(fechaAlta) = $mes AND YEAR(fechaAlta) = $anio";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['cantidad'];
    }

    return 0;
}

// Función para obtener la cantidad de eventos registrados en un mes y año específicos
function obtenerCantidadEventosRegistradosEnMes($mes, $anio)
{
    global $connection;

    $sql = "SELECT COUNT(*) AS cantidad FROM Eventos WHERE MONTH(fecha) = $mes AND YEAR(fecha) = $anio";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['cantidad'];
    }

    return 0;
}




// Función para obtener la cantidad de inscripciones
function obtenerCantidadInscripciones()
{
    global $connection;

    $sql = "SELECT COUNT(*) AS cantidad FROM Inscripciones";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['cantidad'];
    }

    return 0;
}

// Función para obtener el porcentaje de asistencia
function obtenerPorcentajeAsistencia()
{
    global $connection;

    $sqlTotalInscripciones = "SELECT COUNT(*) AS total FROM Inscripciones";
    $resultTotalInscripciones = $connection->query($sqlTotalInscripciones);

    $sqlAsistieron = "SELECT COUNT(*) AS asistieron FROM Inscripciones WHERE asistio = 1";
    $resultAsistieron = $connection->query($sqlAsistieron);

    if (
        $resultTotalInscripciones && $resultAsistieron &&
        $resultTotalInscripciones->num_rows > 0 && $resultAsistieron->num_rows > 0
    ) {
        $totalInscripciones = $resultTotalInscripciones->fetch_assoc()['total'];
        $asistieron = $resultAsistieron->fetch_assoc()['asistieron'];

        // Evitar división por cero
        if ($totalInscripciones > 0) {
            return round(($asistieron / $totalInscripciones) * 100, 2);
        }
    }

    return 0;
}

// Función para obtener los datos de evolución mensual de usuarios registrados
// Función para obtener los datos de evolución mensual de usuarios registrados para los últimos 12 meses
// Función para obtener los datos de evolución mensual de usuarios registrados para los últimos 12 meses
function obtenerDatosEvolucionUsuariosMensual()
{
    global $connection;

    $datos = array();

    // Obtén los datos agrupados por mes y año para los últimos 12 meses
    $sql = "SELECT COUNT(*) AS cantidad, DATE_FORMAT(fechaAlta, '%b %Y') AS etiqueta
            FROM Usuarios
            WHERE fechaAlta >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            GROUP BY YEAR(fechaAlta), MONTH(fechaAlta)
            ORDER BY YEAR(fechaAlta), MONTH(fechaAlta)";

    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $datos[] = $row['cantidad'];
        }
    }

    return $datos;
}

// Función para obtener las etiquetas de evolución mensual de usuarios registrados para los últimos 12 meses
function obtenerLabelsEvolucionUsuariosMensual()
{
    global $connection;

    $labels = array();

    // Obtén las etiquetas agrupadas por mes y año para los últimos 12 meses
    $sql = "SELECT DISTINCT DATE_FORMAT(fechaAlta, '%b %Y') AS etiqueta
            FROM Usuarios
            WHERE fechaAlta >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
            ORDER BY YEAR(fechaAlta), MONTH(fechaAlta)";

    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['etiqueta'];
        }
    }

    return $labels;
}

// Función para obtener el porcentaje de personas con sexo femenino inscritas a eventos
function obtenerPorcentajeFemeninoInscrito()
{
    global $connection;

    $sqlTotalFemenino = "SELECT COUNT(*) AS total FROM Inscripciones WHERE activo = 1 AND IDusuario IN (SELECT IDusuario FROM Usuarios WHERE sexo = 'Femenino')";
    $resultTotalFemenino = $connection->query($sqlTotalFemenino);

    $sqlTotalInscrito = "SELECT COUNT(*) AS total FROM Inscripciones WHERE activo = 1";
    $resultTotalInscrito = $connection->query($sqlTotalInscrito);

    if (
        $resultTotalFemenino && $resultTotalInscrito &&
        $resultTotalFemenino->num_rows > 0 && $resultTotalInscrito->num_rows > 0
    ) {
        $totalFemenino = $resultTotalFemenino->fetch_assoc()['total'];
        $totalInscrito = $resultTotalInscrito->fetch_assoc()['total'];

        // Evitar división por cero
        if ($totalInscrito > 0) {
            return round(($totalFemenino / $totalInscrito) * 100, 2);
        }
    }

    return 0;
}

// Función para obtener el porcentaje de personas con sexo masculino inscritas a eventos
function obtenerPorcentajeMasculinoInscrito()
{
    global $connection;

    $sqlTotalMasculino = "SELECT COUNT(*) AS total FROM Inscripciones WHERE activo = 1 AND IDusuario IN (SELECT IDusuario FROM Usuarios WHERE sexo = 'Masculino')";
    $resultTotalMasculino = $connection->query($sqlTotalMasculino);

    $sqlTotalInscrito = "SELECT COUNT(*) AS total FROM Inscripciones WHERE activo = 1";
    $resultTotalInscrito = $connection->query($sqlTotalInscrito);

    if (
        $resultTotalMasculino && $resultTotalInscrito &&
        $resultTotalMasculino->num_rows > 0 && $resultTotalInscrito->num_rows > 0
    ) {
        $totalMasculino = $resultTotalMasculino->fetch_assoc()['total'];
        $totalInscrito = $resultTotalInscrito->fetch_assoc()['total'];

        // Evitar división por cero
        if ($totalInscrito > 0) {
            return round(($totalMasculino / $totalInscrito) * 100, 2);
        }
    }

    return 0;
}



?>




<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard Administrador</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Dashboard Administrador</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- Estadísticas de Usuarios Registrados -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- Estadísticas de Usuarios Registrados -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>
                                        <?= $cantidadUsuariosRegistrados; ?>
                                    </h3>
                                    <p>Usuarios Registrados</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Estadísticas de Eventos Registrados -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>
                                        <?= $cantidadEventosRegistrados; ?>
                                    </h3>
                                    <p>Eventos Registrados</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-calendar"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Estadísticas de Inscripciones -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>
                                        <?= obtenerCantidadInscripciones(); ?>
                                    </h3>
                                    <p>Inscripciones</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Porcentaje de Asistencia -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>
                                        <?= obtenerPorcentajeAsistencia(); ?>%
                                    </h3>
                                    <p>Porcentaje de Asistencia</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-checkmark-circled"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Porcentaje de personas con sexo femenino inscritas a eventos -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>
                                        <?= obtenerPorcentajeFemeninoInscrito(); ?>%
                                    </h3>
                                    <p>Femenino Inscrito</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-female"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Porcentaje de personas con sexo masculino inscritas a eventos -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>
                                        <?= obtenerPorcentajeMasculinoInscrito(); ?>%
                                    </h3>
                                    <p>Masculino Inscrito</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-male"></i>
                                </div>
                            </div>
                        </div>


                        <!-- Otras estadísticas o contenido aquí... -->

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Evolución Mensual de Usuarios Registrados</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="evolucionUsuariosMensualChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <script>
                            // Obtén los datos para el gráfico de evolución mensual
                            <?php
                            $datosEvolucionUsuariosMensual = obtenerDatosEvolucionUsuariosMensual();
                            $labelsEvolucionUsuariosMensual = obtenerLabelsEvolucionUsuariosMensual();
                            ?>

                            // Inicializa el gráfico de evolución mensual de usuarios
                            var evolucionUsuariosMensualChart = new Chart(document.getElementById('evolucionUsuariosMensualChart'), {
                                type: 'bar',
                                data: {
                                    labels: <?= json_encode($labelsEvolucionUsuariosMensual); ?>,
                                    datasets: [{
                                        label: 'Usuarios Registrados',
                                        data: <?= json_encode($datosEvolucionUsuariosMensual); ?>,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Mes'
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Usuarios Registrados'
                                            }
                                        }
                                    }
                                }
                            });
                        </script>

                    </div><!-- /.container-fluid -->
                </div>


                <!-- Content Header (Page header) -->