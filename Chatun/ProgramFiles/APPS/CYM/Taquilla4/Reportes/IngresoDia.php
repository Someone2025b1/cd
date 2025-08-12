<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$SelectMes = $_POST['SelectMes'];
$anio = $_POST['anio'];

$Asociado = mysqli_query($db, "SELECT IA_FECHA_INGRESO, count(*) as TotalIngreso from Taquilla.INGRESO_ASOCIADO as IA 
WHERE MONTH(IA_FECHA_INGRESO) = ".$SelectMes." and YEAR(IA_FECHA_INGRESO) =   ".$anio."  group by DAY(IA.IA_FECHA_INGRESO);  ");

$NoAsociado = mysqli_query($db, "SELECT INA_FECHA_INGRESO, count(*) as TotalIngreso from Taquilla.INGRESO_NO_ASOCIADO as INA 
WHERE MONTH(INA_FECHA_INGRESO) = ".$SelectMes." and YEAR(INA_FECHA_INGRESO) =  ".$anio." group by DAY(INA.INA_FECHA_INGRESO);  ");
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
<!-- 	<script src="../../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
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
	<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
	<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script> -->
	
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
<!-- 	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css"> -->
	<!-- END STYLESHEETS -->

	<style type="text/css">
        .well{
        	 background: rgb(134, 192, 72);
        }
    </style>

</head>




	<div class="row">
				<header align="center">
					<h3>Ingreso por día del mes de <?php echo nombre_mes($SelectMes)." del ".$anio ?></h3>
				</header>
				<div align="center">
					<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarDiario">Exportar</button>
				</div>
				<br>
					<table class="table table-hover" id="TblDiarioAsociado">
					    <thead>
					      <tr>
					      	<th>Tipo de Ingreso</th>
					        <th>Fecha Ingreso</th>
					        <th>Total Ingreso</th>
					        <th>Detalle</th>					     
					      </tr>
					    </thead>
					    <tbody>
					    	<?php
						while($AsociadoResult = mysqli_fetch_array($Asociado)){
								$ExistenIngresoAsociado = $AsociadoResult[TotalIngreso];
						 	 ?>
				   		  <tr>
				   		  	<td>Asociado</td>
				   			<td class="text-center"><?php echo $AsociadoResult[IA_FECHA_INGRESO]?></td>
				   			<td class="text-center"><?php echo $AsociadoResult[TotalIngreso]?></td>
				   			<td class="text-center">
				   			  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onClick="DetalleDiarioAsociado('<?php echo $AsociadoResult[IA_FECHA_INGRESO]?>')">
				   				<i class="fa fa-search-plus" aria-hidden="true"></i>
				   			  </a>
				   			</td>
				   		 </tr>
				   		 <?php 
				   		 	}//fin while asociado
				   		 while($NoAsociadoResult = mysqli_fetch_array($NoAsociado))
				   		 	{
				   		 		$ExistenIngresoNoAsociado = $NoAsociadoResult[TotalIngreso];
				   		 ?>
				   		 <tr>
				   		 	<td>No Asociado</td>
				   		 	<td class="text-center"><?php echo $NoAsociadoResult[INA_FECHA_INGRESO]?></td>
				   		 	<td class="text-center"><?php echo $NoAsociadoResult[TotalIngreso]?></td>
				   		 	<td class="text-center">
				   			  <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onClick="DetalleDiarioNoAsociado('<?php echo $NoAsociadoResult[INA_FECHA_INGRESO] ?>')">
				   				<i class="fa fa-search-plus" aria-hidden="true"></i>
				   			  </a>
				   			</td>
				   		 </tr>
				   		 <?php 
				   		 	}
				   		 ?>
					    </tbody>
					  </table>
					    		
	</div><!-- fin div row  -->

<script>
jQuery(document).ready(function($) {

	var ExistenIngresoAsociado = "<?php echo $ExistenIngresoAsociado?>";
	var ExistenIngresoNoAsociado = "<?php echo $ExistenIngresoNoAsociado?>";
	$('#BtnExportarDiario').prop('disabled', true);		
	if(ExistenIngresoAsociado >= 1 || ExistenIngresoNoAsociado >= 1)
	{
		$('#BtnExportarDiario').prop('disabled', false);
	}
});

  var TotalNoAsociado = "<?php echo $contador ?>"; // obtiene el total para filtrar
  var tbl_filtrado =  { 
	mark_active_columns: true,
    highlight_keywords: true,
	filters_row_index: 1,
	paging: true,             //paginar 3 filas por pagina
    rows_counter: true,      //mostrar cantidad de filas
    rows_counter_text: "Registros: ", 
	page_text: "Página:",
    of_text: "de",
	btn_reset: true, 
    loader: true, 
    loader_html: "<img src='../../../../../img/Preloader.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
	display_all_text: "-Todos-",
	results_per_page: ["# Filas por Página...",[10,25,50,100, TotalNoAsociado]],  
	btn_reset: true,
	col_0: "select",
	col_1: "select",
  };
  var tf = setFilterGrid('TblDiarioAsociado', tbl_filtrado);//fin opciones para tabla de productos

		$('#BtnExportarDiario').click(function(event) {
			$('#TblDiarioAsociado').tableExport({
				type:'excel',
				escape:'false', 
				ignoreColumn: [3],
			});//fin funcion exportar
		});//fin funcion click
	
	function DetalleDiarioAsociado(FechaIngreso)
	{
		$('#AjaxConsultaReporte').html('');
		$.ajax({
			url: 'ConsultarReporte.php',
			type: 'POST',
			data: {FechaIngreso: FechaIngreso},
			success: function(data)
			{
				$('#AjaxConsultaReporte').html(data);
			}
		})		
	}

	function DetalleDiarioNoAsociado(FechaIngreso)
	{
		$('#AjaxNoAsociado').html('');
		$.ajax({
			url: 'NoAsociados.php',
			type: 'POST',
			data: {FechaIngreso: FechaIngreso},
			success: function(data)
			{
				$('#AjaxNoAsociado').html(data);
			}
		})		
	}//fin funcion detalle diario
</script>
</html>
