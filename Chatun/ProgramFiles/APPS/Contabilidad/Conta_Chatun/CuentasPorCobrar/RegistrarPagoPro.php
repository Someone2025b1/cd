<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/httpful.phar");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<!-- END META -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<!-- END STYLESHEETS -->
	
	<script>
		function Imprimir()
		{
			var Cod = document.getElementById('CodigoFactura').value;

			window.open('ImpRecibo.php?Codigo='+Cod, '_blank');
			
		}

	</script>


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
		<?php
		$Mes = date('m', strtotime('now'));
		$Anho = date('Y', strtotime('now'));
			$TotalTaquillaSinIVA = 0;

			$Uid        = uniqid("tra_");
			$UidD    	= uniqid("trad_");
			$Centinela = true;
			

			$FechaHoraHoy = date('Y-m-d', strtotime('now')).'T'.date('H:i:s', strtotime('now'));
			$TipoPago                 = $_POST["TipoPago"];
			$Fecha                    = $_POST["Fecha"];
			$ClienteRegistrado        = $_POST["ClienteRegistrado"];			
			$TotalFacturaConDescuento = $_POST["TotalFacturaConDescuento"];
			$TotalFacturaFinal        = $_POST["TotalFacturaFinal"];
			$TipoMoneda               = $_POST["MonedaPagoInput"];
			$Direccion 			  = $_POST["Direccion"];
			$Observaciones 			  = $_POST["Observaciones"];
			$NumeroBoleta = $_POST["NumeroBoleta"];
			$CuentaBancaria = $_POST["CuentaBancaria"];
			$DescripcionFac = $_POST["DescripcionFac"];
			$CodigoFac = $_POST["CodigoFac"];
			$MontoFac = $_POST["MontoFac"];
			$SaldoFac = $_POST["SaldoFac"];
			$AbonoFac = $_POST["AbonoFac"];
			$RestaFac = $_POST["RestaFac"];
			$Contador  = count($_POST["AbonoFac"]);


			if($TipoPago == 1)
			{
				if($TipoMoneda == 1)
				{
					$Efectivo = $_POST["TotalEfectivo"];
					$Cambio   = $_POST["Cambio"];
				}
				elseif($TipoMoneda == 2)
				{
					$Efectivo = $_POST["TotalEfectivoDolares"];
					$Cambio   = $_POST["CambioDolaresQuetzalizados"];
				}
				elseif($TipoMoneda == 3)
				{
					$Efectivo = $_POST["TotalEfectivoLempira"];
					$Cambio   = $_POST["CambioLempirasQuetzalizados"];
				}
			}
				
			echo '<input type="hidden" id="CodigoFactura" value="'.$Uid.'" />';

			$QuerySaberPeriodo = "SELECT PC_CODIGO FROM Contabilidad.PERIODO_CONTABLE WHERE PC_MES = ".$Mes." AND PC_ANHO = ".$Anho;
				$ResultSaberPeriodo = mysqli_query($db, $QuerySaberPeriodo) or die(mysqli_error());
				while($FilaSaberPeriodo = mysqli_fetch_array($ResultSaberPeriodo))
				{
					$Periodo = $FilaSaberPeriodo["PC_CODIGO"];
				}

				$queryCorrelativo = "SELECT MAX(TRA_CORRELATIVO) AS CORRELATIVO FROM Contabilidad.TRANSACCION WHERE MONTH( TRA_FECHA_TRANS ) = ".$Mes." AND YEAR( TRA_FECHA_TRANS ) = ".$Anho." AND PC_CODIGO = ".$Periodo;
				$resultCorrelativo = mysqli_query($db, $queryCorrelativo) or die(mysqli_error());
				while($rowC = mysqli_fetch_array($resultCorrelativo))
				{	
					if($rowC["CORRELATIVO"] == 0)
					{
						$Correlativo = 1;
					}
					else
					{
						$Correlativo = $rowC["CORRELATIVO"] + 1;
					}
				}


			$NIT       = $_POST["NIT"];
			$Nombre    = strtoupper($_POST["Nombre"]);
			$Direccion = strtoupper($_POST["Direccion"]);

			

			

			$QueryDatosNIT = mysqli_query($db, "SELECT *
											FROM Bodega.CLIENTE AS A
											WHERE A.CLI_NIT = '".$NIT."'");
			$FilaDatosNIT = mysqli_fetch_array($QueryDatosNIT);

			$NombreCliente = $FilaDatosNIT['CLI_NOMBRE'];
			$DireccionCliente = $FilaDatosNIT['CLI_DIRECCION'];


							###VARIABLES PAGO MIXTO
							$MontoEfectivoCon = $_POST["MontoME"];
							$MontoTarjeta = $_POST["MontoMT"];
							$AutorizacionM = $_POST["AutorizacionM"];
							$MontoBanco = $_POST["MontoMB"];
							$NumeroBoletaM = $_POST["NumeroBoletaM"];
							$CuentaBancariaM = $_POST["CuentaBancariaM"];
							$CodigoA = $_POST["CodigoA"];
							$NombreA = $_POST["NombreA"];
							$MontoMA = $_POST["MontoMA"];
							$CambioM = $_POST["CambioM"];
							$ChequeM = $_POST["ChequeM"];
							$MontoCH = $_POST["MontoCH"];
							$CuentaGastoM = $_POST["CuentaGastoM"];
							$MontoGasto = $_POST["MontoGasto"];
							$ObGasto = $_POST["ObservacionGasto"];
							$NumeroCheque = $_POST["NumeroCheque"];
							$ExpIva = $_POST["ExpIva"];
							$MontoEx = $_POST["MontoEx"];
							$ContadorANTICIPO  = count($_POST["MontoMA"]);
							$MontoAnticipo = 0;
			
							$MontoEfectivo=$MontoEfectivoCon-$CambioM;
			
							#DETERMINAR TOTAL PAGO MIXTO Y ACTUALIZAR ESTADO DE LOS ANTICIPOS
							for($j=0; $j<$ContadorANTICIPO; $j++)
								{
									$CodA = $CodigoA[$j];
									$MonA = $MontoMA[$j];
									
									$MontoAnticipo+=$MonA;
								}
			

								#Recorre las Facturas pagadas y las registra en el kardex
								for($i=0; $i<$Contador; $i++)
								{
									$CodF = $CodigoFac[$i];
									$DesFac = $DescripcionFac[$i];
									$SalFac =  $SaldoFac[$i];
									$MonFac = $MontoFac[$i];
									$AbFac = $AbonoFac[$i];
									$ResFac = $RestaFac[$i];

									
							

									if($AbFac>0){
							###REGISTRO DEL ENCABEZADO

							if($ResFac==0){

								$EstadoFac=2;
								#$DesFac1="/Cancela ".$DesFac;
								$DescripcionJunta=$DescripcionJunta."/Cancela ".$DesFac;

							}else{
								$EstadoFac=1;
								#$DesFac1="/Abona ".$DesFac;
								$DescripcionJunta=$DescripcionJunta."/Abona Q.".$AbFac."A la Factura ".$DesFac;

							}
							
							
						
							$QueryEncabezado = mysqli_query($db, "INSERT INTO Contabilidad.CUENTAS_POR_COBRAR_KARDEX (CC_CODIGO, T_CODIGO, KC_CONCEPTO, KC_MONTO, KC_SALDO_A, KC_SALDO_N, KC_FECHA, KC_ESTADO, KC_TIPO_PAGO, KC_EFECTIVO, KC_BANCO, KC_BOLETA, KC_BANCO_N, KC_TARJETA, KC_AUTORIZACION, KC_CHEQUE, KC_BANCO_CHEQUE, KC_NO_CHEQUE, KC_EX_IVA, KC_ANTICIPO, KC_CAMBIO, KC_USER, KC_CONTA, KC_GASTO_CUENTA, KC_GASTO_TOTAL, KC_OBSERVACIONES_GASTO)
															VALUES ('".$CodF."', '".$Uid."', '".$DesFac1."', '".$AbFac."', '".$SalFac."', '".$ResFac."', CURRENT_DATE(), '".$EstadoFac."', 5, '".$MontoEfectivo."', '".$MontoBanco."', '".$NumeroBoletaM."', '".$CuentaBancariaM."', '".$MontoTarjeta."', '".$AutorizacionM."', '".$MontoCH."', '".$ChequeM."', '".$NumeroCheque."', '".$MontoEx."', '".$MontoAnticipo."', '".$CambioM."', '".$id_user."', 1, '".$CuentaGastoM."', '".$MontoGasto."', '".$ObGasto."')") or die(mysqli_error());

						$queryp = "SELECT * FROM Contabilidad.CUENTAS_POR_COBRAR WHERE CC_CODIGO ='$CodF'";
							$result = mysqli_query($db, $queryp);
							while($rowe = mysqli_fetch_array($result))
							{
								$AbonoAnterior=$rowe["CC_ABONO"];

								$AbonoNew = $AbonoAnterior + $AbFac;

								
								
							$QueryPU = mysqli_query($db, "UPDATE Contabilidad.CUENTAS_POR_COBRAR SET
							CC_ABONO = ".$AbonoNew.",
							CC_FECHA_ABONO = CURRENT_DATE(),
							CC_ESTADO = ".$EstadoFac."
							WHERE CC_CODIGO ='$CodF'");
								
							}

							
						}
					}

					if($MontoCH>0){

						$DescripcionJunta=$DescripcionJunta."Se Pago Con Cheque de ".$ChequeM." No. ".$NumeroCheque;
					}

					if($MontoGasto>0){

						$DescripcionJunta=$DescripcionJunta."Facturas pertenecientes a ACERCATE por  ".$ObGasto;
					}
					#$DescripcionJunta="Prueba";

					
							/****************************************************************************************
							*****************************************************************************************
							*									PARTIDA CONTABLE 								    *
							*****************************************************************************************
							****************************************************************************************/


					$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
					VALUES('".$Uid."', CURRENT_DATE(), '".$DescripcionJunta."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 31, '".$SerieAutorizada."', '".$FacturaNumero."', ".$TotalFacturaFinal.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die(mysqli_error());


							if($MontoBanco>0){

								$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '".$CuentaBancariaM."', ".number_format($MontoBanco, 2, ".", "").", 0.00)");
							}
							if($MontoAnticipo>0){

								$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '2.01.02.001', ".number_format($MontoAnticipo, 2, ".", "").", 0.00)");
							}
							if($MontoEfectivo>0){

								$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '1.01.01.006', ".number_format($MontoEfectivo, 2, ".", "").", 0.00)");
							}
							if($MontoTarjeta>0){

								$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '1.01.03.006', ".number_format($MontoTarjeta, 2, ".", "").", 0.00)");
							}
							if($MontoCH>0){

								$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '1.01.01.009', ".number_format($MontoCH, 2, ".", "").", 0.00)");
							}
							if($MontoEx>0){

								$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '1.01.05.006', ".number_format($MontoEx, 2, ".", "").", 0.00)");
							}

							if($MontoGasto>0){

								$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
															VALUES('".$Uid."', '".$UidD."', '".$CuentaGastoM."', ".number_format($MontoGasto, 2, ".", "").", 0.00)");
							}

							$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$Uid."', '".$UidD."', '1.01.03.003', 0.00, ".number_format($TotalFacturaFinal, 4, ".", "").")");

						

						

							
							
							
					
