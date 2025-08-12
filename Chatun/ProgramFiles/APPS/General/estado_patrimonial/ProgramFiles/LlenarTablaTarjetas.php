<?php
include("../../../../../Script/conex.php");

$ID = $_POST["id"];
	
$Consulta = "SELECT * FROM Estado_Patrimonial.tarjetas_credito_detalle WHERE colaborador =  ".$ID;
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	$opciones.='<tr>';
	$opciones.='<td><h6>'.$row["acreedor"].'</h6></td>';
	$opciones.='<td><h6>'.date('d-m-Y', strtotime($row["vencimiento"])).'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["monto_original"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["saldo_actual"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><a href="EditarTarjetas.php?ID='.$row["id"].'"><h6><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Editar</button></a></h6></td>';
	$opciones.='<td><h6><button type="button" class="btn btn-danger btn-xs deleteRow" ID="'.$row["id"].'" onClick="EliminarTarjetas(this)"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button></h6></td>';
	$opciones.='</tr>';
}

    echo $opciones;
?>