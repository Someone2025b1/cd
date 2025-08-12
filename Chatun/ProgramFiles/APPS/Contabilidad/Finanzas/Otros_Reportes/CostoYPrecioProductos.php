<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
	<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- <script src="../../../../../js/libs/tableexport/base64.min.js"></script> -->
	<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
<script src="../material/material-pro/assets/plugins/jquery/jquery.min.js"></script>
     <script src="../material/material-pro/assets/plugins/datatables/jquery.dataTables.min.js"></script>
 
     <script src="../material/material-pro/assets/plugins/moment/moment.js"></script>
    <script src="../material/material-pro/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="../material/material-pro/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
         <!-- Bootstrap Core CSS -->
    <link href="../material/material-pro/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="../material/material-pro/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="../material/material-pro/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="../material/material-pro/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="../material/material-pro/assets/plugins/css-chart/css-chart.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../material/material-pro/assets/plugins/c3-master/c3.min.css" rel="stylesheet">
    <!-- Vector CSS -->
    <link href="../material/material-pro/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="../material/material-pro/material/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../material/material-pro/material/css/colors/blue.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="../Script/alertify_bueno/alertify.core.css">
    <link rel="stylesheet" href="../Script/alertify_bueno/alertify.default.css"> 
    <script src="datatables/jquery-3.5.1.js"></script>
    <script src="datatables/jquery.dataTables.min.js"></script>
    <script src="datatables/dataTables.buttons.min.js"></script> 
    <script src="datatables/jszip.min.js"></script>
    <script src="datatables/buttons.html5.min.js"></script>
    <script src="datatables/pdf.js"></script>
    <script src="datatables/vfs_fonts.js"></script>  

	<!-- END STYLESHEETS -->

	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

<!-- BEGIN CONTENT-->
<div id="content">
<div class="container">
<form class="form" action="#" method="GET" role="form" >
<div class="col-lg-12">
<br>
<div class="card">
<div class="card-head style-primary">
<h4 class="text-center"><strong>Costo Venta de Recetas</strong></h4>
</div>

<div class="card-body">

<title>Margen Productos 
<?php echo $texto ?></title>
<div class="row">
<br>
<br>
<br>
</div>
<div class="row">
<div class="col-lg-12">

	<?php


	
			?> 
			<center><h4>Recetas 
<?php echo $texto ?></h4></center>

				<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel1" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
					<thead>
						<tr>
							<th><h5><strong>#</strong></h5></th>
							<th><h5><strong>CODIGO</strong></h5></th>
							<th><h5><strong>NOMBRE PRODUCTO</strong></h5></th>
							<th><h5><strong>PRECIO COSTO</strong></h5></th>
							<th><h5><strong>PRECIO VENTA CON IVA</strong></h5></th>
							<th><h5><strong>PRECIO VENTA SIN IVA</strong></h5></th>
							<th><h5><strong>MARGEN DE COSTO</strong></h5></th>
							<th><h5><strong>MARGEN DE GANACIA</strong></h5></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$Contador = 1;
							


								$queryp = "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.R_CODIGO IS NULL AND  PRODUCTO.P_ESTADO=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1";
								$result = mysqli_query($db, $queryp);
								while($rowe = mysqli_fetch_array($result))
								{ 
									$PrecioVenta=$rowe["P_PRECIO_VENTA"];
									

								
								
								$Nombre=$rowe["P_NOMBRE"];
								$Codigo=$rowe["P_CODIGO"];
								$Costo=$rowe["P_ULTIMO_COSTO"];
								$Margen=(((($PrecioVenta/1.12)-$Costo)*100)/$Costo);
								$MargenCo=((($Costo)*100)/($PrecioVenta/1.12));
								$PrecioVentaSin=$PrecioVenta/1.12;
								

								 
								?>
									<tr>
										<td><h6><?php echo $Contador ?></h6></td>
										<td><h6><?php echo $Codigo ?></h6></td>
										<td><h6><?php echo $Nombre ?></h6></td>	 
										<td class="text-center"><h6><?php echo number_format($Costo,2) ?></h6></td>
										<td class="text-center"><h6><?php echo number_format($PrecioVenta,2) ?></h6></td>
										<td class="text-center"><h6><?php echo number_format($PrecioVentaSin,2) ?></h6></td>
										<td class="text-center"><h6><?php echo number_format($MargenCo,2) ?>%</h6></td>
										<td class="text-center"><h6><?php echo number_format($Margen,2) ?>%</h6></td>
									</tr>
								<?php
								
								$sumaConteotO += $Total;
								$Contador++;
								
							
								}
							
						?>
						
						
					</tbody>
				</table>
				

			<?php
		
	?>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include("../MenuUsers.html"); ?>
</form>
<script>
			function verDetalle()
			{
				
							$('#TblTicketsHotel1').DataTable( {
							    dom: 'Bfrtip',
							    buttons: [
							        'copy', 'excel', 'pdf'
							    ]
							} );
							
					};
			
		</script>

<script>
	verDetalle();
	</script>
</div>
</body>
	</html>
 