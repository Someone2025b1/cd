<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


$CantidadMenor = $_POST['CantidadMenor'];
$CifAsignar = $_POST['CifAsignar'];



		$acompaniante_temporal_menor = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_ACOMPANIANTE_MENORES_TEMPORAL (NM_CANTIDAD, USUARIO, FECHA, ASOCIADO)
											VALUES('$CantidadMenor', '$id_user', CURRENT_TIMESTAMP(), '$CifAsignar')");


		if($acompaniante_temporal_menor)
		{
			echo "1";
		}
?>
