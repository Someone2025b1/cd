<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
include("../../../Script/funciones.php");
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
	<script src="../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../js/core/source/App.js"></script>
	<script src="../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../js/core/source/AppCard.js"></script>
	<script src="../../../js/core/source/AppForm.js"></script>
	<script src="../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../js/core/source/AppVendor.js"></script>
	<script src="../../../js/core/demo/Demo.js"></script>
	<script src="../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../libs/alertify/js/alertify.js"></script>
	<script src="../../../libs/bootstrap-table/js/bootstrap-table.min.js"></script>
	<script src="../../../libs/bootstrap-table/1.11.1/extensions/export/bootstrap-table-export.js"></script>
	<script src="../../../libs/tableExport.jquery.plugin-master/tableExport.min.js"></script>
	<script src="../../../libs/tableExport.jquery.plugin-master/libs/es6-promise/es6-promise.auto.min.js"></script>
	<script src="../../../libs/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.min.js"></script>
	<script src="../../../libs/tableExport.jquery.plugin-master/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
	<script src="../../../libs/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
	<script src="../../../libs/tableExport.jquery.plugin-master/libs/pdfmake/pdfmake.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../css/jquery-ui.css" />
	<link type="text/css" rel="stylesheet" href="../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../libs/bootstrap-table/css/bootstrap-table.min.css">
	<link type="text/css" rel="stylesheet" href="../../../libs/bootstrap-table/1.11.1/extensions/filter-control/bootstrap-table-filter-control.css">
	<!-- END STYLESHEETS -->


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php 

        include("../../MenuTop.php") ;




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
								<h4 class="text-center"><strong>COLABORADORES</strong></h4>
							</div>
							<div class="card-body">
							<div align="left">
								<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
							</div> <br>
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
                                            <th data-sortable="true" data-field="NOMBRE" data-filter-control="input"><h6><strong>NOMBRE</strong></h6></th>
											<th data-sortable="true" data-field="CIF" data-filter-control="input"><h6><strong>CIF</strong></h6></th>
											<th data-sortable="true" data-field="PUESTO" data-filter-control="input"><h6><strong>PUESTO</strong></h6></th>
											<th data-sortable="true" data-field="ESTADO" data-filter-control="input"><h6><strong>ESTADO</strong></h6></th> 
										</tr>
									</thead>
									<tbody>
										<?php
                                            $cont=0;
											$consulta = "SELECT A.primer_nombre, A.segundo_nombre, A.tercer_nombre, A.primer_apellido, A.segundo_apellido, A.cif, B.puesto, C.estado
											FROM info_colaboradores.datos_generales AS A 
											JOIN info_colaboradores.datos_laborales AS B ON A.cif = B.cif 
											JOIN info_colaboradores.estado AS C ON B.estado = C.id_estado 
											";
                                            $result = mysqli_query($db, $consulta);
											while($FilaDetalle = mysqli_fetch_array($result))
											{
												$nombrecompleto =  $FilaDetalle["primer_nombre"]." ".$FilaDetalle["segundo_nombre"]." ".$FilaDetalle["tercer_nombre"]." ".$FilaDetalle["primer_apellido"]." ".$FilaDetalle["segundo_apellido"];
											    $cont=$cont+1;
											    ?>
													<tr>
                                                        <td align="lefth" ><?php echo $cont?></td> 
													    <td align="lefth"><?php echo $nombrecompleto ?></td> 
													    <td align="center"><?php echo $FilaDetalle["cif"] ?></td> 
														<?php
														if($FilaDetalle["puesto"]==''){
														?>
													    <td align="lefth" style="color:red;">Puesto Sin Asignar</td>
														<?php 
														}else{
															$puesto = mysqli_query($db,"SELECT A.nombre_puesto
															FROM info_base.define_puestos AS A 
															WHERE A.id_puesto=".$FilaDetalle["puesto"]);
															$FilaPuesto= mysqli_fetch_array($puesto);
															?>
															<td align="center"><?php echo $FilaPuesto["nombre_puesto"] ?></td>
															<?php 
															}?>
													    <td align="center"><?php echo $FilaDetalle["estado"] ?></td> 
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
		
		<?php include("MenuUsers.html"); ?>

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

	<script>
		 $('#BtnExportarTicketHotel').click(function(event) {
			$('#table').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

	 
	</script>
	</html>
