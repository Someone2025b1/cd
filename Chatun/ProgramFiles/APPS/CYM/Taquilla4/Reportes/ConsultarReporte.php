<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
header('Content-Type: text/html; charset=utf-8');
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$SelectMes = $_POST['SelectMes'];
$anio = $_POST['anio'];

$FechaIngreso = $_POST['FechaIngreso'];
if(isset($FechaIngreso))
{
	$FiltroFecha = "WHERE IA_FECHA_INGRESO = '$FechaIngreso' ";
}
else
{
	$FiltroFecha = "WHERE MONTH(IA_FECHA_INGRESO) = ".$SelectMes." and YEAR(IA_FECHA_INGRESO) = ".$anio." ";
}

$asociado = mysqli_query($db, "SELECT * FROM Taquilla.INGRESO_ASOCIADO $FiltroFecha GROUP BY IAT_CIF_ASOCIADO");
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
				<div align="center">
					<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportar">Exportar</button>
				</div>
				<br>
					<table class="table table-hover" id="TblIngresoAsociado">
					    <thead>
					      <tr>
					        <th>#</th>
					        <th>Nombre Asociado</th>
					        <th>Colaborador Ingresa</th>
					        <th>Acompañante</th>
					        <th>Fecha de Ingreso</th>
					        <th>Hora de Ingreso</th>
					      </tr>
					    </thead>
					    <tbody>
					    <?php 
					    	$contador = 1;
		    	while($asociado_result = mysqli_fetch_array($asociado))
		    	{
		    		$ExistenAsociados = $asociado_result["IA_CODIGO"];
		   $acompaniante = mysqli_query($db, "SELECT COUNT( * ) as total
FROM Taquilla.INGRESO_ACOMPANIANTE AS A
INNER JOIN Taquilla.INGRESO_ASOCIADO AS B ON A.IA_REFERENCIA = B.IA_REFERENCIA
WHERE B.IAT_CIF_ASOCIADO = $asociado_result[IAT_CIF_ASOCIADO] ");
		   $acompaniante_result = mysqli_fetch_array($acompaniante);

					    ?>
					      <tr>
					        <td><?php echo $contador++?></td>
					        <td><?php echo utf8_encode(saber_nombre_asociado_orden($asociado_result[IAT_CIF_ASOCIADO]))?></td>
					        <td><?php echo utf8_encode(saber_nombre_asociado_orden($asociado_result[IAT_CIF_COLABORADOR]))?></td>

	        <td class="text-center">
    		  <button type="button" class="btn btn-primary" onClick="DetalleAcompaniante('<?php echo $asociado_result[IA_REFERENCIA]?>', '', '')" <?php if($acompaniante_result[0] == 0){ echo "disabled";}?>>
			      <i class="fa fa-users" aria-hidden="true"></i>
			  </button>
	        </td>

					        <td><?php echo $asociado_result[IA_FECHA_INGRESO]?></td>
					        <td><?php echo $asociado_result[IA_HORA_INGRESO]?></td>
					      </tr>
					    <?php 
					      }//fin while asociado
					    ?>
					    </tbody>
					  </table>
			</div><!-- fin div row  -->


<div class="modal fade" id="ModalDetalleAcompaniante">
	<div class="modal-dialog" style="width:90%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Acompaniante</h4>
			</div>
			<div class="modal-body">
				<div id="DetalleAcompaniante"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>
jQuery(document).ready(function($) {
	var ExistenAsociados = "<?php echo $ExistenAsociados?>";
	$('#BtnExportar').prop('disabled', true);		

	if(ExistenAsociados > 1)
	{
		$('#BtnExportar').prop('disabled', false);
	}
	else
	{
	}
});

function DetalleAcompaniante(IA_REFERENCIA)
{
	$('#ModalDetalleAcompaniante').modal('show');
	$.ajax({
		url: 'DetalleReporteAcompaniante.php',
		type: 'POSt',
		data: {IA_REFERENCIA},
		success: function(data)
		{
			$('#DetalleAcompaniante').html(data);
		}
	})
}//fin fucion detalle_acompaniante
var contador = "<?php echo $contador ?>";
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
	results_per_page: ["# Filas por Página...",[10,25,50,100, contador]],  
	btn_reset: true,
	col_0: "",
	col_3: ""
  };
  var tf = setFilterGrid('TblIngresoAsociado', tbl_filtrado);//fin opciones para tabla de productos

		$('#BtnExportar').click(function(event) {
			$('#TblIngresoAsociado').tableExport({
				type:'excel',
				escape:'false', 
				ignoreColumn: [3],
			});//fin funcion exportar
		});//fin funcion click
	
</script>
</html>
