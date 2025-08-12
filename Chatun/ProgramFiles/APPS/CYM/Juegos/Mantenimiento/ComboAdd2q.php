<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$IdCombo = uniqid("Com_");
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
	<script src="../../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>
	<!-- END STYLESHEETS -->

	<script type="text/javascript">
	function CodigoBarrasFun()
	{
		var Seleccionado = $("input[name='CodigoBarras']:checked").val();

		if(Seleccionado == 1)
		{
			$('#EscanearCodigoBarrasDIV').show();
			$('#CodigoBarrasNuevoDIV').hide();
			$('#Codigo').focus();
		}
		else
		{
			$('#EscanearCodigoBarrasDIV').hide();
			$('#CodigoBarrasNuevoDIV').show();

			var Codigo = $('#CodigoNuevo').val();
			$("#bcTarget1").barcode(Codigo, "code128",{barWidth:2, barHeight:120, renderer:"canvas"});
		}
	}
		
	</script>
	<style>
		input[type=checkbox]
		{
		  /* Double-sized Checkboxes */
		  -ms-transform: scale(0.5); /* IE */
		  -moz-transform: scale(0.5); /* FF */
		  -webkit-transform: scale(0.5); /* Safari and Chrome */
		  -o-transform: scale(0.5); /* Opera */
		  transform: scale(0.5);
		  padding: 10px;
		}

		/* Might want to wrap a span around your checkbox text */
		.checkboxtext
		{
		  /* Checkbox text */
		  font-size: 110%;
		  display: inline;
		}
	</style>
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT--> 
			<div class="container">
				<h1 class="text-center"><strong>Ingreso de Juegos</strong><br></h1>
				<br>
				<form class="form" action="PAddPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Combo</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="Nombre" id="Nombre" required/>
											<label for="Nombre">Nombre</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
											<input class="form-control" type="text" name="PrecioTotal" id="PrecioTotal" required/>
											<label for="PrecioTotal">Precio Total</label>
										</div>
									</div>
								</div>   
								<tbody>
																	<tr class="fila-base">
						                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onChange="CalcularTotal()" style="width: 100px" min="0"></h6></td>
						                                                <input type="hidden" class="form-control" name="Producto[]" id="Producto[]">
						                                                <input type="hidden" class="form-control" name="EligeSabor[]" id="EligeSabor[]">
						                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="Precio[]" id="Precio[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
						                                                <td><h6><input type="number" class="form-control InputDescuento" name="Descuento[]" id="Descuento[]" readonly style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" onchange="CalcularTotal()"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly></h6></td>
						                                                <td class="eliminar">
						                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
						                                                        <span class="glyphicon glyphicon-trash"></span>
						                                                    </button>
						                                                </td>
						                                            </tr>
						                                            <tr>
						                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onChange="CalcularTotal()" style="width: 100px" min="0"></h6></td>
						                                                <input type="hidden" class="form-control" name="Producto[]" id="Producto[]">
						                                                <input type="hidden" class="form-control" name="EligeSabor[]" id="EligeSabor[]">
						                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="Precio[]" id="Precio[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
						                                                <td><h6><input type="number" class="form-control InputDescuento" name="Descuento[]" id="Descuento[]" readonly style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" onchange="CalcularTotal()"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly></h6></td>
						                                                <td class="eliminar">
						                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
						                                                        <span class="glyphicon glyphicon-trash"></span>
						                                                    </button>
						                                                </td>
						                                            </tr>
																</tbody>
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
					</div>
					<br>
					<br>
				</form>
			</div> 
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	<!-- BEGIN JAVASCRIPT -->
 
	<!-- END JAVASCRIPT -->
	<script>
		$(document).ready(function() {
			ListadoDetalle('<?php echo $IdCombo?>');
		}); 
		
		function GuardarJuego(Id)
		{
			var IdCombo = '<?php echo $IdCombo?>';
			$.ajax({
				url: 'AgregarJuego.php',
				type: 'POST',
				dataType: 'html',
				data: {Id:Id, IdCombo:IdCombo},
				success:function(data)
				{
					ListadoDetalle(IdCombo);
					ListadoAgg(IdCombo);
					Calcular();
				}
			})  
		}

		function ListadoDetalle(IdCombo)
		{
			$.ajax({
				url: 'ListadoJuegos.php',
				type: 'POST',
				dataType: 'html',
				data: {IdCombo:IdCombo},
				success:function(data)
				{
					$("#DivJuegos").html(data);
				}
			})  
		}

		function ListadoAgg(IdCombo)
		{
			$.ajax({
				url: 'ListadoAgg.php',
				type: 'POST',
				dataType: 'html',
				data: {IdCombo:IdCombo},
				success:function(data)
				{
					$("#DivJuegosAgg").html(data);
				}
			})  
		}
	</script>
	</body>
	</html>
