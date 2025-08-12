<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];


      
      $query_services = mysqli_query($db, "SELECT * FROM Taquilla.DETALLE_ASIGNACION_VALE WHERE DAV_VALE = '".$search."' AND DAV_ESTADO=1 AND DAV_FECHA_BAJA IS NULL");
      while ($row_services = mysqli_fetch_array($query_services)) {

        $CodHotel =$row_services['H_CODIGO'];

        $sqlRet = mysqli_query($db,"SELECT A.H_NOMBRE 
        FROM Taquilla.HOTEL AS A     
        WHERE A.H_CODIGO = ".$CodHotel); 
        $rowret=mysqli_fetch_array($sqlRet);

        $NombreHotel=$rowret["H_NOMBRE"];

          $Retorno .= '<h5 class="text-ultra-bold"> Vale #'.$row_services['DAV_VALE'].'</h5>';
          $Retorno .= '<h5 class="text-ultra-bold"> Perteneciente a '.$NombreHotel.'</h5>';
      }

      

      

      echo $Retorno;
?>