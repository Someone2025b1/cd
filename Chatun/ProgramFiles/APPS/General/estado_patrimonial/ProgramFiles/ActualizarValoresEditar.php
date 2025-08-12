<?php
include("../../../../../Script/conex.php");

$Clase = $_POST["Clase"];
$Empresa = $_POST["Empresa"];
$Monto        = $_POST["Monto"];
$ValorComercial        = $_POST["ValorComercial"];
$ID           = $_POST["ID"];


$sql = mysqli_query($db, "UPDATE Estado_Patrimonial.valor_acciones_detalle SET clase_titulo = '".$Clase."', institucion = '".$Empresa."', monto = ".$Monto.", valor_comercial = ".$ValorComercial.", fecha = CURRENT_DATE WHERE id = '".$_POST["ID"]."'");


if(!$sql)
{
	echo mysqli_error();
}
else
{
	header('Location: estado_patrimonial.php');
}

?>