if($responseCerti->body->cantidad_errores == 0)
{
	echo '<div class="col-lg-12 text-center">
		<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
		<h2 class="text-light">La factura se ingresó correctamente.</h2>
		<div class="row">
			<a href="RegistrarPago.php">
				<button type="button" class="btn btn-success btn-lg">
					<span class="glyphicon glyphicon-ok-sign"></span> Cuentas Por Cobrar
				</button>
			</a>
		</div>
		<div class="col-lg-6 text-right"><a href="IngresoImp.php?Codigo='.$Uid.'" target="_blank"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>
		<div class="col-lg-6 text-left"><a href="NewFac.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
</div>';

		 

			#ACTUALIZAR ESTADO DE LOS ANTICIPOS
			for($i=0; $i<$ContadorANTICIPO; $i++)
			{
				$CodA = $CodigoA[$i];
				$MonA = $MontoMA[$i];
				
				$QueryUpdateFactura = mysqli_query($db, "UPDATE Contabilidad.ANTICIPO_EVENTOS SET AE_ESTADO = 1, F_CODIGO = '".$Uid."', AE_FECHA_USO = CURRENT_DATE() WHERE AE_CODIGO = '".$CodA."'");

				
			}



		}
		else
		{
			  echo '<br><ul>';

			  foreach ($responseCerti->body->descripcion_errores as $errores) 
			  {
				echo '<li>'.$errores->mensaje_error.'</li>';
			  }
		  
			  echo '<br></ul>';
		}


		?>
		</div><!--end #content-->
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>


	</div><!--end #base-->
	<!-- END BASE -->

	<!-- BEGIN JAVASCRIPT -->
	<script src="../../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../../../js/core/source/App.js"></script>
	<script src="../../../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../../../js/core/source/AppCard.js"></script>
	<script src="../../../../../js/core/source/AppForm.js"></script>
	<script src="../../../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../../../js/core/source/AppVendor.js"></script>
	<script src="../../../../../js/core/demo/Demo.js"></script>
	<script src="../../../../../js/core/demo/DemoFormWizard.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/additional-methods.min.js"></script>
	<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>
	<!-- END JAVASCRIPT -->

</body>
</html>
