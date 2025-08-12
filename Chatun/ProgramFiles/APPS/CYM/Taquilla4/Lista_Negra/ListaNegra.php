<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$PuestoColaborador = saber_puesto($id_user);
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
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
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
				<form class="form" action="RPPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Personas en Lista Negra</strong></h4>
							</div>
							<div class="card-body">
								<div class="row text-center">
									<a href="ListaNegraAdd.php"><button type="button" class="btn btn-primary">Agregar Persona</button></a>
								</div>
								<div class="row">
									<br><br>
								</div>
								<table class="table table-hover table-condensed" id="tbl_resultados">
									<thead>
										<tr>
											<th><h5><strong>#</strong></h5></th>
											<th><h5><strong>NOMBRE</strong></h5></th>
											<th><h5><strong>OBSERVACIONES</strong></h5></th>
											<th><h5><strong>ARCHIVO</strong></h5></th>
											<th><h5><strong>ELIMINAR</strong></h5></th>
										</tr>
									</thead>
									<tbody>
									<?php
										$Contador = 1;
										$Query = mysqli_query($db, "SELECT * FROM Taquilla.LISTA_NEGRA ORDER BY LN_FECHA_HORA");
										while($Fila = mysqli_fetch_array($Query))
										{
											?>
												<tr>
													<td><h6><?php echo $Contador ?></h6></td>
													<td><h6><?php echo saber_nombre_asociado_orden($Fila["LN_CIF_ASOCIADO"]) ?></h6></td>
													<td><h6><?php echo $Fila["LN_OBSERVACIONES"] ?></h6></td>
													<td><a href="<?php echo $Fila[LN_RUTA_ARCHIVO] ?>" target="_blank"><h6><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-search"></span></button></a></h6>
													<?php
														if($PuestoColaborador == 1)
														{
															?>
																<td><h6><button onclick="Eliminar(this.value)" value="<?php echo $Fila[LN_CODIGO] ?>" type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button></h6></td>
															<?php
														}
														else
														{
															?>
																<td><h6>No tienes permiso</h6></td>
															<?php
														}
													?>
												</tr>
											<?php
											$Contador++;
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
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>
		
		<script>
			function Eliminar(x)
			{
				$.ajax({
						url: 'EliminarPersona.php',
						type: 'post',
						data: 'Codigo='+x,
						success: function (data) {
							if(data == 1)
							{
								window.location.reload();
							}
						}
					});
			}
		</script>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
