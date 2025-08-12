<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
			<div class="container">
				<?php
					$FechaApertura = $_POST["Fecha"];
					$MontoInicial  = $_POST["MontoInicial"];
					$ACC           = uniqid('ACC_'); 
					$BQ200 = $_POST["BQ200"];
					$BQ100 = $_POST["BQ100"];
					$BQ50  = $_POST["BQ50"];
					$BQ20  = $_POST["BQ20"];
					$BQ10  = $_POST["BQ10"];
					$BQ5   = $_POST["BQ5"];
					$BQ1   = $_POST["BQ1"];
					$MQ1   = $_POST["MQ1"];
					$MQ50  = $_POST["MQ50"];
					$MQ25  = $_POST["MQ25"];
					$MQ10  = $_POST["MQ10"];
					$MQ5   = $_POST["MQ5"];
					$TCQ   = $_POST["TCQ"];

					$ConteoApertura = mysqli_num_rows(mysqli_query($db, "SELECT *FROM Bodega.APERTURA_CIERRE_CAJA a  
					WHERE a.ACC_FECHA = CURDATE() AND a.ACC_TIPO = 8 "));
					$Apertura = mysqli_fetch_array(mysqli_query($db, "SELECT *FROM Bodega.APERTURA_CIERRE_CAJA a  
					WHERE a.ACC_FECHA = CURDATE() AND a.ACC_TIPO = 8 "));
					if($ConteoApertura > 0)
					{
						$sql1 = mysqli_query($db,"INSERT INTO Bodega.APERTURA_DETALLE (ACC_CODIGO, CD_Q_200, CD_Q_100, CD_Q_50, CD_Q_20, CD_Q_10, CD_Q_5, CD_Q_1, CD_M_1, CD_M_50, CD_M_25, CD_M_10, CD_M_5, CD_TOTAL_Q, CD_USUARIO)
							VALUES ('".$Apertura["ACC_CODIGO"]."', ".$BQ200.", ".$BQ100.", ".$BQ50.", ".$BQ20.", ".$BQ10.", ".$BQ5.", ".$BQ1.", ".$MQ1.", ".$MQ50.", ".$MQ25.", ".$MQ10.", ".$MQ5.", ".$TCQ.", ".$id_user.")") or die(mysqli_error());
					}
					else
					{
					$sql = mysqli_query($db,"INSERT INTO Bodega.APERTURA_CIERRE_CAJA (ACC_CODIGO, ACC_FECHA, ACC_TIPO, ACC_SALDO_INICIAL, ACC_SALDO_FINAL, ACC_ESTADO, ACC_HORA_APERTURA, ACC_USUARIO_APERTURA) 
										VALUES ('".$ACC."', '".$FechaApertura."', 8, ".$MontoInicial.", 0.00, 1, CURRENT_TIMESTAMP(), ".$id_user.")");
					$sql1 = mysqli_query($db,"INSERT INTO Bodega.APERTURA_DETALLE (ACC_CODIGO, CD_Q_200, CD_Q_100, CD_Q_50, CD_Q_20, CD_Q_10, CD_Q_5, CD_Q_1, CD_M_1, CD_M_50, CD_M_25, CD_M_10, CD_M_5, CD_TOTAL_Q, CD_USUARIO)
							VALUES ('".$ACC."', ".$BQ200.", ".$BQ100.", ".$BQ50.", ".$BQ20.", ".$BQ10.", ".$BQ5.", ".$BQ1.", ".$MQ1.", ".$MQ50.", ".$MQ25.", ".$MQ10.", ".$MQ5.", ".$TCQ.", ".$id_user.")") or die(mysqli_error());
					} 
					 
					if($sql)
					{
						echo '<div class="col-lg-12 text-center">
						<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
						<h2 class="text-light">La apertura de caja se ingresó correctamente.</h2>
						</div>';
					}
					else
					{
						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
							<h2 class="text-light">Lo sentimos, no se pudo procesar la apertura de caja.</h2>
						</div>';
					}
				?>
			</div>
		</div><!--end #content-->
		<!-- END CONTENT -->
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>


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
	<script src="../../../../../libs/alertify/js/alertify.js"></script>

	<!-- END JAVASCRIPT -->
</body>
</html>
