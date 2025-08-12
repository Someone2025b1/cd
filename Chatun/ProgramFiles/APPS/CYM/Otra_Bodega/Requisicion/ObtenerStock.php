<?php
      include("../../../../../Script/conex.php");

      $IDProducto = $_POST['IDProducto'];
      $Bodega = $_POST['Bodega'];
      $Total = 0;
      $query_services = mysqli_query($db, "SELECT SUM(TRAD_CARGO_PRODUCTO) AS CARGOS, SUM(TRAD_ABONO_PRODUCTO) AS ABONOS
      								FROM Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION
      								WHERE TRANSACCION_DETALLE.P_CODIGO = ".$IDProducto."
                                                      AND TRANSACCION.B_CODIGO = ".$Bodega);
      while ($row_services = mysqli_fetch_array($query_services)) {
          $Total = $row_services["CARGOS"] - $row_services["ABONOS"];
      }

      echo $Total;
?>