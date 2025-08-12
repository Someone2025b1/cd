<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
include("../../../../../../Script/httpful.phar");

$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Id = $_POST["Id"];
$TIT = $_POST["TIT"];


$Upd = mysqli_query($db, "UPDATE Finanzas.NOMENCLATURA SET T_CODIGO = '$TIT' where N_CODIGO = '$Id'");

if ($Upd) {

	echo "1";
}
?>
 
