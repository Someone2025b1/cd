<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/conex_sql_server.php");
//
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Nombre = $_POST['Nombre'];


	$query_services = sqlsrv_query($db_sql, "SELECT TOP 10 * FROM OPENQUERY(BANKWORKS, 'SELECT CIFNOMBRECLIE, CIFCODCLIENTE, CIFDOCIDENT06, CIFDOCIDENT03 FROM CIFGENERALES WHERE CIFNOMBRECLIE LIKE ''%".$Nombre."%''')");
    while ($row_services = sqlsrv_fetch_array($query_services)) 
    {
    	if($row_services["CIFDOCIDENT06"] == '')
    	{
    		$Identificacion = 'Pasaporte: '.$row_services["CIFDOCIDENT03"];
    	}
    	else
    	{
    		$Identificacion = 'DPI: '.$row_services["CIFDOCIDENT06"];
    	}

        echo '<a class="suggest-element" data="'.$row_services['CIFCODCLIENTE'].'"><b>('.$row_services['CIFCODCLIENTE'].') '.utf8_encode($row_services['CIFNOMBRECLIE']).'</b> --- '.$Identificacion.'</a><br>';
    }
 ?>
