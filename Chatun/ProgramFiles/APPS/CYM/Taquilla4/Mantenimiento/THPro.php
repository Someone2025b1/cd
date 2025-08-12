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
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

	<script language=javascript type=text/javascript>
		$(document).on("keypress", 'form', function (e) {
		    var code = e.keyCode || e.which;
		    if (code == 13) {
		        e.preventDefault();
		        return false;
		    }
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
				<form class="form" action="THPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Asignar un Talonario de Ticket a Hotel</strong></h4>
							</div>
							<div class="card-body">
								<?php
									$Hotel = $_POST["Hotel"];
									$Del = $_POST["Del"];
									$Al = $_POST["Al"];
									$TipoTalonario = $_POST["TipoTalonario"];
									$Validar = mysqli_num_rows(mysqli_query($db, "SELECT *FROM Taquilla.ASIGNACION_TALONARIO_TICKET a WHERE a.ATT_DEL = $Del AND a.ATT_AL = $Al AND a.ATT_ESTADO = 0"));
									$CodigoID = uniqid();
									if ($Validar>0) 
									{
										echo '<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
												<h2 class="text-light">Lo sentimos, no se pudo asignar el talonario. Ya existe!</h2>
											</div>'; 
									}
									else
									{
									$Query = mysqli_query($db, "INSERT INTO Taquilla.ASIGNACION_TALONARIO_TICKET (ATT_CODIGO, ATT_DEL, ATT_AL, H_CODIGO, ATT_COLABORADOR, ATT_FECHA, ATT_HORA, ATT_ESTADO)
															VALUE('".$CodigoID."', '".$Del."', '".$Al."', '".$Hotel."', '".$id_user."', CURRENT_DATE(), CURRENT_TIME(), 0)") or die(mysqli_error($Query));
									$Total = 0;
									$Total = ($Al - $Del) + 1;

									$Numero = $Del;
									for ($i=0; $i < $Total; $i++) { 
										 $Numero = $Del + $i;
										 $InsertVale = mysqli_query($db, "INSERT INTO Taquilla.DETALLE_ASIGNACION_VALE (ATT_CODIGO, DAV_VALE, H_CODIGO)
										 VALUE ('$CodigoID', $Numero, $Hotel) ");
									}

									if($Query)
									{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">El Talonario se asignó correctamente.</h2>
											<div class="row">
												<div class="col-lg-12 text-center"><a href="TH.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
										</div>';

									}
									else
									{
										echo '<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
												<h2 class="text-light">Lo sentimos, no se pudo asignar el talonario.</h2>
											</div>';
										echo mysqli_error($sql);
										
									}
									}
								?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../../Hotel/MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
