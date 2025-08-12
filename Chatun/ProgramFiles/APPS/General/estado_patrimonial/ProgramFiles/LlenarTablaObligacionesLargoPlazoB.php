<?php
include("../../../../../Script/conex.php");

$ID = $_POST["id"];
	
$Consulta = "SELECT * FROM Estado_Patrimonial.obligacioneslp_detalle WHERE entidad_financiera = 'Bancos' AND colaborador =  ".$ID;
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	$opciones.='<tr>';
	$opciones.='<td><h6>'.utf8_decode($row["garantia"]).'</h6></td>';
	$opciones.='<td><h6>'.date('d-m-Y', strtotime($row["vencimiento"])).'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["monto_original"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["saldo_actual"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><h6>'.$row["frecuencia"].'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["monto_amortizacion"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><a href="EditarOLPC.php?ID='.$row["id"].'"><h6><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Editar</button></a></h6></td>';
	$opciones.='<td><h6><button type="button" class="btn btn-warning btn-xs deleteRow" ID="'.$row["id"].'" onClick="EliminarObligacioneslp(this)"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button></h6></td>';
	$opciones.='</tr>';
}

    echo $opciones;
?>