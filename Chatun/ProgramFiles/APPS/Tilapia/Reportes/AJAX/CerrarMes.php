<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"]; 
$MesF = $_GET["Mes"];
$Anio = $_GET["Anio"]; 
$MesSig = $MesF + 1; 
if ($MesSig>12) {
	$MesSig = 1;
	$Anio = date("Y");
}
else
{
	$MesSig = $MesSig;
	$Anio = $Anio;
}
 
$Estanque = $_GET["IdEstanque"]; 
$Detalle = mysqli_fetch_array(mysqli_query($db, "SELECT a.Estanque, a.Existencia, a.CostoUnitario, a.CostoTotal  FROM Bodega.CONTROL_PISICULTURA a WHERE a.Estanque = '$Estanque' AND MONTH(a.Fecha) = $MesF AND YEAR(a.Fecha) = $Anio ORDER BY a.Id DESC LIMIT 1"));
 
$SQL_INSERT = mysqli_query($db, "UPDATE Bodega.INVENTARIO_INICIAL_PECES SET CantidadFinal = $Detalle[Existencia], CostoUnitario = $Detalle[CostoUnitario], CostoTotal = $Detalle[CostoTotal], FechaIngreso = CURRENT_TIMESTAMP, Colaborador = '$id_user' WHERE IdEstanque = $Estanque and Mes = $MesF and Anio = $Anio");   
$SQL_INSERT2 = mysqli_query($db, "INSERT INTO Bodega.INVENTARIO_INICIAL_PECES (IdEstanque, CantidadInicial, Mes, Anio, FechaIngreso, Colaborador) 
VALUES ($Detalle[Estanque], $Detalle[Existencia], $MesSig, $Anio, CURRENT_TIMESTAMP, '$id_user')");   
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<!-- END META -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
<?php 
if($SQL_INSERT){ 
	echo '<div class="col-lg-12 text-center">
			<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
			<h2 class="text-light">El cierre se ingreso correctamente.</h2>
			<div class="row">
				<a href="../ControlMes.php">
					<button type="button" class="btn btn-success btn-lg">
						<span class="glyphicon glyphicon-ok-sign"></span> Regresar
					</button>
				</a>
			</div>';

}else { 
	echo ' 
		<h1><span class="text-xxxl text-light">ERROR! <i class="fa fa-check-circle text-success"></i></span></h1>
		 ';

}

?>	