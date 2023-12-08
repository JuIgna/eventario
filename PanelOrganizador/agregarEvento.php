<?php include "panelAdminLogica.php"; ?>


<?php if (isset($_GET['evento_agregado']) && $_GET['evento_agregado'] == 'true'): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Éxito</h5>
        El evento se agregó correctamente.
    </div>
<?php endif; ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Agregar Evento</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Complete el formulario para agregar un evento</h3>
                    </div>
                    <form role="form" method="post" action="procesarAgregarEvento.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Columna izquierda -->
                                    <div class="form-group">
                                        <label for="nombreEvento">Nombre del Evento</label>
                                        <input type="text" class="form-control" id="nombreEvento" name="nombreEvento"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="fechaEvento">Fecha del Evento</label>
                                        <input type="date" class="form-control" id="fechaEvento" name="fechaEvento"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lugarEvento">Lugar del Evento</label>
                                        <input type="text" class="form-control" id="lugarEvento" name="lugarEvento"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcionEvento">Descripcion del Evento</label>
                                        <input type="text" class="form-control" id="descripcionEvento"
                                            name="descripcionEvento" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="organizadorEvento">Organizador del Evento</label>
                                        <input type="text" class="form-control" id="organizadorEvento"
                                            name="organizadorEvento" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Columna derecha -->
                                    <div class="form-group">
                                        <label for="horaInicio">Hora de inicio</label>
                                        <input type="time" class="form-control" id="horaInicio" name="horaInicio"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="horaFin">Hora finalización del evento</label>
                                        <input type="time" class="form-control" id="horaFin" name="horaFin" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="duracionEvento">Duracion estimada del evento</label>
                                        <input type="time" class="form-control" id="duracionEvento"
                                            name="duracionEvento" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="limiteInscriptos">Limite de Inscripciones</label>
                                        <input type="number" class="form-control" id="limiteInscriptos"
                                            name="limiteInscriptos" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="costoEvento">Costo en pesos del evento</label>
                                        <input type="number" class="form-control" id="costoEvento" name="costoEvento"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="categoriaEvento">Categoría del Evento</label>
                                        <select class="form-control" id="categoriaEvento" name="categoriaEvento"
                                            required>
                                            <!-- Opciones de categorías cargadas desde la base de datos -->
                                            <?php
                                            // Realiza una consulta para obtener las categorías
                                            $queryCategorias = "SELECT * FROM categoriaevento";
                                            $resultCategorias = $connection->query($queryCategorias);

                                            // Muestra las opciones en el formulario
                                            while ($rowCategoria = $resultCategorias->fetch_assoc()) {
                                                echo "<option value='" . $rowCategoria['IDcategoria'] . "'>" . $rowCategoria['nombrecategoria'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="imagenEvento">Seleccionar imagen del evento</label>
                                        <input type="file" class="form-control" id="imagenEvento" name="imagenEvento"
                                            accept="image/*" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Otros campos del formulario aquí -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Agregar Evento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

