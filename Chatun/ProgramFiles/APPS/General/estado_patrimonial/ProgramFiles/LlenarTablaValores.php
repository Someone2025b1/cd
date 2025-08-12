<?php
include("../../../../../Script/conex.php");

$ID = $_POST["id"];
	
$Consulta = "SELECT * FROM Estado_Patrimonial.valor_acciones_detalle WHERE colaborador =  ".$ID;
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	$opciones.='<tr>';
	$opciones.='<td><h6>'.$row["clase_titulo"].'</h6></td>';
	$opciones.='<td><h6>'.$row["institucion"].'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["monto"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["valor_comercial"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><h6><a href="EditarValores.php?ID='.$row["id"].'"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Editar</button></a></h6></td>';
	$opciones.='<td><h6><button type="button" class="btn btn-danger btn-xs deleteRow" ID="'.$row["id"].'" onClick="EliminarValores(this)"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button></h6></td>';
	$opciones.='</tr>';
}

    echo $opciones;
?>