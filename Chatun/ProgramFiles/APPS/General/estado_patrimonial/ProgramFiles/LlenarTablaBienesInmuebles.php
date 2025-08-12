<?php
include("../../../../../Script/conex.php");

$ID = $_POST["id"];
	
$Consulta = "SELECT tipo_inmueble.tipo_inmueble, bienes_inmuebles_detalle.* 
FROM Estado_Patrimonial.tipo_inmueble, Estado_Patrimonial.bienes_inmuebles_detalle
WHERE bienes_inmuebles_detalle.id_tipo_inmueble = tipo_inmueble.id_inmueble
AND bienes_inmuebles_detalle.colaborador = ".$ID;
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	$opciones.='<tr>';
	$opciones.='<td><h6>'.$row["tipo_inmueble"].'</h6></td>';
	$opciones.='<td><h6>'.$row["localizacion"].'</h6></td>';
	$opciones.='<td><h6>'.$row["finca"].'</h6></td>';
	$opciones.='<td><h6>'.$row["folio"].'</h6></td>';
	$opciones.='<td><h6>'.$row["libro"].'</h6></td>';
	$opciones.='<td><h6>'.$row["departamento"].'</h6></td>';
	$opciones.='<td><h6>'.number_format($row["valor_mercado"], 2, '.', ',').'</h6></td>';
	$opciones.='<td><h6><a href="EditarBienInmueble.php?ID='.$row["id"].'"<button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span> Editar</button></h6></a></td>';
	$opciones.='<td><h6><button type="button" class="btn btn-danger btn-xs deleteRow" ID="'.$row["id"].'" onClick="EliminarBienesInmuebles(this)"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button></h6></td>';
	$opciones.='</tr>';
}

    echo $opciones;
?>