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

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT--> 
			<div class="container">
				<h1 class="text-center"><strong>Ingreso de Juegos</strong><br></h1>
				<br>
				<form class="form" method="POST" role="form" id="JuegosForm">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales del Juego</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4 col-lg-8"> 
											<label for="Producto">Producto</label>
											<select name="Producto" id="Producto" class="form-control selectpicker" onchange="ListaEscala(this)" required data-live-search="true" required>
												<option value="" disabled selected>SELECCIONE UNA OPCIÓN</option>
												<?php
                                                    $query = "SELECT a.P_CODIGO, a.P_NOMBRE, a.P_PRECIO FROM Bodega.PRODUCTO a WHERE a.CP_CODIGO = 'JG'";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["P_CODIGO"].'">'.$row["P_NOMBRE"].' - Q.'.$row["P_PRECIO"].'</option>';
                                                    }

                                                ?>
											</select>  
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="number" step="any" name="Cantidad" id="Cantidad" min="2" required/>
											<label for="Cantidad">Cantidad</label>
										</div>
									</div>
								</div>  
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group floating-label">
											<input class="form-control" type="number" step="any" name="Precio" id="Precio" required/>
											<label for="Precio">Precio</label>
										</div>
									</div>
								</div>  
							</div>
						</div>
					</div>
					<div class="col-lg-12" align="center">
						<button type="button" class="btn ink-reaction btn-raised btn-primary" onclick="GuardarEscala()">Guardar</button>
					</div> 
					<br>
					<br>
				</form>
			</div> <br><br>
			<div id="DivEscala"></div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

	<!-- BEGIN JAVASCRIPT -->
 
	<!-- END JAVASCRIPT -->
	<script type="text/javascript">
		function GuardarEscala()
		{
			var IdJuego = $("#Producto").val();
			var JuegosForm = $("#JuegosForm").serialize();
			$.ajax({
				url: 'Ajax/EscalaAddPro.php',
				type: 'POST',
				dataType: 'html',
				data: JuegosForm,
				success:function(data)
				{
					if (data==1) 
					{
						ListaEscala(IdJuego);
						$("#Cantidad").val(" ");
						$("#Precio").val(" ");
					}
					else
					{
						alertify.error("Ha ocurrido un error!");
					}
				}
			})  
		}

		function Eliminar(IdEscala)
		{
			var IdJuego = $("#Producto").val();
			$.ajax({
				url: 'Ajax/EliminarEscala.php',
				type: 'POST',
				dataType: 'html',
				data: {IdEscala:IdEscala},
				success:function(data)
				{
					if (data==1) 
					{
						ListaEscala(IdJuego);
					}
					else
					{
						alertify.error("Ha ocurrido un error!");
					}
				}
			})  
		}

		function ListaEscala(IdJuego)
		{
			var IdJuego = $("#Producto").val();
			$.ajax({
				url: 'Ajax/ListaEscalaJuego.php',
				type: 'POST',
				dataType: 'html',
				data: {IdJuego:IdJuego},
				success:function(data)
				{
					 $("#DivEscala").html(data);
				}
			})  
		}
	</script>
	</body>
	</html>
