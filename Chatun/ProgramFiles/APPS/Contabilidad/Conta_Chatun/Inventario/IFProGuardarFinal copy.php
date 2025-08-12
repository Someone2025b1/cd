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

								#Codigo Notas de Cargo y Abono Para obtener dato de la existencia real a fin de mes
								$Cargo = uniqid('NC_');
								$Abono = uniqid('NA_');
								
								#Codigos de los registros de Kardex
								$KCod  =uniqid('KR_');
								$KCodR  =uniqid('KR_');

								#Codigo Notas de Cargo y Abono que modifica la cantidad real de las existencias
								$CargoR = uniqid('NC_');
								$AbonoR = uniqid('NA_');

								#Codigo Detalle Notas de Cargo y Abono Para obtener dato de la existencia real a fin de mes
								$CargoD = uniqid('NCD_');
								$AbonoD = uniqid('NAD_');

								#Codigo Detalle Notas de Cargo y Abono que modifica la cantidad real de las existencias
								$CargoDR = uniqid('NDC_');
								$AbonoDR = uniqid('NAD_');
								
								#Variabvles del formulario
								$Codigo        = $_POST["Codigo"];
								$CodigoConteo  = $_POST["CodigoConteo"];
								$Punto         = $_POST["Bodega"];
								$Fisico        = $_POST["Fisico"];
								$FechaConteo   = $_POST["FechaConteo"];
								$Real          = $_POST["Real"];
								$Bodega        = $_POST["Bodega"];
								$Contador      = count($Codigo);


								#Actualización del estado del conteo realizado
								$QueryDetalle = mysqli_query($db, "UPDATE Productos.INVENTARIO SET
													I_ESTADO = 2
													WHERE I_CODIGO = '$CodigoConteo'");

								
								

								#recorrido de los datos para almacenar detalles
								for($i=0; $i<$Contador; $i++)
								
								{
									$Cod = $Codigo[$i];
									$Can = $Fisico[$i];
									$Rea = $Real[$i];

									#consuta de Producto para obtener los datos
									$querypr = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO = ".$Cod;
									$resultpr = mysqli_query($db, $querypr);
									while($rowpr = mysqli_fetch_array($resultpr))
									{
										if($Punto==2){
											$newcantsou=$rowpr["P_EXISTENCIA_SOUVENIRS"]+$Can;
											$existenciasou=$rowpr["P_EXISTENCIA_SOUVENIRS"];
										}

										if($Punto==5){
											$newcantsou=$rowpr["P_EXISTENCIA_BODEGA"]+$Can;
											$existenciasou=$rowpr["P_EXISTENCIA_BODEGA"];
										}

										if($Punto==3){
											$newcantsou=$rowpr["P_EXISTENCIA_HELADOS"]+$Can;
											$existenciasou=$rowpr["P_EXISTENCIA_HELADOS"];
										}

										if($Punto==4){
											$newcantsou=$rowpr["P_EXISTENCIA_CAFE"]+$Can;
											$existenciasou=$rowpr["P_EXISTENCIA_CAFE"];
										}
							
										if($Punto==1){
											$newcantsou=$rowpr["P_EXISTENCIA_TERRAZAS"]+$Can;
											$existenciasou=$rowpr["P_EXISTENCIA_TERRAZAS"];
										}
							
							
										
										$existenciagen=$rowpr["P_EXISTENCIA_GENERAL"];
										$existenciagennew=$rowpr["P_EXISTENCIA_GENERAL"]+$Can;


										$Ponderado = $rowpr["P_PRECIO_COMPRA_PONDERADO"];
										
									}
									
									#Actualización de las existencias del producto
									if($Punto==1){
										$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
															P_EXISTENCIA_GENERAL = '".$existenciagennew."',
															P_EXISTENCIA_TERRAZAS = '".$newcantsou."'
															WHERE P_CODIGO = ".$Cod);
	
										}

									if($Punto==2){
									$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
														P_EXISTENCIA_GENERAL = '".$existenciagennew."',
														P_EXISTENCIA_SOUVENIRS = '".$newcantsou."'
														WHERE P_CODIGO = ".$Cod);

									}

									if($Punto==3){
										$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
															P_EXISTENCIA_GENERAL = '".$existenciagennew."',
															P_EXISTENCIA_HELADOS = '".$newcantsou."'
															WHERE P_CODIGO = ".$Cod);
	
										}

										if($Punto==4){
											$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
																P_EXISTENCIA_GENERAL = '".$existenciagennew."',
																P_EXISTENCIA_CAFE = '".$newcantsou."'
																WHERE P_CODIGO = ".$Cod);
		
											}

									if($Punto==5){
										$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
															P_EXISTENCIA_GENERAL = '".$existenciagennew."',
															P_EXISTENCIA_BODEGA = '".$newcantsou."'
															WHERE P_CODIGO = ".$Cod);
	
										}


									#Para Obtener la Canrtidad contada modificada
									$Conteo=$Rea+$Can;
									
									#Condicion para saber si es Cargo o Abono
									if($Can<0){
										$Cantidad=($Can * (-1));
										$SubTotalAbono=$Cantidad*$Ponderado;
										$TotalAbono+=$SubTotalAbono;
										
									
										#Rergistro de Kardex constancia de modificación de existencia
									$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO, K_COSTO_ANTERIOR, K_COSTO_ENTRO, K_COSTO_PONDERADO)
									VALUES('".$KCodR."', '".$AbonoR."', '".$Cod."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Nota de Abono Automatica', '".$existenciagen."', '".$existenciagennew."', '".$Bodega."', '".$existenciasou."', '".$newcantsou."', '-', '-', '-')");

										#Registro de Kardex para Dato Final
									$querykardexDato = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO, K_COSTO_ANTERIOR, K_COSTO_ENTRO, K_COSTO_PONDERADO)
									VALUES('".$KCod."', '".$Abono."', '".$Cod."', '".$FechaConteo."', '22:00:00', 'Nota de Abono Automatica Conteo FInal', 0, 0, '".$Bodega."', '".$Rea."', '".$Conteo."', '-', '-', '-')");
									

										#Nota de Abono Detalle 
									$AbonoDetalle = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO_DETALLE (NCA_CODIGO, NCAD_CODIGO, P_CODIGO, NCAD_CANTIDAD, NCAD_COSTO, NCAD_SUBTOTAL)
									VALUES('".$Abono."', '".$AbonoD."', '".$Cod."', '".$Cantidad."', '".$Ponderado."', '".$SubTotalAbono."')");

									$AbonooDetalleR = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO_DETALLE (NCA_CODIGO, NCAD_CODIGO, P_CODIGO, NCAD_CANTIDAD, NCAD_COSTO, NCAD_SUBTOTAL)
									VALUES('".$AbonoR."', '".$AbonoDR."', '".$Cod."', '".$Cantidad."', '".$Ponderado."', '".$SubTotalAbono."')");

									
									}elseif($Can>0){

										$SubTotalCargo=$Can*$Ponderado;
										$TotalCargo+=$SubTotalCargo;
									
										#Rergistro de Kardex constancia de modificación de existencia
									$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO, K_COSTO_ANTERIOR, K_COSTO_ENTRO, K_COSTO_PONDERADO)
									VALUES('".$KCodR."', '".$CargoR."', '".$Cod."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Nota de Cargo Automatica', '".$existenciagen."', '".$existenciagennew."', '".$Bodega."', '".$existenciasou."', '".$newcantsou."', '-', '-', '-')");

										#Registro de Kardex para Dato Final
									$querykardexDato = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO, K_COSTO_ANTERIOR, K_COSTO_ENTRO, K_COSTO_PONDERADO)
									VALUES('".$KCod."', '".$Cargo."', '".$Cod."', '".$FechaConteo."', '22:00:00', 'Nota de Cargo Automatica Conteo Final', 0, 0, '".$Bodega."', '".$Rea."', '".$Conteo."', '-', '-', '-')");


										#Notas de Cargo
									$CargoDetalle = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO_DETALLE (NCA_CODIGO, NCAD_CODIGO, P_CODIGO, NCAD_CANTIDAD, NCAD_COSTO, NCAD_SUBTOTAL)
									VALUES('".$Cargo."', '".$CargoD."', '".$Cod."', '".$Can."', '".$Ponderado."', '".$SubTotalCargo."')");

									$CanrgoDetalleR = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO_DETALLE (NCA_CODIGO, NCAD_CODIGO, P_CODIGO, NCAD_CANTIDAD, NCAD_COSTO, NCAD_SUBTOTAL)
									VALUES('".$CargoR."', '".$CargoRD."', '".$Cod."', '".$Can."', '".$Ponderado."', '".$SubTotalCargo."')");

									
									}
								
								
	
							}

							#Notas de Cargo y Abono

							$InsertarCargo = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO (NCA_CODIGO, NCA_FECHA, NCA_HORA, NCA_TOTAL, PV_CODIGO, NCA_DESCRIPCION, NCA_CARGO, NCA_ABONO)
								VALUES('".$Cargo."', '".$FechaConteo."', '22:00:00', '".$TotalCargo."', '".$Bodega."', 'Nota de Cargo Automatica Conteo Final de Mes', 1, 0)");

							$InsertarAbono = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO (NCA_CODIGO, NCA_FECHA, NCA_HORA, NCA_TOTAL, PV_CODIGO, NCA_DESCRIPCION, NCA_CARGO, NCA_ABONO)
							VALUES('".$Abono."', '".$FechaConteo."', '22:00:00', '".$TotalAbono."', '".$Bodega."', 'Nota de Abono Automatica Conteo Final de Mes', 0, 1)");

							
							$InsertarCargoR = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO (NCA_CODIGO, NCA_FECHA, NCA_HORA, NCA_TOTAL, PV_CODIGO, NCA_DESCRIPCION, NCA_CARGO, NCA_ABONO)
							VALUES('".$CargoR."', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$TotalCargo."', '".$Bodega."', 'Nota de Cargo Automatica Ajuste de Existencias', 1, 0)");

							$InsertarAbonoR = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO (NCA_CODIGO, NCA_FECHA, NCA_HORA, NCA_TOTAL, PV_CODIGO, NCA_DESCRIPCION, NCA_CARGO, NCA_ABONO)
							VALUES('".$AbonoR."', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$TotalAbono."', '".$Bodega."', 'Nota de Abono Automatica Ajuste de Existencias', 0, 1)");

								

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
