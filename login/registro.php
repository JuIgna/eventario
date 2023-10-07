<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title>Registro - Eventario</title>
   <link rel="stylesheet" type="text/css" href="css/styles.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script>
</head>
<body>
   <header>
      <h1>Eventario</h1>
      <a href="../index.html" id="home-button">Volver al Inicio</a>
   </header>
   <main>
      <section>
         <?php
         // Variable para determinar si se debe mostrar el formulario de registro o el mensaje de éxito/error
         $showForm = true;

         // Establecer la conexión con la base de datos
         $servername = "localhost"; // Cambia esto si tu servidor MySQL está en un host diferente
         $username = "eventario_juan";
         $password_db = "juan$2023";
         $dbname = "eventario_db";

         $conn = new mysqli($servername, $username, $password_db, $dbname);

         // Verificar si hubo un error en la conexión
         if ($conn->connect_error) {
             die("Error de conexión: " . $conn->connect_error);
         }

         // Verificar si se envió el formulario
         if ($_SERVER["REQUEST_METHOD"] === "POST") {
             // Recuperar los datos enviados desde el formulario
             $nombre = $_POST['nombre'];
             $apellido = $_POST['apellido'];
             $email = $_POST['email'];
             $celular = $_POST['celular'];
             $password = $_POST['password'];

             // Validar la longitud de la contraseña
             if (strlen($password) < 8) {
                 echo "<script>
                     Swal.fire({
                         title: 'Error',
                         text: 'La contraseña debe tener al menos 8 caracteres',
                         icon: 'error',
                         confirmButtonText: 'Aceptar'
                     });
                 </script>";
             } else {
                 // Verificar si el correo electrónico ya existe en la tabla de usuarios
                 $check_query = "SELECT * FROM usuarios WHERE email = ?";
                 $stmt_check = $conn->prepare($check_query);
                 $stmt_check->bind_param("s", $email);
                 $stmt_check->execute();
                 $stmt_check->store_result();

                 if ($stmt_check->num_rows > 0) {
                     echo "<script>
                         Swal.fire({
                             title: 'Error',
                             text: 'El correo electrónico ya está registrado',
                             icon: 'error',
                             confirmButtonText: 'Aceptar'
                         });
                     </script>";
                 } else {
                     // Consulta SQL para insertar un nuevo usuario en la tabla de usuarios
                     $sql = "INSERT INTO usuarios (nombre, apellido, email, celular, contrasena) VALUES (?, ?, ?, ?, ?)";

                     // Preparar la declaración SQL con una sentencia preparada
                     $stmt = $conn->prepare($sql);

                     // Verificar si ocurrió un error al preparar la sentencia
                     if (!$stmt) {
                         die("Error al preparar la consulta: " . $conn->error);
                     }

                     // Vincular los parámetros a la sentencia preparada
                     $stmt->bind_param("sssss", $nombre, $apellido, $email, $celular, $password);

                     // Ejecutar la sentencia preparada para insertar el nuevo usuario
                     if ($stmt->execute()) {
                         $showForm = false; // Ya no mostraremos el formulario
                     } else {
                         echo "<script>
                             Swal.fire({
                                 title: 'Error',
                                 text: 'Error al registrar el usuario',
                                 icon: 'error',
                                 confirmButtonText: 'Aceptar'
                             });
                         </script>";
                     }

                     $stmt->close();
                 }

                 $stmt_check->close();
             }
         }

         $conn->close();

         // Mostrar el formulario de registro o el mensaje de éxito/error
         if ($showForm) {
         ?>
         <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h2 class="title-eventos">Registro</h2>
            <div class="form-group">
               <label for="nombre">Nombre:</label>
               <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
               <label for="apellido">Apellido:</label>
               <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
               <label for="email">Email:</label>
               <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
               <label for="celular">Celular:</label>
               <input type="tel" id="celular" name="celular" required>
            </div>
            <div class="form-group">
               <label for="password">Contraseña:</label>
               <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
               <button type="submit">Registrarse</button>
            </div>
         </form>
         <?php
         } else {
             echo "<p>Registro exitoso. Redirigiendo a la página de inicio de sesión...</p>";
             echo "<script>
                 setTimeout(function() {
                     window.location.href = 'login.php';
                 }, 2000); // Redirige después de 2 segundos
             </script>";
         }
         ?>

      </section>
   </main>
</body>
</html>
