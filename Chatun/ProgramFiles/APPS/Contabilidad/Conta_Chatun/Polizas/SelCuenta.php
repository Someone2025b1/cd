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
	function Seleccionar(x)
		{
			window.opener.document.getElementById('CodigoParaIngresar').value = $('#Codigo'+x).val();
			window.opener.document.getElementById('NombreParaIngresar').value = $('#Nombre'+x).val();
			window.close();
		}
	</script>

</head>
<body>


	<div class="col-lg-12">
		<h2 class="text-center"><strong>Seleccione un Proveedor</strong></h2>
		<br>
		<table class="table table-hover table-condensed" id="tbl_resultados">
								<thead>
									<th><strong>Código</strong></th>
									<th><strong>Nombre</strong></th>
									<th><strong>Tipo</strong></th>
									<th><strong>Seleccionar</strong></th>
								</thead>
								<tbody>
								<?php
									$i=1;
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
										    	echo '<td></td>';
										    echo '</tr>';
										}
										elseif($row["N_TIPO"] == 'G')
										{
											echo '<tr>';
										    	echo '<td style="font-size: 14px; font-weight: bold;">'.$row["N_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 14px; font-weight: bold;">'.$row["N_NOMBRE"].'</td>';
										    	echo '<td style="font-size: 14px; font-weight: bold;">'.$row["N_TIPO"].'</td>';
										    	echo '<td></td>';
										    echo '</tr>';
										}
										elseif($row["N_TIPO"] == 'S')
										{
											echo '<tr>';
										    	echo '<td style="font-size: 12px; font-weight: bold;">'.$row["N_CODIGO"].'</td>';               
										    	echo '<td style="font-size: 12px; font-weight: bold;">'.$row["N_NOMBRE"].'</td>';
										    	echo '<td style="font-size: 12px; font-weight: bold;">'.$row["N_TIPO"].'</td>';
										    	echo '<td></td>';
										    echo '</tr>';
										}
										else
										{
											echo '<tr>';
										    	echo '<td style="font-size: 10px">'.$row["N_CODIGO"].'</td>'; 
										    	echo '<input type="hidden" id="Codigo'.$i.'" value="'.$row["N_CODIGO"].'" />';              
										    	echo '<td style="font-size: 10px">'.$row["N_NOMBRE"].'</td>';
										    	echo '<input type="hidden" id="Nombre'.$i.'" value="'.$row["N_NOMBRE"].'" />'; 
										    	echo '<td style="font-size: 10px">'.$row["N_TIPO"].'</td>';
										    	echo '<td><button type="button" class="btn btn-success btn-xs" onclick="Seleccionar('.$i.')">
														    <span class="glyphicon glyphicon-check"></span>
														  </button>
														</td>';
										    echo '</tr>';
										}
										$i++;
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
