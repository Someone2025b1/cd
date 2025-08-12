<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

	$Departamento = $_POST["Departamento"];	



$query = mysqli_query($db, "SELECT * FROM info_base.municipios_guatemala WHERE id_departamento = ".$Departamento." ORDER BY nombre_municipio") or die("error".mysqli_error());
while($fila = mysqli_fetch_array($query))
{
	$Option .= '<option value="'.$fila["id"].'">'.$fila["nombre_municipio"].'</option>';	
}

echo $Option;

?>
