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
        function AbrirNomenclatura(){
		        $('#ModalNomen').modal('show');
		        $('#FechaInicio').focus();
		}
		function SeleccionarCuenta(x)
		{
			$('#CodigoCuenta').val($(x).attr('Valor'));
			$('#NombreCuenta').val($(x).attr('Nombre'));
			$('#ModalNomen').modal('hide');
			$('#FechaInicio').focus();
		}
	</script>

<script>
	function EnviarFormExcel()
	{
		var Formulario = $('#FormularioEnviar');
		$(Formulario).attr('action', 'ECIExcel.php');
		$(Formulario).submit();	

	}
	function EnviarFormPDF()
	{
		var Formulario = $('#FormularioEnviar');
		$(Formulario).attr('action', 'ECImp.php');
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
				<form class="form" method="POST" role="form" id="FormularioEnviar" target="_blank">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Estado de Cuenta</strong></h4>
							</div>
							<div class="row text-center">
								<div class="col-lg-5"></div>
										<div class="col-lg-3 text-center">
											<div class="form-group">
												<input class="form-control" type="text" name="CodigoCuenta" id="CodigoCuenta" readonly></input>
												<input class="form-control" type="text" name="NombreCuenta" id="NombreCuenta" onfocus="AbrirNomenclatura()"></input>
												<label for="Producto">Cuenta Contable</label>
											</div>
										</div>
									</div>
							<div class="card-body">
								<div class="row text-center">
									<div class="col-lg-3"></div>
									<div class="col-lg-6">
										<div class="form-group">
											<div class="input-daterange input-group" id="demo-date-range">
												<div class="input-group-content">
													<input type="date" class="form-control" name="FechaInicio" id="FechaInicio" value="<?php echo date('Y-m-d') ?>">
													<label>Rango de Fechas</label>
												</div>
												<span class="input-group-addon">al</span>
												<div class="input-group-content">
													<input type="date" class="form-control" name="FechaFin" value="<?php echo date('Y-m-d') ?>">
													<div class="form-control-line"></div>
												</div>
											</div>
										</div>
									</div>	
									<div class="col-lg-3"></div>
								</div>
								<div class="col-lg-12" align="center">
									<button type="button" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" onclick="EnviarFormPDF()">PDF</button>
								
									<button type="button" class="btn ink-reaction btn-raised btn-primary" id="Guardar" onclick="EnviarFormExcel()">Excel</button>
								</div>
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
        <div id="ModalNomen" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Nomenclatura</h2>
                    </div>
                    <div class="modal-body">
                    	<table class="table table-hover table-condensed" id="tbl_resultados">
                    		<thead>
                    			<tr>
                    				<th><strong>Código</strong></th>
                    				<th><strong>Nombre</strong></th>
                    				<th><strong>Seleccionar</strong></th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    			<?php
									$Consulta = "SELECT * FROM Contabilidad.NOMENCLATURA ORDER BY N_CODIGO";
									$Resultado = mysqli_query($db, $Consulta);
									while($row = mysqli_fetch_array($Resultado))
									{
										$Codigo = $row["N_CODIGO"];
										if($row["N_TIPO"] == 'GM')
										{
											echo '<tr>';
										    	echo '<td style="font-size: 16px; font-weight: bold;">'.$row["N_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 16px; font-weight: bold;">'.$row["N_NOMBRE"].'</td>';
										    	echo '<td style="font-size: 16px; font-weight: bold;">'.$row["N_TIPO"].'</td>';
										    echo '</tr>';
										}
										elseif($row["N_TIPO"] == 'G')
										{
											echo '<tr>';
										    	echo '<td style="font-size: 14px; font-weight: bold;">'.$row["N_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 14px; font-weight: bold;">'.$row["N_NOMBRE"].'</td>';
										    	echo '<td style="font-size: 14px; font-weight: bold;">'.$row["N_TIPO"].'</td>';
										    echo '</tr>';
										}
										elseif($row["N_TIPO"] == 'S')
										{
											echo '<tr>';
										    	echo '<td style="font-size: 12px; font-weight: bold;">'.$row["N_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 12px; font-weight: bold;">'.$row["N_NOMBRE"].'</td>';
										    	echo '<td style="font-size: 12px; font-weight: bold;">'.$row["N_TIPO"].'</td>';
										    echo '</tr>';
										}
										elseif($row["N_TIPO"] == 'SC')
										{
											echo '<tr>';
										    	echo '<td style="font-size: 12px; font-weight: bold;">'.$row["N_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 12px; font-weight: bold;">'.$row["N_NOMBRE"].'</td>';
										    	echo '<td style="font-size: 12px; font-weight: bold;">'.$row["N_TIPO"].'</td>';
										    echo '</tr>';
										}
										else
										{
											echo '<tr>';
										    	echo '<td style="font-size: 10px">'.$row["N_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 10px">'.$row["N_NOMBRE"].'</td>';
										    	echo '<td style="font-size: 10px">'.$row["N_TIPO"].'</td>';
										    	echo '<td><button Valor="'.$row["N_CODIGO"].'" Nombre="'.$row["N_NOMBRE"].'" type="button" class="btn btn-warning btn-xs" onClick="SeleccionarCuenta(this)">
														    <span class="glyphicon glyphicon-check"></span> Seleccionar
														  </button>
														</td>';
										    echo '</tr>';
										}
									}
								?>	
                    		</tbody>
                    	</table>
                    	<script>
			                var tbl_filtrado =  { 
			                        mark_active_columns: true,
			                        highlight_keywords: true,
			                        filters_row_index:1,
			                    paging: true,             //paginar 3 filas por pagina
			                    paging_length: 15,  
			                    rows_counter: true,      //mostrar cantidad de filas
			                    rows_counter_text: "Registros: ", 
			                    page_text: "Página:",
			                    of_text: "de",
			                    btn_reset: true, 
			                    loader: true, 
			                    loader_html: "<img src='../../../../../libs/TableFilter/img_loading.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
			                    display_all_text: "-Todos-",
			                    results_per_page: ["# Filas por Página...",[10,20,50,100]],  
			                    btn_reset: true,
			                    col_2: "disable",
			                    col_3: "disable",
			                };
			                var tf = setFilterGrid('tbl_resultados', tbl_filtrado);
			            </script>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

	</div><!--end #base-->
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
