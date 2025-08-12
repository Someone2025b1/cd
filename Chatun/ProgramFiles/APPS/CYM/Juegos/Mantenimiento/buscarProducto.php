<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT * FROM Bodega.PRODUCTO WHERE (P_NOMBRE LIKE '%" . $search . "%') AND CP_CODIGO = 'JG' ORDER BY P_NOMBRE LIMIT 100");
      while ($row_services = mysqli_fetch_array($query_services)) {
          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'" dataPrecio="'.$row_services['P_PRECIO'].'"  id="'.$row_services['P_CODIGO'].'">'.$row_services['P_NOMBRE'].'</a></h5>';
      }
?>