<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT PRODUCTO.* FROM Productos.PRODUCTO, Productos.RECETA WHERE PRODUCTO.R_CODIGO=RECETA.R_CODIGO AND ((PRODUCTO.P_NOMBRE LIKE '%".$search."%') OR (PRODUCTO.P_CODIGO_BARRAS = '%".$search."%') OR (PRODUCTO.P_CODIGO = '%".$search."%')) AND PRODUCTO.P_ESTADO = 1 AND RECETA.R_EVENTO = 1
      UNION ALL
      SELECT PRODUCTO.* FROM Productos.PRODUCTO, Productos.RECETA WHERE PRODUCTO.R_CODIGO=RECETA.R_CODIGO AND ((PRODUCTO.P_NOMBRE LIKE '%".$search."%') OR (PRODUCTO.P_CODIGO_BARRAS = '%".$search."%') OR (PRODUCTO.P_CODIGO = '%".$search."%')) AND PRODUCTO.P_ESTADO = 1 AND PRODUCTO.P_HELADOS = 1  
      UNION ALL 
      SELECT PRODUCTO.* FROM Productos.PRODUCTO, Productos.RECETA WHERE PRODUCTO.R_CODIGO=RECETA.R_CODIGO AND ((PRODUCTO.P_NOMBRE LIKE '%".$search."%') OR (PRODUCTO.P_CODIGO_BARRAS = '%".$search."%') OR (PRODUCTO.P_CODIGO = '%".$search."%')) AND PRODUCTO.P_ESTADO = 1 AND PRODUCTO.P_TERRAZAS = 1 AND RECETA.R_TERRAZAS = 1
      UNION ALL
      SELECT PRODUCTO.* FROM Productos.PRODUCTO, Productos.RECETA WHERE PRODUCTO.R_CODIGO=RECETA.R_CODIGO AND ((PRODUCTO.P_NOMBRE LIKE '%".$search."%') OR (PRODUCTO.P_CODIGO_BARRAS = '%".$search."%') OR (PRODUCTO.P_CODIGO = '%".$search."%')) AND PRODUCTO.P_ESTADO = 1 AND PRODUCTO.P_CAFE = 1 AND RECETA.R_CAFE = 1 
      UNION ALL
      SELECT PRODUCTO.* FROM Productos.PRODUCTO WHERE ((PRODUCTO.P_NOMBRE LIKE '%".$search."%') OR (PRODUCTO.P_CODIGO_BARRAS = '%".$search."%') OR (PRODUCTO.P_CODIGO = '%".$search."%')) AND PRODUCTO.P_ESTADO = 1 AND (PRODUCTO.P_TERRAZAS = 1 OR PRODUCTO.P_SOUVENIRS = 1) AND PRODUCTO.R_CODIGO IS NULL
 LIMIT 100");
      while ($row_services = mysqli_fetch_array($query_services)) {
          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'" dataPrecio="'.$row_services['P_PRECIO_VENTA'].'" dataSabor="'.$row_services['P_BOLA'].'" dataYogurt="'.$row_services['P_YOGURT'].'" dataFruta="'.$row_services['P_FRUTA'].'" id="'.$row_services['P_CODIGO'].'">'.$row_services['P_NOMBRE'].'</a></h5>';
      }
?>