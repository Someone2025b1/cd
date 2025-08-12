<?php
include("../../../../../Script/conex.php");

$CIF              = $_POST["CIF"];
$Parentesco       = $_POST["parentesco"];
$Vive             = $_POST["Vive"];
$Direccion        = $_POST["DireccionHijo"];
$Dependiente      = $_POST["dependiente"];
$Ocupacion        = $_POST["OcupacionParentesco"];
$UsuarioID        = $_POST["UsuarioID"];
$TipoPersona      = $_POST["TipoPersona"];
$NombreNoAsociado = $_POST["NombreNoAsociado"];
$FechaNacimiento  = $_POST["FechaNacimiento"];

switch ($Parentesco) {
	case 1:
	$Parentesco = "Hijo / Hija";
	$grado_consaguinidad = "Primer Grado Consaguinidad";
	
	case 2:
	$Parentesco = "Padre / Madre";
	$grado_consaguinidad = "Primer Grado Consaguinidad";
	$Vive = '';
	
	case 3:
	$Parentesco = "Hermano / Hermana";
	$grado_consaguinidad = "Segundo Grado Consaguinidad";
	$Vive = '';
	
	case 4:
	$Parentesco = "Nieto / Nieta";
	$grado_consaguinidad = "Segundo Grado Consaguinidad";
	$Vive = '';
	
	case 5:
	$Parentesco = "Abuelo / Abuela";
	$grado_consaguinidad = "Segundo Grado Consaguinidad";
	$Vive = '';
	
	case 6:
	$Parentesco = "Suegro / Suegra";
	$grado_consaguinidad = "Primer Grado Afinidad";
	$Vive = '';
	
	case 7:
	$Parentesco = "Yerno / Nuera";
	$grado_consaguinidad = "Primer Grado Afinidad";
	$Vive = '';
	
	case 8:
	$Parentesco = "Cuñado / Cuñada";
	$grado_consaguinidad = "Segundo Grado Afinidad";
	$Vive = '';
	
	case 9:
	$Parentesco = "Cónyuge";
	$grado_consaguinidad = "Primer Grado Afinidad";
	$Vive = '';
				
}

if($TipoPersona == 1)
{

	$sql = mysqli_query($db, "UPDATE Estado_Patrimonial.detalle_parentescos SET parentesco = '".$Parentesco."', dependiente = '".$Dependiente."', ocupacion = '".$Ocupacion."', grado_consaguinidad = '".$grado_consaguinidad."', cif = '".$CIF."', actualizo = CURRENT_TIMESTAMP(), fecha_nacimiento_hijo = '".$FechaNacimiento."', vive = '".$Vive."', direccion_hijo = '".$Direccion."', tipo_persona = 1 WHERE id = '".$_POST["IDParentescoEditar"]."'");
}
else
{

	$sql = mysqli_query($db, "UPDATE Estado_Patrimonial.detalle_parentescos SET parentesco = '".$Parentesco."', dependiente = '".$Dependiente."', ocupacion = '".$Ocupacion."', grado_consaguinidad = '".$grado_consaguinidad."', cif = 0, actualizo = CURRENT_TIMESTAMP(), fecha_nacimiento_hijo = '".$FechaNacimiento."', vive = '".$Vive."', direccion_hijo = '".$Direccion."', nombre_no_asociado = '".$NombreNoAsociado."', tipo_persona = 2 WHERE id = '".$_POST["IDParentescoEditar"]."'");
}


if(!$sql)
{
	echo mysqli_error();
}
else
{
	header('Location: informacion_base.php');
}

?>