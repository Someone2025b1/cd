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
	<script src="../../../../../libs/alertify/js/alertify.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.default.css"/>
	<!-- END STYLESHEETS -->
	<script>
	$(document).ready(function(){
		var Anticipo = $('#Anticipo').val();
		window.location = 'LAPro.php?Codigo='+Anticipo;
	});
	</script>
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<?php
				$NuevoSaldo = 0;
				$Centinela = true;

				$query = "SELECT TRA_TOTAL, TRA_ANTICIPO FROM Contabilidad.TRANSACCION WHERE TRA_CODIGO = '".$_GET["Codigo"]."' ";
				$result = mysqli_query($db,$query);
				while($row = mysqli_fetch_array($result))
				{
					$MontoFacturaRecibo = $row["TRA_TOTAL"];
					$Anticipo  = $row["TRA_ANTICIPO"];
				}

				$query = "SELECT TRA_SALDO FROM Contabilidad.TRANSACCION WHERE TRA_CODIGO = '".$Anticipo."' ";
				$result = mysqli_query($db,$query);
				while($row = mysqli_fetch_array($result))
				{
					$SaldoActual = $row["TRA_SALDO"];
				}

				$NuevoSaldo = $SaldoActual + $MontoFacturaRecibo;

				$sql = mysqli_query($db,"DELETE FROM Contabilidad.TRANSACCION WHERE TRA_CODIGO = '".$_GET["Codigo"]."'");
									
				if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
				{

					echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
							<h2 class="text-light">Lo sentimos, no se pudo eliminar la factura/recibo.</h2>
							<h4 class="text-light">Código de transacción: '.$_GET["Codigo"].'</h4>
						</div>';
					echo mysql_error($sql);
					$Centinela = false;
					
				}
				else
				{
					$sql = mysqli_query($db,"DELETE FROM Contabilidad.TRANSACCION_DETALLE WHERE TRA_CODIGO = '".$_GET["Codigo"]."'");

					if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
					{

						echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
								<h2 class="text-light">Lo sentimos, no se pudo eliminar la factura/recibo.</h2>
								<h4 class="text-light">Código de transacción: '.$_GET["Codigo"].', en detalle</h4>
							</div>';
						echo mysql_error($sql);
						$Centinela = false;
						
					}
				}

				if($Centinela == true)
				{
					$sql = mysqli_query($db,"UPDATE Contabilidad.TRANSACCION SET TRA_SALDO = ".$NuevoSaldo." WHERE TRA_CODIGO = '".$Anticipo."'");

					if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
					{
						echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
								<h2 class="text-light">Lo sentimos, no se pudo eliminar la factura/recibo.</h2>
								<h4 class="text-light">Código de transacción: '.$Anticipo.', actualizar saldo</h4>
							</div>';
						echo mysql_error($sql);
						$Centinela = false;
						
					}
				}
				echo '<input type="hidden" id="Anticipo" value="'.$Anticipo.'">';
				?>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>
	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
