<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE (P_NOMBRE LIKE '%" . $search . "%') AND P_HELADOS = 1 AND P_ESTADO = 1 ORDER BY P_NOMBRE LIMIT 100");
      while ($row_services = mysqli_fetch_array($query_services)) {
          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'" dataPrecio="'.$row_services['P_PRECIO_VENTA'].'" dataSabor="'.$row_services['P_BOLA'].'" dataYogurt="'.$row_services['P_YOGURT'].'" dataFruta="'.$row_services['P_FRUTA'].'" id="'.$row_services['P_CODIGO'].'">'.$row_services['P_NOMBRE'].'</a></h5>';
      }
?>