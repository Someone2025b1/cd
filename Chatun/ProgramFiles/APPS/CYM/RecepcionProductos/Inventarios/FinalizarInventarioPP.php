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

								$CodEN         =$_GET["Codigo"];


								$Reconteo = $_GET["Reconteo"];
								$CodReconteo = uniqid("EPDDR_");

								


							$querysa = "SELECT EX_PUNTOS_PEQUENOS_DET.*
                            FROM Productos.EX_PUNTOS_PEQUENOS_DET
                            WHERE EX_PUNTOS_PEQUENOS_DET.EPDD_ESTADO = 0
                            AND EX_PUNTOS_PEQUENOS_DET.EPPD_CODIGO = '$CodEN'";
							$resultsa = mysqli_query($db, $querysa);
							while($rowe = mysqli_fetch_array($resultsa))
							{
								$Pro = $rowe['P_CODIGO'];
								$Diferencia = $rowe['EPDD_DIFERENCIA'];
								$CAN = $rowe['EPPD_VENTA']+$rowe['EPPD_CONCILIACION']-$rowe['EPPD_DEVOLUCIONES']-$rowe['EPDD_DIFERENCIA'];
								
								$CAN = $rowe["EPPD_CONTEO"];
								$Punto=$rowe['EPDD_PUNTO'];
								
								if($rowe['EPDD_PUNTO']=="Kiosco Azados"){
									$querypr = "SELECT * FROM Productos.EX_PUNTOS_PEQUENOS WHERE P_CODIGO = ".$Pro;
									$resultpr = mysqli_query($db, $querypr);
									while($rowpr = mysqli_fetch_array($resultpr))
									{
										$AnteriorEx=$rowpr["EPP_ANTERIOR_KIOSCO"];
										$ExistenciaActual=$rowpr["EPP_KIOSCO"];
										#$ExistenciaNueva=$rowpr["EPP_KIOSCO"]-$CAN;
										$ExistenciaNueva=$CAN;
										$UltimoIngreso=$rowpr["EPP_ULTIMO_KIOSCO"];
										$UltimaFecha=$rowpr["EPP_FECHA_KIOSCO"];
									}
                                }elseif($rowe['EPDD_PUNTO']=="Mirador"){
									$querypr = "SELECT * FROM Productos.EX_PUNTOS_PEQUENOS WHERE P_CODIGO = ".$Pro;
									$resultpr = mysqli_query($db, $querypr);
									while($rowpr = mysqli_fetch_array($resultpr))
									{
										$AnteriorEx=$rowpr["EPP_ANTERIOR_MIRADOR"];
										$ExistenciaActual=$rowpr["EPP_MIRADOR"];
										#$ExistenciaNueva=$rowpr["EPP_MIRADOR"]-$CAN;
										$ExistenciaNueva=$CAN;
										$UltimoIngreso=$rowpr["EPP_ULTIMO_MIRADOR"];
										$UltimaFecha=$rowpr["EPP_FECHA_MIRADOR"];
									}
                                }

								
                                ################################ ACUALIZAR ############

                                if($Reconteo=="SI"){

                                if($Diferencia!=0){

                                    $querykardex2 = mysqli_query($db, "INSERT INTO Productos.EX_PUNTOS_PEQUENOS_DET (EPPD_CODIGO, EPPD_FECHA, P_CODIGO, EPDD_PUNTO, EPDD_ESTADO)
										VALUES('".$CodReconteo."',  CURRENT_DATE(), '".$Pro."', '".$Punto."', 2)");
                                    

                                }else{

                                    if($rowe['EPDD_PUNTO']=="Kiosco Azados"){

                                        $QueryPU = mysqli_query($db, "UPDATE Productos.EX_PUNTOS_PEQUENOS SET
                                            EPP_FECHA_AJUSTE_KIOSCO = CURRENT_DATE(),
                                            EPP_KIOSCO = '".$ExistenciaNueva."'
                                            WHERE P_CODIGO = ".$Pro);
    
                                    }elseif($rowe['EPDD_PUNTO']=="Mirador"){
    
                                        $QueryPU = mysqli_query($db, "UPDATE Productos.EX_PUNTOS_PEQUENOS SET
                                            EPP_FECHA_AJUSTE_MIRADOR = CURRENT_DATE(),
                                            EPP_MIRADOR = '".$ExistenciaNueva."'
                                            WHERE P_CODIGO = ".$Pro);
                                    }

                                }

                            }elseif($Reconteo=="NO"){

                                if($rowe['EPDD_PUNTO']=="Kiosco Azados"){

                                    $QueryPU = mysqli_query($db, "UPDATE Productos.EX_PUNTOS_PEQUENOS SET
                                        EPP_FECHA_AJUSTE_KIOSCO = CURRENT_DATE(),
                                        EPP_KIOSCO = '".$ExistenciaNueva."'
                                        WHERE P_CODIGO = ".$Pro);

                                }elseif($rowe['EPDD_PUNTO']=="Mirador"){

                                    $QueryPU = mysqli_query($db, "UPDATE Productos.EX_PUNTOS_PEQUENOS SET
                                        EPP_FECHA_AJUSTE_MIRADOR = CURRENT_DATE(),
                                        EPP_MIRADOR = '".$ExistenciaNueva."'
                                        WHERE P_CODIGO = ".$Pro);
                                }

                            }

                                
										

                                    
                        
	


									$QueryEstado = mysqli_query($db, "UPDATE Productos.EX_PUNTOS_PEQUENOS_DET SET
										EPDD_ESTADO = 1
										WHERE EPPD_CODIGO = '$CodEN' 
										AND P_CODIGO = ".$Pro);
									
	
														

							}

							$QueryEN = mysqli_query($db, "UPDATE Productos.EX_PUNTOS_ENVIOS SET EPE_ESTADO = 1, EPE_FECHA_RECIBE = CURRENT_DATE() WHERE EPE_CODIGO = '$CodEN'");


							if(!$querysa)
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
								<h2 class="text-light">El Envio se Recibió Correctamente .</h2>
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
