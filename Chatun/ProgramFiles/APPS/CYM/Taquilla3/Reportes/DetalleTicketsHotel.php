<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$CodigoHotel = $_POST['CodigoHotel'];

if($CodigoHotel == "T")
{
	$FiltroHotel = "";
}
else
{
	$FiltroHotel = "where ATT.H_CODIGO = $CodigoHotel";
}

$Tickets = mysqli_query($db, "SELECT ATT.*, H.* from Taquilla.ASIGNACION_TALONARIO_TICKET AS ATT LEFT JOIN Taquilla.HOTEL AS H on ATT.H_CODIGO = H.H_CODIGO $FiltroHotel ");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">

	<style type="text/css">
        .well{
        	 background: rgb(134, 192, 72);
        }
    </style>

</head>



	<header align="center">
		<h3>Tickets Entregados a <?php echo $NombreHotel?></h3>
	</header>
	<?php 
	if(mysqli_num_rows($Tickets) >= 1)
		{
	 ?>
	<div align="center">
		<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar</button>
	</div>
	<?php 
		}
	 ?>
	<br>
		<table class="table table-hover" id="TblTicketsHotel">
		    <thead>
		      <tr>
		      	<th>Colaborador</th>
		        <th>Fecha</th>
		        <th>Hora</th>
		        <th>Hotel</th>
		        <th>Del</th>
		        <th>Al</th>
		        <th>Estado</th>					     
		        <th>Tipo Talonario</th>
		        <th>Razon de baja</th>
		      </tr>
		    </thead>
		    <tbody>
		    <?php
		    $Contador = 1;
		    while($TicketHotelResult = mysqli_fetch_array($Tickets))
		    	{
		    		if($TicketHotelResult["ATT_ESTADO"] == 0)
						{
							$Estado = 'Activo';
						}
						else
						{
							$Estado = 'Inactivo';
						}
					if($TicketHotelResult["ATT_TIPO_TALONARIO"] == 1)
						{
						$TipoTalonario = 'Tickets Niños Menores a 5 Años';
						}
						elseif($fila["ATT_TIPO_TALONARIO"] == 2)
						{
							$TipoTalonario = 'Tickets Niños';
						}
						else
						{
							$TipoTalonario = 'Tickets Adultos';	
						}
		      ?>
		      <tr>
		    	<td><?php echo saber_nombre_asociado_orden($TicketHotelResult[ATT_COLABORADOR]) ?></td>
		    	<td><?php echo cambio_fecha($TicketHotelResult[ATT_FECHA])?></td>
		    	<td><?php echo $TicketHotelResult[ATT_HORA]?></td>
		    	<td><?php echo $TicketHotelResult[H_NOMBRE] ?></td>
		    	<td><?php echo $TicketHotelResult[ATT_DEL] ?></td>
		    	<td><?php echo $TicketHotelResult[ATT_AL] ?></td>
		    	<td><?php echo $Estado?></td>
		    	<td><?php echo $TipoTalonario?></td>
		    	<td><?php echo $TicketHotelResult[ATT_RAZON_BAJA] ?></td>
	    	   </tr>
	    	<?php  
	    	$Contador++;
	    		}
	    	?>
		    </tbody>
		    
		  </table>
					    		

<script>
var Contador = "<?php echo $Contador ?>";
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
	results_per_page: ["# Filas por Página...",[10,25,50,100, Contador]],  
	btn_reset: true,
	col_0: "select",
	col_5: "select",
	col_6: "select",
  };
  var tf = setFilterGrid('TblTicketsHotel', tbl_filtrado);//fin opciones para tabla de productos

  $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click
</script>
</html>
