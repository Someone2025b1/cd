<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
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
	
    <script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php 
		$Cantidad  = $_POST["Cantidad"];
		$Consignacion  = $_POST["Consignacion"];
        $ProductoNombre = $_POST["ProductoNombre"];
        $Uid      = uniqid("CI_");
        $UidD      = uniqid("CID_");
        $Contador  = count($_POST["Cantidad"]);
		$Bodega    = $_POST["Bodega"];
		
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Períodos Contables</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<form action="PCModPro.php" method="POST">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Consulta de Periodos Contables</strong></h4>
						</div>
						<div class="card-body">
							<?php
								$sql1 = mysqli_query($db, "INSERT INTO Productos.CONTROL_INVENTARIO (CI_CODIGO, PV_CODIGO, CI_FECHA_INICIO, CI_HORA_INICIO)
                                VALUES ('".$Uid."', ".$Bodega.",CURRENT_DATE(), CURRENT_TIMESTAMP())");

                                for($i=1; $i<$Contador; $i++)
                                {
                                    $ProN = $ProductoNombre[$i]; 
                                    $Can = $Cantidad[$i];
                                    $Con = $Consignacion[$i];
                                    $ProductoXplotado = explode("/", $ProN);
                                    

                                    $Prod = $ProductoXplotado[0];

                                    $sql2 = mysqli_query($db, "INSERT INTO Productos.CONTROL_INVENTARIO_DETALLE (CI_CODIGO, CID_CODIGO, P_CODIGO, CID_CONTEO_FECHA1, CID_CONSIGNACION1)
                                VALUES ('".$Uid."', '".$UidD."', ".$Prod.", ".$Can.", ".$Con.")");
                                    
                                }

								if(!$sql1) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
								{

									echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo Agregar el COntrol de Inventario.</h2>
											
											</div>';
									
									
								}
								else
								{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">Se Agrego Correctamente</h2>
											<div class="row">
												<div class="col-lg-12 text-center"><a href="ControldeInventario.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
											</div>';					
								}
							?>
						</div>
					</div>
					</form>
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
