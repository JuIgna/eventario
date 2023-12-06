<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Eventario</span>
    </a>



    <!-- Sidebar -->
    <div class="sidebar">
        
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                    <a style="cursor: pointer;" class="nav-link active" onclick="cargarContenido('dashboard.php', 'content-wrapper')">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard   
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Eventos
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a style="cursor: pointer;" class="nav-link" onclick="cargarContenido('agregarEvento.php','content-wrapper')" >
                                <i class="far fa-circle nav-icon"></i>
                                <p>Agregar Evento </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a style="cursor: pointer;" class="nav-link" onclick="cargarContenido('consultaEventos.php','content-wrapper')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Consultar Eventos </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ver Calendario</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="cerrarSesion.php" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Cerrar Sesion
                        </p>
                    </a>
                </li>

                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

</aside>

<script>
    $(".nav-link").on('click', function(){
        $(".nav-link").removeClass ('active');
        $(this).addClass ('active');

    })
</script>