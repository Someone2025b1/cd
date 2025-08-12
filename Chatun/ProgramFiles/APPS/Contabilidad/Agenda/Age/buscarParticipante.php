<?php
    include("../../../../../Script/seguridad.php");
    include("../../../../../Script/conex.php");
    include("../../../../../Script/funciones.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "(SELECT usuarios.* FROM info_bbdd.usuarios WHERE ((usuarios.nombre LIKE '%".$search."%') OR (usuarios.nombre = '%".$search."%') OR (usuarios.nombre= '%".$search."%')) AND usuarios.estado = 1
)");

      while ($row_services = mysqli_fetch_array($query_services)) {
      	
      	
      		$Nombre = $row_services["nombre"];
      	

          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['nombre'].'"  id="'.$row_services['id_user'].'">'.$Nombre.' </a></h5>'; 
      }
?>