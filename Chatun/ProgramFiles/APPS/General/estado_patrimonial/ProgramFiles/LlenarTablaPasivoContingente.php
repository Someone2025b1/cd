<?php
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
	
$Consulta = "SELECT * FROM Estado_Patrimonial.detalle_pasivo_contingente WHERE colaborador = ".$_POST["id"];
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	$opciones.='<tr>';
	$opciones.='<td><h6>'.$row["fiador_de"].'</h6></td>';
	$opciones.='<td><h6>'.$row["institucion"].'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["monto"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><h6>'.date('d-m-Y', strtotime($row["vencimiento"])).'</h6></td>';
	$opciones.='<td><h6><button type="button" class="btn btn-warning btn-xs deleteRow" IDPasivo="'.$row["id"].'" onClick="EliminarPasivoContingente(this)"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button></h6></td>';
	$opciones.='</tr>';
}

    echo $opciones;
?>