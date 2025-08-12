<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "(SELECT P_NOMBRE, P_CODIGO, P_PRECIO, '0' as Cantidad, '0' as Tipo  FROM Bodega.PRODUCTO WHERE ((P_NOMBRE LIKE '%".$search."%') OR (P_CODIGO_BARRAS = '%".$search."%')) AND CP_CODIGO = 'SV' AND P_ESTADO = 1
UNION ALL
SELECT P_NOMBRE, P_CODIGO, P_PRECIO, '0' as Cantidad, '1' as Tipo FROM Bodega.PRODUCTO WHERE P_NOMBRE LIKE '%".$search."%' AND CP_CODIGO = 'JG' 
UNION ALL 
SELECT C_Nombre, C_Id, C_Precio, '0' as Cantidad, '2' as Tipo FROM Bodega.COMBO WHERE C_Estado = 2 AND C_Nombre LIKE '%".$search."%'
UNION ALL 
SELECT b.P_NOMBRE, a.IdEscala, a.Precio, a.Cantidad as Cantidad, '3' as Tipo FROM Bodega.ESCALA_PRODUCTO a
		INNER JOIN Bodega.PRODUCTO  b ON a.P_CODIGO = b.P_CODIGO
		WHERE Estado = 1 AND P_NOMBRE LIKE '%".$search."%'
) LIMIT 100");
      while ($row_services = mysqli_fetch_array($query_services)) {
      	
      	if ($row_services['Tipo']==3) 
      	{
      		$Nombre = $row_services["Cantidad"]." * ".$row_services["P_PRECIO"]." ".$row_services["P_NOMBRE"];
      	}
      	else
      	{
      		$Nombre = $row_services["P_NOMBRE"];
      	}

          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'" dataPrecio="'.$row_services['P_PRECIO'].'" dataCant="'.$row_services['Cantidad'].'" dataTipo="'.$row_services['Tipo'].'" id="'.$row_services['P_CODIGO'].'">'.$Nombre.'</a></h5>'; 
      }
?>