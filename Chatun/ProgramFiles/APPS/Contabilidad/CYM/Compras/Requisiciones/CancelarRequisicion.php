<?php
      include("../../../../../Script/conex.php");

      $Codigo = $_POST['Codigo'];

      $query_services = mysqli_query($db, "UPDATE CompraVenta.REQUISICION SET R_ESTADO = 11 WHERE R_CODIGO = '".$Codigo."'");

     
     
?>