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
<script src="material/material-pro/assets/plugins/jquery/jquery.min.js"></script>
     <script src="material/material-pro/assets/plugins/datatables/jquery.dataTables.min.js"></script>
 
     <script src="material/material-pro/assets/plugins/moment/moment.js"></script>
    <script src="material/material-pro/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="material/material-pro/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
         <!-- Bootstrap Core CSS -->
    <link href="../material/material-pro/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="material/material-pro/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="material/material-pro/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="material/material-pro/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="material/material-pro/assets/plugins/css-chart/css-chart.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="../material/material-pro/assets/plugins/c3-master/c3.min.css" rel="stylesheet">
    <!-- Vector CSS -->
    <link href="material/material-pro/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="material/material-pro/material/css/style.css" rel="stylesheet">
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

	<?php include("../../../../MenuTop.php");
	
	if($id_user==53711 | $id_user==22045 | $id_user==435849) {
		$Filtro="";
	}else{
		$Filtro="AND CC_REALIZO ="."$id_user";
	}
	?>

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
<h4 class="text-center"><strong>Cuentas por Cobrar</strong></h4>
</div>

<div class="card-body">

<title>Cuentas por Cobrar 
<?php echo $texto ?></title>
<div class="row">
</div>
<div class="col-lg-12">
									
									
									<h3 class="text-center">RESUMEN CUENTAS POR COBRAR</h3><br>
									<table class="table table-hover" id="TblTicketsHotelTotal">
									    <thead>
									      <tr> 
									        <th class="text-center">COLABORADOR</th>
											<th class="text-center">MONTO</th>
									        <th class="text-center">CANTIDAD DE FACTURAS</th>
									      </tr>
									    </thead>
									    <tbody>
									    	<?php 
									    	$Query2 = mysqli_query($db, "SELECT COUNT(*) AS CONT, sum(CC_TOTAL - CC_ABONO) as MONTO, A.*, B.CLI_NOMBRE, C.TRA_CONCEPTO, C.TRA_FECHA_HOY
											FROM Contabilidad.CUENTAS_POR_COBRAR AS A,
											Bodega.CLIENTE AS B,
											Contabilidad.TRANSACCION AS C
											WHERE B.CLI_NIT = A.CC_NIT
											AND C.TRA_CODIGO = A.F_CODIGO
											AND A.CC_ESTADO=1
											$Filtro
											GROUP BY A.CC_REALIZO");
									    	while($Fila2 = mysqli_fetch_array($Query2))
											{
												$Usuario   = $Fila2["CC_REALIZO"];

												$ToatlMonto+=$Fila2['MONTO'];
												$TotalFac+=$Fila2['CONT'];

												$sqlRet = mysqli_query($db,"SELECT A.nombre 
												FROM info_bbdd.usuarios AS A     
												WHERE A.id_user = ".$Usuario); 
												$rowret=mysqli_fetch_array($sqlRet);

												$NombreRet=$rowret["nombre"];
										?>
									    	<tr>
									    		<td align="lefth"><?php echo $NombreRet ?></td>
												<td align="lefth">Q.<?php echo number_format($Fila2['MONTO'], 2, '.', ',') ?></td>
									    		<td align="center"><?php echo $Fila2['CONT'] ?></td>
									    	</tr>
											<?php
											}
										?>
										<tr>
									    		<td align="lefth">TOTAL</td>
												<td align="lefth">Q.<?php echo number_format($ToatlMonto, 2, '.', ',') ?></td>
									    		<td align="center"><?php echo $TotalFac ?></td>
									    	</tr>
									    </tbody>
										
									</table>
								</div>	
<div class="row">
<div class="col-lg-12">

	<?php


	$Query = mysqli_query($db, "SELECT A.*, B.CLI_NOMBRE, C.TRA_CONCEPTO, C.TRA_FECHA_HOY
    FROM Contabilidad.CUENTAS_POR_COBRAR AS A,
    Bodega.CLIENTE AS B,
    Contabilidad.TRANSACCION AS C
    WHERE B.CLI_NIT = A.CC_NIT
    AND C.TRA_CODIGO = A.F_CODIGO
    AND A.CC_ESTADO=1
    $Filtro");

	

		$Registros = mysqli_num_rows($Query);

		if($Registros > 0)
		{
			?> 
			<center><h4>Cuentas por Cobrar 
<?php echo $texto ?></h4></center>

				<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel1" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
					<thead>
						<tr>
							<th><h5><strong>#</strong></h5></th>
							<th><h5><strong>FECHA FACTURA</strong></h5></th>
							<th><h5><strong>NOMBRE CLIENTE</strong></h5></th>
							<th><h5><strong>DESCRIPCIÓN</strong></h5></th>
							<th><h5><strong>MONTO</strong></h5></th>
							<th><h5><strong>SALDO</strong></h5></th>
							<th><h5><strong>RESPONSABLE</strong></h5></th>
							<th><h5><strong>DÍAS TRANSCURRIDOS</strong></h5></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$Contador = 1;
							while($Fila = mysqli_fetch_array($Query))
							{

								$MontoFac        =  $Fila["CC_TOTAL"];
                                $SaldoFac        =$Fila["CC_TOTAL"]-$Fila["CC_ABONO"];

                                $CodigoFac = $Fila["CC_CODIGO"]; 
                                $Usuario   = $Fila["CC_REALIZO"];
								$Nombre  = $Fila["CLI_NOMBRE"];           
        
                                $ConceptoFactura= $Fila["TRA_CONCEPTO"];
                                $FechaFacturaaa =$Fila["TRA_FECHA_HOY"];

								$fechapro= new DateTime($Fila["TRA_FECHA_HOY"]);
								$fechalis= new DateTime();
								$diferencia =  $fechapro -> diff($fechalis);
								$Diferencia = $diferencia -> days;

								$Codigo=$Fila["R_CODIGO"];

								$sqlRet = mysqli_query($db,"SELECT A.nombre 
                                FROM info_bbdd.usuarios AS A     
                                WHERE A.id_user = ".$Usuario); 
                                $rowret=mysqli_fetch_array($sqlRet);

                                $NombreRet=$rowret["nombre"];

								

								 
								?>
									<tr>
										<td><h6><?php echo $Contador ?></h6></td>
										<td><h6><?php echo $FechaFacturaaa ?></h6></td>
										<td><h6><?php echo $Nombre ?></h6></td>	 
										<td><h6><?php echo $ConceptoFactura ?></h6></td>	 
										<td class="text-center"><h6><?php echo number_format($MontoFac,2) ?></h6></td>
										<td class="text-center"><h6><?php echo number_format($SaldoFac,2) ?></h6></td>
										<td class="text-center"><h6><?php echo $NombreRet ?></h6></td>
										<td class="text-center"><h6 style="<?php if($Diferencia>30){echo "color:red;";} ?>"><?php echo $Diferencia ?></h6></td>
									</tr>
								<?php
								
								$sumaConteotO += $Total;
								$Contador++;
								
							}
							
							
						?>
						
						
					</tbody>
				</table>
				

			<?php
		}
		else
		{
			?>
				<div class="row text-center">
					<div class="alert alert-warning">
						<strong>No existen registros para las fechas ingresadas</strong>
					</div>
				</div>
			<?php
		}
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
							    buttons: [{
									extend: 'excelHtml5',
									orientation: 'landscape',
									pageSize: 'LEGAL'

									
								},{
									extend: 'pdfHtml5',
									orientation: 'landscape',
									pageSize: 'LEGAL'

									
								}
							    ]
							} );

							$('#TblTicketsHotelTotal').DataTable( {
							    dom: 'Bfrtip',
							    buttons: [{
									extend: 'excelHtml5'

									
								},{
									extend: 'pdfHtml5'

									
								}
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
 