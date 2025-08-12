<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

     if(!$search){
      
      $query_services = mysqli_query($db, "SELECT a.PC_MES  FROM Contabilidad.PERIODO_CONTABLE a WHERE a.EPC_CODIGO = 1 ");
      $row = mysqli_fetch_array($query_services);
      
      echo $row['PC_MES'];

     }else{
      $query_services = mysqli_query($db, "SELECT a.PC_MES  FROM Contabilidad.PERIODO_CONTABLE a WHERE a.PC_CODIGO = $search ");
      $row = mysqli_fetch_array($query_services);
      
      echo $row['PC_MES'];
     }

?>