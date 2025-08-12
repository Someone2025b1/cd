<?php 
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/conex_a_coosajo.php");
include("../../../../Script/conex_sql_server.php");
include("../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
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
	<script src="../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- <script src="../../../../js/libs/tableexport/base64.min.js"></script> -->
	<script src="../../../../js/libs/tableexport/jquery.base64.js"></script>
	<script src="../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	
	<!-- END JAVASCRIPT -->
	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="../../../../libs/TableFilter/filtergrid.css">
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
								<h4 class="text-center"><strong>DETALLE DE CUENTAS POR COBRAR</strong></h4>
							</div>
							<div class="card-body">
								 <div class="row">
								 	<div class="col-lg-8">
									<table class="table table-hover" id="TblTicketsHotel">
									    <thead>
									       <tr>
									      	<th>No.</th>
									        <th>HOTELES SOCIOS VENDEDORES</th>
									        <th class="text-center">ADULTO</th>
									        <th class="text-center">NIÑO</th>
									        <th class="text-center">CUENTA POR COBRAR Q.<br> TOTAL</th>
									      </tr>
									    </thead>
									    <tbody>
									    <?php
									    $Contador = 1;
									   $Tickets = mysqli_query($db, "SELECT a.H_CODIGO, b.H_NOMBRE, SUM(a.IH_ADULTOS) AS ADULTOS, SUM(a.IH_NINOS) AS NINOS 
											FROM Taquilla.INGRESO_HOTEL a
											INNER JOIN Taquilla.HOTEL b ON a.H_CODIGO = b.H_CODIGO
											WHERE a.IH_VALE > 0 AND NOT EXISTS (SELECT *FROM Taquilla.DETALLE_VALE_FACTURA c 
											where a.IH_VALE = c.DVF_Vale AND a.H_CODIGO = c.DVF_Hotel AND c.DVF_Estado = 2)
											GROUP BY a.H_CODIGO
											");
									   $PrecioAdulto = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 1"));
										$PrecioNino = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 2"));
									    while($TicketHotelResult = mysqli_fetch_array($Tickets))
									    	{
									    	$id = $TicketHotelResult["H_CODIGO"];
									    	$total =   ($TicketHotelResult["ADULTOS"]*$PrecioAdulto["Precio"])+($TicketHotelResult["NINOS"]*$PrecioNino["Precio"]);
									      ?>
									      <tr>
									    	<td><?php echo $Contador?></td>
									    	<td><a href="DetalleHotel.php?Id=<?php echo $id ?>"><?php echo $TicketHotelResult[H_NOMBRE]?></a></td>
									    	<td align="center"><?php echo $TicketHotelResult[ADULTOS] ?></td>
									    	<td align="center"><?php echo $TicketHotelResult[NINOS]?></td>
									    	<td align="center">Q. <?php echo number_format($total,2)?></td>   	 
								    	   </tr>
								    	<?php  
								    	$Contador++; 
								    		$totalAdultos += $TicketHotelResult[ADULTOS];
								    		$totalNinos += $TicketHotelResult[NINOS];
								    		$totalHotel += $total;
								    		} 	
								    	?>
								    	<tr>
								    		<td></td>
								    		<td></td>
								    		<td class="text-center"><?php echo $totalAdultos ?> </td> 
								    		<td class="text-center"><?php echo $totalNinos ?> </td> 
								    		<td class="text-center">Q. <?php echo number_format($totalHotel,2) ?></td>
								    	</tr>
									    </tbody>
									  </table>
								</div>	
								<div class="col-lg-4">
									<div class="row">
										<div class="col-lg-6">
											<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
										</div>
										<div class="col-lg-6">
											<a href="ImprimirDetalleCuenta.php" target="_blank" type="button" class="btn ink-reaction btn-raised btn-primary"  >Exportar PDF</a>
										</div>
									</div>
									<h3 class="text-center">RESUMEN VENTAS POR COBRAR</h3><br>
									<h4 class="text-center">FECHA: <?php echo $fechaHoy ?></h4>
									<table class="table table-hover" id="TblTicketsHotelTotal">
									    <thead>
									      <tr> 
									        <th class="text-center">ADULTO</th>
									        <th class="text-center">NIÑO</th>
									        <th class="text-center">TOTAL</th>
									      </tr>
									    </thead>
									    <tbody>
									    	<?php 
									    	$PrecioAdulto = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 1"));
											$PrecioNino = mysqli_fetch_array(mysqli_query($db, "SELECT A.Precio FROM Taquilla.ADMIN_PRECIOS A WHERE A.Id = 2"));
									    	$TotalCobrar = mysqli_fetch_array(mysqli_query($db, "SELECT a.H_CODIGO, b.H_NOMBRE, SUM(a.IH_ADULTOS) AS ADULTOS, SUM(a.IH_NINOS) AS NINOS 
											FROM Taquilla.INGRESO_HOTEL a
											INNER JOIN Taquilla.HOTEL b ON a.H_CODIGO = b.H_CODIGO
											WHERE a.IH_VALE > 0 AND NOT EXISTS (SELECT *FROM Taquilla.DETALLE_VALE_FACTURA c 
											where a.IH_VALE = c.DVF_Vale AND a.H_CODIGO = c.DVF_Hotel AND c.DVF_Estado = 2)
												"));
									    	$totalEntrada =   ($TotalCobrar[ADULTOS]*$PrecioAdulto["Precio"])+($TotalCobrar[NINOS]*$PrecioNino["Precio"]);
										?>
									    	<tr>
									    		<td align="center"><?php echo $TotalCobrar['ADULTOS'] ?></td>
									    		<td align="center"><?php echo $TotalCobrar['NINOS'] ?></td>
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
