<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$UserID = $_SESSION["iduser"];
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
				<form class="form" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Pedido de Producto a Bodega o Punto de Ventas</strong></h4>
							</div>
							<div class="card-body">
							<?php
							#ESTO ES DE LA POLIZA, ingresa a transación y detallle de transacción
								$CodEN         =uniqid('Pe_');
								$CodEND         =uniqid('PeD_');
								$Centinela    = true;

                                $Contador     = count($_POST["Cantidad"]);
								$Cantidad  = $_POST["Cantidad"];
								$DescripcionProd  = $_POST["DescripcionProd"];
                                $FechaNecesidad    = $_POST["FechaNecesidad"];
                                $Descripcion    = $_POST["Descripcion"];
								$Producto  = $_POST["ProductoNombre"];
								$ProductoNombre = $_POST["ProductoNombre"];
                                $Total=$_POST["TotalFacturaFinal"];
                                
								$Contador2  = count($_POST["ProductoNombre"]);



								$QueryEncabezado = mysqli_query($db, "INSERT INTO CompraVenta.PEDIDO_INVENTARIO (PI_CODIGO, PI_ESTADO, PI_FECHA_PEDIDO, PI_HORA_PEDIDO, PI_FECHA_NECESIDAD, PI_DESCRIPCION, PI_USUARIO, PI_TOTAL_PRODUCTOS)
																VALUES ('".$CodEN."', 1, CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$FechaNecesidad."', '".$Descripcion."', '".$UserID."', '".$Total."')");

								

								if(!$QueryEncabezado)
								{
									echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
											<h4 class="text-light">Código de transacción: '.$CodEN.'</h4>
										</div>';
									echo mysqli_error($sq, $query);
									$Centinela = false;
									
								}
								else
								{
									for($j=1; $j<$Contador; $j++)
									{
										$ProN = $ProductoNombre[$j]; 
										$Can = $Cantidad[$j];
										$Des = $DescripcionProd[$j];
										$Pro = $Producto[$j];
										$ProductoXplotado = explode("/", $Pro);

										$Prod = $ProductoXplotado[0];
										$ProdNom=  $ProductoXplotado[1];

										

										$queryd = mysqli_query($db, "INSERT INTO CompraVenta.PEDIDO_INVENTARIO_DETALLE (PI_CODIGO, PID_CODIGO, PID_ESTADO, PID_CODIGO_PRODUCTO, PID_NOMBRE, PID_CANTIDAD, PID_DESCRIPCION)
															VALUES('".$CodEN."', '".$CodEND."', 1, '".$Prod."', '".$ProdNom."', '".$Can."', '".$Des."')");
										
								}	
                            }
								
								
								if($Centinela == true)
									{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">El Pedido Fue Realizado</h2>
											<div class="row">
												<div class="col-lg-6 text-right"><a href="IngresoImp.php?Codigo='.$UI.'" target="_blank"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>
												<div class="col-lg-6 text-left"><a href="NewFac.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
										</div>';
									}
							?>
							</div>
						</div>
					</div>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>
	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
