<?php
      include("../../../../../Script/conex.php");
      include("../../../../../Script/seguridad.php");
      include("../../../../../Script/funciones.php");
      $id_user = $_SESSION["iduser"];
      $id_depto = $_SESSION["id_departamento"];

      $Codigo = $_POST['Codigo'];

      $sql = mysqli_query($db, "UPDATE Contabilidad.ACTIVO_FIJO SET AF_VALOR_ACTUAL = 1, AF_DEPRECIO = $id_user WHERE AF_CODIGO = '$Codigo' ");

      

      
?>