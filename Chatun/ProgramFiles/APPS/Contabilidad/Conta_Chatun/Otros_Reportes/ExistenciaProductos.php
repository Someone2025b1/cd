<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$FechaIni = $_POST["FechaInicio"]; 
$FechaFin = $_POST["FechaFin"]; 
$tipodereporte = $_POST["TipoReporte"];
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
	<script src="../../../../../libs/bootstrap-table/js/bootstrap-table.min.js"></script>
	<script src="../../../../../libs/bootstrap-table/1.11.1/extensions/export/bootstrap-table-export.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/tableExport.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/es6-promise/es6-promise.auto.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/pdfmake/pdfmake.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/bootstrap-table/css/bootstrap-table.min.css">
	<link type="text/css" rel="stylesheet" href="../../../../../libs/bootstrap-table/1.11.1/extensions/filter-control/bootstrap-table-filter-control.css">
	<!-- END STYLESHEETS -->

	


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php 

		include("../../../../MenuTop.php") ;




	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container-fluid">
				<form class="form" role="form" id="FRMReporte" action="#">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>PRECIO PRODUCTOS</strong></h4>
							</div>
							<div class="card-body">
								<?php
								?>
								<table class="table table-hover table-condensed" id="table"
                                   data-toggle="table"
                                   data-toolbar="#toolbar"
                                   data-toggle-pagination="true"
                                   data-show-export="true"
                                   data-icons-prefix="fa"
                                   data-icons="icons"
                                   data-pagination="false"
                                   data-sortable="true"
                                   data-search="true"
                                   data-filter-control="true">
									<thead>
										<tr>
											<th data-sortable="true" data-field="CONTEO" data-filter-control="input"><h6><strong>NO.</strong></h6></th>
                                            <th data-sortable="true" data-field="CODIGO" data-filter-control="input"><h6><strong>CODIGO</strong></h6></th>
											<th data-sortable="true" data-field="NOMBRE" data-filter-control="input"><h6><strong>NOMBRE</strong></h6></th>
											<th data-sortable="true" data-field="PRECIO" data-filter-control="input"><h6><strong>PRECIO</strong></h6></th>
											<th data-sortable="true" data-field="BODEGA" data-filter-control="input"><h6><strong>BODEGA</strong></h6></th> 
										</tr>
									</thead>
									<tbody>
										<?php
                                            $cont=0;
											$consulta = "SELECT A.P_NOMBRE, A.P_CODIGO, A.P_PRECIO, A.CP_CODIGO, A.P_CODIGO_SUBRECETA
											FROM Bodega.PRODUCTO AS A 
											WHERE A.P_PRECIO > 0 
											AND A.P_NOMBRE <> '0'
											AND  A.P_NOMBRE <> '1'
											AND  A.P_NOMBRE <> '.'
											AND  A.P_NOMBRE <> '..'
											AND  A.P_NOMBRE <> '...'
											ORDER BY A.P_NOMBRE";
                                            $result = mysqli_query($db, $consulta);
											while($FilaDetalle = mysqli_fetch_array($result))
											{
												
											    $cont=$cont+1;
											    ?>
													<tr>
                                                        <td align="lefth" ><?php echo $cont?></td> 
													    <td align="lefth"><?php echo $FilaDetalle["P_CODIGO"] ?></td> 
													    <td align="center"><?php echo $FilaDetalle["P_NOMBRE"] ?></td> 
													    <td align="lefth"><?php echo $FilaDetalle["P_PRECIO"] ?></td>
													    <td align="center"><?php echo $FilaDetalle["CP_CODIGO"] ?></td> 
													   </tr>
											    <?php

											}
 
											$consulta = "SELECT A.RS_NOMBRE, A.RS_CODIGO, A.RS_PRECIO, A.RS_BODEGA
											FROM Bodega.RECETA_SUBRECETA AS A 
											WHERE A.RS_PRECIO > 0 
											ORDER BY A.RS_NOMBRE";
                                            $result = mysqli_query($db, $consulta);
											while($FilaDetalle = mysqli_fetch_array($result))
											{
												
											    $cont=$cont+1;
											    ?>
													<tr>
                                                        <td align="lefth" ><?php echo $cont?></td> 
													    <td align="lefth"><?php echo $FilaDetalle["RS_CODIGO"] ?></td> 
													    <td align="center"><?php echo $FilaDetalle["RS_NOMBRE"] ?></td> 
													    <td align="lefth"><?php echo $FilaDetalle["RS_PRECIO"] ?></td>
													    <td align="center"><?php echo $FilaDetalle["RS_BODEGA"] ?></td> 
													   </tr>
											    <?php

											}
 
										?>
									</tbody>

								</table>
							</div>
						</div>
					</div>
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
