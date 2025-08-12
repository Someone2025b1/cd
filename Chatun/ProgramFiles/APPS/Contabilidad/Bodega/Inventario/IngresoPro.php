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
								<h4 class="text-center"><strong>Ingreso de Producto a Bodega</strong></h4>
							</div>
							<div class="card-body">
								<?php
								$UI           = uniqid('tra_');
								$UID          = uniqid('trad_');
								$Contador     = count($_POST["Producto"]);
								$Centinela    = true;

								$CodigoIngreso = $_POST["CodigoIngreso"];
								$Fecha         = $_POST["Fecha"];
								$Concepto      = $_POST["Concepto"];
								$Codigo        = $_POST["Codigo"];
								$Bodega        = $_POST["Bodega"];
								
								$Cantidad       = $_POST["Cantidad"];
								$Producto       = $_POST["Producto"];
								$PrecioUnitario = $_POST["PrecioUnitario"];
								$Total          = $_POST["Total"];
								$TotalIngreso   = $_POST["TotalIngreso"];

								

								$sql = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION (TRA_CODIGO, TRA_FECHA_TRANS, TRA_NUMERO, TRA_CODIGO_FACTURA, TRA_OBSERVACIONES, TRA_FECHA_HOY, TRA_HORA, TRA_USUARIO, E_CODIGO, TRA_TOTAL, TT_CODIGO, B_CODIGO)
									VALUES('".$UI."', '".$Fecha."', ".$CodigoIngreso.", '".$Codigo."', '".$Concepto."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), '".$UserID ."', 1, ".$TotalIngreso .", 1, ".$Bodega.")");

									if(!$sql) //Si el query tuvo algún problema que despligue error y que la ejecución del código se detenga
									{

										echo '<div class="col-lg-12 text-center">
										<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
										<h2 class="text-light">Lo sentimos, no se pudo realizar el ingreos a bodega.</h2>
										<h4 class="text-light">Código de transacción: '.$UI.'</h4>
									</div>';
									echo mysqli_error($sql);
									$Centinela = false;
									
								}
								else
								{
									for($i=0; $i<$Contador; $i++)
									{
										$Can = $Cantidad[$i+1];
										$Pro = $Producto[$i];
										$PUn = $PrecioUnitario[$i+1];
										$Tot = $Total[$i+1];

										$query = mysqli_query($db, "INSERT INTO Bodega.TRANSACCION_DETALLE (TRAD_CODIGO, TRA_CODIGO, P_CODIGO, TRAD_CARGO_PRODUCTO, TRAD_PRECIO_UNITARIO, TRAD_SUBTOTAL)
											VALUES('".$UID."', '".$UI."', ".$Pro.", ".$Can.", ".$PUn.", ".$Tot.")");

										if(!$query)
										{
											echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo ingresar el producto a bodega.</h2>
											<h4 class="text-light">Código de transacción: '.$UID.'</h4>
										</div>';
										echo mysqli_error($query);
										$Centinela = false;
										
									}	
								}	

								if($Centinela == true)
								{
									$sql = mysqli_query($db, "UPDATE Contabilidad.TRANSACCION SET TRANSACCION.TRA_ESTADO_INVENTARIO = 2 WHERE TRANSACCION.TRA_CODIGO = '".$Codigo."'");

									echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
									<h2 class="text-light">El ingreso de producto se realizó correctamente.</h2>
									<div class="row">
										<div class="col-lg-6 text-left"><a href="Ingreso.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
									</div>';
								}
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
