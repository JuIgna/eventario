

 <?php


// if ($_SERVER["REQUEST_METHOD"] == "POST") { --------------------- CODIGO ACTUALMENTE SIN USO ---------------------
//                 // Obtener los valores del formulario
//                 $nombreEvento = $_POST["nombre-evento"];
//                 $fechaEvento = $_POST["fecha-evento"];
//                 $lugarEvento = $_POST["lugar-evento"];
//                 $imagenEvento = $_FILES["imagen-evento"]["name"];
//                 $imagenEventoTmp = $_FILES["imagen-evento"]["tmp_name"];
//                 $descripcionEvento = $_POST["descripcion-evento"];
//                 $horaEvento = $_POST ["hora-evento"];


//                 // Mover la imagen cargada al directorio deseado
//                 $destination = "images/" . $imagenEvento;
//                 move_uploaded_file($imagenEventoTmp, $destination);
      
//                 // Insertar el evento en la base de datos
//                 $query = "INSERT INTO eventos (evento, fecha, lugar, imagen, descripcion, hora) VALUES ('$nombreEvento', '$fechaEvento', '$lugarEvento', '$destination','$descripcionEvento','$horaEvento')";
//                 if ($connection->query($query) === true) {
//                   echo "Evento agregado correctamente.";
//                   header("Location: listaEventos.php");
//                   exit;
//                 } else {
//                   echo "Error al agregar el evento: " . $connection->error;
//                 }
//               }
            
?> 