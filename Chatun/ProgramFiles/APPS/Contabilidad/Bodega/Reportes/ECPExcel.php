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


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" action="ECPImp.php" method="POST" role="form" target="_blank" id="FormularioExcel">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Existencia de Productos</strong></h4>
							</div>
							<div class="card-body">
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th><strong>Código</strong></th>
											<th><strong>Nombre</strong></th>
											<th><strong>Unidad de Medida</strong></th>
											<th><strong>Cantidad</strong></th>
											<th><strong>Costo Unitario</strong></th>
											<th><strong>Costo Total</strong></th>
										</tr>
									</thead>
									<tbody>
										<?php

										$FechaIni = $_GET["FechaInicio"];
$FechaFin = $_GET["FechaFin"];
$Bodega   = $_GET["Bodega"];

$FechaFinal = date('Y-m-d', strtotime($FechaIni."-1 day"));

$TotalActivo = 0;
$TotalPasivo = 0;

										//QUERY PARA TRAER TODO EL MOVIMIENTO DE LAS CUENTAS EN EL RANGO DE FECHAS SELECCIONADO
										$QueryCuentas = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE 
										                FROM Bodega.PRODUCTO, Bodega.UNIDAD_MEDIDA 
										                WHERE PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
										                GROUP BY PRODUCTO.P_NOMBRE ORDER BY PRODUCTO.P_NOMBRE";
										$ResultCuentas = mysqli_query($db, $QueryCuentas);
										while($row = mysqli_fetch_array($ResultCuentas))
										{
										    $ExistenciaMost = 0;
										    $Producto = $row["P_CODIGO"];
										    $ProductoNombre = utf8_decode($row["P_NOMBRE"]);
										    $UnidadMedida = $row["UM_NOMBRE"];

										    if($row["CP_CODIGO"] == 'TR')
										    {
										        $query = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO` ) AS `CARGOS`, SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_PRODUCTO` ) AS `ABONOS`
										        FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
										        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
										        AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
										        AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
										        AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
										        $rest = mysqli_query($db, $query);
										        while($fila = mysqli_fetch_array($rest))
										        {
										            $Existencia = $fila["CARGOS"] - $fila["ABONOS"];
										            $ExistenciaMost = number_format($Existencia, 4, '.', ',');
										            
										            $QueryCosto = "SELECT SUM(`TRANSACCION_DETALLE`.`TRAD_SUBTOTAL`) AS COSTO_TOTAL, SUM(`TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO`) AS TOTAL_ENTRADAS
										                FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
										                WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
										                AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
										                AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
										                AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '2016/01/01' AND '".$FechaFin."'";
										            $ResCosto = mysqli_query($db, $QueryCosto);
										            while($filacosto = mysqli_fetch_array($ResCosto))
										            {
										                $CostoTotal = $filacosto["COSTO_TOTAL"];
										                $Entradas = $filacosto["TOTAL_ENTRADAS"];
										            }

										            $CostoUnitario = $CostoTotal / $Entradas;
										            $CostoUnitarioMostrar = number_format($CostoUnitario, 4, '.', ',');

										            $CostoTotal2 = $Existencia * $CostoUnitario;
										            $CostoTotalMostrar = number_format($CostoTotal2, 4, '.', ',');

										            $CostoTotalSumaTR = $CostoTotalSumaTR + $CostoTotal2;

										            if($Existencia != 0)
										            {
										            	?>
										            	<tr>
										            		<td><?php echo  $Producto?></td>
										            		<td><?php echo  $ProductoNombre?></td>
										            		<td><?php echo  $UnidadMedida?></td>
										            		<td><?php echo  $ExistenciaMost?></td>
										            		<td><?php echo  $CostoUnitarioMostrar?></td>
										            		<td><?php echo  $CostoTotalMostrar?></td>
										            	</tr>
										                
										                <?php
										            }
										            
										        }   
										    }
										    elseif($row["CP_CODIGO"] == 'SV')
										    {
										        $query = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO` ) AS `CARGOS`, SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_PRODUCTO` ) AS `ABONOS`
										        FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
										        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
										        AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
										        AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
										        AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
										        $rest = mysqli_query($db, $query);
										        while($fila = mysqli_fetch_array($rest))
										        {
										            $Existencia = $fila["CARGOS"] - $fila["ABONOS"];
										            $ExistenciaMost = number_format($Existencia, 4, '.', ',');
										            
										            $QueryCosto = "SELECT SUM(`TRANSACCION_DETALLE`.`TRAD_SUBTOTAL`) AS COSTO_TOTAL, SUM(`TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO`) AS TOTAL_ENTRADAS
										                FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
										                WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
										                AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
										                AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
										                AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '2016/01/01' AND '".$FechaFin."'";
										            $ResCosto = mysqli_query($db, $QueryCosto);
										            while($filacosto = mysqli_fetch_array($ResCosto))
										            {
										                $CostoTotal = $filacosto["COSTO_TOTAL"];
										                $Entradas = $filacosto["TOTAL_ENTRADAS"];
										            }

										            $CostoUnitario = $CostoTotal / $Entradas;
										            $CostoUnitarioMostrar = number_format($CostoUnitario, 4, '.', ',');

										            $CostoTotal2 = $Existencia * $CostoUnitario;
										            $CostoTotalMostrar = number_format($CostoTotal2, 4, '.', ',');

										            $CostoTotalSumaSV = $CostoTotalSumaSV + $CostoTotal2;

										            if($Existencia != 0)
										            {
										                $DataSV[] = array('col1'=>$Producto, 'col2'=>$ProductoNombre, 'col3'=>$UnidadMedida, 'col4'=>$ExistenciaMost, 'col5'=>$CostoUnitarioMostrar, 'col6'=>$CostoTotalMostrar);
										            }
										            
										        }   
										    }
										    if($row["CP_CODIGO"] == 'HS')
										    {
										        $query = "SELECT SUM( `TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO` ) AS `CARGOS`, SUM( `TRANSACCION_DETALLE`.`TRAD_ABONO_PRODUCTO` ) AS `ABONOS`
										        FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
										        WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
										        AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
										        AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
										        AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '".$FechaIni."' AND '".$FechaFin."'";
										        $rest = mysqli_query($db, $query);
										        while($fila = mysqli_fetch_array($rest))
										        {
										            $Existencia = $fila["CARGOS"] - $fila["ABONOS"];
										            $ExistenciaMost = number_format($Existencia, 4, '.', ',');
										            
										            $QueryCosto = "SELECT SUM(`TRANSACCION_DETALLE`.`TRAD_SUBTOTAL`) AS COSTO_TOTAL, SUM(`TRANSACCION_DETALLE`.`TRAD_CARGO_PRODUCTO`) AS TOTAL_ENTRADAS
										                FROM `Bodega`.`TRANSACCION_DETALLE` AS `TRANSACCION_DETALLE`, `Bodega`.`TRANSACCION` AS `TRANSACCION` 
										                WHERE `TRANSACCION_DETALLE`.`TRA_CODIGO` = `TRANSACCION`.`TRA_CODIGO` 
										                AND `TRANSACCION`.`B_CODIGO` = ".$Bodega."
										                AND `TRANSACCION_DETALLE`.`P_CODIGO` = ".$Producto."
										                AND `TRANSACCION`.`TRA_FECHA_TRANS` BETWEEN '2016/01/01' AND '".$FechaFin."'";
										            $ResCosto = mysqli_query($db, $QueryCosto);
										            while($filacosto = mysqli_fetch_array($ResCosto))
										            {
										                $CostoTotal = $filacosto["COSTO_TOTAL"];
										                $Entradas = $filacosto["TOTAL_ENTRADAS"];
										            }

										            $CostoUnitario = $CostoTotal / $Entradas;
										            $CostoUnitarioMostrar = number_format($CostoUnitario, 4, '.', ',');

										            $CostoTotal2 = $Existencia * $CostoUnitario;
										            $CostoTotalMostrar = number_format($CostoTotal2, 4, '.', ',');

										            $CostoTotalSumaHS = $CostoTotalSumaHS + $CostoTotal2;

										            if($Existencia != 0)
										            {
										                $DataHS[] = array('col1'=>$Producto, 'col2'=>$ProductoNombre, 'col3'=>$UnidadMedida, 'col4'=>$ExistenciaMost, 'col5'=>$CostoUnitarioMostrar, 'col6'=>$CostoTotalMostrar);
										            }
										            
										        }   
										    }

										    
										}

										?>
									</tbody>
								</table>
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

		<!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Resultados de su búsqueda</h2>
                    </div>
                    <div class="modal-body">
                    	<div id="suggestions" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
