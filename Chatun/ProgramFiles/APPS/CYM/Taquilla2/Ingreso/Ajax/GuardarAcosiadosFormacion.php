<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$programaActivo = $_POST["programaActivo"];
$noParticipantes = $_POST["noParticipantes"];
$clasificador = $_POST["clasificadorEvento"];
$fechaFormacion = $_POST["fechaFormacion"];
$id_user = $_SESSION["iduser"];
$tipoEvento = $_POST["tipoEvento"];
$duenoEvento     = $_POST["duenoEvento"];   
$fechaEvento = $_POST["fechaEvento"];
$nomEmpresa = $_POST["nomEmpresa"];
$areaUtilizada = $_POST["areaUtilizada"];
$telEmpresa = $_POST["telEmpresa"];
$procedenciaEvento = $_POST["procedenciaEvento"];
$NombreEvento = $_POST["NombreEvento"];
$id_user = $_SESSION["iduser"];
$procedenciaPais = $_POST["procedenciaPais"];
$otrosPaises = $_POST["otrosPaises"];
if ($telEmpresa=="") {
	$telEmpresa=0;
}
else
{
	$telEmpresa=$telEmpresa;
}
if ($otrosPaises=="true") 
{
	$municipio = 0;
	$depto = 0;
	$pais = $procedenciaPais;
}
else
{
$trozos = explode(", ", $procedenciaEvento);
$municipio= $trozos[0];
$depto =  $trozos[1];
$pais = 73;
}

$verevento = mysqli_num_rows(mysqli_query($db, "SELECT a.* FROM Taquilla.ASOCIADOS_FORMACION a 
WHERE a.AF_PARTICIPANTES = '$noParticipantes' AND a.PA_ID = '$programaActivo' AND a.CE_ID = '$clasificador'
AND a.AF_FECHA = '$fechaFormacion' AND a.E_ID = '$tipoEvento' AND a.IE_DUENO_EVENTO = '$duenoEvento'
AND a.IE_NOMBRE_EMPRESA = '$nomEmpresa' AND a.AU_ID = '$areaUtilizada'"));

if ($verevento>0) 
{

	echo "2";   
	
	
}else{


$insert = mysqli_query($db, "INSERT INTO Taquilla.ASOCIADOS_FORMACION(AF_PARTICIPANTES, PA_ID, CE_ID, AF_FECHA, AF_COLABORADOR, E_ID, NOMBRE_EVENTO, IE_DUENO_EVENTO,  IE_NOMBRE_EMPRESA, AU_ID, IE_TEL_EMPRESA, IE_FECHA_INGRESO, AF_MUNICIPIO, AF_DEPTO, AF_PAIS)
VALUES('$noParticipantes', $programaActivo, $clasificador, '$fechaFormacion', $id_user, '$tipoEvento', '$NombreEvento', '$duenoEvento', '$nomEmpresa', '$areaUtilizada', $telEmpresa, CURRENT_TIMESTAMP, $municipio, $depto, $pais)");

if($insert){
	
    echo "1";
}

}
?>