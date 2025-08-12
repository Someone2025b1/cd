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
	function Enviar(x)
		{
			window.opener.document.getElementById('CodigoProveedor').value = $('#Codigo'+x).val();
			window.opener.document.getElementById('Nombre').value          = $('#Nombre'+x).val();
			window.opener.document.getElementById('NIT').value             = $('#NIT'+x).val();
			window.opener.document.getElementById('DPI').value             = $('#DPI'+x).val();
			window.opener.document.getElementById('Domicilio').value             = $('#Domicilio'+x).val();
			var Cuenta = window.opener.document.getElementsByName('Cuenta[]');   
			Cuenta[5].value = $('#Codigo'+x).val()+"/"+$('#Nombre'+x).val();
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
				<tr>
					<th><h6><strong>No.</strong></h6></th>
					<th><h6><strong>Cta. Contable</strong></h6></th>
					<th><h6><strong>Nombre</strong></h6></th>
					<th><h6><strong>NIT</strong></h6></th>
					<th><h6><strong>DPI</strong></h6></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				$Consulta = "SELECT PROVEEDOR.*, REGIMEN.* 
				FROM Contabilidad.PROVEEDOR, Contabilidad.REGIMEN 
				WHERE PROVEEDOR.REG_CODIGO = REGIMEN.REG_CODIGO
				ORDER BY P_NOMBRE";
				$Resultado = mysqli_query($db, $Consulta);
				while($row = mysqli_fetch_array($Resultado))
				{
					echo '<tr>';
					echo '<td><h6>'.$i.'</h6></td>';
					echo '<td><h6>'.$row["P_CODIGO"].'</h6></td>';
					echo '<input type="hidden" name="Codigo'.$i.'" id="Codigo'.$i.'" value="'.$row["P_CODIGO"].'"/>';
					echo '<td><h6>'.$row["P_NOMBRE"].'</h6></td>';
					echo '<input type="hidden" name="Nombre'.$i.'" id="Nombre'.$i.'" value="'.$row["P_NOMBRE"].'"/>';
					echo '<td><h6>'.$row["P_NIT"].'</h6></td>';
					echo '<input type="hidden" name="NIT'.$i.'" id="NIT'.$i.'" value="'.$row["P_NIT"].'"/>';
					echo '<td><h6>'.$row["P_DPI"].'</h6></td>';
					echo '<input type="hidden" name="DPI'.$i.'" id="DPI'.$i.'" value="'.$row["P_DPI"].'"/>';
					echo '<input type="hidden" name="Domicilio'.$i.'" id="Domicilio'.$i.'" value="'.$row["P_DIRECCION"].'"/>';
					echo '<td><h6><button type="button" class="btn btn-primary btn-xs" value="'.$row["P_CODIGO"].'" onclick="Enviar('.$i.')">
					<span class="glyphicon glyphicon-ok"></span> Seleccionar
				</button></h6></td>';
				echo '</tr>';
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
			                    col_0: "disable",
			                    col_5: "disable",
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
