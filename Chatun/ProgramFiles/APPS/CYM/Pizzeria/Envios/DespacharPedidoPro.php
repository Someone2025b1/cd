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
								$CodEN         =uniqid('env_');
								$CodEND         =uniqid('envd_');
								$Centinela    = true;

                                $Contador     = count($_POST["Cantidad"]);
								$Cantidad  = $_POST["Cantidad"];
                                $Bodega    = $_POST["Bodega"];
                                $Descripcion    = $_POST["Descripcion"];
								$Producto  = $_POST["ProductoNombre"];
								$ProductoNombre = $_POST["ProductoNombre"];
                                $Total=$_POST["TotalFacturaFinal"];
                                
								$Contador2  = count($_POST["ProductoNombre"]);

								$CodigoEnv=$_POST["Codigo"];
												$insuficiente = 0;

                                                //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                $query = "SELECT * FROM Productos.ENVIOS WHERE EN_CODIGO = '$CodigoEnv'";
                                                $result = mysqli_query($db, $query);
                                                while($row = mysqli_fetch_array($result))
                                                {
													$cod=$row["EN_CODIGO"];
													$estado=$row["EN_ESTADO"];
													$envia=$row["EN_ENVIA"];
													$recibe=$row["EN_RECIBE"];
													$fechasolicitud=$row["EN_FECHA_SOLICITUD"];
													$hora=$row["EN_HORA_SOLICITUD"];
													$desc=$row["EN_DESCRIPCION"];
													$tot=$row["EN_TOTAL_PRODUCTOS"];


												}

												$totalfin=$tot-$Total;



								$QueryEncabezado = mysqli_query($db, "INSERT INTO Productos.ENVIOS_PENDIENTES_EXISTENCIA (EN_CODIGO, ENVIODIF, EN_ESTADO, EN_ENVIA, EN_RECIBE, EN_FECHA_SOLICITUD, EN_HORA_SOLICITUD, EN_DESCRIPCION, EN_USUARIO, EN_TOTAL_PRODUCTOS)
																VALUES ('".$CodEN."', '".$cod."', 8, '".$envia."', '".$recibe."', '".$fechasolicitud."', '".$hora."', '".$desc."', '".$UserID."', '".$totalfin."')");

								

								if(!$QueryEncabezado)
								{
									echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Lo sentimos, no se pudo ingresar la factura de compra.</h2>
											<h4 class="text-light">Código de transacción: '.$CodEN.'</h4>
										</div>';
									echo mysqli_error($sq, $query);
									$Centinela = false;
									
								}
								else
								{
									for($j=0; $j<$Contador; $j++)
									{
										$ProN = $ProductoNombre[$j]; 
										$Can = $Cantidad[$j];
										$Pro = $Producto[$j];
										$ProductoXplotado = explode("/", $Pro);

										$Prod = $ProductoXplotado[0];

										$query = "SELECT * FROM Productos.ENVIOS_DETALLE WHERE ENVIOS_DETALLE.EN_CODIGO = '$CodigoEnv' AND ENVIOS_DETALLE.P_CODIGO = $Prod";
										$result = mysqli_query($db, $query);
										while($row = mysqli_fetch_array($result))
										{
											$canpen= $row["END_CANTIDAD"]-$Can;
										}

										$corr=$j+1;
										if($canpen > 0){
										$queryd = mysqli_query($db, "INSERT INTO Productos.ENVIOS_PENDIENTES_EXISTENCIA_DETALLE (EN_CODIGO, END_CODIGO, END_CORRELATIVO, P_CODIGO, END_CANTIDAD)
															VALUES('".$CodEN."', '".$CodEND."', '".$corr."', '".$Prod."', '".$canpen."')");
										}

								}	
                            }

							


							$QueryEN = mysqli_query($db, "UPDATE Productos.ENVIOS SET EN_ESTADO = 4, EN_TOTAL_PRODUCTOS=$Total WHERE EN_CODIGO = '$CodigoEnv'");


							for($j=0; $j<$Contador; $j++)
									{
										$ProN = $ProductoNombre[$j]; 
										$Can = $Cantidad[$j];
										$Pro = $Producto[$j];
										$ProductoXplotado = explode("/", $Pro);

										$Prod = $ProductoXplotado[0];

										$QueryEN = mysqli_query($db, "UPDATE Productos.ENVIOS_DETALLE SET END_CANTIDAD = $Can WHERE EN_CODIGO = '$CodigoEnv' AND P_CODIGO = $Prod");

								}	
								
								if($Centinela == true)
									{
										echo '<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
											<h2 class="text-light">El Pedido se Despacho Correctamente.</h2>
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
