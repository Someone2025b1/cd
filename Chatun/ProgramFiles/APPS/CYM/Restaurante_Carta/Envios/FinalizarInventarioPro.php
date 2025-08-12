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
        $Contador  = count($_POST["Cantidad"]);
		$Bodega    = $_POST["Bodega"];
		$CodigoInventario = $_POST["Codigo"];
		$CodFin = uniqid("EPPD_");


		


	$Traslados = 0;
	$Ventas = 0;
	$Devoluciones = 0;
    
		
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Control de Intventarios</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<form action="PCModPro.php" method="POST">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Consulta de Periodos Contables</strong></h4>
						</div>
						<div class="card-body">
							<?php

                                for($i=0; $i<$Contador; $i++)
                                {
                                    $ProN = $ProductoNombre[$i]; 
                                    $Can = $Cantidad[$i];
                                    $Con = $Consignacion[$i];
                                    $ProductoXplotado = explode("/", $ProN);
                                    

                                    $Prod = $ProductoXplotado[0];

									########## Conteo Anterio ############

									$query = "SELECT * FROM Productos.EX_PUNTOS_PEQUENOS
									WHERE  P_CODIGO = '".$Prod."'";
									$result = mysqli_query($db,$query);
									while($row = mysqli_fetch_array($result))
									{	

										if($row["EPP_FECHA_MIRADOR"]>$row["EPP_FECHA_AJUSTE_MIRADOR"]){

											$FechaInicio =  $row["EPP_FECHA_MIRADOR"];

										}else{
											$FechaInicio =  $row["EPP_FECHA_AJUSTE_MIRADOR"];
										}

										
										$AnteriorEx=$row["EPP_ANTERIOR_MIRADOR"];
										$ExistenciaActual=$row["EPP_MIRADOR"];
										$UltimoIngreso=$row["EPP_ULTIMO_MIRADOR"];

										
										

									}
									$FechaFin=date("Y-m-d");
									#$FechaInicio = "2024-03-31";

									##########FIN##########


									if(is_null($FechaInicio)){
										$Ventas = 0;
										$Devoluciones = 0;
									}else{

									########## Ventas ############

									$NomTitulo = mysqli_query($db, "SELECT KARDEX.*
									FROM Productos.KARDEX
									WHERE KARDEX.P_CODIGO = '".$Prod."'
									AND KARDEX.K_DESCRPCION LIKE '%Venta de Producto Segun Factura de Restaurante Mirador%'
									AND KARDEX.K_FECHA BETWEEN '$FechaInicio' AND '$FechaFin'
									AND KARDEX.K_PUNTO_VENTA = 1");
									while($row1 = mysqli_fetch_array($NomTitulo))
									{

										

										$Cantidadd=$row1["K_EXISTENCIA_ANTERIOR_PUNTO"]-$row1["K_EXISTENCIA_ACTUAL_PUNTO"];

										

											
											$Ventas=$Ventas+$Cantidadd;

										
										

									}

									
                                  
									
									##########FIN##########

									########## Devoluciones ############

									$NomTitulo = mysqli_query($db, "SELECT KARDEX.*
									FROM Productos.KARDEX
									WHERE KARDEX.P_CODIGO = '".$Prod."'
									AND KARDEX.K_DESCRPCION LIKE '%Devolucion de Producto Segun Factura Anulada de Restaurante Mirador%'
									AND KARDEX.K_FECHA BETWEEN '$FechaInicio' AND '$FechaFin'
									AND KARDEX.K_PUNTO_VENTA = 1");
									while($row1 = mysqli_fetch_array($NomTitulo))
											{

											$Cantidadd=$row1["K_EXISTENCIA_ACTUAL_PUNTO"]-$row1["K_EXISTENCIA_ANTERIOR_PUNTO"];

											$Devoluciones=$Devoluciones+$Cantidadd;
	
											
											

												
											}

									##########FIN##########
									
										}
									


										
											$TotalSistema=$Can+$Ventas+$Con-$Devoluciones;
											$Diferencia = $TotalSistema-$ExistenciaActual;



											$querykardex2 = mysqli_query($db, "INSERT INTO Productos.EX_PUNTOS_PEQUENOS_DET (EPPD_CODIGO, EPPD_FECHA, P_CODIGO, EPPD_CONTEO, EPPD_CONCILIACION, EPPD_VENTA, EPPD_DEVOLUCIONES, EPDD_EX_ANTERIOR, EPDD_DIFERENCIA, EPDD_PUNTO)
											VALUES('".$CodFin."', CURRENT_DATE(), '".$Prod."', '".$Can."', '".$Con."', '".$Ventas."', '".$Devoluciones."', '".$ExistenciaActual."', '".$Diferencia."', 'Mirador')");



										#$QueryPU = mysqli_query($db, "UPDATE Productos.EX_PUNTOS_PEQUENOS SET
										#EPP_ANTERIOR_MIRADOR = '".$ExistenciaActual."'
										#EPP_FECHA_AJUSTE_MIRADOR = CURRENT_DATE(),
										#EPP_MIRADOR = '".$Can."'
										#WHERE P_CODIGO = ".$Prod);

										

									$Ventas=0;
									$Devoluciones=0;


									
									
									
                                    
                                }

								if(!$querykardex2) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
								{

									echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo Agregar el Control de Inventario '.$FechaFin.'.</h2>
											
											</div>';
									
									
								}
								else
								{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">Se Agrego Correctamente '.$FechaInicio.'</h2>
											<div class="row">
												
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
