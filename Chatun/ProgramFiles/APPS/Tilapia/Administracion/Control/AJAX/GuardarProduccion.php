<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Fecha = $_POST['Fecha'];
$NoEstanque = $_POST["NoEstanque"];  
$UniTerminadas = $_POST["UniTerminadas"];
$LibrasTerminadas = $_POST["LibrasTerminadas"];
$Observaciones = $_POST["Observaciones"];
$Entrego = $_POST["Entrego"];
$SQL_INSERT = mysqli_query($db, "INSERT INTO Bodega.CONTROL_PISICULTURA (Fecha, Estanque, UnidadesTerminadas, LibrasTerminadas, ObservacionProd, EntregoA, ColaboradorProd, FechaProduccion) 
VALUES ('$Fecha', '$NoEstanque', '$UniTerminadas', '$LibrasTerminadas', '$Observaciones', '$Entrego', '$id_user', CURRENT_TIMESTAMP)");

if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	