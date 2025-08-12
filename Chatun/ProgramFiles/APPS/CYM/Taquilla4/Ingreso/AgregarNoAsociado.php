<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

include("../../../../../Script/funciones.php");

$hoy = date('Y-m-d');
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$PoseeTicket = $_POST['PoseeTicket'];
$Departamento = $_POST['Departamento'];
$Municipio = $_POST['Municipio'];
$FrecuenciaVisita = $_POST['FrecuenciaVisita'];
$Enterado = $_POST['Enterado'];
$BusquedaParque = $_POST['BusquedaParque'];
$CodigoPrecio[] = $_POST['CodigoPrecio'];
$Cantidad = $_POST['Cantidad'];
$Valor[]= $_POST['Valor'];
$Total[] = $_POST['Total'];
$CodigoPrecio[] = $_POST['CodigoPrecio'];
$Valor[] = $_POST['Valor'];
$Total[] = $_POST['Total'];
$CodigoPrecio[] = $_POST['CodigoPrecio'];
$Valor[] = $_POST['Valor'];
$Total[] = $_POST['Total'];

$no_asociado = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_NO_ASOCIADO_TEMPORAL VALUES ('', $id_user, NOW(), $PoseeTicket, 73, $Departamento, $Municipio, $FrecuenciaVisita, $Enterado, $BusquedaParque, $Cantidad[0], $Cantidad[1], $Cantidad[2])") or die("Insertar en No asociado tepmoral".mysqli_error());

if($no_asociado)
	{
		echo "1";
	}
?>
