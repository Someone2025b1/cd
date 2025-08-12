<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
	<!-- END STYLESHEETS -->

	<script>
	function CalcularTotalQ()
	{
		var B200 = $('#BQ200').val();
		var B100 = $('#BQ100').val();
		var B50  = $('#BQ50').val();
		var B20  = $('#BQ20').val();
		var B10  = $('#BQ10').val();
		var B5   = $('#BQ5').val();
		var B1   = $('#BQ1').val();
		var M1   = $('#MQ1').val();
		var M50  = $('#MQ50').val();
		var M25  = $('#MQ25').val();
		var M10  = $('#MQ10').val();
		var M5   = $('#MQ5').val();

		var CantidadEntera = parseFloat(B200 * 200) + parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5) + parseFloat(B1 * 1);
		var CantidadMoneda = parseFloat(M1 * 1) + parseFloat(M50 * 0.50) + parseFloat(M25 * 0.25) + parseFloat(M10 * 0.10) + parseFloat(M5 * 0.05);

		var Total = CantidadEntera + CantidadMoneda;
		Total = Total.toFixed(2);

		$('#TCQ').val(Total);
	}
	function CalcularTotalD()
	{
		var B100 = $('#BD100').val();
		var B50  = $('#BD50').val();
		var B20  = $('#BD20').val();
		var B10  = $('#BD10').val();
		var B5   = $('#BD5').val();
		var B1   = $('#BD1').val();

		var CantidadEntera = parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5) + parseFloat(B1 * 1);
		
		var Total = CantidadEntera;
		Total = Total.toFixed(2);

		$('#TCD').val(Total);
	}
	function CalcularTotalL()
	{
		var B500 = $('#BL500').val();
		var B100 = $('#BL100').val();
		var B50  = $('#BL50').val();
		var B20  = $('#BL20').val();
		var B10  = $('#BL10').val();
		var B5   = $('#BL5').val();
		
		var CantidadEntera = parseFloat(B500 * 500) + parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5);
		
		var Total = CantidadEntera;
		Total = Total.toFixed(2);

		$('#TCL').val(Total);
	}
	</script>
	

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	 
	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Modificar un Cierre de Caja</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Cierres</strong></h4>
						</div>
						<div class="card-body">
							<?php
								$BilletesQ200   = $_POST["BQ200"];
								$BilletesQ100   = $_POST["BQ100"];
								$BilletesQ50    = $_POST["BQ50"];
								$BilletesQ20    = $_POST["BQ20"];
								$BilletesQ10    = $_POST["BQ10"];
								$BilletesQ5     = $_POST["BQ5"];
								$BilletesQ1     = $_POST["BQ1"];
								$BilletesM1     = $_POST["MQ1"];
								$BilletesM50    = $_POST["MQ50"];
								$BilletesM25    = $_POST["MQ25"];
								$BilletesM10    = $_POST["MQ10"];
								$BilletesM5    = $_POST["MQ5"];
								$BilletesQTotal = $_POST["TCQ"];

								$BilletesD100   = $_POST["BD100"];
								$BilletesD50    = $_POST["BD50"];
								$BilletesD20    = $_POST["BD20"];
								$BilletesD10    = $_POST["BD10"];
								$BilletesD5     = $_POST["BD5"];
								$BilletesD1     = $_POST["BD1"];
								$BilletesDTotal = $_POST["TCD"];
								
								$BilletesL500   = $_POST["BL500"];
								$BilletesL100   = $_POST["BL100"];
								$BilletesL50    = $_POST["BL50"];
								$BilletesL20    = $_POST["BL20"];
								$BilletesL10    = $_POST["BL10"];
								$BilletesL5     = $_POST["BL5"];
								$BilletesLTotal = $_POST["TCL"];

								$CodigoCierre = $_POST["CodigoCierre"];

								$Cont = mysqli_query($db, "SELECT * FROM Bodega.APERTURA_CIERRE_CAJA a WHERE a.ACC_TIENE_PARCIAL = 1 AND a.ACC_CODIGO = '$CodigoCierre'");


							   if ($Cont) 
							   { 
								   $Consulta = "SELECT *FROM Bodega.CIERRE_DETALLE_PARCIAL a WHERE a.ACC_CODIGO = '$CodigoCierre'";
										   $Resultado = mysqli_query($db, $Consulta);
										   while($row = mysqli_fetch_array($Resultado))
										   {
											   $TotalParcial+=$row["ACCP_TOTAL"];
											   $BilletesQTotal+=$row["CD_TOTAL_Q"];
											   $BilletesDTotal+=$row["CD_TOTAL_D"];
											   $BilletesLTotal+=$row["CD_TOTAL_L"];
										   }
										   
								   $TotalGeneral+=$TotalParcial;
		   
							   }

								$Query = mysqli_query($db, "UPDATE Bodega.CIERRE_DETALLE SET CD_Q_200 = ".$BilletesQ200.", CD_Q_100 = ".$BilletesQ100.", CD_Q_50 = ".$BilletesQ50.", CD_Q_20 = ".$BilletesQ20.", CD_Q_10 = ".$BilletesQ10.", CD_Q_5 = ".$BilletesQ5.", CD_Q_1 = ".$BilletesQ1.", CD_M_1 = ".$BilletesM1.", CD_M_50 = ".$BilletesM50.", CD_M_25 = ".$BilletesM25.", CD_M_10 = ".$BilletesM10.", CD_M_5 = ".$BilletesM5.", CD_TOTAL_Q = ".$BilletesQTotal.", CD_D_100 = ".$BilletesD100.", CD_D_50 = ".$BilletesD50.", CD_D_20 = ".$BilletesD20.", CD_D_10 = ".$BilletesD10.", CD_D_5 = ".$BilletesD5.", CD_D_1 = ".$BilletesD1.", CD_TOTAL_D = ".$BilletesDTotal.", CD_L_500 = ".$BilletesL500.", CD_L_100 = ".$BilletesL100.", CD_L_50 = ".$BilletesL50.", CD_L_20 = ".$BilletesL20.", CD_L_10 = ".$BilletesL10.", CD_L_5 = ".$BilletesL5.", CD_TOTAL_L = ".$BilletesLTotal.", CD_ACTUALIZA = ".$id_user." WHERE ACC_CODIGO = '".$CodigoCierre."'") or die(mysqli_error($Query));

								if(!$Query)
								{
									echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo modificar la cuenta.</h2>
											<h4 class="text-light">Código de transacción: '.$CodigoCierre.'</h4>
											</div>';
									echo mysqli_error($Query);
								 
								}
								else
								{
									echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
									<h2 class="text-light">La cuenta se modificó correctamente.</h2>
									<div class="row">
										<div class="col-lg-12 text-center"><a href="CC.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
									</div>';
								}
							?>
						</div>
					</div>
				</div>
			</div>
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
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<!-- END JAVASCRIPT -->

	</body>
	</html>
