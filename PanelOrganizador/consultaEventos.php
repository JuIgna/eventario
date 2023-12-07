<?php
session_start();
?>



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
?>


<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Consultar Eventos Creados</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Consultar Eventos Creados</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <!-- PHP code to fetch and display events -->
        <?php
        // Incluye la conexión a la base de datos y verifica la sesión del administrador

        // Consulta para obtener la información de los eventos
        $query = "SELECT IDeventos, evento, fecha, hora, duracion, imagen FROM eventos";
        $result = $connection->query($query);

        // Verifica si hay eventos disponibles
        if ($result && $result->num_rows > 0) {
            echo "<div class='row'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4'>";
                echo "<div class='card'>";
                echo "<img src='{$row['imagen']}' class='card-img-top' alt='Event Image'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>{$row['evento']}</h5>";
                echo "<p class='card-text'>Fecha: {$row['fecha']}</p>";
                echo "<p class='card-text'>Hora: {$row['hora']}</p>";
                echo "<p class='card-text'>Duración: {$row['duracion']}</p>";
                // Agrega el botón "Ver Detalle" con el ID del evento
                echo "<a href='detalleEvento.php?ID={$row['IDeventos']}' class='btn btn-primary'>Ver Detalle</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No hay eventos disponibles.</p>";
        }
        ?>
        <!-- End PHP code -->

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

