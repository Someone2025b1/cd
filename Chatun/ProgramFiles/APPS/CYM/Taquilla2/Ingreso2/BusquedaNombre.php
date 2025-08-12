<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/conex_a_coosajo.php");
//
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Nombre = $_POST['Nombre'];


	// $query_services = sqlsrv_query($db_sql, "SELECT TOP 10 * FROM OPENQUERY(BANKWORKS, 'SELECT CIFNOMBRECLIE, CIFCODCLIENTE, CIFDOCIDENT06, CIFDOCIDENT03 FROM CIFGENERALES WHERE CIFNOMBRECLIE LIKE ''%".$Nombre."%''')");
    $query_services = mysqli_query($dbc, "SELECT cifnombreclie, cifcodcliente, cifdocident06, cifdocident03 FROM bankworks.cif_generales WHERE cifnombreclie LIKE '%".$Nombre."%'");
    
    while ($row_services = mysqli_fetch_array($query_services)) 
    {
    	if($row_services["cifdocident06"] == '')
    	{
    		$Identificacion = 'Pasaporte: '.$row_services["cifdocident03"];
    	}
    	else
    	{
    		$Identificacion = 'DPI: '.$row_services["cifdocident06"];
    	}

        echo '<a class="suggest-element" data="'.$row_services['cifcodcliente'].'"><b>('.$row_services['cifcodcliente'].') '.utf8_encode($row_services['cifnombreclie']).'</b> --- '.$Identificacion.'</a><br>';
    }
 ?>
