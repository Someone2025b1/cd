<?php
      include("../../../../../Script/conex.php");
      include("../../../../../Script/seguridad.php");
      include("../../../../../Script/funciones.php");
      $id_user = $_SESSION["iduser"];
      $id_depto = $_SESSION["id_departamento"];

      $Codigo = $_POST['Codigo'];

      $sql = mysqli_query($db, "UPDATE Eventos.EVENTO SET EV_CANCELADO = 1 WHERE EV_CODIGO = '$Codigo' ");

      

      
?>