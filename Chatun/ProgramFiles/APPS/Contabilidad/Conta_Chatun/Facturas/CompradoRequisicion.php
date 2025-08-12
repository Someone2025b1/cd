<?php
      include("../../../../../Script/conex.php");

      $Codigo = $_POST['Codigo'];

      $sql = mysqli_query($db, "UPDATE Contabilidad.REQUISICION SET RE_CODIGO = 3 WHERE R_CODIGO = '".$Codigo."'") or die(mysqli_error());


      
?>