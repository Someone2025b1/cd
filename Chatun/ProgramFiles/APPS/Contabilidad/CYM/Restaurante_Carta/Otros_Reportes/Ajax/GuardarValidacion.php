<?php 
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$login=$_POST["User"]; 
$Codigo = $_POST["Codigo"];
$id_user = $_SESSION["iduser"];
$sql = mysqli_query($db,"UPDATE Bodega.CIERRE_DETALLE set ACC_USUARIO_CONTABILIZA = $login
	WHERE ACC_CODIGO = '$Codigo' and CD_USUARIO = $id_user") or die (mysqli_error());
if ($sql) 
{
	echo "1";
}

  
?>