<?php
    include("../../../../../Script/seguridad.php");
    include("../../../../../Script/conex.php");
    include("../../../../../Script/funciones.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "(SELECT PRODUCTO.*, '0' as Cantidad, '0' as Tipo FROM Productos.PRODUCTO, Productos.RECETA WHERE PRODUCTO.R_CODIGO=RECETA.R_CODIGO AND ((PRODUCTO.P_NOMBRE LIKE '%".$search."%') OR (PRODUCTO.P_CODIGO_BARRAS = '%".$search."%') OR (PRODUCTO.P_CODIGO = '%".$search."%')) AND PRODUCTO.P_ESTADO = 1 AND PRODUCTO.P_TERRAZAS = 1 AND RECETA.R_TERRAZAS = 1
) UNION ALL
SELECT PRODUCTO.*, '0' as Cantidad, '0' as Tipo FROM Productos.PRODUCTO WHERE ((PRODUCTO.P_NOMBRE LIKE '%".$search."%') OR (PRODUCTO.P_CODIGO_BARRAS = '%".$search."%') OR (PRODUCTO.P_CODIGO = '%".$search."%')) AND PRODUCTO.P_ESTADO = 1 AND PRODUCTO.P_TERRAZAS = 1 AND PRODUCTO.R_CODIGO IS NULL
 LIMIT 100");

      while ($row_services = mysqli_fetch_array($query_services)) {
      	
      	
      		$Nombre = $row_services["P_NOMBRE"];
      	

          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'"  id="'.$row_services['P_CODIGO'].'">'.$Nombre.' </a></h5>'; 
      }
?>