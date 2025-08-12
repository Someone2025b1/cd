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

	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Consulta de Colaboradores</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						</div>
						<div class="card-body">
							<table class="table table-hover table-condensed" id="tbl_resultados">
								<thead>
									<th><strong>CODIGO</strong></th>
									<th><strong>NOMBRE</strong></th>
									<th><strong>AREA</strong></th>
									<th><strong>PUESTO</strong></th>
									<th><strong>VER/IMPRIMIR</strong></th>
									<th><strong>PARA PLANILLA</strong></th>
								</thead>
								<tbody>
								<?php
									$Contador = 1;
									$Consulta = "SELECT A.*, B.C_NOMBRES, B.C_APELLIDOS, B.A_CODIGO, B.P_CODIGO
													FROM RRHH.EVALUACION_DESEMPENO AS A, RRHH.COLABORADOR AS B
													WHERE A.C_CODIGO = B.C_CODIGO
													ORDER BY A.ED_FECHA DESC";

#$Consulta = "SELECT A.*, B.C_NOMBRES, B.C_APELLIDOS, B.A_CODIGO, B.P_CODIGO
#FROM RRHH.EVALUACION_DESEMPENO AS A, RRHH.COLABORADOR AS B
#WHERE A.C_CODIGO = B.C_CODIGO
#GROUP BY A.C_CODIGO
#ORDER BY A.ED_FECHA DESC";


									$Resultado = mysqli_query($db, $Consulta);
									while($row = mysqli_fetch_array($Resultado))
									{
										$Codigo = $row["ED_CODIGO"];
										$Area = $row["A_CODIGO"];
										$Puesto = $row["P_CODIGO"];
										$Fecha = $row["ED_FECHA"];

										$sqlRet = mysqli_query($db,"SELECT A.A_NOMBRE 
										FROM RRHH.AREAS AS A     
										WHERE A.A_CODIGO = ".$Area); 
										$rowret=mysqli_fetch_array($sqlRet);

										$NomArea=$rowret["A_NOMBRE"];

                                        $sqlRet = mysqli_query($db,"SELECT A.P_NOMBRE 
										FROM RRHH.PUESTO AS A     
										WHERE A.P_CODIGO = ".$Puesto); 
										$rowret=mysqli_fetch_array($sqlRet);

										$NomPuesto=$rowret["P_NOMBRE"];



										echo '<tr>';
										    	echo '<td style="font-size: 14px">'.$row["C_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 14px">'.$row["C_NOMBRES"]." ".$row["C_APELLIDOS"].'</td>';
										    	echo '<td style="font-size: 14px">'.$Fecha.'</td>';
										    	echo '<td style="font-size: 14px">'.$NomPuesto.'</td>';

											

													echo '<td style="font-size: 8px"><a href="ImpEvaluacion.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-dark">
														    <span class="fa fa-print"></span>
														  </button></a>

														  <a href="VerEvaluacion.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-light">
														    <span class="fa fa-eye"></span>
														  </button></a>
														</td>';

														echo '<td style="font-size: 8px"><a href="ImpEvaluacionPlanilla.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-dark">
														    <span class="fa fa-print"></span>
														  </button></a>

														  ';

										    	
												
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
