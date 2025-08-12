<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
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

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Productos</strong><br></h1>
				<br>
				<form class="form" method="POST" role="form">
					<?php
 
				
						
						$CodPR         =uniqid('PR_');
						$CodPRD         =uniqid('PRD_');
						$KCod	   = uniqid("KR_");
						$PrecioPonderadoSub=0;

						


								$Cantidad  = $_POST["CantidadM"];
								$Producto  = $_POST["ProductoNombreM"];
								$CantidadP  = $_POST["CantidadP"];
								$ProductoP  = $_POST["ProductoNombreP"];
								$Contador2  = count($_POST["ProductoNombreM"]);
					 
					 
					 
						$sql = mysqli_query($db, "INSERT INTO Productos.PRODUCCION_SUBRECETA (PR_CODIGO, PR_FECHA, PR_HORA, PR_USUARIO, PR_PUNTO)
											VALUES ('".$CodPR."', CURRENT_DATE(), CURRENT_TIMESTAMP(),'".$id_user."', 'TERRAZAS')");
						
						
						
						if(!$sql)
						{
							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo ingresar el producto.</h2>
								</div>';
							echo mysqli_error($sq, $sql);
							
						}
						else
						{
							for($j=1; $j<$Contador2; $j++)
									{
										
										$Can = $Cantidad[$j];
										$Pro = $Producto[$j];
										$ProductoXplotado = explode("/", $Pro);

										$Prod = $ProductoXplotado[0];


						$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$Prod;
						$result = mysqli_query($db, $queryp);
						while($rowe = mysqli_fetch_array($result))
						{
							

							$existenciaAn=$rowe["P_EXISTENCIA_TERRAZAS"];
							$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

							$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] - $Can;

							$nuevaexistencia = $rowe["P_EXISTENCIA_TERRAZAS"] - $Can;

							$PrecioPonderadoSub+=($rowe["P_PRECIO_COMPRA_PONDERADO"] * $Can);
							$PrecioUltimoSub+=($rowe["P_ULTIMO_COSTO"] * $Can);

						

						$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
						P_EXISTENCIA_TERRAZAS = '".$nuevaexistencia."',
						P_EXISTENCIA_GENERAL = '".$cantidadgen."'
						WHERE P_CODIGO = ".$Prod);

						
						$queryd = mysqli_query($db, "INSERT INTO Productos.PRODUCCION_SUBRECETA_DETALLE (PR_CODIGO, PRD_CODIGO, PRD_CORRELATIVO, P_CODIGO, PRD_CANTIDAD_M, PRD_CANTIDAD_P)
															VALUES('".$CodPR."', '".$CodPRD."', '".$j."', '".$Prod."', '".$Can."', 0)");

						$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
						VALUES('".$KCod."', '".$CodPR."', '".$Prod."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Baja de producto por producción de Subreceta ', '".$existenciaGAn."', '".$cantidadgen."', 1, '".$existenciaAn."', '".$nuevaexistencia."')");

						}	
									}



					$ProductoXplotadoP = explode("/", $ProductoP);

					$ProdP = $ProductoXplotadoP[0];
					
				

					$queryp = "SELECT * FROM Productos.PRODUCTO WHERE P_CODIGO =".$ProdP;
					$result = mysqli_query($db, $queryp);
					while($rowe = mysqli_fetch_array($result))
					{
						

						$existenciaAn=$rowe["P_EXISTENCIA_TERRAZAS"];
						$existenciaGAn=$rowe["P_EXISTENCIA_GENERAL"];

						$cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $CantidadP;

						$nuevaexistencia = $rowe["P_EXISTENCIA_TERRAZAS"] + $CantidadP;

						$PrecioAn=$rowe["P_PRECIO_COMPRA_PONDERADO"];
						$costototalanter=$rowe["P_EXISTENCIA_GENERAL"]*$rowe["P_PRECIO_COMPRA_PONDERADO"];
						$precioultimo=$rowe["P_EXISTENCIA_GENERAL"]*$rowe["P_ULTIMO_COSTO"];

						if( $rowe["P_EXISTENCIA_GENERAL"]<0){

							$cantidadgen = $CantidadP;
							$costototalanter=0;

						   }else{
						   $cantidadgen = $rowe["P_EXISTENCIA_GENERAL"] + $CantidadP;
						   }

						   $CostoTotal=$costototalanter+$PrecioPonderadoSub;
						   $PrecioEntro=$PrecioPonderadoSub/$CantidadP;
						   $PrecioNuevoSubreceta=$CostoTotal/$cantidadgen;

						   $PrecioNuevoActual=$PrecioUltimoSub/$CantidadP;


					

					$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
					P_EXISTENCIA_TERRAZAS = '".$nuevaexistencia."',
					P_EXISTENCIA_GENERAL = '".$cantidadgen."',
					P_PRECIO_COMPRA_PONDERADO = '".$PrecioNuevoSubreceta."',
					P_ULTIMO_COSTO = '".$PrecioNuevoActual."'
					WHERE P_CODIGO = ".$ProdP);

					
					$queryd = mysqli_query($db, "INSERT INTO Productos.PRODUCCION_SUBRECETA_DETALLE (PR_CODIGO, PRD_CODIGO, PRD_CORRELATIVO, P_CODIGO, PRD_CANTIDAD_M, PRD_CANTIDAD_P)
														VALUES('".$CodPR."', '".$CodPRD."', '".$j."', '".$ProdP."', 0, '".$CantidadP."')");

					$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO, K_COSTO_ANTERIOR, K_COSTO_ENTRO, K_COSTO_PONDERADO)
					VALUES('".$KCod."', '".$CodPR."', '".$ProdP."', CURRENT_DATE(), CURRENT_TIMESTAMP(), 'Aumento de producto por producción de Subreceta ', '".$existenciaGAn."', '".$cantidadgen."', 1, '".$existenciaAn."', '".$nuevaexistencia."','".$PrecioAn."', '".$PrecioEntro."', '".$PrecioNuevoSubreceta."')");
					}

							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El producto se ingresó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="IngresarSubreceta.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
							</div>';
						}
					?>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

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
	<!-- END JAVASCRIPT -->

	</body>
	</html>
