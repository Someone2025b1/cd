<?php
      include("../../../../../Script/conex.php");
      include("../../../../../Script/seguridad.php");
      include("../../../../../Script/funciones.php");
      $id_user = $_SESSION["iduser"];
      $id_depto = $_SESSION["id_departamento"];

      $Motivo = $_POST['Motivo'];
      $Codigo = $_POST['Codigo'];
      $Numero = $_POST['NumeroR'];

      $sql = mysqli_query($db, "UPDATE CompraVenta.REQUISICION_DETALLE SET RD_ESTADO = 11, R_CANCELADA = '$Motivo' WHERE RD_CODIGO = '$Codigo' ");

      
      $QueryDetalle = mysqli_query($db, "INSERT INTO CompraVenta.SEGUIMIENTO_REQUICISION(R_CODIGO, RD_CODIGO, RD_ESTADO, SR_DESCRIPCIÓN, SR_FECHA, SR_HORA, U_CODIGO)
      VALUES('".$Numero."', '".$Codigo."', 11, 'Se Cancelo el Producto por: ".$Motivo."', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$id_user."')");


      
?>