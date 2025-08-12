<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$observaciones = $_POST["observaciones"];
 
$asociado = mysqli_query($db, "SELECT * FROM Taquilla.INGRESO_ASOCIADO_TEMPORAL WHERE IAT_CIF_COLABORADOR = ".$id_user)or die('Error 1: '.mysqli_error($asociado));
while($fila = mysqli_fetch_array($asociado))
{
	$CodigoUnico = uniqid();
	$CIFAsociado = $fila["IAT_CIF_ASOCIADO"];

	$QueryAsociado = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_ASOCIADO (IAT_CIF_ASOCIADO, IAT_CIF_COLABORADOR, IA_FECHA_INGRESO, IA_HORA_INGRESO, IA_REFERENCIA, IA_OBSERVACIONES)
									VALUES('".$CIFAsociado."', '".$id_user."', CURRENT_TIMESTAMP, CURRENT_TIME(), '".$CodigoUnico."', '$observaciones')")or die('Error 2: '.mysqli_error($QueryAsociado));

	$QueryConsultaTemporal = mysqli_query($db, "SELECT * FROM Taquilla.INGRESO_ACOMPANIANTE_TEMPORAL WHERE IAT_CIF_COLABORADOR = ".$id_user." AND IAT_CIF_ASOCIADO = ".$CIFAsociado)or die('Error 3: '.mysqli_error($QueryConsultaTemporal));
	while($FilaAcompananteTemporal = mysqli_fetch_array($QueryConsultaTemporal))
	{
		$Datos        = $FilaAcompananteTemporal["IAT_DATOS"];
		$Pais         = $FilaAcompananteTemporal["IAT_SELECT_PAIS"];
		$Departamento = $FilaAcompananteTemporal["IAT_SELECT_DEPARTAMENTO"];
		$Municipio    = $FilaAcompananteTemporal["IAT_SELECT_MUNICIPIO"];
		$Frecuencia   = $FilaAcompananteTemporal["IAT_FRECUENCIA_VISITA"];
		$Enterado     = $FilaAcompananteTemporal["IAT_ENTERADO"];
		$Telefono     = $FilaAcompananteTemporal["IAT_TELEFONO"];
		$Busqueda     = $FilaAcompananteTemporal["IAT_BUSQUEDA_CENTRO"];
		$Nombre       = $FilaAcompananteTemporal["IAT_NOMBRE"];
		$Correo       = $FilaAcompananteTemporal["IAT_CORREO"];
		$Edad         = $FilaAcompananteTemporal["IAT_EDAD"];
		$ConoceParque = $FilaAcompananteTemporal["IAT_CONOCE_PARQUE"];
		$AsisteCon    = $FilaAcompananteTemporal["IAT_ASISTE_CON"];
		$VisitaEsquipulas = $FilaAcompananteTemporal["IAT_VISITA_ESQUIPULAS"];

		echo "INSERT INTO Taquilla.INGRESO_ACOMPANIANTE VALUES('', $id_user, $CIFAsociado, $Datos, $Pais, $Departamento, $Municipio, $Frecuencia, $Enterado, $Telefono, $Busqueda, '".$CodigoUnico."', CURRENT_TIMESTAMP, CURRENT_TIME(), '$Nombre', '$Correo', $Edad, $ConoceParque, $AsisteCon, $VisitaEsquipulas)";

		$QueryIngresoAcompaniante = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_ACOMPANIANTE VALUES('', $id_user, $CIFAsociado, $Datos, $Pais, $Departamento, $Municipio, $Frecuencia, $Enterado, $Telefono, $Busqueda, '".$CodigoUnico."', CURRENT_TIMESTAMP, CURRENT_TIME(), '$Nombre', '$Correo', $Edad, $ConoceParque, $AsisteCon, $VisitaEsquipulas)")or die('Error 4: '.mysqli_error($QueryIngresoAcompaniante));
	}
}

//$QueryLimpieza = mysqli_query($db, "DELETE FROM Taquilla.INGRESO_ASOCIADO_TEMPORAL WHERE IAT_CIF_COLABORADOR = ".$id_user)or die('Error 5: '.mysqli_error($QueryLimpieza));
//$QueryLimpieza1 = mysqli_query($db, "DELETE FROM Taquilla.INGRESO_ACOMPANIANTE_TEMPORAL WHERE IAT_CIF_COLABORADOR = ".$id_user)or die('Error 6: '.mysqli_error($QueryLimpieza1));	

?>
