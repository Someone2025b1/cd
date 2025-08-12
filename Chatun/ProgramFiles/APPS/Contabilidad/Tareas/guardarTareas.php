<?php
include ("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
$id_user = $_SESSION["iduser"];

    if(isset($_POST['tarea'])){
    
$tarea = $_POST['tarea'];
$tipo = $_POST['Tipo_tarea'];
$Usuario = $_POST['usuario'];


     for ($i=0; $i < count($tarea); $i++) { 
    
     $query = "INSERT INTO tareas.tareas_mes(Tarea, Tipo_tarea, Usuario) VALUES
    
     ('$tarea[$i]','$tipo[$i]', $id_user)";
     $result = mysqli_query ($db, $query);
    
    }
    
}

 if ($result){ 
   echo "1";
  
}
?>
