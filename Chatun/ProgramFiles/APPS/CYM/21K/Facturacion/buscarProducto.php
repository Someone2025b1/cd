<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT a.P_PRECIO  FROM Bodega.PRODUCTO a WHERE a.P_CODIGO = $search ");
      $row_services = mysqli_fetch_array($query_services);
          echo $row_services['P_PRECIO'];
      
?>