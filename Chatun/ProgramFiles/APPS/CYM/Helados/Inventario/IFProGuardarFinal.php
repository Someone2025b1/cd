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
				<form class="form" action="IFProPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Conteo de Inventario Físico</strong></h4>
							</div>
							<div class="card-body">
								<?php
								
								$Codigo        = $_POST["Codigo"];
								$CodigoConteo  = $_POST["CodigoConteo"];
								$Fisico        = $_POST["Fisico"];
								$Contador      = count($Codigo);


								$QueryDetalle = mysqli_query($db, "UPDATE Productos.INVENTARIO SET
													I_FECHA = CURRENT_DATE(),
													I_HORA = CURRENT_TIMESTAMP(),
													I_USER = '".$id_user."',
													I_ESTADO = 1
													WHERE I_CODIGO = '$CodigoConteo'");


								for($i=0; $i<$Contador; $i++)
								{
									$Cod = $Codigo[$i];
									$Can = $Fisico[$i];

									


								$querypr = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO = ".$Cod;
								$resultpr = mysqli_query($db, $querypr);
								while($rowpr = mysqli_fetch_array($resultpr))
								{

									$existenciasou=$rowpr["P_EXISTENCIA_HELADOS"];

									$diferencia=$Can-$existenciasou;
								}
								

									
									$QueryDetalle = mysqli_query($db, "UPDATE Productos.INVENTARIO_DETALLE SET
													ID_CANTIDAD_CONTADA = '".$Can."',
													ID_CANTIDAD_SISTEMA = '".$existenciasou."',
													ID_DIFERENCIA = '".$diferencia."'
													WHERE I_CODIGO = '$CodigoConteo'
													AND P_CODIGO = ".$Cod);
							}
									
								

								if($QueryDetalle)
								{
									echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
									<h2 class="text-light">El conteo se ingresó correctamente.</h2>
									</div>';
								}
								else
								{
									echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo procesar el conteo. '.$CodigoConteo.'</h2>
									</div>';
								}

								?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
