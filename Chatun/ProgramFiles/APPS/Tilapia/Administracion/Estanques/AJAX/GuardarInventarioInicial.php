<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$CapacidadEstanque = $_POST['Capacidad'];
$Observaciones = $_POST["Observaciones"];  
$Metros = $_POST["Metros"];
$SQL_INSERT = mysqli_query($db, "UPDATE SET InventarioInicial =  Pisicultura.Estanque  WHERE ");

if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	