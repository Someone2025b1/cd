<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT * FROM Bodega.RECETA_SUBRECETA WHERE (RS_NOMBRE LIKE '%" . $search . "%') AND RS_BODEGA = 'HS' AND RS_TIPO = 1 ORDER BY RS_NOMBRE LIMIT 100");
      while ($row_services = mysqli_fetch_array($query_services)) {
          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['RS_NOMBRE'].'" dataPrecio="'.$row_services['RS_PRECIO'].'" dataSabor="'.$row_services['RS_CANTIDAD_BOLAS'].'" dataYogurt="'.$row_services['P_YOGURT'].'" dataFruta="'.$row_services['P_FRUTA'].'" id="'.$row_services['RS_CODIGO'].'">'.$row_services['RS_NOMBRE'].'</a></h5>';
      }
?>