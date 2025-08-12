<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<?php
					$UI             = uniqid('tra_');
					$UID            = uniqid('trad_');
					$Contador       = count($_POST["Cuenta"]);
					$Centinela      = true;
					
					$CIFSolicitante = $_POST["CIFSolicitante"];
					$AutorizaGasto  = $_POST["AutorizaGasto"];
					$AreaGasto      = $_POST["AreaGasto"];
					$Descripcion    = $_POST["Descripcion"];
					$TotalAnticipo  = $_POST["TotalAnticipo"];
					$Correlativo  = $_POST["Correlativo"];
					
					$Cuenta         = $_POST["Cuenta"];
					$Cargos         = $_POST["Cargos"];
					$Abonos         = $_POST["Abonos"];
					$Razon          = $_POST["Razon"];

					if(isset($_POST["Inventario"]))
					{
						$Inventario = 1;
					}
					else
					{
						$Inventario = 0;
					}


					$sql = mysqli_query($db,"INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_SOLICITA_GASTO, TRA_AUTORIZA_GASTO, TRA_AREA_GASTO, TRA_CONCEPTO, TRA_TOTAL, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TT_CODIGO, TRA_SALDO, TRA_NO_ANTICIPO, TRA_A_INVENTARIO, TRA_ESTADO_INVENTARIO)
						VALUES('".$UI."', CURRENT_DATE(), ".$CIFSolicitante.", ".$AutorizaGasto.", ".$AreaGasto.", '".$Descripcion."', ".$TotalAnticipo.", CURRENT_DATE(), CURRENT_TIMESTAMP(), ".$id_user .", 1, 10, ".$TotalAnticipo.", ".$Correlativo.", ".$Inventario.", 1)");

					if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
					{
						echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
								<h2 class="text-light">Lo sentimos, no se pudo ingresar la solicitud de anticipo.</h2>
								<h4 class="text-light">Código de transacción: '.$UI.'</h4>
							</div>';
		
						echo mysql_error($sql);
						$Centinela = false;
						
					}
					else
					{
						for($i=1; $i<$Contador; $i++)
						{
							$Cue = $Cuenta[$i];
							$Car = $Cargos[$i];
							$Abo = $Abonos[$i];
							$Raz = $Razon[$i];

							$Xplotado = explode("/", $Cue);
							$NCue = $Xplotado[0];

							$query = mysqli_query($db,"INSERT INTO Contabilidad.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA, TRAD_RAZON)
												VALUES('".$UID."', '".$UI."', '".$NCue."', ".$Car.", ".$Abo.", '".$Raz."')");

							if(!$query)
							{
								echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo ingresar la solicitud de anticipo.</h2>
										<h4 class="text-light">Código de transacción: '.$UID.'</h4>
									</div>';
								echo mysql_error($query);
								$Centinela = false;
								
							}	
						}	

						if($Centinela == true)
						{
							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
									<h2 class="text-light">La solicitud se ingresó correctamente.</h2>
									<div class="row">
										<div class="col-lg-6 text-right"><a href="SAImp.php?Codigo='.$UI.'" target="_blank"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>
										<div class="col-lg-6 text-left"><a href="SA.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
									</div>';
						}
					}

				?>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
