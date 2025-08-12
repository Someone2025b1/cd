<?php
      include("../../../../../Script/conex.php");

      $Motivo = $_POST['Motivo'];
      $Codigo = $_POST['Codigo'];

      $sql = mysqli_query($db, "UPDATE Contabilidad.REQUISICION SET RE_CODIGO = 4, R_MOTIVO_CANCELACION = '".$Motivo."' WHERE R_CODIGO = '".$Codigo."' ");


      
?>