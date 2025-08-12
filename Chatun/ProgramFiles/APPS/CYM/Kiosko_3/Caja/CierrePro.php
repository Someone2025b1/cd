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
					
					$BD100 = $_POST["BD100"];
					$BD50  = $_POST["BD50"];
					$BD20  = $_POST["BD20"];
					$BD10  = $_POST["BD10"];
					$BD5   = $_POST["BD5"];
					$BD1   = $_POST["BD1"];
					$TCD   = $_POST["TCD"];
					
					$BL500 = $_POST["BL500"];
					$BL100 = $_POST["BL100"];
					$BL50  = $_POST["BL50"];
					$BL20  = $_POST["BL20"];
					$BL10  = $_POST["BL10"];
					$BL5   = $_POST["BL5"];
					$TCL   = $_POST["TCL"];

					$CodigoCierre = $_POST["CodigoCierre"];

					$TotalDolares = 7.50 * $TCD;
					$TotalLempiras = 0.34 * $TCL;
					$TipoCierre = $_POST["TipoCierre"];
					$TotalGeneral = $TCQ + $TotalDolares + $TotalLempiras;

					$Cont = mysqli_num_rows(mysqli_query($db, "SELECT *FROM Bodega.CIERRE_DETALLE  a WHERE a.ACC_CODIGO = '$CodigoCierre'"));

					if ($TipoCierre==2 && $Cont > 0) 
					{ 
					$sql = mysqli_query($db,"UPDATE Bodega.APERTURA_CIERRE_CAJA SET ACC_SALDO_FINAL = ".$TotalGeneral.", ACC_ESTADO = 2, ACC_HORA_CIERRE = CURRENT_TIME(), ACC_USUARIO_CIERRE = ".$id_user." WHERE ACC_CODIGO = '".$CodigoCierre."'") or die(mysqli_error());
					} 

					elseif ($TipoCierre==2 && $Cont == 0) 
					{

					$sql = mysqli_query($db,"UPDATE Bodega.APERTURA_CIERRE_CAJA SET ACC_SALDO_FINAL = ".$TotalGeneral.", ACC_ESTADO = 2, ACC_HORA_CIERRE = CURRENT_TIME(), ACC_USUARIO_CIERRE = ".$id_user." WHERE ACC_CODIGO = '".$CodigoCierre."'") or die(mysqli_error());
					
					$sql1 = mysqli_query($db,"INSERT INTO Bodega.CIERRE_DETALLE (ACC_CODIGO, CD_Q_200, CD_Q_100, CD_Q_50, CD_Q_20, CD_Q_10, CD_Q_5, CD_Q_1, CD_M_1, CD_M_50, CD_M_25, CD_M_10, CD_M_5, CD_TOTAL_Q, CD_D_100, CD_D_50, CD_D_20, CD_D_10, CD_D_5, CD_D_1, CD_TOTAL_D, CD_L_500, CD_L_100, CD_L_50, CD_L_20, CD_L_10, CD_L_5, CD_TOTAL_L, CD_USUARIO)
							VALUES ('".$CodigoCierre."', ".$BQ200.", ".$BQ100.", ".$BQ50.", ".$BQ20.", ".$BQ10.", ".$BQ5.", ".$BQ1.", ".$MQ1.", ".$MQ50.", ".$MQ25.", ".$MQ10.", ".$MQ5.", ".$TCQ.", ".$BD100.", ".$BD50.", ".$BD20.", ".$BD10.", ".$BD5.", ".$BD1.", ".$TCD.", ".$BL500.", ".$BL100.", ".$BL50.", ".$BL20.", ".$BL10.", ".$BL5.", ".$TCL.", ".$id_user.")") or die(mysqli_error());
					}
				    elseif ($TipoCierre==1)
					{ 
						
						$sql = mysqli_query($db,"INSERT INTO Bodega.CIERRE_DETALLE (ACC_CODIGO, CD_Q_200, CD_Q_100, CD_Q_50, CD_Q_20, CD_Q_10, CD_Q_5, CD_Q_1, CD_M_1, CD_M_50, CD_M_25, CD_M_10, CD_M_5, CD_TOTAL_Q, CD_D_100, CD_D_50, CD_D_20, CD_D_10, CD_D_5, CD_D_1, CD_TOTAL_D, CD_L_500, CD_L_100, CD_L_50, CD_L_20, CD_L_10, CD_L_5, CD_TOTAL_L, CD_USUARIO)
							VALUES ('".$CodigoCierre."', ".$BQ200.", ".$BQ100.", ".$BQ50.", ".$BQ20.", ".$BQ10.", ".$BQ5.", ".$BQ1.", ".$MQ1.", ".$MQ50.", ".$MQ25.", ".$MQ10.", ".$MQ5.", ".$TCQ.", ".$BD100.", ".$BD50.", ".$BD20.", ".$BD10.", ".$BD5.", ".$BD1.", ".$TCD.", ".$BL500.", ".$BL100.", ".$BL50.", ".$BL20.", ".$BL10.", ".$BL5.", ".$TCL.", ".$id_user.")");
						

						
					} 

					if($sql)
					{
						echo '<div class="col-lg-12 text-center">
						<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
						<h2 class="text-light">El cierre de caja se ingresó correctamente.</h2>
						</div>';
					}
					else
					{
						echo '<div class="col-lg-12 text-center">
							<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
							<h2 class="text-light">Lo sentimos, no se pudo procesar el cierre de caja.</h2>
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
