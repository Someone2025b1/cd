<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$UserID = $_SESSION["iduser"];
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
			<div class="container">
				<form class="form" role="form">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Ingreso de Factura de compra</strong></h4>
							</div>
							<div class="card-body">
							<?php
							#ESTO ES DE LA POLIZA, ingresa a transación y detallle de transacción
								$UI           = uniqid('tra_');
								$UID          = uniqid('trad_');
								$CodR         =uniqid('rep_');
								$KCod         =uniqid('KR_');
								$CodRD         =uniqid('repd_');
								$Contador     = count($_POST["Cuenta"]);
								$Centinela    = true;
								$Establecimiento = 1;
								
								$CodigoProveedor = $_POST["CodigoProveedor"];
								$NombreP         = $_POST["Nombre"];
								$SerieFactura = $_POST["SerieFactura"];
								$NoPedido = $_POST["Pedido"];
								$Factura      = $_POST["Factura"];
								$Fecha        = $_POST["Fecha"];
								$Descripcion  = $_POST["Descripcion"];
								$regimenp     =$_POST["RegimenC"];
								$TipoCompra   = "B";
								$Inventario = 1;

								$TotalFactura    = $_POST["TotalFactura"];

								$Cuenta       = $_POST["Cuenta"];
								$Cargos       = $_POST["Cargos"];
								$Abonos       = $_POST["Abonos"];
								$Razon        = $_POST["Razon"];


								$Cantidad  = $_POST["Cantidad"];
								$Producto  = $_POST["ProductoNombre"];
								$Precio    = $_POST["Precio"];
								$SubTotal  = $_POST["SubTotal"];
								$ProductoNombre = $_POST["ProductoNombre"];
								$Tipo 			= $_POST["Tipo"];
								$Contador2  = count($_POST["ProductoNombre"]);

								$TotalPoliza  = 0;

								if(isset($_POST["CajaChica"]))
								{
									$CajaChica = 1;
								}
								else
								{
									$CajaChica = 0;
								}

								if(isset($_POST["FacturaEspecial"]))
								{
									$FacturaEspecial = 1;
								}
								else
								{
									$FacturaEspecial = 0;
								}
							
								for($i=1; $i<$Contador; $i++)
								{
									$TotalPoliza  = $TotalPoliza + $Cargos[$i];
								}

								if($FacturaEspecial==0){
								$sql = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION (TRA_CODIGO, TRA_ESTABLECIMIENTO, TRA_FECHA_TRANS, TRA_SERIE, TRA_FACTURA, TRA_CONCEPTO, TC_CODIGO, TRA_TOTAL, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, P_CODIGO, TT_CODIGO, COM_CODIGO, TRA_A_INVENTARIO, TRA_ESTADO_INVENTARIO, TRA_SIN_FP, TRA_SALDO, TRA_CAJA_CHICA)
													VALUES('".$UI."', '$Establecimiento', '".$Fecha."', '".$SerieFactura."', '".$Factura."', '".$Descripcion."', '".$TipoCompra."', ".$TotalFactura.", CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$UserID ."', 1, '".$CodigoProveedor ."', 13, '---', ".$Inventario.", 1, 0, ".$TotalPoliza.", ".$CajaChica.")");
									
								if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
								{

									echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
											<h4 class="text-light">Código de transacción: '.$UI.'</h4>
										</div>';
									echo mysqli_error($sq, $sql);
									$Centinela = false;
									
								}
								else
								{
									for($i=1; $i<$Contador; $i++)
									{
										$Cue = $Cuenta[$i];
										$Car = $Cargos[$i];
										$Abo = $Abonos[$i];
										$Raz = $Razon[$i];

										$Xplotado = explode("/", $Cue);
										$NCue = $Xplotado[0];

										$query = mysqli_query($db, "INSERT INTO Contabilidad.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, N_CODIGO, TRAD_CARGO_CONTA, TRAD_ABONO_CONTA, TRAD_RAZON)
															VALUES('".$UID."', '".$UI."', '".$NCue."', ".$Car.", ".$Abo.", '".$Raz."')");

										if(!$query)
										{
											echo '<div class="col-lg-12 text-center">
													<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
													<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
													<h4 class="text-light">Código de transacción: '.$UID.'</h4>
												</div>';
											echo mysqli_error($sq, $query);
											$Centinela = false;
											
										}	
									}	
									
									
								}
							}

								$QueryEncabezado = mysqli_query($db, "INSERT INTO CompraVenta.RECEPCION_DE_PRODUCTO (RP_CODIGO, TRA_CODIGO, RP_FECHA, RP_NUMERO_FACTURA, RP_SERIE_FACTURA, PR_CODIGO, RP_TOTAL, RP_FECHA_HOY, C_NUMERO_DE_PEDIDO, RP_OBSERVACIONES, RP_USUARIO)
																VALUES ('".$CodR."', '".$UI."', '".$Fecha."', '".$Factura."', '".$SerieFactura."', '".$CodigoProveedor."', '".$TotalFactura."', CURRENT_DATE(), '".$NoPedido."', '".$Razon."', '".$UserID."')");

								

								if(!$QueryEncabezado)
								{
									echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
											<h4 class="text-light">Código de transacción: '.$UID.'</h4>
										</div>';
									echo mysqli_error($sq, $query);
									$Centinela = false;
									
								}
								else
								{
									for($j=1; $j<$Contador2; $j++)
									{
										$ProN = $ProductoNombre[$j]; 
										$Can = $Cantidad[$j];
										$Pro = $Producto[$j];
										$Pre = $Precio[$j];
										$Sub = $SubTotal[$j];
										$Tip = $Tipo[$j];
										$costototaling =0;
										$costonu=0;
										$ProductoXplotado = explode("/", $Pro);

										$Prod = $ProductoXplotado[0];

										

										$queryd = mysqli_query($db, "INSERT INTO CompraVenta.RECEPCION_DE_PRODUCTO_DETALLE (RP_CODIGO, RPD_CODIGO, RPD_CORRELATIVO, RPD_CANTIDAD, P_CODIGO, RPD_PRECIOUNITARIO, RPD_SUBTOTAL)
															VALUES('".$CodR."', '".$CodRD."', '".$j."', '".$Can."', '".$Prod."', '".$Pre."', '".$Sub."')");
										
										
										$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$Prod;
                                                    $result = mysqli_query($db, $queryp);
                                                    while($rowe = mysqli_fetch_array($result))
                                                    {
                                                       $existenciaAn=$rowe["P_EXISTENCIA_BODEGA"];
													   $existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];
													   $PrecioAn=$rowe["P_PRECIO_COMPRA_PONDERADO"];
													   $costototalanter=$rowe["P_EXISTENCIA_GENERAL"]*$rowe["P_PRECIO_COMPRA_PONDERADO"];
													   $cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $Can;


													   if( $rowe["P_EXISTENCIA_GENERAL"]<0){

														$cantidadgenP = $Can;
														$costototalanter=0;

													   }else{
													   $cantidadgenP = $rowe["P_EXISTENCIA_GENERAL"] + $Can;
													   }

													   $nuevaexistencia = $rowe["P_EXISTENCIA_BODEGA"] + $Can;
													   $costototaling=$Sub;

														if ($regimenp == 1){
															
															$costototaling=$Sub;
															$costonu = $Pre;

														}else{

															$costototaling= $Sub / 1.12;
															$costosiniva=number_format($costototaling, 3, ".", "");
															$costonu = $Pre / 1.12;
														}
														$totalcantidad=($costototalanter+$costototaling);

														
														$PrecioPonderado=$totalcantidad/$cantidadgenP;
                                                    

													$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
													P_EXISTENCIA_BODEGA = '".$nuevaexistencia."',
													P_EXISTENCIA_GENERAL = '".$cantidadgen."',
													P_PRECIO_COMPRA_PONDERADO = '".$PrecioPonderado."',
													P_ULTIMO_COSTO = '".$costonu."'
													WHERE P_CODIGO = ".$Prod);



													$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO, K_COSTO_ANTERIOR, K_COSTO_ENTRO, K_COSTO_PONDERADO)
													VALUES('".$KCod."', '".$UI."', '".$Prod."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Ingreso de Producto segun factura ".$Factura." del proveedor ".$NombreP."', '".$existenciaGAn."', '".$cantidadgen."', 5, '".$existenciaAn."', '".$nuevaexistencia."', '".$PrecioAn."', '".$costonu."', '".$PrecioPonderado."')");


													
								}}
								}	
								
								
								if($Centinela == true)
									{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">La factura de compra se ingresó correctamente.</h2>
											<div class="row">
												<div class="col-lg-6 text-right"><a href="IngresoImp.php?Codigo='.$UI.'" target="_blank"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>
												<div class="col-lg-6 text-left"><a href="NewFac.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
										</div>';
									}
							?>
							</div>
						</div>
					</div>
					<br>
					<br>
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
