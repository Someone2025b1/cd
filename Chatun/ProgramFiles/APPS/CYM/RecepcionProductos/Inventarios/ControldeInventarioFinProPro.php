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
								

								$QueryU = mysqli_query($db, "UPDATE Productos.CONTROL_INVENTARIO SET
								CI_FECHA_FINAL = CURRENT_DATE(),
								CI_HORA_FINAL = CURRENT_TIMESTAMP()
								WHERE CI_CODIGO = '$CodigoInventario'");


								$query = "SELECT * FROM Productos.CONTROL_INVENTARIO
								WHERE  CI_CODIGO = '$CodigoInventario'";
								$result = mysqli_query($db,$query);
								while($row = mysqli_fetch_array($result))
								{	

									$Punto       =  $row["PV_CODIGO"];
									$FechaInicio = $row["CI_FECHA_INICIO"];
									
									$HoraInicio        = $row["CI_HORA_INICIO"];
									$FechaFin = $row["CI_FECHA_FINAL"];
									$HoraFin      = $row["CI_HORA_FINAL"];
									


								}

								$FechaInicio = "2024-04-07";
								$HoraInicio = "19:00:00";
								$FechaFin = "2024-04-09";
								$HoraFin = "18:00:00";

                                for($i=0; $i<$Contador; $i++)
                                {
                                    $ProN = $ProductoNombre[$i]; 
                                    $Can = $Cantidad[$i];
                                    $Con = $Consignacion[$i];
                                    $ProductoXplotado = explode("/", $ProN);
                                    

                                    $Prod = $ProductoXplotado[0];


									########## Ventas ############

									$NomTitulo = mysqli_query($db, "SELECT KARDEX.*
									FROM Productos.KARDEX
									WHERE KARDEX.P_CODIGO = '".$Prod."'
									AND KARDEX.K_DESCRPCION LIKE '%Venta de Producto %'
									AND KARDEX.K_FECHA BETWEEN '$FechaInicio' AND '$FechaFin'
									AND KARDEX.K_PUNTO_VENTA =".$Punto);
									while($row1 = mysqli_fetch_array($NomTitulo))
									{

										$Fechak = $row1["K_FECHA"];
										$HoraK = $row1["K_HORA"];

										$Cantidadd=$row1["K_EXISTENCIA_ANTERIOR_PUNTO"]-$row1["K_EXISTENCIA_ACTUAL_PUNTO"];

										if($Fechak == $FechaInicio){

											if($HoraK >= $HoraInicio){

											$Ventas=$Ventas+$Cantidadd;

											}

										}elseif($Fechak == $FechaFin){

											if($HoraK <= $HoraFin){

												$Ventas=$Ventas+$Cantidadd;
	
												}
										}else{

											
											$Ventas=$Ventas+$Cantidadd;

										}
										

									}

									
                                  
									
									##########FIN##########
									
									########## Ingresos ############


									$NomTitulo = mysqli_query($db, "SELECT KARDEX.*
									FROM Productos.KARDEX
									WHERE KARDEX.P_CODIGO = '".$Prod."'
									AND KARDEX.K_DESCRPCION LIKE '%Envío de producto interno de BODEGA GENERAL %'
									AND KARDEX.K_FECHA  BETWEEN '$FechaInicio' AND '$FechaFin'
									AND KARDEX.K_PUNTO_VENTA =".$Punto);
									while($row1 = mysqli_fetch_array($NomTitulo))
											{
												$Fechak = $row1["K_FECHA"];
										$HoraK = $row1["K_HORA"];
												
											$Cantidadd=$row1["K_EXISTENCIA_ACTUAL_PUNTO"]-$row1["K_EXISTENCIA_ANTERIOR_PUNTO"];
												

											if($Fechak == $FechaInicio){

												if($HoraK >= $HoraInicio){
	
													$Traslados=$Traslados+$Cantidadd;
	
												}
	
											}elseif($Fechak == $FechaFin){
	
												if($HoraK <= $HoraFin){
	
													$Traslados=$Traslados+$Cantidadd;
		
													}
											}else{
	
												
												$Traslados=$Traslados+$Cantidadd;
	
											}

												
											}

									##########FIN##########
									
									########## Devoluciones ############

									$NomTitulo = mysqli_query($db, "SELECT KARDEX.*
									FROM Productos.KARDEX
									WHERE KARDEX.P_CODIGO = '".$Prod."'
									AND KARDEX.K_DESCRPCION LIKE '%Devolucion de Producto%'
									AND KARDEX.K_FECHA BETWEEN '$FechaInicio' AND '$FechaFin'
									AND KARDEX.K_PUNTO_VENTA =".$Punto);
									while($row1 = mysqli_fetch_array($NomTitulo))
											{
												
												$Fechak = $row1["K_FECHA"];
										$HoraK = $row1["K_HORA"];
											$Cantidadd=$row1["K_EXISTENCIA_ACTUAL_PUNTO"]-$row1["K_EXISTENCIA_ANTERIOR_PUNTO"];
												
											if($Fechak == $FechaInicio){

												if($HoraK >= $HoraInicio){
	
													$Devoluciones=$Devoluciones+$Cantidadd;
	
												}
	
											}elseif($Fechak == $FechaFin){
	
												if($HoraK <= $HoraFin){
	
													$Devoluciones=$Devoluciones+$Cantidadd;
		
													}
											}else{
	
												
												$Devoluciones=$Devoluciones+$Cantidadd;
	
											}
											

												
											}

									##########FIN##########

									########## Conteo Anterio ############

									$query = "SELECT * FROM Productos.CONTROL_INVENTARIO_DETALLE
									WHERE  CI_CODIGO = '$CodigoInventario'
									AND P_CODIGO = '".$Prod."'";
									$result = mysqli_query($db,$query);
									while($row = mysqli_fetch_array($result))
									{	

										$ContFecha1       =  $row["CID_CONTEO_FECHA1"];
										$Consig1 = $row["CID_CONSIGNACION1"];
										
										$ContAnterior = $ContFecha1+$Consig1;
										

									}

									##########FIN##########

											$Sistema = $ContAnterior+$Traslados-$Ventas-$Con+$Devoluciones;

										

											$Diferencia = $Can-$Sistema;



									$QueryDetalle = mysqli_query($db, "UPDATE Productos.CONTROL_INVENTARIO_DETALLE SET
									CID_CONTEO_FECHA2 = '".$Can."',
									CID_CONSIGNACION2 = '".$Con."',
									CID_INGRESO = '".$Traslados."',
									CID_VENTA   = '".$Ventas."',
									CID_DEVOLUCIONES = '".$Devoluciones."',
									CID_SISTEMA = '".$Sistema."',
									CID_DIFERENCIA = '".$Diferencia."'
									WHERE CI_CODIGO = '".$CodigoInventario."'
									AND P_CODIGO = '".$Prod."'");

									$Traslados=0;
									$Ventas=0;
									$Devoluciones=0;
									$Sistema=0;

									
									
									
                                    
                                }

								if(!$NomTitulo) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
								{

									echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo Agregar el Control de Inventario.</h2>
											
											</div>';
									
									
								}
								else
								{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">Se Agrego Correctamente '.$Fechak.'</h2>
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
