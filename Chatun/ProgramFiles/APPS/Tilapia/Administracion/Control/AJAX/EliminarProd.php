<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Id = $_POST['Id'];   
$SQL_INSERT = mysqli_query($db, "DELETE FROM Bodega.CONTROL_PISICULTURA WHERE Id = $Id");

if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	