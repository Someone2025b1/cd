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
								

							$CDCod           = uniqid('cd_');

								$Nombre    = $_POST["Nombre"];
								$PrecioVenta = $_POST["PrecioVenta"];
								$Cantidad  = $_POST["Cantidad"];
								$Producto  = $_POST["ProductoNombre"];
								$Precio    = $_POST["Precio"];
								$SubTotal  = $_POST["SubTotal"];
								$ProductoNombre = $_POST["ProductoNombre"];
								$Tipo 			= $_POST["Tipo"];
								$Contador2  = count($_POST["ProductoNombre"]);

								$TotalPoliza  = 0;

							
								

								$sql = mysqli_query($db, "INSERT INTO Productos.PRODUCTO (P_NOMBRE, UM_CODIGO, P_PRECIO_VENTA, P_ESTADO, P_SOUVENIRS, P_JUEGOS, P_TAQUILLA, P_LLEVA_EXISTENCIA, P_COMBO)
											VALUES ('".$Nombre."', 6, '".$PrecioVenta."', 1, 1, 1, 1, 0, 1)");
								

								if(!$sql)
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
									$query = "SELECT * FROM Productos.PRODUCTO WHERE P_NOMBRE='$Nombre'";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        $Codigo=$row["P_CODIGO"];
                                                    }

									$combo= mysqli_query($db, "INSERT INTO Productos.COMBO (C_CODIGO, C_NOMBRE, C_PRECIO)
									VALUES ('".$Codigo."', '".$Nombre."', '".$PrecioVenta."')");
						
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

										

										$queryd = mysqli_query($db, "INSERT INTO Productos.COMBO_DETALLE (C_CODIGO, CD_CODIGO, CD_CORRELATIVO, P_CODIGO, CD_CANTIDAD)
															VALUES('".$Codigo."', '".$CodRD."', '".$j."', '".$Prod."', '".$Can."')");
										
										
					

													
								}
								}	
								
								
								
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">EL COMBO SE INGRESO CORRECTAMENTE.</h2>
											';
									
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
