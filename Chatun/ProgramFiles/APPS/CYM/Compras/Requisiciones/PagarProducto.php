<?php
      include("../../../../../Script/conex.php");
      include("../../../../../Script/seguridad.php");
      include("../../../../../Script/funciones.php");
      $id_user = $_SESSION["iduser"];
      $id_depto = $_SESSION["id_departamento"];

      $Banco = $_POST['Banco'];
      $NoBoleta = $_POST['NoBoleta'];
      $FechaPago = $_POST['FechaPago'];
      $Codigo = $_POST['Codigo'];
      $Numero = $_POST['NumeroR3'];



      $sql = mysqli_query($db, "UPDATE CompraVenta.REQUISICION_DETALLE SET RD_ESTADO = 10, RD_BANCO = '$Banco', RD_FECHA_PAGO = '$FechaPago', RD_BOLETA = '$NoBoleta' WHERE RD_CODIGO = '$Codigo' ");

      $QueryDetalle = mysqli_query($db, "INSERT INTO CompraVenta.SEGUIMIENTO_REQUICISION(R_CODIGO, RD_CODIGO, RD_ESTADO, SR_DESCRIPCIÓN, SR_FECHA, SR_HORA, U_CODIGO)
      VALUES('".$Numero."', '".$Codigo."', 10, 'Se Pago el Pedido ', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$id_user."')");

 

      
      


      
?>