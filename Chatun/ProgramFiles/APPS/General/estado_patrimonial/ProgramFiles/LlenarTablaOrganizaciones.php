<?php
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
	
$Consulta = "SELECT * FROM Estado_Patrimonial.detalle_organizaciones_civiles WHERE colaborador = ".$_POST["id"];
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	$opciones.='<tr>';
	$opciones.='<td><h6>'.$row["tipo_organizacion"].'</h6></td>';
	$opciones.='<td><h6>'.$row["nombre_organizacion"].'</h6></td>';
	$opciones.='<td><h6>'.$row["cargo"].'</h6></td>';
	$opciones.='<td><h6>'.date('d-m-Y', strtotime($row["fecha_ingreso"])).'</h6></td>';
	$opciones.='<td><h6><button type="button" class="btn btn-warning btn-xs deleteRow" IDOrganizacion="'.$row["id"].'" onClick="EliminarOrganizacion(this)"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button></h6></td>';
	$opciones.='</tr>';
}

    echo $opciones;
?>