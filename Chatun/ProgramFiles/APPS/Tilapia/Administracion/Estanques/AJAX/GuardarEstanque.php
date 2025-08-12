<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$CapacidadEstanque = $_POST['Capacidad'];
$Observaciones = $_POST["Observaciones"]; 
$Inicial  = $_POST["Inicial"]; 
$NoEstanque = $_POST["NoEstanque"];
$Metros = $_POST["Metros"];
$CostoTotal = $_POST["CostoTotal"];
$CostoUni = $CostoTotal / $Inicial;
$Correlativo = mysqli_fetch_array(mysqli_query($db, "SELECT MAX(Correlativo) AS Max FROM Pisicultura.Estanque"));
$Id = $Correlativo["Max"] + 1;
$SQL_INSERT = mysqli_query($db, "INSERT INTO Pisicultura.Estanque (IdEstanque, Correlativo, Capacidad, CostoUnitario, CostoTotal, InventarioInicial, Estado, Metros, Observaciones, FechaCreacion, Usuario) 
VALUES ('$NoEstanque', $Id, '$CapacidadEstanque', '$CostoUni', '$CostoTotal', '$Inicial', '1', '$Metros', '$Observaciones', CURRENT_TIME, '$id_user')");

$SQL_INSERT2 = mysqli_query($db, "INSERT INTO Bodega.INVENTARIO_INICIAL_PECES (IdEstanque, CantidadInicial, Mes, Anio, FechaIngreso, Colaborador) 
VALUES ('$NoEstanque', '$Inicial', 11, 2021, CURRENT_TIME, '$id_user')");


if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	