<?php
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
	
$Consulta = "SELECT * FROM Estado_Patrimonial.detalle_parentescos WHERE colaborador = ".$_POST["id"];
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	if($row["fecha_nacimiento_hijo"] != '0000-00-00')
	{
		$FechaNacimiento = date('d-m-Y', strtotime($row["fecha_nacimiento_hijo"]));
	}
	else
	{
		$FechaNacimiento = '---';
	}

	if($row["vive"] == 2)
	{
		$Vive = 'No';
	}
	elseif($row["vive"] == 1)
	{
		$Vive = 'Si';
	}
	elseif($row["vive"] == '')
	{
		$Vive = '---';
	}

	if($row["dependiente"] == 1)
	{
		$Depende = 'Si';
	}
	elseif($row["dependiente"] == 2)
	{
		$Depende = 'No';
	}
	elseif($row["dependiente"] == '')
	{
		$Depende = '---';
	}

	$opciones.='<tr>';
	$opciones.='<td><h6>'.$row["cif"].'</h6></td>';
	if($row["tipo_persona"] == 1)
	{
		$opciones.='<td><h6>'.saber_nombre_asociado($row["cif"]).'</h6></td>';
	}
	else
	{
		$opciones.='<td><h6>'.$row["nombre_no_asociado"].'</h6></td>';
	}
	$opciones.='<td><h6>'.$row["parentesco"].'</h6></td>';
	$opciones.='<td><h6>'.$row["grado_consaguinidad"].'</h6></td>';
	$opciones.='<td><h6>'.$FechaNacimiento.'</h6></td>';
	$opciones.='<td><h6>'.$Vive.'</h6></td>';
	$opciones.='<td><h6>'.$row["direccion_hijo"].'</h6></td>';
	$opciones.='<td><h6>'.$Depende.'</h6></td>';
	$opciones.='<td><h6>'.$row["ocupacion"].'</h6></td>';
	$opciones.='<td><h6><a href="EditarParentesco.php?CodigoPariente='.$row["id"].'"><button type="button" class="btn btn-warning btn-xs deleteRow" ><span class="glyphicon glyphicon-pencil"></span> Editar</button></h6></td>';
	$opciones.='<td><h6><button type="button" class="btn btn-danger btn-xs deleteRow" CIFPariente="'.$row["id"].'" CIFColaborador="'.$UserID.'" onClick="EliminarParentesco(this)"><span class="glyphicon glyphicon-minus-sign"></span> Eliminar</button></h6></td>';
	$opciones.='</tr>';
}

    echo $opciones;
?>