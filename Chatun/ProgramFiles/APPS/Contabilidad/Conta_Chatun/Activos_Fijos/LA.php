<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
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
	<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- <script src="../../../../../js/libs/tableexport/base64.min.js"></script> -->
	<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">

	
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>

	<script src="../../../../../libs/alertify/js/alertify.js"></script>
	<!-- END STYLESHEETS -->

	<script>

function DepreciarFun(z)
	{
		//alert('llega');
		
		var CodigoRequisicion = z.value;
		//Le pasamos el valor del input al ajax

		var confirmar = confirm("¿Está seguro de que desea Depreciar este Activo?");
    
		if (!confirmar) {
			return; // Si el usuario cancela, no se ejecuta la función
		}

		
		$.ajax({
			type: "POST",
			url: "DepreciarActivo.php",
			data:"Codigo="+z,

			success: function(data) {
				alertify.success('El Acrtivo fue Depreciado con éxito');
				location.reload();

			},
			error: function(data)
			{
				alertify.error('No se pudo Depreciar el Activo');
			}
		});

		
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
				<h1 class="text-center"><strong>Lista de Activos Fijos</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Activos Fijos</strong></h4>
						</div>
						<br><div align="left">
		<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
	</div> <br>
						<div >
							<table class="table table-hover" id="tbl_resultados">
								<thead>
									<tr>
										<th>
											<strong><h6>Código</h6></strong>
										</th>
										<th>
											<strong><h6>Nuevo Código</h6></strong>
										</th>
										<th>
											<strong><h6>Nombre</h6></strong>
										</th>
										<th>
											<strong><h6>Responsable</h6></strong>
										</th>
										<th>
											<strong><h6>Tipo</h6></strong>
										</th>
										<th>
											<strong><h6>Área</h6></strong>
										</th>
										<th>
											<strong><h6>Observaciones</h6></strong>
										</th>
										<th>
											<strong><h6>Valor</h6></strong>
										</th>
										<th>
											<strong><h6>Valor Actual</h6></strong>
										</th>
										<th>
											<strong><h6>Depreciación Acumulada</h6></strong>
										</th>
										<th>
											<strong><h6>Agregar Nuevo Código</h6></strong>
										</th>
										<th>
											<strong><h6>Depreciar</h6></strong>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$query = "SELECT ACTIVO_FIJO.*, AREA_GASTO.AG_NOMBRE, TIPO_ACTIVO.TA_NOMBRE
									FROM Contabilidad.ACTIVO_FIJO, Contabilidad.AREA_GASTO, Contabilidad.TIPO_ACTIVO 
									WHERE ACTIVO_FIJO.AF_AREA = AREA_GASTO.AG_CODIGO
									AND ACTIVO_FIJO.TA_CODIGO = TIPO_ACTIVO.TA_CODIGO
									";
									$result = mysqli_query($db,$query);
									while($row = mysqli_fetch_array($result))
									{
										$Acumulado=$row["AF_VALOR"]-$row["AF_VALOR_ACTUAL"]+1;
										$NombreResponsable = saber_nombre_colaborador($row["AF_RESPONSABLE"]);
										?>
										<tr>
											<td><h6><?php echo $row["AF_CODIGO"]; ?></h6></td>
											<td><h6><?php echo $row["AF_NUEVO_CODIGO"]; ?></h6></td>
											<td><h6><?php echo $row["AF_NOMBRE"]; ?></h6></td>
											<td><h6><?php echo $NombreResponsable; ?></h6></td>
											<td><h6><?php echo $row["TA_NOMBRE"]; ?></h6></td>
											<td><h6><?php echo $row["AG_NOMBRE"]; ?></h6></td>
											<td><h6><?php echo $row["AF_OBSERVACIONES"]; ?></h6></td>
											<td><h6><?php echo number_format($row["AF_VALOR"], 2, '.', ',') ?></h6></td>
											<td><h6><?php echo number_format($row["AF_VALOR_ACTUAL"], 2, '.', ',') ?></h6></td>
											<td><h6><?php echo number_format($Acumulado, 2, '.', ',') ?></h6></td>
											<td>
												<button type="button" class="btn btn-warning" onclick="AgregarNuevoCodigo(this.value)" value="<?php echo $row["AF_CODIGO"] ?>"><span class="fa fa-edit"></span></button>
											</td>
											<?php
											if($row["AF_VALOR_ACTUAL"]==1){
											?>
											<td>
												<h6>Depreciado</h6>
											</td>
											<?php
											}else{

											
											?>
											<td>
											<button type="button" class="btn ink-reaction btn-raised btn-danger" id="btnCancelar" value="<?php echo $row["AF_CODIGO"]; ?>" onclick="DepreciarFun(this.value)">Depreciar</button>
											</td>
											<?php
											}
											?>
										</tr>
										<?php
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
			                    paging_length: 20,  
			                    rows_counter: true,      //mostrar cantidad de filas
			                    rows_counter_text: "Registros: ", 
			                    page_text: "Página:",
			                    of_text: "de",
			                    btn_reset: true, 
			                    loader: true, 
			                    loader_html: "<img src='../../../../../libs/TableFilter/img_loading.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
			                    display_all_text: "-Todos-",
			                    results_per_page: ["# Filas por Página...",[10,20,50,100,2000]],  
			                    btn_reset: true,
			                    col_2: "select",
			                    col_3: "select",
			                    col_4: "select",
			                };
			                var tf = setFilterGrid('tbl_resultados', tbl_filtrado);
			            </script>
			        </div>
			    </div>
			</div>
		</div>
		<!-- END CONTENT -->

		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	<div class="modal fade" id="ModalEditarNuevoCodigo">
		<div class="modal-dialog" style="width: 60%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Editar Nuevo Código</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<form id="FRMEditarNuevoCodigo">
							<input type="hidden" id="CodigoActivo" name="CodigoActivo">
							<div class="col-lg-12">
								<div class="form-group col-lg-4">
									<label for="">Codigo Nuevo Activo</label>
									<input type="text" class="form-control" name="CodigoNuevoActivo" id="CodigoNuevoActivo" required>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" onclick="GuardarEditarNuevoCodigo()">Guardar</button>
				</div>
			</div>
		</div>
	</div>

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
	<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- <script src="../../../../../js/libs/tableexport/base64.min.js"></script> -->
	<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	<!-- END JAVASCRIPT -->

	<script>
		function AgregarNuevoCodigo(x)
		{
			$('#CodigoActivo').val(x);
			$('#ModalEditarNuevoCodigo').modal('show');

			$.ajax({
					url: 'ObtenerNuevoCodigoActivo.php',
					type: 'post',
					data: 'CodigoActivo='+x,
					success: function (data) {
						$('#CodigoNuevoActivo').val(data);
						$('#CodigoNuevoActivo').focus();
					}
				});
		}
		function GuardarEditarNuevoCodigo()
		{
			if($('#FRMEditarNuevoCodigo')[0].checkValidity())
			{
				$.ajax({
						url: 'GuardarNuevoCodigoActivo.php',
						type: 'post',
						data: $('#FRMEditarNuevoCodigo').serialize(),
						success: function (data) {
							if(data == 1)
							{
								window.location.reload();
							}
							else
							{
								alertify.error('Hubo un error al tratar de Guardar el nuevo código');
							}
						}
					});
			}
			else
			{
				alertify.error('Debe llenar el campo antes de continuar');
			}
		}
	</script>

<script>
		 $('#BtnExportarTicketHotel').click(function(event) {
			$('#tbl_resultados').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

	 
	</script>

</body>
</html>
