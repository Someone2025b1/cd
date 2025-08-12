<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");


$cont = 0;
$fecha_inicio = $_POST["FechaInicio"];
$fecha_fin = $_POST["FechaFin"];
$contatemp = 0;
$fechatemp = $fecha_inicio;


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
				<h1 class="text-center"><strong>Lista de Envios Pendientes de Recibir</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						</div>
						<div class="card-body">
						<form class="form" method="POST" role="form" id="FormularioEnviar">
						<input type="hidden" name="TipoEvento" value="<?php echo $tipodereevento ?>">
						</form>
							<table class="table table-hover table-condensed" id="tbl_resultados">
								<thead>
									<th><strong>#</strong></th>
									<th><strong>Numero de Envio</strong></th>
									<th><strong>Quien Recibe</strong></th>
									<th><strong>Observaciones</strong></th>
                                    <th><strong>FECHA</strong></th>
                                    <th><strong>Cantidad de Productos</strong></th>
                                    <th colspan="2"><strong  align="center"><h6 align="center"> Opciones</h1></strong></th>
								</thead>
                                
								<tbody>
								<?php
									$Contador = 1;
									$Consulta = "SELECT * FROM Productos.ENVIOS AS A WHERE A.EN_ESTADO = 1 AND A.EN_ENVIA = 4 ORDER BY A.EN_FECHA_SOLICITUD ";
									$Resultado = mysqli_query($db, $Consulta);
									while($row = mysqli_fetch_array($Resultado))
									{
										$Codigo = $row["EN_CODIGO"];
										$EN = $row['EN_RECIBE'];
                                        										echo '<tr>';
										    	echo '<td style="font-size: 10px">'.$Contador.'</td>'; 
                                                echo '<td style="font-size: 10px">'.$row["EN_CODIGO"].'</td>';
                                                $ListEvento = mysqli_query($db, "SELECT a.PV_NOMBRE FROM CompraVenta.PUNTO_VENTA a WHERE a.PV_CODIGO =".$EN);
												while ($RowEvento = mysqli_fetch_array($ListEvento))
												{
													$Envia = $RowEvento["PV_NOMBRE"];
												}
                                                echo '<td style="font-size: 10px">'.$Envia.'</td>';
										    	echo '<td style="font-size: 10px">'.$row["EN_DESCRIPCION"].'</td>';
                                                echo '<td style="font-size: 10px">'.$row["EN_FECHA_SOLICITUD"].'a las: '.$row["EN_HORA_SOLICITUD"].' horas</td>';
                                                echo '<td style="font-size: 10px">'.$row["EN_TOTAL_PRODUCTOS"].'</td>';
										    	echo '<td><a href="DespacharPedido.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-warning">
														     Despachar Pedido
														  </button></a>
														</td>';
                                               
										    echo '</tr>';

										    $Contador++;
									}
								?>									
								</tbody>
                               
                                <?php
                                
                                ?>
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
			                    col_5: "disable",
                                col_6: "disable",
                                col_7: "disable",
								col_1: "select",
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
