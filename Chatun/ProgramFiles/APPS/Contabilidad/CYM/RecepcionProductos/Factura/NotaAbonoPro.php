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
								<h4 class="text-center"><strong>Pedido de Producto a Bodega o Punto de Ventas</strong></h4>
							</div>
							<div class="card-body">
							<?php
							#ESTO ES DE LA POLIZA, ingresa a transación y detallle de transacción
								$Cargo         =uniqid('NC_');
								$CargoD         =uniqid('NCD_');
								$Centinela    = true;
                                $KCod          = uniqid('KR_');

                                $Contador     = count($_POST["Cantidad"]);
								$Cantidad  = $_POST["Cantidad"];
                                $Bodega    = 5;
                                $Descripcion    = $_POST["Descripcion"];
								$Producto  = $_POST["ProductoNombre"];
								$ProductoNombre = $_POST["ProductoNombre"];
                                $Total=$_POST["TotalFacturaFinal"];
                                
								$Contador2  = count($_POST["ProductoNombre"]);



								
								

								
									for($j=1; $j<$Contador; $j++)
									{
										$ProN = $ProductoNombre[$j]; 
										$Can = $Cantidad[$j];
										$Pro = $Producto[$j];
										$ProductoXplotado = explode("/", $Pro);

										$Prod = $ProductoXplotado[0];


                                        #consuta de Producto para obtener los datos
									$querypr = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO = ".$Prod;
									$resultpr = mysqli_query($db, $querypr);
									while($rowpr = mysqli_fetch_array($resultpr))
									{

                                        $newcantsou=$rowpr["P_EXISTENCIA_BODEGA"]-$Can;
                                        $existenciasou=$rowpr["P_EXISTENCIA_BODEGA"];
										$existenciagen=$rowpr["P_EXISTENCIA_GENERAL"];
										$existenciagennew=$rowpr["P_EXISTENCIA_GENERAL"]-$Can;


										$Ponderado = $rowpr["P_PRECIO_COMPRA_PONDERADO"];


										
									}

                                    $QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
															P_EXISTENCIA_GENERAL = '".$existenciagennew."',
															P_EXISTENCIA_BODEGA = '".$newcantsou."'
															WHERE P_CODIGO = ".$Prod);

										
                                    $SubTotalCargo=$Can*$Ponderado;
                                    $TotalCargo+=$SubTotalCargo;
                                
                                    #Rergistro de Kardex constancia de modificación de existencia
                                $querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO, K_COSTO_ANTERIOR, K_COSTO_ENTRO, K_COSTO_PONDERADO)
                                VALUES('".$KCod."', '".$Cargo."', '".$Prod."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Nota de Abono Manual', '".$existenciagen."', '".$existenciagennew."', '".$Bodega."', '".$existenciasou."', '".$newcantsou."', '-', '-', '-')");

                                    #Notas de Cargo
                                $CargoDetalle = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO_DETALLE (NCA_CODIGO, NCAD_CODIGO, P_CODIGO, NCAD_CANTIDAD, NCAD_COSTO, NCAD_SUBTOTAL)
                                VALUES('".$Cargo."', '".$CargoD."', '".$Prod."', '".$Can."', '".$Ponderado."', '".$SubTotalCargo."')");

								}	

                                $InsertarCargo = mysqli_query($db, "INSERT INTO Productos.NOTAS_CARGO_ABONO (NCA_CODIGO, NCA_FECHA, NCA_HORA, NCA_TOTAL, PV_CODIGO, NCA_DESCRIPCION, NCA_CARGO, NCA_ABONO)
								VALUES('".$Cargo."', CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$TotalCargo."', '5', '".$Descripcion."', '1', '0')");

                        if(!$InsertarCargo)
                        {
                            echo '<div class="col-lg-12 text-center">
                                    <h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
                                    <h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
                                    <h4 class="text-light">Código de transacción: '.$CodEN.'</h4>
                                </div>';
                            echo mysqli_error($sq, $query);
                            $Centinela = false;
                            
                                }else{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">La factura de compra se ingresó correctamente.</h2>
											';
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
	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
