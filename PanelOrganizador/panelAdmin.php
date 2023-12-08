<?php 

include "panelAdminLogica.php"; 
include "assets/modulos/head.php";
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