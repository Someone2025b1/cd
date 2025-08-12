<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");


$cont = 0;
$fecha_inicio = $_POST["FechaInicio"];
$fecha_fin = $_POST["FechaFin"];
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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

   

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Lista y Detalle de la Producción de Sub recetas</strong><br></h1>
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
                        FROM Productos.PRODUCCION_SUBRECETA AS A
                        WHERE A.PR_PUNTO = 'HELADOS' 
						AND A.PR_FECHA BETWEEN '$fecha_inicio' AND '$fecha_fin' ORDER BY A.PR_FECHA ";
                        $Resultado = mysqli_query($db, $Consulta);
                        while($row = mysqli_fetch_array($Resultado))
                        {

                            $CodigoProduccion = $row["PR_CODIGO"];

                            $Consulta1 = "SELECT B.PRD_CANTIDAD_M, B.PRD_CANTIDAD_P, C.P_NOMBRE
                                                    FROM Productos.PRODUCCION_SUBRECETA_DETALLE AS B, Productos.PRODUCTO AS C
                                                    WHERE B.PR_CODIGO = '$CodigoProduccion'
                                                    AND B.P_CODIGO = C.P_CODIGO";
                                                    $Resultado1= mysqli_query($db, $Consulta1);
                                                    while($row1 = mysqli_fetch_array($Resultado1))
                                                    {
                                                        if($row1["PRD_CANTIDAD_P"]>0)
                                                        $NombreProducto=$row1["P_NOMBRE"];
                                                    }

                        

                      
                        ?>
                    <div class="card panel">
								<div class="card-head style-<?php echo $Colores[$Color]; ?> collapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-<?php echo $CONT; ?>" aria-expanded="false">
									<header>Producción de <?php echo $NombreProducto." Fecha: ".$row["PR_FECHA"]; ?></header>
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
															<td><h5><b>PRODUCTO</b></h5></td>
															<td><h5><b>CANTIDAD USADA</b></h5></td>
															<td><h5><b>CANTIDAD PRODUCIDA</b></h5></td>
														</tr>
                                                        <?php
                                                    $Consulta1 = "SELECT B.PRD_CANTIDAD_M, B.PRD_CANTIDAD_P, C.P_NOMBRE
                                                    FROM Productos.PRODUCCION_SUBRECETA_DETALLE AS B, Productos.PRODUCTO AS C
                                                    WHERE B.PR_CODIGO = '$CodigoProduccion'
                                                    AND B.P_CODIGO = C.P_CODIGO";
                                                    $Resultado1= mysqli_query($db, $Consulta1);
                                                    while($row1 = mysqli_fetch_array($Resultado1))
                                                    {

                                                      ?>
														<tr>
															<td><h5><b><?php echo $row1["P_NOMBRE"]; ?></b></h5></td>
															<td><h5><b><?php echo $row1["PRD_CANTIDAD_M"]; ?></b></h5></td>
															<td><h5><b><?php echo $row1["PRD_CANTIDAD_P"]; ?></b></h5></td>
														</tr>
														

                                                        <?php
                                                        
                                                    }
                                                        ?>
														 
													</tbody>
												</table>

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
