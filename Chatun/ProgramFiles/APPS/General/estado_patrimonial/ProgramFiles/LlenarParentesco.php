<?php
include("../../../../../Script/conex.php");

$CIF              = $_POST["CIFParent"];
$Parentesco       = $_POST["Parentesco"];
$Fecha            = $_POST["Fecha"];
$Vive             = $_POST["Vive"];
$Direccion        = $_POST["Direccion"];
$Dependiente      = $_POST["Dependiente"];
$Ocupacion        = $_POST["Ocupacion"];
$UsuarioID        = $_POST["UsuarioID"];
$TipoPersona      = $_POST["TipoPersona"];
$NombreNoAsociado = $_POST["NombreNoAsociado"];

switch ($Parentesco) {
	case 1:
	$Parentesco = "Hijo / Hija";
	$grado_consaguinidad = "Primer Grado Consaguinidad";
	
	case 2:
	$Parentesco = "Padre / Madre";
	$grado_consaguinidad = "Primer Grado Consaguinidad";
	
	case 3:
	$Parentesco = "Hermano / Hermana";
	$grado_consaguinidad = "Segundo Grado Consaguinidad";
	
	case 4:
	$Parentesco = "Nieto / Nieta";
	$grado_consaguinidad = "Segundo Grado Consaguinidad";
	
	case 5:
	$Parentesco = "Abuelo / Abuela";
	$grado_consaguinidad = "Segundo Grado Consaguinidad";
	
	case 6:
	$Parentesco = "Suegro / Suegra";
	$grado_consaguinidad = "Primer Grado Afinidad";
	
	case 7:
	$Parentesco = "Yerno / Nuera";
	$grado_consaguinidad = "Primer Grado Afinidad";
	
	case 8:
	$Parentesco = "Cuñado / Cuñada";
	$grado_consaguinidad = "Segundo Grado Afinidad";
	
	case 9:
	$Parentesco = "Cónyuge";
	$grado_consaguinidad = "Primer Grado Afinidad";
		
	case 10:
	$Parentesco = "Tio/Tia";
	$grado_consaguinidad = "Tercer Grado Consaguinidad";
		
	case 11:
	$Parentesco = "Sobrino/Sobrina";
	$grado_consaguinidad = "Tercer Grado Consaguinidad";
		
	case 12:
	$Parentesco = "Biznieto/Biznieta";
	$grado_consaguinidad = "Tercer Grado Consaguinidad";
		
	case 13:
	$Parentesco = "Bisabuela/Bisabuelo";
	$grado_consaguinidad = "Tercer Grado Consaguinidad";
		
	case 14:
	$Parentesco = "Primo / Prima";
	$grado_consaguinidad = "Cuarto Grado Consaguinidad";
	
}

if($TipoPersona == 1)
{
	$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.detalle_parentescos (colaborador, parentesco, dependiente, ocupacion, grado_consaguinidad, cif, actualizo, fecha_nacimiento_hijo, vive, direccion_hijo, tipo_persona) 
						VALUES (".$UsuarioID.", '".$Parentesco."', '".$Dependiente."', '".$Ocupacion."', '".$grado_consaguinidad."', '".$CIF."', CURRENT_TIMESTAMP(), '".$Fecha."', '".$Vive."', '".$Direccion."', 1)") or die($Error = mysqli_error());
}
else
{
	$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.detalle_parentescos (colaborador, parentesco, dependiente, ocupacion, grado_consaguinidad, cif, actualizo, fecha_nacimiento_hijo, vive, direccion_hijo, nombre_no_asociado, tipo_persona) 
						VALUES (".$UsuarioID.", '".$Parentesco."', '".$Dependiente."', '".$Ocupacion."', '".$grado_consaguinidad."', '0', CURRENT_TIMESTAMP(), '".$Fecha."', '".$Vive."', '".$Direccion."', '".$NombreNoAsociado."', 2)") or die($Error = mysqli_error());
}


if(!$sql)
{
	echo $Error;
}

?>