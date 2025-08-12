<?php
      include("../../../../../Script/conex.php");

      $Codigo = $_POST['idRequisicion'];

      $query_services = mysqli_query($db, "UPDATE Bodega.REQUISICION SET R_ESTADO = 2 WHERE R_CODIGO = '".$Codigo."'");
     
?>