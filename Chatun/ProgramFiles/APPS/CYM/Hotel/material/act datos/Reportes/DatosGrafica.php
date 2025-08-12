<?php
include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");

include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");

include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

//include($_SERVER["DOCUMENT_ROOT"]."/includes/Header.php");

//include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');

header("Content-type: text/json");

$anio = $_GET['anio'];
//$fecha_final = $_GET['fecha_final'];

	//generada
		$rows = array();

		$sql1 = mysqli_query($db, $portal_coosajo_db2, "SELECT  b.nombre, count(a.id) as gestiones
																								from coosajo_asociatividad.gestion_actualizacion as a
																								INNER JOIN desarrollo_humano.meses as b
																								on month(a.fecha_gestion) = b.id
																								where year(a.fecha_gestion) = '$anio'
																								GROUP BY month(a.fecha_gestion)");

														while($res1 = mysqli_fetch_array($sql1)) {
														    $row[0] = $res1[0];
														    $row[1] = $res1[1];
														    array_push($rows,$row);
														}
																print json_encode($rows,JSON_NUMERIC_CHECK);
?>
