<?php
include("../../../../../Script/conex.php");

	$NIT = $_POST["id"];
	$Consulta = mysqli_fetch_array(mysqli_query($db, "SELECT a.CLI_EMAIL from Bodega.CLIENTE a WHERE a.CLI_NIT = '$NIT'"));
	$url = "https://www.ingface.net/ServiciosIngface/ingfaceWsServices?wsdl";
	$contextOptions = array(
	    'ssl' => array(
	    'verify_peer' => false,
	    'verify_peer_name' => false,
	    'allow_self_signed' => true
	    ));

	$sslContext = stream_context_create($contextOptions);

	$params =  array(
	    'trace' => 1,
	    'exceptions' => true,
	    'cache_wsdl' => WSDL_CACHE_NONE,
	    'stream_context' => $sslContext
	    );

	try {
	    $client = new SoapClient( $url, $params );

		$result = $client->nitContribuyentes( [ "usuario" => 'DEMO', "clave" => "C2FDC80789AFAF22C372965901B16DF533A4FCB19FD9F2FD5CBDA554032983B0", "nit" => $NIT ] );

		if($result->return->nombre == 'Nit no valido')
		{
			$Data["Respuesta"] = 'FAIL';
			$Data["Nombre"] = $result->return->nombre;
		}
		else
		{
			$Data["Respuesta"] = 'OK';
			$Data["Nombre"] = $result->return->nombre;
			$Data["Direccion"] = $result->return->direccion_completa;
			$Data["Email"] = $Consulta["CLI_EMAIL"];
		}

		echo json_encode($Data);
	} 
	catch ( SoapFault $e ) 
	{
		echo $e->getMessage();
	}
?>
