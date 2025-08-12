<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];									

$Codigo = $_POST["Codigo"];

$Query = mysqli_query($db, "DELETE FROM Taquilla.LISTA_NEGRA WHERE LN_CODIGO = ".$Codigo);

if($Query)
{
	echo 1;
}
else
{
	echo 0;
}

?>
