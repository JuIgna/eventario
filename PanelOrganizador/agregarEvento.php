<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Agregar Evento </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Agregar Evento </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- agregarEvento.php -->
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Agregar Nuevo Evento</h3>
                        </div>
                        <div class="card-body">
                            <form action="procesarAgregarEvento.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nombre-evento">Nombre del Evento</label>
                                    <input type="text" class="form-control" name="nombre-evento" required>

                                    <label for="nombre-evento">Nombre del Evento</label>
                                    <input type="text" class="form-control" name="nombre-evento" required>

                                    <label for="nombre-evento">Nombre del Evento</label>
                                    <input type="text" class="form-control" name="nombre-evento" required>

                                    <label for="nombre-evento">Nombre del Evento</label>
                                    <input type="text" class="form-control" name="nombre-evento" required>

                                    <label for="nombre-evento">Nombre del Evento</label>
                                    <input type="text" class="form-control" name="nombre-evento" required>

                                    <label for="nombre-evento">Nombre del Evento</label>
                                    <input type="text" class="form-control" name="nombre-evento" required>

                                    <label for="nombre-evento">Nombre del Evento</label>
                                    <input type="text" class="form-control" name="nombre-evento" required>

                                    <label for="nombre-evento">Nombre del Evento</label>
                                    <input type="text" class="form-control" name="nombre-evento" required>

                                    <label for="nombre-evento">Nombre del Evento</label>
                                    <input type="text" class="form-control" name="nombre-evento" required>
                                </div>
                                <!-- Agrega los demás campos del formulario según la estructura de tu base de datos -->

                                <div class="form-group">
                                    <label for="imagen">Imagen del Evento</label>
                                    <input type="file" class="form-control-file" name="imagen" accept="image/*"
                                        required>
                                </div>

                                <button type="submit" class="btn btn-primary">Agregar Evento</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->