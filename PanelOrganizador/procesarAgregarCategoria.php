<?php
include "panelAdminLogica.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreCategoria = $_POST["nombreCategoria"];

    // Verificar si la categoría ya existe en la base de datos
    $queryVerificar = "SELECT * FROM categoriaevento WHERE nombrecategoria = '$nombreCategoria'";
    $resultVerificar = $connection->query($queryVerificar);

    if ($resultVerificar->num_rows == 0) {
        // La categoría no existe, agregarla
        $queryAgregar = "INSERT INTO categoriaevento (nombrecategoria) VALUES ('$nombreCategoria')";
        if ($connection->query($queryAgregar) === TRUE) {
            $_SESSION['categoriaExito'] = "La categoria se añadio con exito";
            header("Location: panelAdmin.php");
            exit();
        } else {
            header("Location: panelAdmin.php");
            exit();
        }
    } else {
        // La categoría ya existe
        $_SESSION['categoriaFallo'] = "La categoria no se pudo añadir, ya existe una igual";
        header("Location: panelAdmin.php");
        exit();
    }
}
?>
