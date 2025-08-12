<?php
      include("../../../../../Script/conex.php");

      $Codigo = $_POST['Codigo'];
      $Factura = $_POST['Factura'];
      $Proveedor = $_POST['Proveedor'];

      $sql = mysqli_query($db, "UPDATE Contabilidad.REQUISICION SET R_FACTURA_COMPRA = '".$Factura."', R_PROVEEDOR = '".$Proveedor."' WHERE R_CODIGO = '".$Codigo."'") or die(mysqli_error());


      
?>