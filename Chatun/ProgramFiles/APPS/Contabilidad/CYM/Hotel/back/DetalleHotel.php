<?php 
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/conex_a_coosajo.php");
include("../../../../Script/conex_sql_server.php");
include("../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$Id = $_GET["Id"];
$NombreHotel = mysqli_fetch_array(mysqli_query($db, "SELECT b.H_NOMBRE
FROM   Taquilla.HOTEL b WHERE b.H_CODIGO = $Id"));
$PrecioAdulto = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 1"));
$PrecioNino = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 2"));

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
	<script src="../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../../js/core/source/App.js"></script>
	<script src="../../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../../js/core/source/AppCard.js"></script>
	<script src="../../../../js/core/source/AppForm.js"></script>
	<script src="../../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../../js/core/source/AppVendor.js"></script>
	<script src="../../../../js/core/demo/Demo.js"></script>
	<script src="../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../libs/alertify/js/alertify.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin">

	<?php include("../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container"><br>
				<form class="form" action="#" method="GET" role="form" >
					<div class="col-lg-12"> 
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>HISTORIAL DE VENTAS</strong></h4>
							</div>
							<div class="card-body">
								<h2>INSTITUCIÓN: <?php echo $NombreHotel["H_NOMBRE"] ?></h2>
								 <div class="row">
								 	<div class="col-lg-8">
									<table class="table table-hover" id="TblTicketsHotel">
									    <thead>
									      <tr>
									      	<th></th>
									      	<th></th>
									      	<th></th>
									      	<th>TAQUILLA</th>
									      	<th></th>
									      	<th></th> 
									      </tr>
									      <tr> 
									        <th class="text-center">FECHA</th>
									        <th class="text-center">DESCRIPCION</th> 
									        <th>Total</th>
									        <th>Adultos</th>
									        <th>Niños</th>
									        <th>TOTAL CXC</th> 
									        <th>Vales</th>
									      </tr>
									    </thead>
									    <tbody>
									    <?php
									    $Contador = 1;
									   $Tickets = mysqli_query($db, "SELECT SUM(a.IH_ADULTOS) AS ADULTOS, SUM(a.IH_NINOS) AS NINOS, DATE(a.IH_FECHA) AS Fecha
										FROM Taquilla.INGRESO_HOTEL a
										INNER JOIN Taquilla.HOTEL b ON a.H_CODIGO = b.H_CODIGO
										WHERE a.H_CODIGO = $Id AND a.IH_VALE>0
										GROUP BY DATE(a.IH_FECHA)
										HAVING ADULTOS >0 OR NINOS >0");
									    while($TicketHotelResult = mysqli_fetch_array($Tickets))
									    	{
									    	$id = $TicketHotelResult["H_CODIGO"];
									    	$total =   ($TicketHotelResult["ADULTOS"]*$PrecioAdulto["Precio"])+($TicketHotelResult["NINOS"]*$PrecioNino["Precio"]);
									      	
									      ?>
									      <tr>
									    	<td><?php echo cambio_fecha($TicketHotelResult["Fecha"])?></td> 
									    	<td>INGRESO</td>
									    	<td></td>
									    	<td align="center"><?php echo $TicketHotelResult[ADULTOS] ?></td>
									    	<td align="center"><?php echo $TicketHotelResult[NINOS]?></td>
									    	<td align="center">Q. <?php echo $total?></td>
									    	<td>
									    		<?php 
									    		$Vales = mysqli_query($db, "SELECT a.IH_VALE FROM Taquilla.INGRESO_HOTEL  a 
												WHERE a.H_CODIGO = $Id AND a.IH_FECHA = '$TicketHotelResult[Fecha]'");
												while ($DetVale = mysqli_fetch_array($Vales)) 
												{
													echo $DetVale["IH_VALE"].", ";
												}
											 ?>
									    	</td>
									     	 
								    	   </tr>
								    	<?php  
								    	$Contador++; 
								    		$totalAdultos += $TicketHotelResult[ADULTOS];
								    		$totalNinos += $TicketHotelResult[NINOS];
								    		$totalHotel += $total;
								    		} 	 

									 /*  $Tickets2 = mysqli_query($db, "SELECT DATE(b.CH_Fecha) as Fecha, SUM(a.DC_Adultos) AS ADULTOS, SUM(a.DC_Ninos) AS NINO 
										FROM Taquilla.DETALLE_CORTE a 
										INNER JOIN Taquilla.CORTE_HOTEL b ON a.CH_Id = b.CH_Id
										WHERE a.H_CODIGO = 1
										GROUP BY  DATE(b.CH_Fecha) ");
									    while($TicketHotelResult2 = mysqli_fetch_array($Tickets2))
									    	{
									    	$id = $TicketHotelResult2["H_CODIGO"];
									    	$total1 =   ($TicketHotelResult2["ADULTOS"]*$PrecioAdulto["Precio"])+($TicketHotelResult2["NINO"]*$PrecioNino["Precio"]);
									      ?>
									      <tr>
									    	<td><?php echo cambio_fecha($TicketHotelResult2["Fecha"])?></td> 
									    	<td>CORTE</td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td align="center"><?php echo $TicketHotelResult2[ADULTOS] ?></td>
									    	<td align="center"><?php echo $TicketHotelResult2[NINO]?></td>
									    	<td align="center">Q. <?php echo $total1?></td>   	 
								    	   </tr>
								    	<?php    
								    		$totalAdultos1 += $TicketHotelResult2[ADULTOS];
								    		$totalNinos1 += $TicketHotelResult2[NINO];
								    		$totalHotel1 += $total1;
								    		} 	
								    	*/
								    	$Tickets3 = mysqli_query($db, "SELECT a.ATT_FECHA, COUNT(*) AS CONTADOR FROM Taquilla.ASIGNACION_TALONARIO_TICKET a 
								    	WHERE a.H_CODIGO = $Id AND a.ATT_ESTADO = 0
										GROUP BY a.ATT_FECHA");
									    while($TicketHotelResult3 = mysqli_fetch_array($Tickets3))
									    	{  
									      ?>
									      <tr>
									    	<td><?php echo cambio_fecha($TicketHotelResult3["ATT_FECHA"])?></td> 
									    	<td>ENTREGA</td>
									    	<td align="center"><?php echo $TicketHotelResult3["CONTADOR"] ?></td>
									    	<td align="center"> </td>
									    	<td align="center"> </td> 
								    	   </tr>
								    	<?php    
								    		 $totalEntrega += $TicketHotelResult3["CONTADOR"];
								    		} 	
								    	?>
								    	<tr>
								    		<td></td>
								    		<td></td>
								    		<td class="text-center"><?php echo $totalEntrega ?> </td>
								    		<td class="text-center"><?php echo $totalAdultos ?> </td> 
								    		<td class="text-center"><?php echo $totalNinos ?> </td> 
								    		<td class="text-center">Q. <?php echo number_format($totalHotel,2) ?></td>
								    		<td class="text-center"><?php echo $totalAdultos1 ?> </td> 
								    		<td class="text-center"><?php echo $totalNinos1 ?> </td>  
								    	</tr>
									    </tbody>
									  </table>
								</div>	
								<div class="col-lg-4">
									<!-- <div class="row">
										<div class="col-lg-6">
											<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
										</div>
										<div class="col-lg-6">
											<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar PDF</button>
										</div>
									</div> -->
									<h3 class="text-center">TOTAL PENDIENTE CORTE</h3><br>
									<h4 class="text-center">FECHA: <?php echo $fechaHoy ?></h4>
									<table class="table table-hover" id="TblTicketsHotelTotal">
									    <thead> 
									      <tr> 
									        <th class="text-center">ADULTO</th>
									        <th class="text-center">NIÑO</th>
									        <th class="text-center">SALDO</th>
									      </tr>
									    </thead>
									    <tbody>
									    	<?php 
											$TotalAdu = $totalAdultos - $totalAdultos1;
									    	$TotalNino = $totalNinos - $totalNinos1; 
									    	$totalEntrada =   abs(($TotalAdu*$PrecioAdulto["Precio"])+($TotalNino*$PrecioNino["Precio"]));
										?>
									    	<tr>
									    		<td align="center"><?php echo abs($TotalAdu) ?></td>
									    		<td align="center"><?php echo abs($TotalNino) ?></td>
									    		<td align="center">Q. <?php echo number_format($totalEntrada,2) ?></td>
									    	</tr>
									    </tbody>
										
									</table>
								</div>	    		
								</div>
							</div>
						</div>
					</div> 
				</form>
			</div>
		</div>
	</div>
	 <?php include("MenuUsers.html"); ?>
	<!-- END BASE -->
	</body>
	</html>
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
    loader_html: "<img src='../../../../img/Preloader.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
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
