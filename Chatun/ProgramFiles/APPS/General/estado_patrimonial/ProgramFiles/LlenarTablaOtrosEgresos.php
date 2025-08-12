<?php
include("../../../../../Script/conex.php");

$ID = $_POST["id"];
	
$Consulta = "SELECT * FROM Estado_Patrimonial.otros_egresos_detalle WHERE colaborador =  ".$ID;
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	$opciones.='<tr>';
	$opciones.='<td><h6>'.$row["descripcion"].'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["monto"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><h6><button type="button" class="btn btn-warning btn-xs deleteRow" ID="'.$row["id"].'" onClick="EliminarOtrosEgresos(this)"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button></h6></td>';
	$opciones.='</tr>';
}

    echo $opciones;
?>