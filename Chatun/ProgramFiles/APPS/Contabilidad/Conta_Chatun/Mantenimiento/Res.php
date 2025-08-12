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

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->
	

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="row">
				<h1 class="text-center"><strong>Consulta de Resoluciones</strong><br></h1>
				<br>
				<div class="col-lg-12">
					<div class="card">
						<div class="card-head style-primary">
						<h4 class="text-center"><strong>Proveedores</strong></h4>
						</div>
						<div class="card-body">
							<table class="table table-hover table-condensed" id="tbl_resultados">
								<thead>
									<th><strong>Resolución</strong></th>
									<th><strong>Fecha Autorización</strong></th>
									<th><strong>Serie</strong></th>
									<th><strong>Del</strong></th>
									<th><strong>Al</strong></th>
									<th><strong>Fecha Ingreso</strong></th>
									<th><strong>Tipo Documento</strong></th>
									<th><strong>Fecha Vencimiento</strong></th>
									<th><strong>Correlativo Actual</strong></th>
									<th><strong>Estado</strong></th>
								</thead>
								<tbody>
									<?php
									$Consulta = "SELECT A.*, (SELECT B.TRA_FACTURA FROM Contabilidad.TRANSACCION AS B WHERE B.RES_NUMERO = A.RES_NUMERO ORDER BY B.TRA_FECHA_TRANS DESC LIMIT 1) AS TRA_FACTURA
													FROM Bodega.RESOLUCION AS A
													ORDER BY A.RES_NUMERO";
									$Resultado = mysqli_query($db, $Consulta);
									while($row = mysqli_fetch_array($Resultado))
									{
										if($row["RES_ESTADO"] == 0)
										{
											$Estado = 'Inactivo (Por Usar)';
										}
										elseif($row["RES_ESTADO"] == 1)
										{
											$Estado = 'Activo';
										}
										else
										{
											$Estado = 'Inactivo (Completo)';
										}

										if($Estado == 1)
										{

										}
										else
										{

										}

										$Codigo = $row["RES_NUMERO"];
										echo '<tr>';
												echo '<td style="font-size: 12px">'.$row["RES_NUMERO"].'</td>';               
												echo '<td style="font-size: 12px">'.date('d-m-Y', strtotime($row["RES_FECHA_RESOLUCION"])).'</td>';
												echo '<td style="font-size: 12px">'.$row["RES_SERIE"].'</td>';
												echo '<td style="font-size: 12px">'.$row["RES_DEL"].'</td>';
												echo '<td style="font-size: 12px">'.$row["RES_AL"].'</td>';
												echo '<td style="font-size: 12px">'.date('d-m-Y', strtotime($row["RES_FECHA_INGRESO"])).'</td>';
												echo '<td style="font-size: 12px">'.$row["RES_TIPO_DOCUMENTO"].'</td>';
												echo '<td style="font-size: 12px">'.date('d-m-Y', strtotime($row["RES_FECHA_VENCIMIENTO"])).'</td>';
												echo '<td style="font-size: 12px" align="center">'.number_format($row["TRA_FACTURA"]).'</td>';
												echo '<td style="font-size: 12px">'.$Estado.'</td>';
												echo '<td><a href="ResMod.php?Codigo='.$Codigo.'"><button type="button" class="btn btn-primary btn-xs">
												 Consultar
													</button></a></td>';
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
			                    col_4: "disable",
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
