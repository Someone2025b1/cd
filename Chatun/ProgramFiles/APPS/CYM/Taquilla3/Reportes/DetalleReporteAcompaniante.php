<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$IA_REFERENCIA = $_POST['IA_REFERENCIA'];

$Acompaniante = mysqli_query($db, "SELECT IA.*, EP.EP_NOMBRE FROM Taquilla.INGRESO_ACOMPANIANTE as IA,
Taquilla.ENTERADO_PARQUE as EP where IA.IAT_ENTERADO = EP.EP_ID AND IA_REFERENCIA =  '$IA_REFERENCIA' ");
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

	<style type="text/css">
        .well{
        	 background: rgb(134, 192, 72);
        }
    </style>

</head>


	<div class="row">
				<div align="center">
					<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarDetalleAcompanante">Exportar</button>
				</div>
				<br>
					<table class="table table-hover" id="TblAcompaniante">
					    <thead>
					      <tr>					     
					        <th>#</th>
					        <th>Asociado</th>
					        <th>Pais</th>
					        <th>Departamento</th>
					        <th>Municipio</th>
					        <th>Frecuencia Visita</th>
							<th>Tipo Enterado</th>
							<th>Teléfono</th>
							<th>Búsqueda Centro</th>
							<th>Fecha Ingreso</th>
							<th>Hora Ingreso</th>
					      </tr>
					    </thead>
					    <tbody>
					    <?php 
					    $contador_acompaniante = 1;
					    while($DetalleAcompaniante = mysqli_fetch_array($Acompaniante))
					    	{
					    	$ExistenAcompaniante = $DetalleAcompaniante["IAT_CODIGO"];
					    	$Pais = $DetalleAcompaniante['IAT_SELECT_PAIS'];
					    	$Departamento = $DetalleAcompaniante['IAT_SELECT_DEPARTAMENTO'];
					    	$Municipio = $DetalleAcompaniante['IAT_SELECT_MUNICIPIO'];

					    	if($DetalleAcompaniante['IAT_SELECT_PAIS'] == 73)// si es guatemala
					    	{
					    		$Pais = saber_pais($DetalleAcompaniante['IAT_SELECT_PAIS']);
					    		$Departamento = saber_departamento($DetalleAcompaniante['IAT_SELECT_DEPARTAMENTO']);
					    		$Municipio = saber_municipio_nombre($DetalleAcompaniante['IAT_SELECT_MUNICIPIO']);
					    	}
					    	if($Pais == 54)//si es El salvador
					    	{
					    		 $Pais = saber_pais($DetalleAcompaniante['IAT_SELECT_PAIS']);
					    		 $Departamento = saber_departamento_salvador($DetalleAcompaniante['IAT_SELECT_DEPARTAMENTO']);
					    		 $Municipio  = "--";
					    	}
					    	if($DetalleAcompaniante['IAT_SELECT_PAIS'] == 79)// si es honduras
					    	{
					    		$Pais = saber_pais($DetalleAcompaniante['IAT_SELECT_PAIS']);
					    		$Departamento = saber_departamento_honduras($DetalleAcompaniante['IAT_SELECT_DEPARTAMENTO']);
					    		$Municipio = "--";
					    	}
					    	if($DetalleAcompaniante['IAT_TELEFONO'] == "")					    
					    	{
					    		$Telefono = "--";
					    	}
					    ?>
						  <tr>
						  	<td><?php echo $contador_acompaniante++ ?></td>
						  	<td><?php echo saber_nombre_asociado_orden($DetalleAcompaniante["IAT_CIF_ASOCIADO"])?></td>
						  	<td><?php echo $Pais?></td>
						  	<td><?php echo $Departamento?></td>
						  	<td><?php echo $Municipio?></td>
						  	<td><?php echo $DetalleAcompaniante["IAT_FRECUENCIA_VISITA"]?></td>
						  	<td><?php echo $DetalleAcompaniante["EP_NOMBRE"]?></td>
						  	<td><?php echo $Telefono?></td>
						  	<td><?php echo $DetalleAcompaniante["IAT_BUSQUEDA_CENTRO"]?></td>
						  	<td class="text-center"><?php echo cambio_fecha($DetalleAcompaniante["IA_FECHA_INGRESO"])?></td>
						  	<td class="text-center"><?php echo $DetalleAcompaniante["IA_HORA_INGRESO"]?></td>
						  </tr>
						  <?php 
						  	}
						  ?>
					    </tbody>
					  </table>
			</div><!-- fin div row  -->

<script>
jQuery(document).ready(function($) {
	var contador = "<?php echo $ExistenAcompaniante?>";
	$('#BtnExportarDetalleAcompanante').prop('disabled', true);		

	if(contador > 1)
	{
		$('#BtnExportarDetalleAcompanante').prop('disabled', false);
	}
	else
	{
	}
});


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
	results_per_page: ["# Filas por Página...",[10,25,50,100]],  
	btn_reset: true,
	col_0: "",
	col_1: "select",
	col_2: "select",
	col_3: "select",
	col_4: "select",
	col_5: "select",
	col_6: "select",
	col_8: "select",
  };
  var tf = setFilterGrid('TblAcompaniante', tbl_filtrado);//fin opciones para tabla de productos

		$('#BtnExportarDetalleAcompanante').click(function(event) {
			alertify.error();
			$('#TblAcompaniante').tableExport({type:'excel',escape:'false'});
		});
	
</script>
</html>
