<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");  
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$Id = $_GET["Id"];
$NombreHotel = mysqli_fetch_array(mysqli_query($db, "SELECT b.H_NOMBRE
FROM   Taquilla.HOTEL b WHERE b.H_CODIGO = $Id"));
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
	<script src="../../../../../libs/alertify/js/alertify.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container"><br>
				<form class="form" action="#" method="GET" role="form" >
					<div class="col-lg-12"> 
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>INVENTARIO</strong></h4>

								<h4 class="text-right"><strong><a href="CTH.php">Regresar </a></strong></h4>
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
									      	<th>ENTREGADOS</th>
									      	<th></th>
									      	<th></th>
									      	<th>RECIBIDOS</th>
									      	<th></th>
									      	<th></th> 
									      	<th>DE BAJA</th>
									      	<th></th>
									      	<th></th> 
									      	<th>CORTE</th>
									      	<th></th>
									      </tr>
									      <tr> 
									        <th class="text-center">FECHA</th>
									        <th class="text-center">DESCRIPCION</th> 
									        <th class="text-center">DEL</th>
									        <th class="text-center">AL</th>
									        <th class="text-center">TOTAL</th>
									        <th class="text-center">DEL</th>
									        <th class="text-center">AL</th>
									        <th class="text-center">TOTAL</th>
									        <th class="text-center">DEL</th>
									        <th class="text-center">AL</th>
									        <th class="text-center">TOTAL</th>
									        <th class="text-center">DEL</th>
									        <th class="text-center">AL</th>
									        <th class="text-center">TOTAL</th>
									        <th class="text-center">VALES DISPONIBLES</th>
									      </tr>
									    </thead>
									    <tbody>
									    <?php
									    $Contador = 1;
									  $Tickets = mysqli_query($db, "SELECT a.ATT_DEL, a.ATT_AL, a.ATT_FECHA  FROM Taquilla.ASIGNACION_TALONARIO_TICKET a 
										WHERE a.H_CODIGO = $Id 
										");
									    while($TicketHotelResult = mysqli_fetch_array($Tickets))
									    	{
												$del=$TicketHotelResult["ATT_DEL"];
												$al=$TicketHotelResult["ATT_AL"];

												

									    	$id = $TicketHotelResult["H_CODIGO"];
											
									    	$totalValeEntrega = ($TicketHotelResult["ATT_AL"] - $TicketHotelResult["ATT_DEL"])+1;

											
									      ?>
									      <tr>
									    	<td><?php echo cambio_fecha($TicketHotelResult["ATT_FECHA"])?></td> 
									    	<td>ENTREGA</td>
									    	<td align="center"><?php echo $TicketHotelResult["ATT_DEL"] ?></td>
									    	<td align="center"><?php echo $TicketHotelResult["ATT_AL"] ?></td>
									    	<td align="center"><?php echo $totalValeEntrega ?></td> 
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>  
									    	<td></td>
									    	<td></td> 
									    	<td></td>		 
								    	   </tr>
								    	<?php  
								    	$Contador++; 
								    		$totalAdultos += $TicketHotelResult[ADULTOS];
								    		$totalNinos += $TicketHotelResult[NINOS];
								    		$totalHotel += $totalValeEntrega;
											$TiketReal=0;

											
								    		} 	 

									   $Tickets2 = mysqli_query($db, "SELECT COUNT(*) AS Contador, MIN(a.IH_VALE) AS MINIMO, MAX(a.IH_VALE) AS MAXIMO, DATE(a.IH_FECHA) AS Fecha
										FROM Taquilla.INGRESO_HOTEL a 
										WHERE a.IH_VALE > 0 and a.H_CODIGO = $Id
										GROUP BY DATE(a.IH_FECHA)
										 ");
									    while($TicketHotelResult2 = mysqli_fetch_array($Tickets2))
									    	{
									    	$id = $TicketHotelResult2["H_CODIGO"];
									    	$total1 =  mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(*) AS Contador FROM Taquilla.INGRESO_HOTEL a
											WHERE a.IH_VALE > 0 and a.H_CODIGO = $Id
											GROUP BY DATE(a.IH_FECHA)"));
											$total1 = $TicketHotelResult2["Contador"];
									      ?>
									      <tr>
									    	<td><?php echo cambio_fecha($TicketHotelResult2["Fecha"])?></td> 
									    	<td>INGRESO</td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td align="center"><?php echo $TicketHotelResult2[MINIMO] ?></td>
									    	<td align="center"><?php echo $TicketHotelResult2[MAXIMO]?></td>
									    	<td align="center"><?php echo $total1?></td>  
									    	<td></td>
									    	<td></td>
									    	<td></td> 
									    	<td></td>
									    	<td></td>
									    	<td></td> 
									    	<td></td>		 
								    	   </tr>
								    	<?php    
								    		$totalAdultos1 += $TicketHotelResult2[ADULTOS];
								    		$totalNinos1 += $TicketHotelResult2[NINO];
								    		$totalHotel1 += $total1;
								    		} 	
								    	
								    	$Tickets3 = mysqli_query($db, "SELECT MIN(a.DAV_VALE) AS MINIMO, MAX(a.DAV_VALE) AS MAXIMO, a.DAV_FECHA_BAJA
										FROM Taquilla.DETALLE_ASIGNACION_VALE a 
										WHERE a.H_CODIGO = $Id AND a.DAV_ESTADO = 3
										GROUP BY a.ATT_CODIGO 
										");
									    while($TicketHotelResult3 = mysqli_fetch_array($Tickets3))
									    	{  
									    		$totalValeEntrega3 = ($TicketHotelResult3["MAXIMO"] - $TicketHotelResult3["MINIMO"]) + 1;
									      ?>
									      <tr>
									    	<td><?php echo cambio_fecha($TicketHotelResult3["DAV_FECHA_BAJA"])?></td> 
									    	<td>BAJA</td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td align="center"><?php echo $TicketHotelResult3["MINIMO"] ?></td>
									    	<td align="center"><?php echo $TicketHotelResult3["MAXIMO"] ?></td>
									    	<td align="center"><?php echo $totalValeEntrega3 ?></td>  
									    	<td></td>
									    	<td></td>
									    	<td></td> 
									    	<td></td>	
								    	   </tr>
								    	<?php    
								    		 $totalHotel2 += $totalValeEntrega3;
								    		} 	
								    	 $Tickets2 = mysqli_query($db, "SELECT DATE(b.CH_Fecha) as Fecha, MIN(c.DVF_Vale) AS MINIMO, MAX(c.DVF_Vale) AS MAXIMO, COUNT(*) AS CONT
										FROM Taquilla.DETALLE_CORTE a 
										INNER JOIN Taquilla.CORTE_HOTEL b ON a.CH_Id = b.CH_Id
										INNER JOIN Taquilla.DETALLE_VALE_FACTURA c ON c.DC_Id = a.DC_Id
										WHERE a.H_CODIGO = $Id and b.CH_Estado = 2
										GROUP BY  DATE(b.CH_Fecha)");
									    while($TicketHotelResult2 = mysqli_fetch_array($Tickets2))
									    	{
									    	 
									      ?>
									      <tr>
									    	<td><?php echo cambio_fecha($TicketHotelResult2["Fecha"])?></td> 
									    	<td>CORTE</td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td></td>
									    	<td align="center"> </td>
									    	<td align="center"> </td>
									    	<td align="center"> </td>  
									    	<td align="center"><?php echo $TicketHotelResult2[MINIMO] ?></td>
									    	<td align="center"><?php echo $TicketHotelResult2[MAXIMO]?></td>
									    	<td align="center"><?php echo $TicketHotelResult2[CONT]?></td>   	 
									    	<td></td> 
								    	   </tr>
								    	<?php     
								    		$totalcorte += $TicketHotelResult2[CONT]; 
								    		} 
								    		?>
								    	<tr>
								    		<td></td>
								    		<td></td>
								    		<td class="text-center"> </td> 
								    		<td class="text-center"> </td> 
								    		<td class="text-center"><?php echo $totalHotel ?></td>
								    		<td class="text-center"> </td> 
								    		<td class="text-center"> </td> 
								    		<td class="text-center"><?php echo $totalHotel1 ?></td>
								    		<td class="text-center"> </td> 
								    		<td class="text-center"> </td> 
								    		<td class="text-center"><?php echo $totalHotel2 ?></td>
								    		<td class="text-center"> </td>
								    		<td class="text-center"> </td>
								    		<td class="text-center"><?php echo $totalcorte ?></td>
								    		<td class="text-center"><?php echo abs($totalHotel - $totalHotel1 -$totalHotel2) ?></td>

								    	</tr>
									    </tbody>
									  </table>
								</div>
								<!--
								<div class="col-lg-4">
								<h3 class="text-center">TOTAL INGRESO HOTEL</h3><br>
									<h4 class="text-center">FECHA: <?php echo $fechaHoy ?></h4>
								
									<div>
									<table class="table table-hover" id="TblTicketsHotelTotal">
									    <thead> 
									      <tr> 
									        <th class="text-center">ADULTO</th>
									        <th class="text-center">NIÑO</th>
									        <th class="text-center">SALDO</th>
									      </tr>
									    </thead>
									    <tbody>
									    	<tr>
									    		<td align="center"><?php echo abs($TotalAdu) ?></td>
									    		<td align="center"><?php echo abs($TotalNino) ?></td>
									    		<td align="center">Q. <?php echo number_format($totalHotel,2) ?></td>
									    	</tr>
									    </tbody>
										
									</table>	  
								</div>
								-->
								</div>
							</div>
						</div>
					</div>
					</div>
					 
				</form>
			</div>
		</div>
	</div>
	 <?php include("../../Hotel/MenuUsers.html"); ?>
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
