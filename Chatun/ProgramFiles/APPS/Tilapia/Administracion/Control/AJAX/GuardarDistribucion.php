<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Fecha = $_POST['Fecha'];
$PuntoVenta = $_POST["PuntoVenta"];  
$UniTerminadas = $_POST["UniTerminadas"];
$LibrasTerminadas = $_POST["LibrasTerminadas"];
$Observaciones = $_POST["Observaciones"]; 
$Entrego = $_POST["Entrego"];
 
$SQL_INSERT = mysqli_query($db, "INSERT INTO Bodega.DISTRIBUCION_PUNTOS_VENTA (Fecha, Colaborador, FechaIngreso, Estado) 
VALUES ('$Fecha', '$id_user', CURRENT_TIMESTAMP, 1)");
$Id = mysqli_insert_id($db);
 
$Contador = count($PuntoVenta);
for ($i=0; $i < $Contador; $i++) {  
$SQL_INSERT2 = mysqli_query($db, "INSERT INTO Bodega.DISTRIBUCION_TILAPIA_DETALLE (IdDetalle, Unidades, Libras, IdPunto, Observaciones, Colaborador) 
VALUES ($Id,  '$UniTerminadas[$i]', '$LibrasTerminadas[$i]', $PuntoVenta[$i], '$Observaciones[$i]', '$Entrego[$i]')");
 $Libras += $LibrasTerminadas[$i];
 $Unidades += $UniTerminadas[$i];
 }

$SQL_INSERT1 = mysqli_query($db, "UPDATE Bodega.DISTRIBUCION_PUNTOS_VENTA SET TotalUnidades = $Unidades , TotalLibras = $Libras WHERE Id = $Id ");
if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	