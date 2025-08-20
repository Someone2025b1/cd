<?php

include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


	
	$Anho = date('Y', strtotime($_POST["fecha"]));
	$Anho2 = date('y', strtotime($_POST["fecha"]));
    $Mes = date('m', strtotime($_POST["fecha"]));


	if($Mes==2 AND $Anho==2024){

	$query = "SELECT * FROM Contabilidad.TRANSACCION WHERE YEAR(TRA_FECHA_TRANS) = ".$Anho."
	AND TRA_NO_HOJA IS NOT NULL 
	ORDER BY TRA_NO_HOJA DESC
	LIMIT 1";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	
		$CodigoAnt = $row["TRA_NO_HOJA"];
	}
if($CodigoAnt==NULL){

	$CodigoNuevo=$Anho2."-".$Mes."-"."0001";

}else{

	$correlativoante = explode("$Anho2-$Mes-", $CodigoAnt);
	$correlatinuev=$CodigoAnt+1;
	$CodigoNuevo=$correlatinuev;

}
	}else{
		$query = "SELECT * FROM Contabilidad.TRANSACCION WHERE YEAR(TRA_FECHA_TRANS) = ".$Anho." AND MONTH(TRA_FECHA_TRANS) = ".$Mes."
	AND TRA_NO_HOJA IS NOT NULL 
	ORDER BY TRA_NO_HOJA DESC
	LIMIT 1";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	
		$CodigoAnt = $row["TRA_NO_HOJA"];
	}
if($CodigoAnt==NULL){

	$CodigoNuevo=$Anho2."-".$Mes."-"."0001";

}else{

	$correlativoante = explode("$Anho2-$Mes-", $CodigoAnt);
	$correlatinuev=$correlativoante[1]+1;
	$CodigoNuevo=$Anho2."-".$Mes."-".sprintf("%04d",$correlatinuev);

}
	}
echo $CodigoNuevo;

	?>