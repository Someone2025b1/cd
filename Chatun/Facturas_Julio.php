<?php

include('Script/conex.php');

$SerieAutorizada = 'F2S';
$NumeroResolucion = '2020568702925336';
$FechaResolucion = '2020-07-21';

$QueryFacturas = mysql_query("
		SELECT *
		FROM Bodega.FACTURA_SV AS A
		INNER JOIN Bodega.CLIENTE AS B ON A.CLI_NIT = B.CLI_NIT
		WHERE A.F_FECHA_TRANS BETWEEN '2020-07-01' AND CURRENT_DATE()
	", $db);
while($FilaFacturas = mysql_fetch_array($QueryFacturas))
{
	echo var_dump($FilaFacturas).'<br>';

	$TotalDescuentoFactura = 0;

	$ContadorDetalle = 0;

	$NIT = $FilaFacturas["CLI_NIT"];
	$Nombre = $FilaFacturas["CLI_NOMBRE"];
	$Direccion = $FilaFacturas["CLI_DIRECCION"];

	$TotalFacturaFinal = $FilaFacturas["F_TOTAL"];


	$IVADebito = (($TotalFacturaFinal * 0.12) / 1.12);
	$VentaSinIVA = $TotalFacturaFinal - $IVADebito;

	$TotalFacturaCorroborar = $IVADebito + $VentaSinIVA;

	if(number_format($TotalFacturaCorroborar, 2, ".", "") != number_format($TotalFacturaFinal, 2, ".", ""))
	{
		if(number_format($TotalFacturaCorroborar, 2, ".", "") > number_format($TotalFacturaFinal, 2, ".", ""))
		{
			$Diferencia = number_format($TotalFacturaCorroborar, 2, ".", "") - number_format($TotalFacturaFinal, 2, ".", "");
		} 
		elseif(number_format($TotalFacturaCorroborar, 2, ".", "") < number_format($TotalFacturaFinal, 2, ".", ""))
		{
			$Diferencia = number_format($TotalFacturaFinal, 2, ".", "") - number_format($TotalFacturaCorroborar, 2, ".", "");
		}

		$IVADebito = number_format($IVADebito, 2, ".", "") + number_format($Diferencia, 2, ".", "");
	}

	$QueryCorrelativoActual = mysql_query("SELECT A.RES_CORRELATIVO_ACTUAL FROM Bodega.RESOLUCION AS A WHERE A.RES_SERIE = '".$SerieAutorizada."' AND A.RES_NUMERO = '".$NumeroResolucion."'", $db);
	$FilaCorrelativoActual = mysql_fetch_array($QueryCorrelativoActual);
	$NumeroDocumento = $FilaCorrelativoActual[RES_CORRELATIVO_ACTUAL] + 1;

	$QueryDetalleFactura = mysql_query("
			SELECT *
			FROM Bodega.FACTURA_SV_DETALLE AS A
			INNER JOIN Bodega.PRODUCTO AS B ON A.P_CODIGO = B.P_CODIGO
			WHERE A.F_CODIGO = '".$FilaFacturas["F_CODIGO"]."'
		", $db);
	while($FilaFacturasDetalle = mysql_fetch_array($QueryDetalleFactura))
	{
		$IVAProducto = (($FilaFacturasDetalle["FD_SUBTOTAL"] / 1.12) * 0.12);
		$SubNeto = $FilaFacturasDetalle["FD_SUBTOTAL"] - $IVAProducto;

		$detalle[$ContadorDetalle]["cantidad"] = $FilaFacturasDetalle["FD_CANTIDAD"];
        $detalle[$ContadorDetalle]["unidadMedida"] = "UND";
        $detalle[$ContadorDetalle]["codigoProducto"] = $FilaFacturasDetalle["P_CODIGO"];
        $detalle[$ContadorDetalle]["descripcionProducto"] = $FilaFacturasDetalle["P_NOMBRE"];
        $detalle[$ContadorDetalle]["precioUnitario"] = $FilaFacturasDetalle["FD_PRECIO_UNITARIO"];
        $detalle[$ContadorDetalle]["montoBruto"] = $FilaFacturasDetalle["FD_SUBTOTAL"];
        $detalle[$ContadorDetalle]["montoDescuento"] = $FilaFacturasDetalle["FD_DESCUENTO"];
        $detalle[$ContadorDetalle]["importeNetoGravado"] = $SubNeto;
        $detalle[$ContadorDetalle]["detalleImpuestosIva"] = $IVAProducto;								
        $detalle[$ContadorDetalle]["importeExento"] = 0;
        $detalle[$ContadorDetalle]["otrosImpuestos"] = 0;
        $detalle[$ContadorDetalle]["importeOtrosImpuestos"] = 0;
        $detalle[$ContadorDetalle]["importeTotalOperacion"] = $FilaFacturasDetalle["FD_SUBTOTAL"];
        $detalle[$ContadorDetalle]["tipoProducto"]="B";
		$detalle[$ContadorDetalle]["personalizado_01"]="1";
		$detalle[$ContadorDetalle]["personalizado_02"]="2";
		$detalle[$ContadorDetalle]["personalizado_03"]="3";
		$detalle[$ContadorDetalle]["personalizado_04"]="4";
		$detalle[$ContadorDetalle]["personalizado_05"]="5";
		$detalle[$ContadorDetalle]["personalizado_06"]="6";			

		$TotalDescuentoFactura = $TotalDescuentoFactura + $FilaFacturasDetalle["FD_DESCUENTO"];

		$ContadorDetalle++;
	}


		try { 
	         $client = new SoapClient("https://www.ingface.net/listener/ingface?wsdl",array("exceptions" => 1)); 
	         $resultado = $client->registrarDte(array("dte"=>array(
			 "usuario"=>"ACERCATE",
			 "clave"=>"FB7A6CBC297896B4ADBEF6587BCD5284D41D8CD98F00B204E9800998ECF8427E",
			 "validador"=>false,
			 "dte"=>array(
			 "codigoEstablecimiento"=>"1",
			 "idDispositivo"=>"001",
			 "serieAutorizada"=>$SerieAutorizada,
			 "numeroResolucion"=>str_replace("-", "",$NumeroResolucion),
			 "fechaResolucion"=>$FechaResolucion,
			 "tipoDocumento"=>"FACE",
			 "serieDocumento"=>"63",
			 "numeroDocumento"=>$NumeroDocumento,
			 "fechaDocumento"=>date('Y-m-d'),
			 "fechaAnulacion"=>date('Y-m-d'),
			 "estadoDocumento"=>"ACTIVO",
			 "codigoMoneda"=>"GTQ",
			 "tipoCambio"=>1.00,
			 "nitComprador"=>str_replace("-", "",$NIT),
			 "nombreComercialComprador"=>$Nombre,
			 "direccionComercialComprador"=>$Direccion,
			 "telefonoComprador"=>"N/A",
			 "correoComprador"=>"N/A",
	         "regimen2989"=>0,
			 "departamentoComprador"=>"N/A",
			 "municipioComprador"=>"N/A",
			 "importeBruto"=>$VentaSinIVA,
			 "detalleImpuestosIva"=>$IVADebito,
			 "importeNetoGravado"=>$TotalFacturaFinal,
			 "importeDescuento"=>$TotalDescuentoFactura,
			 "importeTotalExento"=>0,
			 "importeOtrosImpuestos"=>0,
			 "montoTotalOperacion"=>$TotalFacturaFinal, 
			 "descripcionOtroImpuesto"=>"N/A",
			 "observaciones"=>"N/A",
			 "nitVendedor"=>str_replace("-", "","9206609-7"),
			 "NombreComercialRazonSocialVendedor"=>"ACERCATE",
			 "nombreCompletoVendedor"=>"ASOCIACIÓN PARA EL CRECIMIENTO EDUCATIVO REG. COOPERATIVO Y APOYO TURÍSTICO DE ESQUIPULAS",
			 "direccionComercialVendedor"=>"KILOMETRO 226.5 CARRETERA DE ASFALTADA HACIA",
			 "departamentoVendedor"=>"CHIQUIMULA",
			 "municipioVendedor"=>"ESQUIPULAS",
			 "regimenISR"=>"NO_RET_DEFINITIVA",
			 "personalizado_01"=>"1",
			 "personalizado_02"=>"2",
			 "personalizado_03"=>"3",
			 "personalizado_04"=>"4",
			 "personalizado_05"=>"5",
			 "personalizado_06"=>"6",
			 "personalizado_07"=>"1",
			 "personalizado_08"=>"1",
			 "personalizado_09"=>"1",
			 "personalizado_10"=>"1",
			 "personalizado_11"=>"1",
			 "personalizado_12"=>"1",
			 "personalizado_13"=>"1",
			 "personalizado_14"=>"1",
			 "personalizado_15"=>"1",
			 "personalizado_16"=>"1",
			 "personalizado_17"=>"1",
			 "personalizado_18"=>"1",
			 "personalizado_19"=>"1",
			 "personalizado_20"=>"1",
			 "nitGface"=>str_replace("-", "","12521337"),
			 "detalleDte"=>$detalle )
			 )));	
			//------------------------- RESPUESTA DEL WEB SERVICE  -----------------------

			if($resultado->return->valido)
			{  
				$Update = mysql_query("UPDATE Bodega.FACTURA_SV SET F_SERIE = '".$SerieAutorizada."', RES_NUMERO = '".$NumeroResolucion."', F_CAE = '".$resultado->return->cae."', F_DTE = '".$resultado->return->numeroDte."', F_FECHA_TRANS = '2020-07-27' WHERE F_CODIGO = '".$FilaFacturas["F_CODIGO"]."'");

				$Update = mysql_query("UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Vta. Helados Según Fact. ".$resultado->return->numeroDte." ', RES_NUMERO = '".$NumeroResolucion."', TRA_FECHA_TRANS = '2020-07-27' WHERE TRA_CODIGO = '".$FilaFacturas["F_CODIGO"]."'");

				$Update = mysql_query("UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Vta. Helados Según Fact. ".$resultado->return->numeroDte." ', TRA_FECHA_TRANS = '2020-07-27' WHERE F_CODIGO = '".$FilaFacturas["F_CODIGO"]."'");

				$QueryUpdateCorrelativoActual = mysql_query("UPDATE Bodega.RESOLUCION SET RES_CORRELATIVO_ACTUAL = RES_CORRELATIVO_ACTUAL + 1 WHERE RES_SERIE = '".$SerieAutorizada."' AND RES_NUMERO = '".$NumeroResolucion."'", $db);
				

	           echo "NUMERO DE DTE:   "."<b>".$resultado->return->numeroDte."</b>"."</p>";
			   echo "CAE:   "."<b>".$resultado->return->cae."</b>"."</p>";	

			}
			else
			{
			   echo "ERROR, REVISE LO SIGUIENTE:   "."<b>".$resultado->return->descripcion."</b>";			
			}
	       
		} 
		catch (SoapFault $E) 
		{ 
		  echo $E->faultstring;
		}


	echo '<br><br><br><br>-----------------------------------------------------------------------------------------------------<BR><BR>';
}
?>
