<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "(SELECT P_NOMBRE, P_CODIGO, P_PRECIO_COMPRA_PONDERADO, P_ULTIMO_COSTO  FROM Productos.PRODUCTO WHERE ((P_NOMBRE LIKE '%".$search."%') OR (P_CODIGO_BARRAS = '%".$search."%') OR (P_CODIGO = '%".$search."%')) AND P_ESTADO = 1
) LIMIT 100");
      while ($row_services = mysqli_fetch_array($query_services)) {
      	
      	
      		$Nombre = $row_services["P_NOMBRE"];
      	

          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'" dataCosto="'.$row_services['P_ULTIMO_COSTO'].'" dataCant="'.$row_services['Cantidad'].'" dataTipo="'.$row_services['Tipo'].'" id="'.$row_services['P_CODIGO'].'">'.$Nombre.'</a></h5>'; 
      }
?>