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
					 "numeroDocumento"=>($FilaCorrelativoActual[RES_CORRELATIVO_ACTUAL] + 1),
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
						if($Centinela == true)
						{
							echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
							<h2 class="text-light">La factura se ingresó correctamente.</h2>
							<div class="row">
								<a href="Vta.php">
									<button type="button" class="btn btn-success btn-lg">
										<span class="glyphicon glyphicon-ok-sign"></span> Nueva Factura
									</button>
								</a>
							</div>';
						}
			           echo "NUMERO DE DTE:   "."<b>".$resultado->return->numeroDte."</b>"."</p>";
					   echo "CAE:   "."<b>".$resultado->return->cae."</b>"."</p>";	

					   $QueryUpdateCorrelativoActual = mysql_query("UPDATE Bodega.RESOLUCION SET RES_CORRELATIVO_ACTUAL = RES_CORRELATIVO_ACTUAL + 1 WHERE RES_SERIE = '".$SerieAutorizada."' AND RES_NUMERO = '".$NumeroResolucion."'", $db);

					   $QueryUpdateFactura = mysql_query("UPDATE Bodega.FACTURA SET F_CAE = '".$resultado->return->cae."', F_DTE = '".$resultado->return->numeroDte."' WHERE F_CODIGO = '".$Uid."'", $db);

					   $QueryUpdateTransaccionBodega = mysql_query("UPDATE Bodega.TRANSACCION SET TRA_OBSERVACIONES = 'Vta. Restaurante Según Fact. ".$resultado->return->numeroDte."' WHERE F_CODIGO = '".$Uid."'", $db);

					   $QueryUpdateTransaccionContabilidad = mysql_query("UPDATE Contabilidad.TRANSACCION SET TRA_CONCEPTO = 'Vta. Restaurante Según Fact. ".$resultado->return->numeroDte."' WHERE TRA_CODIGO = '".$Uid."'", $db);
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