<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "(SELECT P_NOMBRE, P_CODIGO, P_PRECIO_VENTA, P_EXISTENCIA_SOUVENIRS, P_LLEVA_EXISTENCIA, P_SERVICIO, '0' as Cantidad, '0' as Tipo FROM Productos.PRODUCTO WHERE ((P_NOMBRE LIKE '%".$search."%') OR (P_CODIGO_BARRAS = '%".$search."%') OR (P_CODIGO = '%".$search."%')) AND P_ESTADO = 1 AND P_SOUVENIRS = 1
) LIMIT 100");
      while ($row_services = mysqli_fetch_array($query_services)) {
      	
      	
      		$Nombre = $row_services["P_NOMBRE"];
      	

          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'" dataPrecio="'.$row_services['P_PRECIO_VENTA'].'" dataCant="'.$row_services['Cantidad'].'" dataTipo="'.$row_services['P_SERVICIO'].'" id="'.$row_services['P_CODIGO'].'" dataexistencia="'.$row_services['P_EXISTENCIA_SOUVENIRS'].'" dataInventario="'.$row_services['P_LLEVA_EXISTENCIA'].'">'.$Nombre.' </a></h5>'; 
      }
?>