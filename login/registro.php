<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro - Eventario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
    <link rel="shortcut icon" href="../logo.png" type="image/x-icon">
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
                $sexo = isset($_POST['sexo']) ? implode(", ", $_POST['sexo']) : "";

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
                        $sql = "INSERT INTO usuarios (nombre, apellido, email, celular, contrasena, sexo, fechaAlta) VALUES (?, ?, ?, ?, ?, ?, NOW())";

                        // Preparar la declaración SQL con una sentencia preparada
                        $stmt = $conn->prepare($sql);

                        // Verificar si ocurrió un error al preparar la sentencia
                        if (!$stmt) {
                            die("Error al preparar la consulta: " . $conn->error);
                        }

                        // Vincular los parámetros a la sentencia preparada
                        $stmt->bind_param("ssssss", $nombre, $apellido, $email, $celular, $password, $sexo);

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

                    <br><br><br>


                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="row g-3">
                    <h2 class="title-eventos">Registro</h2>
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="celular" class="form-label">Celular:</label>
                        <input type="tel" id="celular" name="celular" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="sexo" class="form-label">Sexo:</label>
                        <div class="form-check">
                            <input type="checkbox" id="masculino" name="sexo[]" value="masculino" class="form-check-input">
                            <label for="masculino" class="form-check-label">Masculino</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="femenino" name="sexo[]" value="femenino" class="form-check-input">
                            <label for="femenino" class="form-check-label">Femenino</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Registrarse</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>