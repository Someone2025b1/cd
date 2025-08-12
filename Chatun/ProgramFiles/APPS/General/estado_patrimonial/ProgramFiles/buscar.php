<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT cifcodcliente, cifnombreclie FROM bankworks.cif_generales WHERE MATCH (cifnombreclie) AGAINST ('".$search."') LIMIT 50");
      while ($row_services = mysqli_fetch_array($query_services)) {
          echo '<a class="suggest-element" data="'.$row_services['cifnombreclie'].'" id="'.$row_services['cifcodcliente'].'">'.utf8_encode($row_services['cifnombreclie']." (".$row_services['cifcodcliente'].")").'</a><br>';
      }
?>