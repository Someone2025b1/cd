<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT * FROM Bodega.PRODUCTO WHERE (P_NOMBRE LIKE '%" . $search . "%') AND CP_CODIGO = 'TQ' ORDER BY P_CODIGO LIMIT 100");
      while ($row_services = mysqli_fetch_array($query_services)) {
          $Retorno .= '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'" dataPrecio="'.$row_services['P_PRECIO'].'" id="'.$row_services['P_CODIGO'].'" dataTipoProducto="1">'.$row_services['P_NOMBRE'].'</a></h5>';
      }

      $query_recetas = mysqli_query($db, "SELECT * FROM Bodega.RECETA_SUBRECETA WHERE RS_NOMBRE LIKE '%" . $search . "%' AND RS_BODEGA = 'TR' AND RS_TIPO = 1 ORDER BY RS_NOMBRE LIMIT 100");
      while ($row_recetas = mysqli_fetch_array($query_recetas)) {
          $Retorno .= '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_recetas['RS_NOMBRE'].'" dataPrecio="'.$row_recetas['RS_PRECIO'].'" id="'.$row_recetas['RS_CODIGO'].'" dataTipoProducto="2">'.$row_recetas['RS_NOMBRE'].'</a></h5>';
      }

      echo $Retorno;
?>