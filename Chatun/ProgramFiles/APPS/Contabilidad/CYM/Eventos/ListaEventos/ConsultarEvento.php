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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php");


	if($id_user==53711 | $id_user==10345 | $id_user==22045) {
		$Filtro="";
	}else{
		$Filtro="AND A.EV_ENCARGADO ="."$id_user";
	} 
	$FechaHoy=date('Y-m-d', strtotime('now'));
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Consulta de Eventos</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						</div>
						<div class="card-body">
							<table class="table table-hover table-condensed" id="tbl_resultados">
								<thead>
									<th><strong>CODIGO</strong></th>
									<th><strong>DUEÑO</strong></th>
									<th><strong>FECHA EV</strong></th>
									<th><strong>LUGAR</strong></th>
									<th><strong>ENCARGADO</strong></th>
									<th><strong></strong></th>
									<th><strong>Comentario Final</strong></th>
								</thead>
								<tbody>
								<?php
									$Contador = 1;
									$Consulta = "SELECT A.*
													FROM Eventos.EVENTO AS A
													WHERE (A.EV_FECHA_EV >= NOW() OR A.EV_FECHA_EV >= date_add(NOW(), INTERVAL -8 DAY))
													$Filtro
													ORDER BY A.EV_FECHA_EV";
									$Resultado = mysqli_query($db, $Consulta);
									while($row = mysqli_fetch_array($Resultado))
									{
										$Codigo = $row["EV_CODIGO"];
										$Usuario = $row["EV_ENCARGADO"];

										$sqlRet = mysqli_query($db,"SELECT A.nombre 
										FROM info_bbdd.usuarios AS A     
										WHERE A.id_user = ".$Usuario); 
										$rowret=mysqli_fetch_array($sqlRet);

										$NombreRet=$rowret["nombre"];


										echo '<tr>';
										    	echo '<td style="font-size: 14px">'.$row["EV_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 14px">'.$row["EV_DUENO"].'</td>';
										    	echo '<td style="font-size: 14px">'.$row["EV_FECHA_EV"].'</td>';
										    	echo '<td style="font-size: 14px">'.$row["EV_LUGAR"].'</td>';
										    	echo '<td style="font-size: 14px">'.$NombreRet.'</td>';
												if($row["EV_FECHA_EV"]<$FechaHoy  | $id_user==10345 | $id_user==22045){

													echo '<td style="font-size: 24px"><a href="VerEvento.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-info">
													<span class="fa fa-eye"></span>
												  </button></a>
												</td>';
												}else{
										    	echo '<td style="font-size: 24px"><a href="EditarEvento.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-warning">
														    <span class="fa fa-pencil"></span>
														  </button></a>
														</td>';
												}
												if($row["EV_FECHA_EV"]<=$FechaHoy & $row["EV_COM_JEFE"]==0 & ($id_user==10345 | $id_user==53711)){

													echo '<td style="font-size: 24px"><a href="ComentarioEventoJefe.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-secondary">
													<span class="fa fa-comments-o"></span>
												  </button></a>
												</td>';
												}

												if($row["EV_FECHA_EV"]<=$FechaHoy & $row["EV_ESTADO"]==0 & ($id_user==$row["EV_ENCARGADO"] | $id_user==53711)){

													echo '<td style="font-size: 24px"><a href="ComentarioEventoEncargado.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-secondary">
													<span class="fa fa-comments-o"></span>
												  </button></a>
												</td>';
												}
										    echo '</tr>';

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
			                    col_4: "disable"
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
