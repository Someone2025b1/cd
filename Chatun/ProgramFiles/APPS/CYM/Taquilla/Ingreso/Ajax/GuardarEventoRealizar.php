<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$tipoEvento = $_POST["tipoEvento"];
$duenoEvento     = $_POST["duenoEvento"];
$cantPersonas 	 = $_POST["cantPersonas"];
$clasificadorEvento = $_POST["clasificadorEvento"];
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
$verevento = mysqli_num_rows(mysqli_query($db, "SELECT a.* FROM Taquilla.INGRESO_EVENTO a 
WHERE a.IE_CANTIDAD_PERSONAS = '$cantPersonas' AND a.CE_ID = '$clasificadorEvento'
AND a.IE_FECHA_EVENTO = '$fechaEvento' AND a.E_ID = '$tipoEvento' AND a.IE_DUENO_EVENTO = '$duenoEvento'
AND a.IE_NOMBRE_EMPRESA = '$nomEmpresa' AND a.AU_ID = '$areaUtilizada' AND a.NOMBRE_EVENTO = '$NombreEvento'"));

if ($verevento>0) 
{

	echo "2";   
	
	
}else{

$insert = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_EVENTO(E_ID, NOMBRE_EVENTO, IE_DUENO_EVENTO, IE_CANTIDAD_PERSONAS, CE_ID, IE_NOMBRE_EMPRESA, AU_ID, IE_TEL_EMPRESA, IE_FECHA_EVENTO, IE_FECHA_INGRESO, IE_COLABORADOR, IE_MUNICIPIO, IE_DEPTO, IE_PAIS)
VALUES('$tipoEvento', '$NombreEvento', '$duenoEvento', $cantPersonas, $clasificadorEvento, '$nomEmpresa', '$areaUtilizada', $telEmpresa, '$fechaEvento', CURRENT_TIMESTAMP, $id_user, $municipio, $depto, $pais)");

if($insert){
    echo "1";
}
}
?>