<?php
      include ("../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "SELECT cif, primer_nombre, segundo_nombre, tercer_nombre, primer_apellido, segundo_apellido, apellido_casada FROM info_colaboradores.datos_generales WHERE MATCH (primer_nombre, segundo_nombre, tercer_nombre, primer_apellido, segundo_apellido, apellido_casada) AGAINST ('".$search."') LIMIT 10");
      while ($row_services = mysqli_fetch_array($query_services)) {
          echo '<a class="suggest-element" style="cursor: pointer" data="'.$row_services['cif'].'">'.$row_services['primer_nombre'].' '.$row_services['segundo_nombre'].' '.$row_services['tercer_nombre'].' '.$row_services['primer_apellido'].' '.$row_services['segundo_apellido'].' '.$row_services['apellido_casada'].'</a><br>';
      }
?>