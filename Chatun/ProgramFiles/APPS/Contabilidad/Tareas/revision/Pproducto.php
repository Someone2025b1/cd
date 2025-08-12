<?php include('conexion.php') ?>

<?php 
  

  $search = $_POST['service'];

 

  $query_services = mysqli_query($conn, "SELECT PRECIO  FROM productos WHERE idProducto = $search ");
  $row_services = mysqli_fetch_array($query_services);
      echo $row_services['PRECIO'];
  
?>
  