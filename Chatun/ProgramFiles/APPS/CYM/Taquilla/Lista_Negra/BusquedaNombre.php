<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
//include("../../../../../Script/conex_a_coosajo.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex_sql_server.php");

$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Nombre = $_POST['Nombre'];


	$sql = 'SELECT "CIFCODCLIENTE", LEFT("CIFNOMBRECLIE", 256) AS CIFNOMBRECLIE, 
               "CIFDOCIDENT02", "CIFDOCIDENT03", "CIFDOCIDENT06", "CIFSEXO"
        FROM "Chatun"."dbo"."CIFGENERALES_TEMPORAL"
        WHERE "CIFNOMBRECLIE" LIKE \'%' . $Nombre . '%\' ESCAPE \'\\\'';

$resultado = sqlsrv_query($db_sql, $sql);

if ($resultado === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
    $CIF       = $fila['CIFCODCLIENTE'];
    $Nombre    = $fila['CIFNOMBRECLIE'];
    $NIT       = $fila['CIFDOCIDENT02'];
    $DPI       = $fila['CIFDOCIDENT06'];
    $Pasaporte = $fila['CIFDOCIDENT03'];
    $Sexo      = $fila['CIFSEXO'];

	if($DPI == '')
		{
			$Identificacion = '<b>Pasaporte</b> '.$Pasaporte;	
		}
		else
		{
			$Identificacion = '<b>DPI</b> '.$DPI;	
		}

        echo '<a style="font-size: 11px" class="suggest-element" data="'.$CIF.'"><b>('.$CIF.') '.utf8_encode($Nombre).'</b> --- '.$Identificacion.'</a><br>';
	}
 ?>
