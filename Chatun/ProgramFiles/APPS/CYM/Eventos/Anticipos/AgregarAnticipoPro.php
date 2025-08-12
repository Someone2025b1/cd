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

			window.open('ImpAnticipo.php?Codigo='+Cod, '_blank');
			
		}

	</script>


</head>
<body class="menubar-hoverable header-fixed menubar-pin " onload="Imprimir()">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
		<?php
			$TotalTaquillaSinIVA = 0;

			$UIE        = uniqid("AE_");
			$UIED    	= uniqid("AED_");
			$Centinela = true;
			$Contador  = count($_POST["Cantidad"]);
			$TotalDescuentoFactura = 0;
			$Monto = $_POST["Monto"];
			$FechaEv = $_POST["FechaEvento"];

			$FechaHoraHoy = date('Y-m-d', strtotime('now')).'T'.date('H:i:s', strtotime('now'));
			$CodigoEstablecimiento = 1;

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
				
			echo '<input type="hidden" id="CodigoFactura" value="'.$UIE.'" />';


			$NIT       = $_POST["NIT"];
			$Nombre    = strtoupper($_POST["Nombre"]);
			$Direccion = strtoupper($_POST["Direccion"]);

			//Si el número de NIT NO esta registrado
			//Se crea un nuevo cliente con los datos ingresados anteriormente
			$sql = mysqli_query($db, "INSERT INTO Bodega.CLIENTE (CLI_NIT, CLI_NOMBRE, CLI_DIRECCION) VALUES ('".$NIT."', '".$Nombre."', '".$Direccion."')ON DUPLICATE KEY UPDATE CLI_NOMBRE = '".$Nombre."', CLI_DIRECCION = '".$Direccion."'");

			if(!$sql)
			{
				echo 'ERROR EN INGRESO DE CLIENTE';
				
			}

			

			$QueryDatosNIT = mysqli_query($db, "SELECT *
											FROM Bodega.CLIENTE AS A
											WHERE A.CLI_NIT = '".$NIT."'");
			$FilaDatosNIT = mysqli_fetch_array($QueryDatosNIT);

			$NombreCliente = $FilaDatosNIT['CLI_NOMBRE'];
			$DireccionCliente = $FilaDatosNIT['CLI_DIRECCION'];


			//Si el tipo de pago fue en EFECTIVO
			
				$Moneda = $_POST["MonedaPagoInput"];

				$QueryEncabezado = mysqli_query($db, "INSERT INTO Contabilidad.ANTICIPO_EVENTOS (AE_CODIGO, AE_NOMBRE_CLIENTE, CLI_NIT, AE_MONTO, AE_FECHA, AE_FECHA_EVENTO, AE_ESTADO, AE_USER, AE_TIPOPAGO, AE_OBSERVACIONES, AE_BOLETA)
												VALUES ('".$UIE."', '".$Nombre."', '".$NIT."', ".$Monto.", CURRENT_DATE(), '".$FechaEv."', 0, ".$id_user.", ".$TipoPago.", '".$Observaciones."',  '".$NumeroBoleta."')") or die('Encabezado Factura 1'.mysqli_error());

				

				/****************************************************************************************
				*****************************************************************************************
				*									PARTIDA CONTABLE 								    *
				*****************************************************************************************
				****************************************************************************************/


				$Mes = date('m', strtotime('now'));
				$Anho = date('Y', strtotime('now'));
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


				$sqlCaj = mysqli_query($db,"SELECT A.nombre 
				FROM info_bbdd.usuarios AS A     
				WHERE A.id_user = ".$id_user); 
				$rowcaj=mysqli_fetch_array($sqlCaj);

				$NombreCaj=$rowcaj["nombre"];

				$SqlContable = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_CONCEPTO, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SERIE, TRA_FACTURA, TRA_TOTAL, RES_NUMERO, TRA_CORRELATIVO, PC_CODIGO)
										 VALUES('".$UIE."', CURRENT_DATE(), 'Anticipo para evento a realizarse el $FechaEv, a nombre de $NombreCliente; responsable de evento $NombreCaj Recibo de caja No. $UIE',  CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 2, 30, '".$SerieAutorizada."', '".$FacturaNumero."', ".$Monto.", '".$NumeroResolucion."', ".$Correlativo.", ".$Periodo.")") or die('Encabezado Conta 1'.mysqli_error());

			if($TipoPago == 1)
			{
				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
											VALUES('".$UIE."', '".$UIED."', '1.01.01.006', ".number_format($Monto, 2, ".", "").", 0.00)");

			}elseif($TipoPago == 2)
			{
				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
											VALUES('".$UIE."', '".$UIED."', '1.01.03.006', ".number_format($Monto, 2, ".", "").", 0.00)");

			}elseif($TipoPago == 4)
			{
				$SqlContableD = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
											VALUES('".$UIE."', '".$UIED."', '".$CuentaBancaria."', ".number_format($Monto, 2, ".", "").", 0.00)");

			}

				$SqlContableD1 = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE(TRA_CODIGO, TRAD_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA) 
												VALUES('".$UIE."', '".$UIED."', '2.01.02.001', 0.00, ".number_format($Monto, 4, ".", "").")");


			


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
