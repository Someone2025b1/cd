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

								$CodEN         =$_POST["Codigo"];

								$KCod         =uniqid('KR_');

								$Envia = $_POST["Envia"];


							$querysa = "SELECT ENVIOS_DETALLE.*, ENVIOS.EN_CODIGO FROM Productos.ENVIOS_DETALLE, Productos.ENVIOS WHERE ENVIOS.EN_CODIGO = ENVIOS_DETALLE.EN_CODIGO AND ENVIOS.EN_ESTADO <> 2 AND ENVIOS_DETALLE.EN_CODIGO = '$CodEN'";
							$resultsa = mysqli_query($db, $querysa);
							while($rowe = mysqli_fetch_array($resultsa))
							{
								$Pro = $rowe['P_CODIGO'];
								$CAN = $rowe['END_CANTIDAD'];

								if($Envia=="CAFE LOS ABUELOS"){
									$querypr = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO = ".$Pro;
									$resultpr = mysqli_query($db, $querypr);
									while($rowpr = mysqli_fetch_array($resultpr))
									{
										$existenciabode=$rowpr["P_EXISTENCIA_CAFE"];
										$newcantbo=$rowpr["P_EXISTENCIA_CAFE"]-$CAN;
										$newcantsou=$rowpr["P_EXISTENCIA_BODEGA"]+$CAN;
										$existenciasou=$rowpr["P_EXISTENCIA_BODEGA"];
										$existenciagen=$rowpr["P_EXISTENCIA_GENERAL"];
										$ponderado = $rowpr["P_PRECIO_COMPRA_PONDERADO"];
									}
	
									$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
														P_EXISTENCIA_CAFE = '".$newcantbo."',
														P_EXISTENCIA_BODEGA = '".$newcantsou."'
														WHERE P_CODIGO = ".$Pro);
	
														$Pun=4;
	
	
									}elseif($Envia=="TERRAZAS"){
	
										$querypr = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO = ".$Pro;
									$resultpr = mysqli_query($db, $querypr);
									while($rowpr = mysqli_fetch_array($resultpr))
									{
										$existenciabode=$rowpr["P_EXISTENCIA_TERRAZAS"];
										$newcantbo=$rowpr["P_EXISTENCIA_TERRAZAS"]-$CAN;
										$newcantsou=$rowpr["P_EXISTENCIA_BODEGA"]+$CAN;
										$existenciasou=$rowpr["P_EXISTENCIA_BODEGA"];
										$existenciagen=$rowpr["P_EXISTENCIA_GENERAL"];
										$ponderado = $rowpr["P_PRECIO_COMPRA_PONDERADO"];
									}
	
									$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
														P_EXISTENCIA_TERRAZAS = '".$newcantbo."',
														P_EXISTENCIA_BODEGA = '".$newcantsou."'
														WHERE P_CODIGO = ".$Pro);
	
	
														$Pun=1;
	
	
									}elseif($Envia=="HELADOS"){
	
										$querypr = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO = ".$Pro;
									$resultpr = mysqli_query($db, $querypr);
									while($rowpr = mysqli_fetch_array($resultpr))
									{
										$existenciabode=$rowpr["P_EXISTENCIA_HELADOS"];
										$newcantbo=$rowpr["P_EXISTENCIA_HELADOS"]-$CAN;
										$newcantsou=$rowpr["P_EXISTENCIA_BODEGA"]+$CAN;
										$existenciasou=$rowpr["P_EXISTENCIA_BODEGA"];
										$existenciagen=$rowpr["P_EXISTENCIA_GENERAL"];
										$ponderado = $rowpr["P_PRECIO_COMPRA_PONDERADO"];
									}
	
									$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
														P_EXISTENCIA_HELADOS = '".$newcantbo."',
														P_EXISTENCIA_BODEGA = '".$newcantsou."'
														WHERE P_CODIGO = ".$Pro);
	
	
														$Pun=3;
	
	
									}elseif($Envia=="SOUVENIR"){
	
										$querypr = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO = ".$Pro;
									$resultpr = mysqli_query($db, $querypr);
									while($rowpr = mysqli_fetch_array($resultpr))
									{
										$existenciabode=$rowpr["P_EXISTENCIA_SOUVENIRS"];
										$newcantbo=$rowpr["P_EXISTENCIA_SOUVENIRS"]-$CAN;
										$newcantsou=$rowpr["P_EXISTENCIA_BODEGA"]+$CAN;
										$existenciasou=$rowpr["P_EXISTENCIA_BODEGA"];
										$existenciagen=$rowpr["P_EXISTENCIA_GENERAL"];
										$ponderado = $rowpr["P_PRECIO_COMPRA_PONDERADO"];
									}
	
									$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
														P_EXISTENCIA_SOUVENIRS = '".$newcantbo."',
														P_EXISTENCIA_BODEGA = '".$newcantsou."'
														WHERE P_CODIGO = ".$Pro);
	
	
														$Pun=2;
	
	
									}
	
									$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO, K_COSTO_ANTERIOR, K_COSTO_ENTRO, K_COSTO_PONDERADO)
									VALUES('".$KCod."', '".$CodEN."', '".$Pro."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Envío de producto interno de ".$Envia." a Café LOs Abuelos', '".$existenciagen."', '".$existenciagen."', 5, '".$existenciasou."', '".$newcantsou."', '-', '-', '-')");
	
									$querykardex2 = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO, K_COSTO_ANTERIOR, K_COSTO_ENTRO, K_COSTO_PONDERADO)
									VALUES('".$KCod."', '".$CodEN."', '".$Pro."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Envío de producto interno de ".$Envia." a Café Los Abuelos', '".$existenciagen."', '".$existenciagen."', '".$Pun."', '".$existenciabode."', '".$newcantbo."', '-', '-', '".$ponderado."')");
	
								}
	
								$QueryEN = mysqli_query($db, "UPDATE Productos.ENVIOS SET EN_ESTADO = 2, EN_FECHA_RECIBE = CURRENT_DATE() WHERE EN_CODIGO = '$CodEN'");
							if(!$QueryEN)
							{
								echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
										<h4 class="text-light">Código de transacción: '.$CodEN.'</h4>
									</div>';
								echo mysqli_error($sq, $query);
								$Centinela = false;
								
							}

							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El Envio se Recibió Correctamente.</h2>
								<div class="row">
									<div class="col-lg-6 text-left"><a href="PedidosPendientes.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
							</div>';
									
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
