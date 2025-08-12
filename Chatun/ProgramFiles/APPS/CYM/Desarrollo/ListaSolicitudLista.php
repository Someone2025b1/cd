<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");


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
	
    <script src="../../../../libs/TableFilter/tablefilter_all_min.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link rel="stylesheet" type="text/css" href="../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../MenuTop.php") ?>

   

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Lista de Solicitudes de Desarrollo Listas</strong><br></h1>
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
									<th><strong>APlICACIÓN</strong></th>
									<th><strong>DESCRIPCIÓN</strong></th>
									<th><strong>QUIEN LO REALIZO</strong></th>
                                    <th><strong>FECHA SOLICITADA</strong></th>
									<th><strong>FECHA PROCESO</strong></th>
                                    <th><strong>FECHA LISTA</strong></th>
                                    <th><strong>TIEMPO TRANSCURRIDO</strong></th>
								</thead>

								<tbody>
								<?php
									$Contador = 1;
									$Consulta = "SELECT * FROM Desarrollo.DESARROLLO AS A WHERE A.ED_ESTADO = 2 and A.D_FECHA_LISTO BETWEEN '$fecha_inicio' AND '$fecha_fin' ORDER BY A.D_FECHA ";
									$Resultado = mysqli_query($db, $Consulta);
									while($row = mysqli_fetch_array($Resultado))
									{
										$Codigo = $row["D_CODIGO"];
										$US = $row['D_USUARIO'];
                                        $fechapro= new DateTime($row["D_FECHA_PROCESO"]);
                                        $fechalis= new DateTime($row["D_FECHA_LISTO"]);
                                        $diferencia =  $fechapro -> diff($fechalis);
                                        $Diferencia = $diferencia -> format('%M meses y %D días');
                                        										echo '<tr>';
										    	echo '<td style="font-size: 10px">'.$Contador.'</td>'; 
                                                echo '<td style="font-size: 10px">'.$row["D_APLICACION"].'</td>';
                                                echo '<td style="font-size: 10px">'.$row["D_DESCRIPCION"].'</td>';

												$ListEvento = mysqli_query($db, "SELECT a.primer_nombre, a.primer_apellido FROM info_colaboradores.datos_generales a WHERE a.cif =".$US);
												while ($RowEvento = mysqli_fetch_array($ListEvento))
												{
													$usuario = $RowEvento["primer_nombre"]." ".$RowEvento["primer_apellido"];
												}

										    	echo '<td style="font-size: 10px">'.$usuario.'</td>';
                                                echo '<td style="font-size: 10px">'.$row["D_FECHA"].'</td>';
                                                echo '<td style="font-size: 10px">'.$row["D_FECHA_PROCESO"].'</td>';
												echo '<td style="font-size: 10px">'.$row["D_FECHA_LISTO"].'</td>';
                                                echo '<td style="font-size: 10px">'.$Diferencia.'</td>';
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

			<?php include("MenuUsers.html"); ?>

		</div><!--end #base-->
		<!-- END BASE -->

		<!-- BEGIN JAVASCRIPT -->
		<script src="../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../../../js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../../../js/libs/spin.js/spin.min.js"></script>
		<script src="../../../../js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="../../../../js/core/source/App.js"></script>
		<script src="../../../../js/core/source/AppNavigation.js"></script>
		<script src="../../../../js/core/source/AppOffcanvas.js"></script>
		<script src="../../../../js/core/source/AppCard.js"></script>
		<script src="../../../../js/core/source/AppForm.js"></script>
		<script src="../../../../js/core/source/AppNavSearch.js"></script>
		<script src="../../../../js/core/source/AppVendor.js"></script>
		<script src="../../../../js/core/demo/Demo.js"></script>
		<script src="../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
		<!-- END JAVASCRIPT -->

	</body>
	</html>
