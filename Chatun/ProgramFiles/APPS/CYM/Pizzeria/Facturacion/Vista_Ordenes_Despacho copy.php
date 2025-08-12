<?php
include("../../../../../Script/funciones.php");
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
<style>
.myDiv {
  background-color: lightblue;    
  text-align: center;
}
</style>
</head>
<body class="header-fixed" onload="setInterval('ObtenerOrdenes()', 5000);">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div align="right"> 
				<button onclick="ObtenerOrdenes()" type="button" class="btn waves-effect waves-light btn-warning">Actualizar</button>
			</div>
			<div style="display: none;" class="myDiv" id="mensaje">Por favor espere, cargando...</div>
			<div id="Resultados">
				<?php 
					$Contador = 1; 
					$QueryOrdenes = mysqli_query($db,"SELECT A.F_CODIGO, A.F_ORDEN, A.F_OBSERVACIONES
										FROM Bodega.FACTURA_PIZZA AS A 
										WHERE (A.F_DESPACHADA <> 1) AND A.F_FECHA_TRANS  = CURDATE()
										ORDER BY A.F_ORDEN ASC");
					while($FilaOrdenes = mysqli_fetch_array($QueryOrdenes))
					{
					if($Contador == 1)
					{
					?>
					<div class="row">
					<?php
					}
					?>
					<div class="col-lg-3">
					<div class="card">
						<div class="card-head">
							<header><strong>ORDEN #<?php echo $FilaOrdenes["F_ORDEN"] ?></strong></header>
						</div>
						<div class="card-body text-default-light">
							<ul class="list">
								<?php
									$QueryDetalle = mysqli_query($db,"SELECT A.FD_CANTIDAD, B.P_NOMBRE
																	FROM Bodega.FACTURA_PIZZA_DETALLE AS A
																	INNER JOIN Productos.PRODUCTO AS B ON A.RS_CODIGO = B.P_CODIGO
																	WHERE A.F_CODIGO = '".$FilaOrdenes['F_CODIGO']."'");
									while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
									{
										?>
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-text"><b><?php echo number_format($FilaDetalle['FD_CANTIDAD'], 0).' - '.$FilaDetalle['P_NOMBRE'] ?></b></div>
												</a>
											</li>				
										<?php
									}
								?>
							</ul>
							<hr>
							<p><?php echo $FilaOrdenes['F_OBSERVACIONES'] ?></p>
						</div><!--end .card-body -->
						<div class="card-actionbar">
							<div class="card-actionbar-row">
								<a href="RealizarOrden_Despacho.php?Orden=<?php echo $FilaOrdenes[F_CODIGO] ?>">
									<button type="button" class="btn ink-reaction btn-floating-action btn-lg btn-primary"><i class="fa fa-check"></i></button>
								</a>
							</div>
						</div><!--end .card-actionbar -->
					</div>
					</div>
					<?php
					if($Contador == 4)
					{
					?>
					</div>
					<?php
					$Contador = 0;
					}

					$Contador++;
					}
					?>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>

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

	<script>
		 
		
		function ObtenerOrdenes()
		{
			location.reload();
		}
		
		function Realizar(x)
		{
			$.ajax({
					url: 'RealizarOrden_Despacho.php',
					type: 'post',
					data: 'Orden='+x,
					success: function (data) {
					 location.reload();
					}
				});
		}
	</script>
	<script>
		
	</script>

	</body>
	</html>
