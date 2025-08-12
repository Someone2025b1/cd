<?php
      include("../../../../../Script/conex.php");
      include("../../../../../Script/seguridad.php");
      include("../../../../../Script/funciones.php");
      $id_user = $_SESSION["iduser"];
      $id_depto = $_SESSION["id_departamento"];

      $Comentario = $_POST['Comentario'];
      $Factura = $_POST['Factura'];
      $Codigo = $_POST['Codigo'];
      $Numero = $_POST['NumeroR'];


if($Factura==1){
      $sql = mysqli_query($db, "UPDATE CompraVenta.REQUISICION_DETALLE SET RD_ESTADO = 9, RD_COMENTARIO = '$Comentario' WHERE RD_CODIGO = '$Codigo' ");

      $QueryDetalle = mysqli_query($db, "INSERT INTO CompraVenta.SEGUIMIENTO_REQUICISION(R_CODIGO, RD_CODIGO, RD_ESTADO, SR_DESCRIPCIÓN, SR_FECHA, SR_HORA, U_CODIGO)
      VALUES('".$Numero."', '".$Codigo."', 9, 'El Ususario Recibio el Producto/Servicio ya Facturado', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$id_user."')");

}else{
      $sql = mysqli_query($db, "UPDATE CompraVenta.REQUISICION_DETALLE SET RD_ESTADO = 8, RD_COMENTARIO = '$Comentario' WHERE RD_CODIGO = '$Codigo' ");

      $QueryDetalle = mysqli_query($db, "INSERT INTO CompraVenta.SEGUIMIENTO_REQUICISION(R_CODIGO, RD_CODIGO, RD_ESTADO, SR_DESCRIPCIÓN, SR_FECHA, SR_HORA, U_CODIGO)
      VALUES('".$Numero."', '".$Codigo."', 8, 'El Ususario Recibio el Producto/Servicio Factura Pendiente', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$id_user."')");
}
      

      
      


      
?>