<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php"); 
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"]; 
$Fecha = $_POST["Fecha"];  
$Contador2 = mysqli_num_rows(mysqli_query($db, "SELECT  * FROM Bodega.DISTRIBUCION_PUNTOS_VENTA a WHERE a.Fecha = '$Fecha' AND a.Estado = 1")); 
echo $Contador2;
?>
        