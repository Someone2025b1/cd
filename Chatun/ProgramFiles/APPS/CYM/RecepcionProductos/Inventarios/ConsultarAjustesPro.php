<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");


$cont = 0;
$fecha_inicio = $_POST["FechaInicio"];
$fecha_fin = $_POST["FechaFin"];
$Punto = $_POST["Bodega"];
$contatemp = 0;

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

	<script>
	function EnviarForm(x)
	{
		var Formulario = $('#FormularioEnviar');
        $(Formulario).attr('action', 'ConsultarAjustesPro.php');
        $(Formulario).submit();
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

   

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Lista y Detalle de Evios <?php echo $Punto; ?></strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
                    <div class="container"> 
					<div class="col-lg-12">
						<div class="panel-group" id="accordion6">
                        <?php
                        $Colores = ["info", "success", "danger", "warning", "primary"];
                        $Color=0;
                        $CONT=1;
                        $Consulta = "SELECT A.*
                        FROM Productos.EX_PUNTOS_PEQUENOS_DET AS A
                        WHERE A.EPDD_PUNTO = '$Punto' AND A.EPPD_FECHA BETWEEN '$fecha_inicio' AND '$fecha_fin'
						GROUP BY A.EPPD_CODIGO
						ORDER BY A.EPPD_FECHA";
                        $Resultado = mysqli_query($db, $Consulta);
                        while($row = mysqli_fetch_array($Resultado))
                        {

                            $CodigoEnvio = $row["EPPD_CODIGO"];
                            $Fecha1 = $row["EPPD_FECHA"];
                            $Estado = $row["EPDD_ESTADO"];

                            

                        

                      
                        ?>
                    <div class="card panel">
								<div class="card-head style-<?php echo $Colores[$Color]; ?> collapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-<?php echo $CONT; ?>" aria-expanded="false">
									<header>Envío de <?php echo $Fecha1; ?></header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-<?php echo $CONT; ?>" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<?php 	
														
											?> 	
												<table class="table table-hover table-condensed">
													<tbody>
                                                    <tr>
															<td><h5><b>Codigo</b></h5></td>
															<td><h5><b>Producto</b></h5></td>
															<td><h5><b>Conteo</b></h5></td>
															<td><h5><b>Consiganación</b></h5></td>
															<td><h5><b>Venta</b></h5></td>
															<td><h5><b>Devoluciones</b></h5></td>
															<td><h5><b>Existencia Anterior</b></h5></td>
															<td><h5><b>Diferenccia</b></h5></td>
														</tr>
                                                        <?php
														$totprod=0;
														$totusad=0;
                                                    $Consulta1 = "SELECT B.*, C.P_NOMBRE
                                                    FROM Productos.EX_PUNTOS_PEQUENOS_DET AS B, Productos.PRODUCTO AS C
                                                    WHERE B.EPPD_CODIGO = '$CodigoEnvio'
                                                    AND B.P_CODIGO = C.P_CODIGO";
                                                    $Resultado1= mysqli_query($db, $Consulta1);
                                                    while($row1 = mysqli_fetch_array($Resultado1))
                                                    {

														$TotalFecha1=$row1["CID_CONTEO_FECHA1"]+$row1["CID_CONSIGNACION1"];
														$DiferenciaConteo=$TotalFecha1-$row1["CID_CONTEO_FECHA2"];
														$totusad+=$subUsada;
														$totprod+=$subProdu;
                                                      ?>
														<tr>
															<td><h5><b><?php echo $row1["P_CODIGO"]; ?></b></h5></td>
															<td><h5><b><?php echo $row1["P_NOMBRE"]; ?></b></h5></td>
															<td><h5><b><?php echo number_format($row1["EPPD_CONTEO"], 2, '.', ','); ?></b></h5></td>
															<td><h5><b><?php echo number_format($row1["EPPD_CONCILIACION"], 2, '.', ','); ?></b></h5></td>
															<td><h5><b><?php echo number_format($row1["EPPD_VENTA"], 2, '.', ','); ?></b></h5></td>
															<td><h5><b><?php echo number_format($row1["EPPD_DEVOLUCIONES"], 2, '.', ','); ?></b></h5></td>
															<td><h5><b><?php echo number_format($row1["EPDD_EX_ANTERIOR"], 2, '.', ','); ?></b></h5></td>
															<td <?php if($row1["EPDD_DIFERENCIA"]>0){ echo 'style="color: green;"';}elseif($row1["EPDD_DIFERENCIA"]==0){ echo 'style="color: black;"';}else{echo 'style="color: red;"';} ?>><h5><b><?php echo number_format($row1["EPDD_DIFERENCIA"], 2, '.', ','); ?></b></h5></td>
															</tr>
														

                                                        <?php
                                                        
                                                    }

													?>
														
														 
													</tbody>
												</table>

												<?php
												if($Estado==0){

													?>

											<a href="FinalizarInventarioPP.php?Codigo=<?php echo $CodigoEnvio.'&Reconteo=SI'; ?>"><button type="button" class="btn btn-warning">
																										Enviar Reconteo
													</button></a>

													<a href="FinalizarInventarioPP.php?Codigo=<?php echo $CodigoEnvio.'&Reconteo=NO'; ?>"><button type="button" class="btn btn-danger">
																										Ajustar
													</button></a>
													
													<?php
												}

													?>

											</div>
										</div>
									</div>
								</div>
							</div><!--end .panel -->

                            <?php

                             $NombreProducto="NO INGRESARON PRODUCCION";
                            $CONT=$CONT+1;

                            if($Color==4){
                                $Color=0;
                            }else{
                                $Color++;
                            }
                        }
                            ?>
					</div>
				</div>
			</div>
            </div>
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
