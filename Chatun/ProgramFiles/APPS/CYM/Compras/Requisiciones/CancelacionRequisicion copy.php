<?php
      include("../../../../../Script/conex.php");

      $Motivo = $_POST['Motivo'];
      $Codigo = $_POST['Codigo'];

      $sql = mysqli_query($db, "UPDATE CompraVenta.REQUISICION SET R_ESTADO = 11, R_CANCELADA = '".$Motivo."' WHERE R_CODIGO = '".$Codigo."' ");


      
?>