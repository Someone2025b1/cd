<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
//include("../../../../../Script/conex_a_coosajo.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Nombre = $_POST['Nombre'];


	$query_services = mysqli_query($db, "SELECT cifcodcliente, cifdocident06, cifdocident03 FROM bankworks.cif_generales WHERE MATCH cifnombreclie AGAINST ('".$Nombre."') LIMIT 25");
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

        echo '<a style="font-size: 11px" class="suggest-element" data="'.$row_services['cifcodcliente'].'"><b>('.$row_services['cifcodcliente'].') '.utf8_encode(saber_nombre_asociado_orden($row_services['cifcodcliente'])).'</b> --- '.$Identificacion.'</a><br>';
    }
 ?>
