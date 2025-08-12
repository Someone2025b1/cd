<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$IdEscala = $_POST["IdEscala"];  

$sql = mysqli_query($db, "UPDATE Bodega.ESCALA_PRODUCTO SET Estado = 2  where IdEscala = $IdEscala");

if($sql)
{
	echo "1";
} 
?>
