<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
//
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$CIF = $_POST['CIF'];

$existente = mysqli_query($db, "SELECT IAT_CIF_ASOCIADO FROM Taquilla.INGRESO_ASOCIADO_TEMPORAL where IAT_CIF_ASOCIADO = $CIF AND IAT_CIF_COLABORADOR = ".$id_user);

	if(mysqli_num_rows($existente) > 0) //verifico si ya se está ingresando el cif al momento del registro
		{
			echo "1";
		}
	else
		{
			$prestamo = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_ASOCIADO_TEMPORAL (IAT_CIF_ASOCIADO, IAT_CIF_COLABORADOR)
							VALUES($CIF, $id_user)");	
		}

?>
