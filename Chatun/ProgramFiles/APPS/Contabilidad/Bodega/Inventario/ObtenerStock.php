<?php
      include("../../../../../Script/conex.php");

      $IDProducto = $_POST['IDProducto'];
      $Total = 0;
      $query_services = mysqli_query($db, "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO) AS CARGOS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_PRODUCTO) AS ABONOS
      								FROM Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION
      								WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
                                                      AND TRANSACCION.B_CODIGO = 4 
                                                      AND TRANSACCION_DETALLE.P_CODIGO = ".$IDProducto);
      while ($row_services = mysqli_fetch_array($query_services)) {
          $Total = $row_services["CARGOS"] - $row_services["ABONOS"];
      }

      echo $Total;
?>