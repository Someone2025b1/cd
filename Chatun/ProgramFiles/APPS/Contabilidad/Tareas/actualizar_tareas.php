<?php 
include ("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
if (isset($_POST['Id'])){


$id = $_POST['Id'];
$estado = $_POST['estado'];

if ($estado == 0) {
    $estado = 1;
} else {
    $estado = 0;
}


$query = "UPDATE tareas.editar_tareas set ESTATUS = '$estado' WHERE Id_edition = '$id' ";
$resultado = mysqli_query($db, $query);
}
?>





