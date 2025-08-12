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
	 
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content"> 
			<div class="container"> 
					<div class="col-lg-12">
						<div class="panel-group" id="accordion6">
							<div class="card panel">
								<div class="card-head style-info collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-1" aria-expanded="false">
									<header>Detalle de facturas</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-1" class="collapse" aria-expanded="false" style="height: 0px;">
									
									<div class="card-body"> 
									<div class="card panel"> 
										<div class="col-lg-12" align="center">
											<a target="_blank" href="CierreImpUsuario.php?FechaInicio=<?php echo $_GET['FechaInicio']?>&Usuario=<?php echo $_GET['Usuario']?>" class="btn btn-warning" >Imprimir</a>
										</div> 
										<table class="table" id="tbl_resultados">
											<thead>
												<tr>
													<th>Serie</th>
													<th>Factura</th>
													<th>NIT</th>
													<th>Neto</th>
													<th>IVA</th>
													<th>Total</th>
													<th>Tipo</th>
													<th>Moneda</th>
													<th>Descuento</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$SqlFacturas = "SELECT FACTURA_KS_4.* FROM Bodega.FACTURA_KS_4
																	WHERE FACTURA_KS_4.F_FECHA_TRANS = '".$_GET["FechaInicio"]."' AND FACTURA.F_USUARIO = '".$_GET["Usuario"]."'
																	ORDER BY FACTURA_KS_4.F_SERIE, FACTURA_KS_4.F_NUMERO";
													$ResultFacturas = mysqli_query($db,$SqlFacturas);
													while($FilasFacturas = mysqli_fetch_array($ResultFacturas))
													{
														if($FilasFacturas["F_TIPO"] == 1)
														{
															$Tipo = 'Efectivo';
														}
														elseif($FilasFacturas["F_TIPO"] == 2)
														{
															$Tipo = 'Tarjeta Crédito';
														}
														elseif($FilasFacturas["F_TIPO"] == 3)
														{
															$Tipo = 'Crédito';
														}
														elseif($FilasFacturas["F_TIPO"] == 4)
														{
															$Tipo = 'Depósito';
														}

														if($FilasFacturas["F_TIPO"] == 1)
														{
															if($FilasFacturas["F_MONEDA"] == 1)
															{
																$Moneda = 'Quetzal';
															}
															elseif($FilasFacturas["F_MONEDA"] == 2)
															{
																$Moneda = 'Dólar';
															}
															elseif($FilasFacturas["F_MONEDA"] == 3)
															{
																$Moneda = 'Lempira';
															}
														}
														elseif($FilasFacturas["F_TIPO"] == 4)
														{
															$Moneda = 'Quetzal';
														}
														else
														{
															$Moneda = '---';
														}

														
														$IVA = ($FilasFacturas["F_TOTAL"] * 0.12) / 1.12;
														$Neto = $FilasFacturas["F_TOTAL"] - $IVA;

														echo '<tr>';
															echo '<td>'.$FilasFacturas["F_SERIE"].'</td>';
															echo '<td>'.$FilasFacturas["F_NUMERO"].'</td>';
															echo '<td>'.$FilasFacturas["CLI_NIT"].'</td>';
															echo '<td>'.number_format($Neto, 2, '.', ',').'</td>';
															echo '<td>'.number_format($IVA, 2, '.', ',').'</td>';
															echo '<td>'.number_format($FilasFacturas["F_TOTAL"], 2, '.', ',').'</td>';
															if($FilasFacturas["F_ESTADO"] == 2)
															{	
																echo '<td>ANULADA</td>';
																echo '<td>ANULADA</td>';
															}
															elseif($FilasFacturas["F_ESTADO"] == 1)
															{
																echo '<td>'.$Tipo.'</td>';
																echo '<td>'.$Moneda.'</td>';
															}
															echo '<td>'.number_format($FilasFacturas["F_CON_DESCUENTO"], 2, '.', ',').'</td>';
														echo '</tr>';
													}
												?>
											</tbody>
										</table> 
							</div><!--end .panel -->
							 
						</div>
					</div> 
			</div>
		</div>
		<!-- END CONTENT -->

		<form method="POST" target="_blank" action="CierreImp.php" name="FormCorte">
			<input type="hidden" value="<?php echo $Codigo?>" id="CodigoApertura" name="CodigoApertura">
			<input type="hidden" name="TipoCorte" id="TipoCorte" value="Restaurante Terrazas">

			<input type="hidden" name="FechaImp" id="FechaImp" value="<?php echo $Fecha ?>">
			<input type="hidden" name="FacturasEmitidasCorte" id="FacturasEmitidasCorte" value="<?php echo $FacturasEmitidas ?>">
			<input type="hidden" name="FacturasAnuladasCorte" id="FacturasAnuladasCorte" value="<?php $FacturasAnuladas ?>">
			<input type="hidden" name="SerieFacturaCorte" id="SerieFacturaCorte" value="<?php echo $SerieFactura; ?>">
			<input type="hidden" name="DelFacturaCorte" id="DelFacturaCorte" value="<?php echo $DelFactura ?>">
			<input type="hidden" name="AlFacturaCorte" id="AlFacturaCorte" value="<?php echo $AlFactura ?>">

			<input type="hidden" name="EfectivoCorte" id="EfectivoCorte" value="<?php echo $TCQ ?>">
			<input type="hidden" name="CreditoCorte" id="CreditoCorte" value="<?php echo $TotalCreditos ?>">
			<input type="hidden" name="TCCorte" id="TCCorte" value="<?php echo $TotalTarjetaCredito ?>">
			<input type="hidden" name="DolaresCorte" id="DolaresCorte" value="<?php echo $TCD ?>">
			<input type="hidden" name="Dolares1Corte" id="Dolares1Corte" value="<?php echo $TotalDolaresQuetzalisados ?>">
			<input type="hidden" name="LempirasCorte" id="LempirasCorte" value="<?php echo $TCL ?>">
			<input type="hidden" name="Lempiras1Corte" id="Lempiras1Corte" value="<?php echo $TotalLempirasQuetzalisados ?>">
			<input type="hidden" name="DepositosCorte" id="DepositosCorte" value="<?php echo $TotalDeposito ?>">
			<input type="hidden" name="IngresosCorte" id="IngresosCorte" value="<?php echo $Total ?>">
			<input type="hidden" name="FacturadoCorte" id="FacturadoCorte" value="<?php echo $TotalFacturado ?>">
			<input type="hidden" name="FaltanteSobrante" id="FaltanteSobrante" value="<?php echo $FaltSob ?>">


		</form>
		
		<?php include("../MenuUsers.html"); ?>

	</div><!--end #base-->
	<!-- END BASE -->

