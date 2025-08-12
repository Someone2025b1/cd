<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/httpful.phar");

$Usuar = $_SESSION["iduser"];

if($Usuar==53711 | $Usuar==10345){
	$Flitro="";
}else{
	$Flitro="AND CC_REALIZO ="."$Usuar";
}
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
				<h1 class="text-center"><strong>Consulta de Anticipos Pendientes de Usar</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Anticipos</strong></h4>
						</div>
						<div class="card-body">
							<table class="table table-hover table-condensed" id="tbl_resultados">
								<thead>
									<th><strong>Código</strong></th>
									<th><strong>Área</strong></th>
									<th><strong>Aspecto</strong></th>
									<th><strong>EDITAR</strong></th>
									
								</thead>
								<tbody>
								<?php
									$Consulta = "SELECT ASPECTOS_EVALUAR.*, AREA_EVALUAR.AR_NOMBRE FROM RRHH.ASPECTOS_EVALUAR, RRHH.AREA_EVALUAR WHERE AREA_EVALUAR.AR_CODIGO = ASPECTOS_EVALUAR.AR_CODIGO 
                                    ORDER BY ASPECTOS_EVALUAR.ARE_CODIGO";
									$Resultado = mysqli_query($db, $Consulta);
									while($row = mysqli_fetch_array($Resultado))
									{
										$Codigo = $row["ARE_CODIGO"];
										$Puesto = $row["P_CODIGO"];

										$sqlRet = mysqli_query($db,"SELECT A.P_NOMBRE, A.A_CODIGO 
												FROM RRHH.PUESTO AS A     
												WHERE A.P_CODIGO = ".$Puesto); 
												$rowret=mysqli_fetch_array($sqlRet);

												$NombrePuesto=$rowret["P_NOMBRE"];

												if($row["AR_NOMBRE"]=="POR PUESTO DE TRABAJO")
												{
													$Area=$NombrePuesto;
												}else{
													$Area=$row["AR_NOMBRE"];
												}


										echo '<tr>';
										    	echo '<td style="font-size: 10px">'.$row["ARE_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 10px">'.$Area.'</td>';
										    	echo '<td style="font-size: 10px">'.$row["ARE_NOMBRE"].'</td>';
										    	
														
                                                echo '<td><a href="EditarAspecto.php?Codigo='.$Codigo.'" Target="_blank"><button type="button" class="btn btn-warning">
                                                <span class="glyphicon glyphicon-pencil"></span> Editar
                                                </button></a>
                                            </td>';
														
										    echo '</tr>';
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
			                    paging_length: 10,  
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
			                    col_3: "disable",
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
