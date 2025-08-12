<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT N_CODIGO, N_NOMBRE, N_TIPO FROM Contabilidad.NOMENCLATURA WHERE ((N_NOMBRE LIKE '%" . $search . "%') OR (N_CODIGO LIKE '%" . $search . "%')) AND ((N_TIPO <> 'GM') AND (N_TIPO <> 'G') AND (N_TIPO <> 'S') AND (N_TIPO <> 'SC')) ORDER BY N_CODIGO");
      while ($row_services = mysqli_fetch_array($query_services)) {
          echo '<H5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['N_NOMBRE'].'" id="'.$row_services['N_CODIGO'].'">'.$row_services['N_CODIGO']."/".$row_services['N_NOMBRE'].'</a></H5>';
      }
?>