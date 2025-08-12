<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $Sel = mysqli_query($db, "SELECT * FROM Contabilidad.TRANSACCION a WHERE a.TRA_FECHA_TRANS = '2021-09-05' AND a.TRA_CORRELATIVO <> 731 AND a.TT_CODIGO <> 2  
ORDER BY a.TRA_HORA ASC");
      while ($Row = mysqli_fetch_array($Sel)) 
      {
            $Sel1 = mysqli_fetch_array(mysqli_query($db, "SELECT a.TRA_CODIGO, a.TRA_CORRELATIVO FROM Contabilidad.TRANSACCION a WHERE a.TRA_FECHA_TRANS = '2021-09-05' AND a.TRA_HORA < '$Row[TRA_HORA]' AND a.TT_CODIGO <> 2 order by a.TRA_HORA desc "));
            $query_services = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION a SET  a.TRA_CORRELATIVO = $Sel1[TRA_CORRELATIVO] + 1
            WHERE a.TRA_CODIGO = '$Row[TRA_CODIGO]'"); 
      }  
 
?>