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
				<form class="form" action="THPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Consulta de Talonarios Activos</strong></h4>
							</div>
							<div class="card-body">
								<?php
								$Query = mysqli_query($db, "SELECT A.*, B.H_NOMBRE
													FROM Taquilla.ASIGNACION_TALONARIO_TICKET AS A 
													INNER JOIN Taquilla.HOTEL AS B
													ON A.H_CODIGO = B.H_CODIGO 
													WHERE A.ATT_ESTADO = 0
													GROUP BY A.H_CODIGO"); 
								$Registros = mysqli_num_rows($Query);
								if($Registros > 0)
								{
								?>
								<table class="table table-hover table-condensed" id="tbl_resultados">
									<thead>
										<tr>
											<th>#</th>
											<th>NOMBRE</th> 
											<th>VALES DISPONIBLES</th>
											<th>Estado</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									<?php
										$i = 1;
										while($fila = mysqli_fetch_array($Query))
										{
											$Id = $fila["H_CODIGO"];
											if($fila["ATT_ESTADO"] == 0)
											{
												$Estado = 'Activo';
											}
											else
											{
												$Estado = 'Inactivo';
											} 
											$Vales = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(*) AS CONTADOR FROM Taquilla.DETALLE_ASIGNACION_VALE a WHERE a.H_CODIGO = $fila[H_CODIGO] AND a.DAV_ESTADO = 1"));  
											if ($Vales["CONTADOR"]<10) 
											{
												$text = 'style="color: #ff0000; background: white;"';
											}
											else
											{
												$text = '';
											}
											
											?>
												<tr <?php echo $text ?>>
													<td><h6><?php echo $i; ?></h6></td>
													<td><h6><?php echo $fila["H_NOMBRE"]; ?></h6></td> 
													<td  align="center"><h6></h6><?php echo $Vales["CONTADOR"]?></td>
													<td><h6><?php echo $Estado; ?></h6></td>
													<td><a href="DetalleHotel.php?Id=<?php echo $Id?>" type="button" class="btn btn-primary btn-sm">Consultar</a></td>
												</tr>
											<?php
											$i++;
											$ValesTot += $Vales["CONTADOR"]; 
										}
									?>
									<tr>
													<td><h6>TOTAL</h6></td>
													<td> </td> 
													<td align="center"><h6></h6><?php echo $ValesTot?></td>
													<td> </td>
													<td> </td>
												</tr>
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
					                    col_0: "disabled",
			                    		col_1: "select",
			                    		col_2: "select",
			                    		col_3: "disabled",
			                    		col_4: "select",
			                    		col_5: "disabled",
					                };
					                var tf = setFilterGrid('tbl_resultados', tbl_filtrado);
					            </script>
								<?php
								}
								else
								{
									?>
									<div class="alert alert-warning">
										<strong>No existen Talonraios de Tickets Activos</strong> 
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../../Hotel/MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
