<?php 

include "panelAdminLogica.php"; 
include "assets/modulos/head.php";


if (isset($_SESSION['success_message'])) {
  echo '<div id="successMessage" class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><i class="icon fas fa-check"></i> Éxito</h5>
          ' . $_SESSION['success_message'] . '
        </div>';

  // Limpiar el mensaje de éxito después de mostrarlo
  unset($_SESSION['success_message']);
}
?>


<!--
Archivo plantilla base, compartida para mostrar el sidebar, navbar.
En la parte central esta lo dinamico que cambiara con cada funcionalidad.
-->


  <div class="wrapper">

    <!-- Navbar -->
    <?php include "assets/modulos/navbar.php" ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include "assets/modulos/aside.php" ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <?php include "dashboard.php" ?>

    </div>


    <!-- /.content-wrapper -->



    <!-- Main Footer -->
    <?php include "assets/modulos/footer.php" ?>
    <!-- ./wrapper -->



  </div>


</body>



</html>