<div class="modal fade" tabindex="-1" role="dialog" id="ModalFacturas2" >
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Credenciales de inicio de sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
	      	 <div class="form-group">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="text" required="" placeholder="Usuario" name="username" id="username">
	          </div>
		      </div> 
		</div>
		<div class="row">
	        <div class="form-group ">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="password" required="" placeholder="Contraseña" id="password" name="password" required>
	          </div>
	        </div> 
      	</div> 
      </div> 
      <div id="mensaje" style="display: none" align="center">
      		<h3>Cargando...</h3>
      		<img src="loading.gif" alt="" width="300" height="100">      	
      </div>
      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" onclick="EditarCuadre()">Validar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="ModalFacturas" >
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Credenciales de inicio de sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class="row">
	      	 <div class="form-group">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="text" required="" placeholder="Usuario" name="usernameV" id="usernameV">
	          </div>
		      </div> 
		</div>
		<div class="row">
	        <div class="form-group ">
	          <div class="col-xs-6">
	            <input required="" class="form-control" type="password" required="" placeholder="Contraseña" id="passwordV" name="passwordV" required>
	          </div>
	        </div> 
      	</div> 
      </div> 
      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" onclick="ValidarCredenciales()">Validar</button>
      </div>
    </div>
  </div>
</div>
<script>
	function CalcularTotalQ()
	{
		var B200 = $('#BQ200').val();
		var B100 = $('#BQ100').val();
		var B50  = $('#BQ50').val();
		var B20  = $('#BQ20').val();
		var B10  = $('#BQ10').val();
		var B5   = $('#BQ5').val();
		var B1   = $('#BQ1').val();
		var M1   = $('#MQ1').val();
		var M50  = $('#MQ50').val();
		var M25  = $('#MQ25').val();
		var M10  = $('#MQ10').val();
		var M5   = $('#MQ5').val();

		var CantidadEntera = parseFloat(B200 * 200) + parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5) + parseFloat(B1 * 1);
		var CantidadMoneda = parseFloat(M1 * 1) + parseFloat(M50 * 0.50) + parseFloat(M25 * 0.25) + parseFloat(M10 * 0.10) + parseFloat(M5 * 0.05);

		var Total = CantidadEntera + CantidadMoneda;
		Total = Total.toFixed(2);

		$('#TCQ').val(Total);
	}
	function CalcularTotalD()
	{
		var B100 = $('#BD100').val();
		var B50  = $('#BD50').val();
		var B20  = $('#BD20').val();
		var B10  = $('#BD10').val();
		var B5   = $('#BD5').val();
		var B1   = $('#BD1').val();

		var CantidadEntera = parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5) + parseFloat(B1 * 1);
		
		var Total = CantidadEntera;
		Total = Total.toFixed(2);

		$('#TCD').val(Total);
	}
	function CalcularTotalL()
	{
		var B500 = $('#BL500').val();
		var B100 = $('#BL100').val();
		var B50  = $('#BL50').val();
		var B20  = $('#BL20').val();
		var B10  = $('#BL10').val();
		var B5   = $('#BL5').val();
		
		var CantidadEntera = parseFloat(B500 * 500) + parseFloat(B100 * 100) + parseFloat(B50 * 50) + parseFloat(B20 * 20) + parseFloat(B10 * 10) + parseFloat(B5 * 5);
		
		var Total = CantidadEntera;
		Total = Total.toFixed(2);

		$('#TCL').val(Total);
	} 

		function EditarCuadre()
		{
			var Usuario = $("#username").val();
			var Password = $("#password").val();
			$.ajax({
				url: 'Ajax/ComprobarUsuario.php',
				type: 'POST',
				dataType: 'html',
				data: {Usuario:Usuario, Password:Password},
				success:function(data)
				{
					if (data==3) 
					{
						alertify.error("No tiene permisos...");
					}
					else if (data==2) 
					{
						alertify.error("Usuario o contraseña incorrecta..");
					}
					else 
					{  
					$("#UsuarioContabiliza").val(data);
					var Form = $("#FormData").serialize();
					$.ajax({
						url: 'CCModPro.php',
						type: 'POST',
						dataType: 'html',
						data: Form,
						beforeSend: function() {
					        // setting a timeout
					       $("#mensaje").show();
					    },
						success:function(data)
						{
							if(data==1)
							{
								location.reload();
							}
							else
							{
								alertify.error("Ha ocurrido un error.");
							}
						}
					})
				} 
			}
		})
	}

		function ValidarCredenciales()
		{
			var Codigo = $("#CodigoCierre").val();
			var Usuario = $("#usernameV").val();
			var Password = $("#passwordV").val();
			$.ajax({
				url: 'Ajax/ComprobarUsuario.php',
				type: 'POST',
				dataType: 'html',
				data: {Usuario:Usuario, Password:Password},
				success:function(data)
				{
					if (data==3) 
					{
						alertify.error("No tiene permisos...");
					}
					else if (data==2) 
					{
						alertify.error("Usuario o contraseña incorrecta..");
					}
					else 
					{
						var User = data;
						$.ajax({
							url: 'Ajax/GuardarValidacion.php',
							type: 'POST',
							dataType: 'html',
							data: {User:User, Codigo:Codigo},
							success:function(data)
							{
								if (data==1) 
								{
									ImprimirCorte();
									$("#ModalFacturas").modal("hide");
									location.reload();
								}
								else
								{
									alertify.error("Error en la verificación.")
								}
							} 
						}) 						
					}
				}
			}) 
			
		}
	</script>
	</body>
	</html>
