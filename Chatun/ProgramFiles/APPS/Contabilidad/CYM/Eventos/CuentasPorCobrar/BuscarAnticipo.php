<?php
      include("../../../../../Script/conex.php");
      include("../../../../../Script/seguridad.php");
      include("../../../../../Script/funciones.php");

      $search = $_POST['service'];
      $id_user = $_SESSION["iduser"];

      $query_services = mysqli_query($db, "SELECT * FROM Contabilidad.ANTICIPO_EVENTOS WHERE (AE_NOMBRE_CLIENTE LIKE '%" . $search . "%') AND AE_ESTADO=0 AND AE_USER = $id_user ORDER BY AE_NOMBRE_CLIENTE");
      while ($row_services = mysqli_fetch_array($query_services)) {
          $Retorno .= '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" dataNombre="'.$row_services['AE_NOMBRE_CLIENTE'].'" dataMonto="'.$row_services['AE_MONTO'].'" idA="'.$row_services['AE_CODIGO'].'">'.$row_services['AE_NOMBRE_CLIENTE'].' Monto Q.'.$row_services['AE_MONTO'].'</a></h5>';
      }

      echo $Retorno;
?>