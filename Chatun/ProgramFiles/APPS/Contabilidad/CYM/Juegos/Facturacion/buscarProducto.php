<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT * FROM Bodega.PRODUCTO WHERE (P_NOMBRE LIKE '%" . $search . "%') AND CP_CODIGO = 'JG' ORDER BY P_NOMBRE LIMIT 100");

      while ($row_services = mysqli_fetch_array($query_services)) {

      	$Conteo = mysqli_num_rows(mysqli_query($db, "SELECT Precio FROM Bodega.ESCALA_PRODUCTO WHERE P_CODIGO = $row_services[P_CODIGO] and Estado = 1 "));
      	if ($Conteo>0) 
      	{
      		$Detalle = mysqli_fetch_array(mysqli_query($db, "SELECT Precio FROM Bodega.ESCALA_PRODUCTO WHERE P_CODIGO = $row_services[P_CODIGO] and Estado = 1 "));
      		$Precio = $Detalle["Precio"];
      	}
      	else
      	{
      		$Precio = $row_services['P_PRECIO'];
      	}
        echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'" dataPrecio="'.$Precio.'"  id="'.$row_services['P_CODIGO'].'">'.$row_services['P_NOMBRE'].'</a></h5>';
      }

      $query_services1 = mysqli_query($db, "SELECT * FROM Bodega.COMBO WHERE (C_Nombre LIKE '%" . $search . "%') AND C_Estado = '1' ORDER BY C_Nombre LIMIT 100");
      while ($row_services1 = mysqli_fetch_array($query_services1)) {
          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services1['C_Nombre'].'" dataPrecio="'.$row_services1['C_Precio'].'"  id="'.$row_services1['C_Id'].'">'.$row_services1['C_Nombre'].'</a></h5>';
      }
?>