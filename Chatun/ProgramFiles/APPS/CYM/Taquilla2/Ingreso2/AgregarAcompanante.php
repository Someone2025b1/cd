<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Datos      = $_POST['Datos'];

if($Datos == 1)
{
	$CifAsignar = $_POST['CifAsignar'];
	$SelectPais = $_POST['SelectPais'];
	$Telefono   = $_POST['Telefono'];
	$NombreAcompaniante = $_POST['NombreAcompaniante'];
	$CorreoAcompaniante = $_POST['CorreoAcompaniante'];
	$EdadAcompaniante = $_POST['EdadAcompaniante'];
	$SelectConociaParqueAcompaniante = $_POST['SelectConociaParqueAcompaniante'];
	$SelectAsisteconAcompaniante = $_POST['SelectAsisteconAcompaniante'];
	$SelectVisitaEsquipulasAcompaniante = $_POST['SelectVisitaEsquipulasAcompaniante'];
	$SelectDepartamentoSalvador = $_POST['SelectDepartamentoSalvador'];
	$SelectDepartamentoHonduras = $_POST['SelectDepartamentoHonduras'];
	$Municipio = $_POST["Municipio"];

	if($SelectPais != 73)
	{
		$SelectDepartamento = 0;
		$Municipio          = 0;
	}
	
	if($SelectPais == 73)
	{
		$Departamento = $_POST['SelectDepartamento'];
		$Municipio = $_POST['Municipio'];

	}
	if($SelectPais == 79)
	{
		$Departamento = $_POST['SelectDepartamentoHonduras'];
		$Municipio = 0;
	}
	if($SelectPais ==54)
	{
		$Departamento = $_POST['SelectDepartamentoSalvador'];
		$Municipio = 0;
	}



	if($Municipio == 310)
	{
		$SelectVisitaEsquipulasAcompaniante = 0;
	}
	if($EdadAcompaniante == "")
	{
		$EdadAcompaniante = 0;
	}

	$FrecuenciaVisita = $_POST['FrecuenciaVisita'];
	$Enterado         = $_POST['Enterado'];
	$BusquedaCentro   = $_POST['BusquedaCentro'];
}
else
{
	$CifAsignar         = $_POST['CifAsignar'];
	$SelectPais         = 0;
	$Telefono           = 0;
	$SelectDepartamento = 0;
	$Municipio          = 0;
	$FrecuenciaVisita   = 0;
	$Enterado           = 0;
	$BusquedaCentro     = 0;
}


// echo "INSERT INTO Taquilla.INGRESO_ACOMPANIANTE_TEMPORAL 
// 											VALUES('', $id_user, $CifAsignar, $Datos, $SelectPais, $Departamento, $Municipio, $FrecuenciaVisita, $Enterado, $Telefono, $BusquedaCentro, '$NombreAcompaniante', '$CorreoAcompaniante', $EdadAcompaniante, $SelectConociaParqueAcompaniante, $SelectAsisteconAcompaniante, $SelectVisitaEsquipulasAcompaniante) ";

		$acompaniante_temporal = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_ACOMPANIANTE_TEMPORAL 
											VALUES('', '$id_user', '$CifAsignar', '$Datos', '$SelectPais', '$Departamento', '$Municipio', '$FrecuenciaVisita', '$Enterado', '$Telefono', '$BusquedaCentro', '$NombreAcompaniante', '$CorreoAcompaniante', '$EdadAcompaniante', '$SelectConociaParqueAcompaniante', '$SelectAsisteconAcompaniante', '$SelectVisitaEsquipulasAcompaniante') ") or die("Acompaniante temporal ".mysqli_error($acompaniante_temporal));
		if($acompaniante_temporal)
		{
			echo "1";
		}
?>
