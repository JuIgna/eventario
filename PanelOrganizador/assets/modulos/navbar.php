<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a style="cursor: pointer;" class="nav-link active"
                onclick="cargarContenido('dashboard.php', 'content-wrapper')">
                Dashboard Principal</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a style="cursor: pointer;" class="nav-link active"
                onclick="cargarContenido('agregarEvento.php', 'content-wrapper')">
                Agregar Evento</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a style="cursor: pointer;" class="nav-link active"
                onclick="cargarContenido('consultaEventos.php', 'content-wrapper')">

            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="cerrarSesion.php" class="nav-link">Cerrar Sesion</a>
        </li>
    </ul>

    <!-- Right navbar links -->

</nav>