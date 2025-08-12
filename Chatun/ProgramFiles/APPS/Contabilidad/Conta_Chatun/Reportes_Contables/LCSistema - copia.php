<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Periodo  = $_GET["Periodo"];
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
	<script src="../../../../../libs/bootstrap-table/js/bootstrap-table.min.js"></script>
	<script src="../../../../../libs/bootstrap-table/1.11.1/extensions/export/bootstrap-table-export.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/tableExport.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/es6-promise/es6-promise.auto.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/jsPDF/jspdf.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/js-xlsx/xlsx.core.min.js"></script>
	<script src="../../../../../libs/tableExport.jquery.plugin-master/libs/pdfmake/pdfmake.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/bootstrap-table/css/bootstrap-table.min.css">
	<link type="text/css" rel="stylesheet" href="../../../../../libs/bootstrap-table/1.11.1/extensions/filter-control/bootstrap-table-filter-control.css">
	<!-- END STYLESHEETS -->


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php 

		include("../../../../MenuTop.php") ;




	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container-fluid">
				<form class="form" role="form" id="FRMReporte" action="#" method="GET">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Libro Compras</strong></h4>
							</div>
							<div class="card-body">
								<table class="table table-hover table-condensed" id="table"
                                   data-toggle="table"
                                   data-toolbar="#toolbar"
                                   data-toggle-pagination="true"
                                   data-show-export="true"
                                   data-icons-prefix="fa"
                                   data-icons="icons"
                                   data-pagination="false"
                                   data-sortable="true"
                                   data-search="true"
                                   data-filter-control="true">
									<thead>
										<tr>
											<th data-sortable="true" data-field="FECHA" data-filter-control="input"><h6><strong>FECHA</strong></h6></th>
											<th data-sortable="true" data-field="SERIE" data-filter-control="input"><h6><strong>SERIE</strong></h6></th>
											<th data-sortable="true" data-field="FACTURA" data-filter-control="input"><h6><strong>FACTURA</strong></h6></th>
											<th data-sortable="true" data-field="NIT" data-filter-control="input"><h6><strong>NIT</strong></h6></th>
											<th data-sortable="true" data-field="PROVEEDOR" data-filter-control="input"><h6><strong>PROVEEDOR</strong></h6></th>
											<th data-sortable="true" data-field="DOCTO" data-filter-control="input"><h6><strong>DOCTO</strong></h6></th>
											<th data-sortable="true" data-field="BIENES" data-filter-control="input"><h6><strong>BIENES</strong></h6></th>
											<th data-sortable="true" data-field="SERVICIOS" data-filter-control="input"><h6><strong>SERVICIOS</strong></h6></th>
											<th data-sortable="true" data-field="COMBUSTIBLES" data-filter-control="input"><h6><strong>COMBUSTIBLES</strong></h6></th>
											<th data-sortable="true" data-field="IMPORTACION" data-filter-control="input"><h6><strong>IMPORTACIÓN</strong></h6></th>
											<th data-sortable="true" data-field="IVA" data-filter-control="input"><h6><strong>IVA</strong></h6></th>
											<th data-sortable="true" data-field="TOTAL" data-filter-control="input"><h6><strong>TOTAL</strong></h6></th>
										</tr>
									</thead>
									<tbody>
										<?php
											$QueryDetalle = mysqli_query($db, "SELECT *
																		FROM Contabilidad.TRANSACCION
																		LEFT JOIN Contabilidad.PROVEEDOR ON PROVEEDOR.P_CODIGO = TRANSACCION.P_CODIGO
																		LEFT JOIN Contabilidad.COMBUSTIBLE ON TRANSACCION.COM_CODIGO = COMBUSTIBLE.COM_CODIGO
																		WHERE (TRANSACCION.TT_CODIGO = 2 OR TRANSACCION.TT_CODIGO = 13 OR TRANSACCION.TT_CODIGO = 19)
																		AND TRANSACCION.E_CODIGO = 2
																		AND TRANSACCION.PC_CODIGO  = ".$Periodo."
																		AND TRANSACCION.TRA_CONCEPTO <> 'PÓLIZA ANULADA'
															            ORDER BY TRANSACCION.TRA_FECHA_TRANS ASC");
											while($row = mysqli_fetch_array($QueryDetalle))
											{
												$Bienes = 0;
									            $Combustibles = 0;
									            $Importacion = 0;
									            $Galones = 0;
									            $BienesNeto = 0;
									            $ImportacionNeto = 0;
									            $IDP = 0;
									            $CombustiblesNeto = 0;
									            $IVA = 0;
									            $Total = 0;

									            //SI PROVEEDOR ES PEQUEÑO CONTRIBUYENTE
											    if($row["REG_CODIGO"] == 1)
											    {
											        //SI LA FACTURA ES DE COMBUSTIBLES
											        if($row["TC_CODIGO"] == 'C')
											        {
											            $IVA = 0;
											            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
											            $Serie            = $row["TRA_SERIE"];
											            $Factura          = $row["TRA_FACTURA"];
											            $NIT              = $row["P_NIT"];
											            $Proveedor        = $row["P_NOMBRE"];
											            $Documento        = $row["TF_CODIGO"];
											            $Bienes           = 0.00;
											            $Combustibles     = $row["TRA_TOTAL"];
											            $Importacion      = 0.00;
											            $Galones          = $row["TRA_CANT_GALONES"];
											            $TipoCombustible  = $row["COM_CODIGO"];
											            $BienesNeto       = 0.00;
											            $ImportacionNeto  = 0.00;
											            $IDP              = $Galones * $row["COM_IDP"];
											            $CombustiblesNeto = ($row["TRA_TOTAL"]);
											            $IVA              = 0;
											            $Total            = $CombustiblesNeto + $IVA + $IDP;

											            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
											            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
											            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
											            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
											            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
											            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
											            $IDPMostrar              = number_format($IDP, 2, '.', ',');
											            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
											            $IVAMostrar              = number_format($IVA, 2, '.', ',');
											            $TotalMostrar            = number_format($Total, 2, '.', ',');

											            ?>
														    <tr>
														    <td align="left"><?php echo $Fecha ?></td>
														    <td align="left"><?php echo $Serie  ?></td>
														    <td align="left"><?php echo $Factura ?></td>
														    <td align="left"><?php echo $NIT ?></td>
														    <td align="left" ><?php echo $Proveedor ?></td>
														    <td align="left"><?php echo $Documento ?></td>
														    <td align="right"><?php echo $BienesMostrar ?></td>
														    <td align="right">0.00</td>
														    <td align="right"><?php echo $CombustiblesMostrar ?></td>
														    <td align="right"><?php echo $ImportacionMostrar ?></td>
														    <td align="right"><?php echo $IVAMostrar ?></td>
														    <td align="right"><?php echo $TotalMostrar ?></td>
														    </tr>
														<?php

											            $SumaTotalBienes       = $SumaTotalBienes + $Bienes;
											            $SumaTotalServicios    = $SumaTotalServicios + 0;
											            $SumaTotalCombustibles = $SumaTotalCombustibles + $Combustibles;
											            $SumaTotalImportacion  = $SumaTotalImportacion + $CombustiblesNeto;
											            $SumaTotalTotal        = $SumaTotalTotal + $Total;

											        }
											        //SI LA FACTURA ES BIENES
											        elseif($row["TC_CODIGO"] == 'B')
											        {
											            $IVA = 0;
											            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
											            $Serie            = $row["TRA_SERIE"];
											            $Factura          = $row["TRA_FACTURA"];
											            $NIT              = $row["P_NIT"];
											            $Proveedor        = $row["P_NOMBRE"];
											            $Documento        = $row["TF_CODIGO"];
											            $Bienes           = $row["TRA_TOTAL"];
											            $Combustibles     = 0.00;
											            $Importacion      = 0.00;
											            $Galones          = 0.00;
											            $TipoCombustible  = 0.00;
											            $ImportacionNeto  = 0.00;
											            $IDP              = 0.00;
											            $CombustiblesNeto = 0.00;
											            $BienesNeto1      = $row["TRA_TOTAL"];
											            $IVA              = 0;
											            $BienesNeto       = $row["TRA_TOTAL"]-$IVA;
											            $Total            = $BienesNeto + $IVA;

											            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
											            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
											            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
											            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
											            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
											            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
											            $IDPMostrar              = number_format($IDP, 2, '.', ',');
											            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
											            $IVAMostrar              = number_format($IVA, 2, '.', ',');
											            $TotalMostrar            = number_format($Total, 2, '.', ',');

											            ?>
														    <tr>
														    <td align="left"><?php echo $Fecha ?></td>
														    <td align="left"><?php echo $Serie  ?></td>
														    <td align="left"><?php echo $Factura ?></td>
														    <td align="left"><?php echo $NIT ?></td>
														    <td align="left" ><?php echo $Proveedor ?></td>
														    <td align="left"><?php echo $Documento ?></td>
														    <td align="right"><?php echo $BienesMostrar ?></td>
														    <td align="right">0.00</td>
														    <td align="right"><?php echo $CombustiblesMostrar ?></td>
														    <td align="right"><?php echo $ImportacionMostrar ?></td>
														    <td align="right">0.00</td>
														    <td align="right"><?php echo $TotalMostrar ?></td>
														    </tr>
														<?php

											           
											            
											            $SumaTotalBienes       = $SumaTotalBienes + $Bienes;
											            $SumaTotalServicios    = $SumaTotalServicios + 0;
											            $SumaTotalCombustibles = $SumaTotalCombustibles + $Combustibles;
											            $SumaTotalImportacion  = $SumaTotalImportacion + $CombustiblesNeto;
											            $SumaTotalTotal        = $SumaTotalTotal + $Total;
											        }
											        elseif($row["TC_CODIGO"] == 'S')
											        {
											            $IVA = 0;
											            $Concepto         = $row["TRA_CONCEPTO"];
											            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
											            $Serie            = $row["TRA_SERIE"];
											            $Factura          = $row["TRA_FACTURA"];
											            $NIT              = $row["P_NIT"];
											            $Proveedor        = $row["P_NOMBRE"];
											            $Documento        = $row["TF_CODIGO"];
											            $Bienes           = $row["TRA_TOTAL"];
											            $Combustibles     = 0.00;
											            $Importacion      = 0.00;
											            $Galones          = 0.00;
											            $TipoCombustible  = 0.00;
											            $ImportacionNeto  = 0.00;
											            $IDP              = 0.00;
											            $CombustiblesNeto = 0.00;
											            $BienesNeto1      = $row["TRA_TOTAL"];
											            $IVA              = 0;
											            $BienesNeto       = $row["TRA_TOTAL"]-$IVA;
											            $Total            = $BienesNeto + $IVA;

											            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
											            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
											            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
											            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
											            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
											            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
											            $IDPMostrar              = number_format($IDP, 2, '.', ',');
											            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
											            $IVAMostrar              = number_format($IVA, 2, '.', ',');
											            $TotalMostrar            = number_format($Total, 2, '.', ',');

											            if($Concepto != 'PÓLIZA ANULADA')
											            {
											            	?>
															    <tr>
															    <td align="left"><?php echo $Fecha ?></td>
															    <td align="left"><?php echo $Serie  ?></td>
															    <td align="left"><?php echo $Factura ?></td>
															    <td align="left"><?php echo $NIT ?></td>
															    <td align="left" ><?php echo $Proveedor ?></td>
															    <td align="left"><?php echo $Documento ?></td>
															    <td align="right">0.00</td>
															    <td align="right"><?php echo $BienesMostrar ?></td>
															    <td align="right"><?php echo $CombustiblesMostrar ?></td>
															    <td align="right"><?php echo $ImportacionMostrar ?></td>
															    <td align="right">0.00</td>
															    <td align="right"><?php echo $TotalMostrar ?></td>
															    </tr>
															<?php
												           
												            
												            $SumaTotalBienes       = $SumaTotalBienes + 0;
												            $SumaTotalServicios    = $SumaTotalServicios + $Bienes;
												            $SumaTotalCombustibles = $SumaTotalCombustibles + $Combustibles;
												            $SumaTotalImportacion  = $SumaTotalImportacion + $CombustiblesNeto;
												            $SumaTotalTotal        = $SumaTotalTotal + $Total;
											            }
											            
											        }
											    }
											    //SI ES PROVEEDOR CONTRIBUYENTE NORMAL
											    elseif($row["REG_CODIGO"] == 2 || $row["REG_CODIGO"] == 4)
											    {
											        //SI LA FACTURA ES DE COMBUSTIBLES
											        if($row["TC_CODIGO"] == 'C')
											        {
											            $IVA = 0;
											            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
											            $Serie            = $row["TRA_SERIE"];
											            $Factura          = $row["TRA_FACTURA"];
											            $NIT              = $row["P_NIT"];
											            $Proveedor        = $row["P_NOMBRE"];
											            $Documento        = $row["TF_CODIGO"];
											            $Bienes           = 0.00;
											            $Combustibles     = $row["TRA_TOTAL"];
											            $Importacion      = 0.00;
											            $Galones          = $row["TRA_CANT_GALONES"];
											            $TipoCombustible  = $row["COM_CODIGO"];
											            $BienesNeto       = 0.00;
											            $ImportacionNeto  = 0.00;
											            $IDP              = $Galones * $row["COM_IDP"];
											            $CombustiblesNeto = ($row["TRA_TOTAL"])/1.12;
											            $IVA              = $CombustiblesNeto * 0.12;
											            $Total            = $CombustiblesNeto + $IVA;

											            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
											            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
											            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
											            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
											            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
											            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
											            $IDPMostrar              = number_format($IDP, 2, '.', ',');
											            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
											            $IVAMostrar              = number_format($IVA, 2, '.', ',');
											            $TotalMostrar            = number_format($Total, 2, '.', ',');

											            ?>
														    <tr>
														    <td align="left"><?php echo $Fecha ?></td>
														    <td align="left"><?php echo $Serie  ?></td>
														    <td align="left"><?php echo $Factura ?></td>
														    <td align="left"><?php echo $NIT ?></td>
														    <td align="left"><?php echo $Proveedor ?></td>
														    <td align="left"><?php echo $Documento ?></td>
														    <td align="right"><?php echo $BienesMostrar ?></td>
														    <td align="right">0.00</td>
														    <td align="right"><?php echo $CombustiblesNetoMostrar ?></td>
														    <td align="right"><?php echo $ImportacionMostrar ?></td>
														    <td align="right"><?php echo $IVAMostrar ?></td>
														    <td align="right"><?php echo $TotalMostrar ?></td>
														    </tr>
														<?php
											
											           

											            
											            $SumaTotalBienes       = $SumaTotalBienes + $BienesNeto;
											            $SumaTotalServicios    = $SumaTotalServicios + 0;
											            $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
											            $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
											            $SumaTotalTotal        = $SumaTotalTotal + $Total;
											        }
											        //SI LA FACTURA ES BIENES/SERVICIOS
											        elseif($row["TC_CODIGO"] == 'B')
											        {
											            $IVA = 0;
											            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
											            $Serie            = $row["TRA_SERIE"];
											            $Factura          = $row["TRA_FACTURA"];
											            $NIT              = $row["P_NIT"];
											            $Proveedor        = $row["P_NOMBRE"];
											            $Documento        = $row["TF_CODIGO"];
											            $Bienes           = $row["TRA_TOTAL"];
											            $Combustibles     = 0.00;
											            $Importacion      = 0.00;
											            $Galones          = 0.00;
											            $TipoCombustible  = 0.00;
											            $BienesNeto       = $row["TRA_TOTAL"]/1.12;
											            $ImportacionNeto  = 0.00;
											            $IDP              = 0.00;
											            $CombustiblesNeto = 0.00;
											            $IVA              = $BienesNeto * 0.12;
											            $Total            = $BienesNeto + $IVA;

											            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
											            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
											            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
											            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
											            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
											            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
											            $IDPMostrar              = number_format($IDP, 2, '.', ',');
											            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
											            $IVAMostrar              = number_format($IVA, 2, '.', ',');
											            $TotalMostrar            = number_format($Total, 2, '.', ',');

											            ?>
														    <tr>
														    <td align="left"><?php echo $Fecha ?></td>
														    <td align="left"><?php echo $Serie  ?></td>
														    <td align="left"><?php echo $Factura ?></td>
														    <td align="left"><?php echo $NIT ?></td>
														    <td align="left"><?php echo $Proveedor ?></td>
														    <td align="left"><?php echo $Documento ?></td>
														    <td align="right"><?php echo $BienesNetoMostrar ?></td>
														    <td align="right">0.00</td>
														    <td align="right"><?php echo $CombustiblesMostrar ?></td>
														    <td align="right"><?php echo $ImportacionMostrar ?></td>
														    <td align="right"><?php echo $IVAMostrar ?></td>
														    <td align="right"><?php echo $TotalMostrar ?></td>
														    </tr>
														<?php

											           

											            $SumaTotalBienes       = $SumaTotalBienes + $BienesNeto;
											            $SumaTotalServicios    = $SumaTotalServicios + 0;
											            $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
											            $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
											            $SumaTotalTotal        = $SumaTotalTotal + $Total;
											        }
											        elseif($row["TC_CODIGO"] == 'S')
											        {
											            $IVA = 0;
											            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
											            $Serie            = $row["TRA_SERIE"];
											            $Factura          = $row["TRA_FACTURA"];
											            $NIT              = $row["P_NIT"];
											            $Proveedor        = $row["P_NOMBRE"];
											            $Documento        = $row["TF_CODIGO"];
											            $Bienes           = $row["TRA_TOTAL"];
											            $Combustibles     = 0.00;
											            $Importacion      = 0.00;
											            $Galones          = 0.00;
											            $TipoCombustible  = 0.00;
											            $BienesNeto       = $row["TRA_TOTAL"]/1.12;
											            $ImportacionNeto  = 0.00;
											            $IDP              = 0.00;
											            $CombustiblesNeto = 0.00;
											            $IVA              = $BienesNeto * 0.12;
											            $Total            = $BienesNeto + $IVA;

											            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
											            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
											            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
											            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
											            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
											            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
											            $IDPMostrar              = number_format($IDP, 2, '.', ',');
											            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
											            $IVAMostrar              = number_format($IVA, 2, '.', ',');
											            $TotalMostrar            = number_format($Total, 2, '.', ',');

											            ?>
														    <tr>
														    <td align="left"><?php echo $Fecha ?></td>
														    <td align="left"><?php echo $Serie  ?></td>
														    <td align="left"><?php echo $Factura ?></td>
														    <td align="left"><?php echo $NIT ?></td>
														    <td align="left"><?php echo $Proveedor ?></td>
														    <td align="left"><?php echo $Documento ?></td>
														    <td align="right">0.00</td>
														    <td align="right"><?php echo $BienesNetoMostrar ?></td>
														    <td align="right"><?php echo $CombustiblesMostrar ?></td>
														    <td align="right"><?php echo $ImportacionMostrar ?></td>
														    <td align="right"><?php echo $IVAMostrar ?></td>
														    <td align="right"><?php echo $TotalMostrar ?></td>
														    </tr>
														<?php
											
											           

											            $SumaTotalBienes       = $SumaTotalBienes + 0;
											            $SumaTotalServicios    = $SumaTotalServicios + $BienesNeto;
											            $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
											            $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
											            $SumaTotalTotal        = $SumaTotalTotal + $Total;
											        }
											        else
											        {
											        	if($row["TT_CODIGO"] == 19)
											        	{
											        		if($row["TRA_CONCEPTO"] == 'Bien')
											        		{
											        			$IVA = 0;
													            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
													            $Serie            = $row["TRA_SERIE"];
													            $Factura          = $row["TRA_FACTURA"];
													            $NIT              = $row["P_NIT"];
													            $Proveedor        = $row["P_NOMBRE"];
													            $Documento        = $row["TF_CODIGO"];
													            $Bienes           = $row["TRA_TOTAL"];
													            $Combustibles     = 0.00;
													            $Importacion      = 0.00;
													            $Galones          = 0.00;
													            $TipoCombustible  = 0.00;
													            $BienesNeto       = $row["TRA_TOTAL"]/1.12;
													            $ImportacionNeto  = 0.00;
													            $IDP              = 0.00;
													            $CombustiblesNeto = 0.00;
													            $IVA              = $BienesNeto * 0.12;
													            $Total            = $BienesNeto + $IVA;

													            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
													            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
													            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
													            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
													            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
													            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
													            $IDPMostrar              = number_format($IDP, 2, '.', ',');
													            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
													            $IVAMostrar              = number_format($IVA, 2, '.', ',');
													            $TotalMostrar            = number_format($Total, 2, '.', ',');

													            ?>
																    <tr>
																    <td align="left"><?php echo $Fecha ?></td>
																    <td align="left"><?php echo $Serie  ?></td>
																    <td align="left"><?php echo $Factura ?></td>
																    <td align="left"><?php echo $NIT ?></td>
																    <td align="left"><?php echo $Proveedor ?></td>
																    <td align="left"><?php echo $Documento ?></td>
																    <td align="right"><?php echo $BienesNetoMostrar ?></td>
																    <td align="right">0.00</td>
																    <td align="right"><?php echo $CombustiblesMostrar ?></td>
																    <td align="right"><?php echo $ImportacionMostrar ?></td>
																    <td align="right"><?php echo $IVAMostrar ?></td>
																    <td align="right"><?php echo $TotalMostrar ?></td>
																    </tr>
																<?php

													           

													            $SumaTotalBienes       = $SumaTotalBienes + $BienesNeto;
													            $SumaTotalServicios    = $SumaTotalServicios + 0;
													            $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
													            $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
													            $SumaTotalTotal        = $SumaTotalTotal + $Total;
											        		}
											        		else
											        		{
											        			$IVA = 0;
													            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
													            $Serie            = $row["TRA_SERIE"];
													            $Factura          = $row["TRA_FACTURA"];
													            $NIT              = $row["P_NIT"];
													            $Proveedor        = $row["P_NOMBRE"];
													            $Documento        = $row["TF_CODIGO"];
													            $Bienes           = $row["TRA_TOTAL"];
													            $Combustibles     = 0.00;
													            $Importacion      = 0.00;
													            $Galones          = 0.00;
													            $TipoCombustible  = 0.00;
													            $BienesNeto       = $row["TRA_TOTAL"]/1.12;
													            $ImportacionNeto  = 0.00;
													            $IDP              = 0.00;
													            $CombustiblesNeto = 0.00;
													            $IVA              = $BienesNeto * 0.12;
													            $Total            = $BienesNeto + $IVA;

													            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
													            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
													            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
													            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
													            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
													            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
													            $IDPMostrar              = number_format($IDP, 2, '.', ',');
													            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
													            $IVAMostrar              = number_format($IVA, 2, '.', ',');
													            $TotalMostrar            = number_format($Total, 2, '.', ',');

													            ?>
																    <tr>
																    <td align="left"><?php echo $Fecha ?></td>
																    <td align="left"><?php echo $Serie  ?></td>
																    <td align="left"><?php echo $Factura ?></td>
																    <td align="left"><?php echo $NIT ?></td>
																    <td align="left"><?php echo $Proveedor ?></td>
																    <td align="left"><?php echo $Documento ?></td>
																    <td align="right">0.00</td>
																    <td align="right"><?php echo $BienesNetoMostrar ?></td>
																    <td align="right"><?php echo $CombustiblesMostrar ?></td>
																    <td align="right"><?php echo $ImportacionMostrar ?></td>
																    <td align="right"><?php echo $IVAMostrar ?></td>
																    <td align="right"><?php echo $TotalMostrar ?></td>
																    </tr>
																<?php
													
													           

													            $SumaTotalBienes       = $SumaTotalBienes + 0;
													            $SumaTotalServicios    = $SumaTotalServicios + $BienesNeto;
													            $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
													            $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
													            $SumaTotalTotal        = $SumaTotalTotal + $Total;
											        		}
											        	}
											        }
											         $TotalIVASuma +=$IVA; 
											    }
											}
										?>
									</tbody>
									<tfoot>
										<?php
											$TotalIVASuma  = number_format($TotalIVASuma, 2, '.', ',');
											$SumaTotalBienesFormato       = number_format($SumaTotalBienes, 2, '.', ',');
											$SumaTotalServiciosFormato    = number_format($SumaTotalServicios, 2, '.', ',');
											$SumaTotalCombustiblesFormato = number_format($SumaTotalCombustibles, 2, '.', ',');
											$SumaTotalImportacionFormato  = 0.00;
											$SumaTotalTotalFormato        = number_format($SumaTotalTotal, 2, '.', ',');

											?>
												<tr>
											    <td align="left"></td>
											    <td align="left"></td>
											    <td align="left"></td>
											    <td align="left"></td>
											    <td align="left"></td>
											    <td align="left">TOTAL</td>
											    <td align="right"><b><?php echo $SumaTotalBienesFormato ?></b></td>
											    <td align="right"><b><?php echo $SumaTotalServiciosFormato ?></b></td>
											    <td align="right"><b><?php echo $SumaTotalCombustiblesFormato ?></b></td>
											    <td align="right"><b><?php echo $SumaTotalImportacionFormato ?></b></td>
											    <td align="right"><b><?php echo $TotalIVASuma ?></b></td>
											    <td align="right"><b><?php echo $SumaTotalTotalFormato ?></b></td>
											    </tr>
											<?php
										?>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

		<!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Resultados de su búsqueda</h2>
                    </div>
                    <div class="modal-body">
                    	<div id="suggestions" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
