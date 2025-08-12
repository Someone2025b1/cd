<?php
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");

$sql = "SELECT vista_colaboradores_idt.cif FROM info_colaboradores.vista_colaboradores_idt WHERE vista_colaboradores_idt.estado = 'Activo' ORDER BY cif";
$result = mysqli_query($db, $sql);
while($fila = mysqli_fetch_array($result))
{
	$ID = $fila["cif"];

	$query = "SELECT id FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE id = '".$ID."' AND fecha = '2013-12-31'";
	$Res = mysqli_query($db, $query);
	$Registros = mysqli_num_rows($Res);

	if($Registros == 0)
	{
		echo $ID.' '.saber_nombre_asociado($ID).'<br>';
	}
	else
	{

	}
}


?>