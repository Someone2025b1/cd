<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$SelectMes = $_POST['SelectMes'];
$anio = $_POST['anio'];

$FechaIngreso = $_POST['FechaIngreso'];
if(isset($FechaIngreso))
{
	$FiltroFecha = "WHERE INA_FECHA_INGRESO = '$FechaIngreso' ";
}
else
{
	$FiltroFecha = "WHERE MONTH(INA_FECHA_INGRESO) = ".$SelectMes." and YEAR(INA_FECHA_INGRESO) = ".$anio." ";
}

$NoAsociado = mysqli_query($db, "SELECT * FROM Taquilla.INGRESO_NO_ASOCIADO $FiltroFecha ");
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
					<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarNoAsociado">Exportar</button>
				</div>
				<br>
					<table class="table table-hover" id="TblIngresoNoAsociado">
					    <thead>
					      <tr>
					        <th>#</th>
					        <th>Nombre</th>
					        <th>Pais</th>
					        <th>Departamento</th>
					        <th>Municipio</th>
					        <th>Visita Esquipulas</th>
					        <th>Frecuencia Parque</th>
					        <th>Email</th>
					        <th>Busca en Parque</th>
					        <th>Colaborador Ingresa</th>
					        <th>Fecha Ingreso</th>
					        <th>Adulto</th>
					        <th>Niño</th>
					        <th>Menor a 5 años</th>
					      </tr>
					    </thead>
					    <tbody>
					    <?php 
					    	$contador =1 ;
					    	while($NoAsociadoResult = mysqli_fetch_array($NoAsociado))
					    	{
					    		$ExistenNoAsociados = $NoAsociadoResult[INA_CODIGO];
					    		if($NoAsociadoResult[INA_PAIS] == 79)
					    		{
					    			$SaberDepartamento = saber_departamento_honduras($NoAsociadoResult[INA_DEPARTAMENTO]);
					    			$SaberMunicipio = "";
					    		}
					    		if($NoAsociadoResult[INA_PAIS] == 73)
					    		{
					    			$SaberDepartamento = saber_departamento($NoAsociadoResult[INA_DEPARTAMENTO]);
					    			$SaberMunicipio = saber_municipio_nombre($NoAsociadoResult[INA_MUNICIPIO]);
					    		}
					    		if($NoAsociadoResult[INA_PAIS] == 54)
					    		{
					    			$SaberDepartamento = saber_departamento_salvador($NoAsociadoResult[INA_DEPARTAMENTO]);
					    			$SaberMunicipio = "";
					    		}

					    		if($NoAsociadoResult[INA_VISITA_ESQUIPULAS] == 1)
					    		{
					    			$VisitaEsquipulas = "Cada Mes";
					    		}
					    		if($NoAsociadoResult[INA_VISITA_ESQUIPULAS] == 2)
					    		{
					    			$VisitaEsquipulas = "Dos veces al año";
					    		}
					    		if($NoAsociadoResult[INA_VISITA_ESQUIPULAS] == 3)
					    		{
					    			$VisitaEsquipulas = "Una vezl año";
					    		}	
					    		if($NoAsociadoResult[INA_VISITA_ESQUIPULAS == 4])
					    		{
					    			$VisitaEsquipulas = "Otros";
					    		}
					    			
					    ?>
						   	<tr>
						   		<td><?php echo $contador++?></td>
						   		<td><?php echo $NoAsociadoResult[INA_NOMBRE]?></td>
						   		<td><?php echo saber_pais($NoAsociadoResult[INA_PAIS])?></td>
						   		<td><?php echo $SaberDepartamento?></td>
						   		<td><?php echo $SaberMunicipio?></td>
						   		<td><?php echo $VisitaEsquipulas?></td>
						   		<td><?php echo $NoAsociadoResult[INA_FRECUENCIA_VISITA]?></td>
						   		<td><?php echo $NoAsociadoResult[INA_CORREO]?></td>
						   		<td><?php echo $NoAsociadoResult[INA_BUSQUEDA_CENTRO]?></td>
						   		<td><?php echo saber_nombre_asociado_orden($NoAsociadoResult[INA_CIF_COLABORADOR])?></td>
						   		<td class="text-center"><?php echo cambio_fecha($NoAsociadoResult[INA_FECHA_INGRESO])?></td>
						   		<td class="text-center"><?php echo $NoAsociadoResult[INA_ADULTO]?></td>
						   		<td class="text-center"><?php echo $NoAsociadoResult[INA_NINIO]?></td>
						   		<td class="text-center"><?php echo $NoAsociadoResult[INA_NINIO_MENOR_5]?></td>
						   	</tr>
					   <?php 
					   		}
					   ?>
					    </tbody>
					  </table>
					    		
			</div><!-- fin div row  -->


<script>
	$('#myTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
    });

jQuery(document).ready(function($) {
	var ExistenNoAsociados = "<?php echo $ExistenNoAsociados?>";
	$('#BtnExportarNoAsociado').prop('disabled', true);		

	if(ExistenNoAsociados >= 1)
	{
		$('#BtnExportarNoAsociado').prop('disabled', false);
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
	col_0: "",
	col_2: "select",
	col_3: "select",
	col_4: "select",
  };
  var tf = setFilterGrid('TblIngresoNoAsociado', tbl_filtrado);//fin opciones para tabla de productos

		$('#BtnExportarNoAsociado').click(function(event) {
			$('#TblIngresoNoAsociado').tableExport({
				type:'excel',
				escape:'false', 
				ignoreColumn: [3],
			});//fin funcion exportar
		});//fin funcion click
	
</script>
</html>
