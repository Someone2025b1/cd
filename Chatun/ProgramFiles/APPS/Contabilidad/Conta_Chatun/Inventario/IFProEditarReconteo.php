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

	<script language=javascript type=text/javascript>
		$(document).on("keypress", 'form', function (e) {
		    var code = e.keyCode || e.which;
		    if (code == 13) {
		        e.preventDefault();
		        return false;
		    }
		});
	</script>

<script>
	function EnviarForGuardar()
	{
		var Formulario = $('#FormularioEnviar');
		$(Formulario).attr('action', 'IFProGuardar.php');
		$(Formulario).submit();	

	}
	function EnviarFormFinal()
	{
		var Formulario = $('#FormularioEnviar');
		$(Formulario).attr('action', 'IFProGuardarFinalReconteo.php');
		$(Formulario).submit();	

	}

	function actualizarSeleccionDesdeInput(input) {
	let codigo = input.getAttribute("data-codigo");
	let cantidad = input.value;
	var codigoIn = "<?php echo $_GET['Codigo']; ?>";
	var Punto = "<?php echo $_GET['Punto']; ?>";

	let formData = new FormData();
	formData.append("codigo", codigo);
	formData.append("cantidad", cantidad);
	formData.append("codigoIn", codigoIn);
	formData.append("Punto", Punto);

	fetch("actualizarReconteo.php", {
		method: "POST",
		body: formData
	})
	.then(response => response.text())
	.then(data => {
		console.log(data); // Opcional: para verificar la respuesta del servidor
	})
	.catch(error => console.error("Error:", error));

	location.reload();
}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php"); 


										$Bodega      = $_GET["Punto"];
										$Codigo = $_GET["Codigo"];
										?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<form class="form" method="POST" role="form" id="FormularioEnviar">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Diferencias Encontradas en el Conteo de Inventario Físico</strong></h4>
							</div>
							<div class="card-body">
							<?php
									


									$Consulta = "SELECT * FROM Productos.INVENTARIO_RECONTEO AS A WHERE A.I_ESTADO = 1 AND A.IR_CODIGO = '$Codigo' ORDER BY A.I_FECHA ";
									$Resultado = mysqli_query($db, $Consulta);
									while($row = mysqli_fetch_array($Resultado))
									{
										$FechaConteo=$row["I_FECHA"];
									}

									

									
									?>
									
									<input class="form-control" type="date" name="FechaConteo" id="FechaConteo" value="<?php echo $FechaConteo; ?>" required readonly/>
									
								<div class="row">
									
								</div>
								<div class="row">
									<div class="col-lg-10">
										<div class="form-group">
										<input class="form-control" min="0" type="hidden" name="CodigoConteo"  id="CodigoConteo" value="<?php echo $Codigo; ?>" required/>
											<input class="form-control" type="hidden" name="Bodega"  id="Bodega" value="<?php echo $Bodega ?>"/>
											
										</div>
									</div>	
								</div>
								<table class="table table-hover table-condensed">
									<thead>
									<tr>
											<th><h4><strong>#</strong></h4></th>
											<th><h4><strong>Código</strong></h4></th>
											<th><h4><strong>Producto</strong></h4></th>
											<th><h4><strong>Conteo</strong></h4></th>
											<th><h4><strong>Real</strong></h4></th>
											<th><h4><strong>Diferencia</strong></h4></th>
										</tr>
									</thead>
									<tbody>
										<?php

										
										$i 		     = 1;



										//QUERY PARA TRAER TODO EL MOVIMIENTO DE LAS CUENTAS EN EL RANGO DE FECHAS SELECCIONADO
										$QueryCuentas = "SELECT INVENTARIO_RECONTEO_DETALLE.P_CODIGO, INVENTARIO_RECONTEO_DETALLE.ID_CANTIDAD_SISTEMA, INVENTARIO_RECONTEO_DETALLE.ID_CANTIDAD_CONTADA, INVENTARIO_RECONTEO_DETALLE.ID_DIFERENCIA, UNIDAD_MEDIDA.UM_NOMBRE, PRODUCTO.P_NOMBRE 
										                FROM Productos.INVENTARIO_RECONTEO_DETALLE, Productos.PRODUCTO, Bodega.UNIDAD_MEDIDA
										                WHERE INVENTARIO_RECONTEO_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
														AND PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
														AND INVENTARIO_RECONTEO_DETALLE.ID_DIFERENCIA <> 0
														AND INVENTARIO_RECONTEO_DETALLE.IR_CODIGO = '$Codigo'
										                GROUP BY PRODUCTO.P_NOMBRE ORDER BY PRODUCTO.P_NOMBRE";
										$ResultCuentas = mysqli_query($db, $QueryCuentas);
										while($row = mysqli_fetch_array($ResultCuentas))
										{
											$ExistenciaMost = 0;
											$Producto = $row["P_CODIGO"];
											$ProductoNombre = $row["P_NOMBRE"];
											$UnidadMedida = $row["UM_NOMBRE"];


											?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $Producto; ?></td>
												<td><?php echo $ProductoNombre." - ".$UnidadMedida; ?></td>
												<td><b><input class="form-control"
																	min="0"
																	type="number"
																	name="Conteo[]"
																	value="<?php echo $row["ID_CANTIDAD_CONTADA"]; ?>"
																	data-codigo="<?php echo $row["P_CODIGO"]; ?>"
																	onchange="actualizarSeleccionDesdeInput(this)" 
																	required /></b></td>
												<td><b><?php echo $row["ID_CANTIDAD_SISTEMA"]; ?></b></td>
												<td><b><?php echo $row["ID_DIFERENCIA"]; ?></b></td>
												
												
												
											</tr>
												<input class="form-control" min="0" type="hidden" name="Real[]"  id="Real[]" value="<?php echo $row["ID_CANTIDAD_SISTEMA"]; ?>" required readonly/>
												<input class="form-control" min="0" type="hidden" name="Fisico[]"  id="Fisico[]" value="<?php echo $row["ID_DIFERENCIA"]; ?>" required readonly/>
											<input class="form-control" min="0" type="hidden" name="Codigo[]"  id="Codigo[]" value="<?php echo $Producto; ?>" required/>

											<?php
											$i++;
										}
										
										
										?>
									</tbody>
								</table>
								
								<div class="row">
									<br>
									<br>
								</div>
								<div class="row text-center">
								<button type="button" class="btn ink-reaction btn-raised btn-danger" id="Guardar" onclick="EnviarFormFinal()">CREAR NOTAS DE CREDITO Y DÉBITO</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
