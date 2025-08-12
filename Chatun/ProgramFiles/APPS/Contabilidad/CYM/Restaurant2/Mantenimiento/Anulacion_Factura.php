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


</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Búsqueda de Factura Electrónica</strong></h4>
							</div>
							<div class="card-body"> 
									<?php 
											$Query = mysqli_query($db, "SELECT * 
																	FROM Bodega.FACTURA AS A
																	INNER JOIN Bodega.CLIENTE AS B ON A.CLI_NIT = B.CLI_NIT
																	WHERE A.F_FECHA_TRANS = CURDATE() 
																	AND A.F_CAE <> ''
																	AND A.F_CODIGO NOT IN (SELECT DISTINCT(T.TRA_FACTURA_NOTA_CREDITO)
																							FROM Contabilidad.TRANSACCION AS T 
																							WHERE T.TRA_FACTURA_NOTA_CREDITO <> ''
																							AND T.TT_CODIGO = 17)");

											?>
												<table class="table table-hover table-condensed">
													<thead>
														<tr>
															<th>DTE</th>
															<th>NIT</th>
															<th>CLIENTE</th>
															<th>TOTAL FACTURA</th>
															<th>ANULACIÓN FACTURA</th>
														</tr>
													</thead>
													<tbody>
													<?php
														while($Fila = mysqli_fetch_array($Query))
														{
															?>
																<tr>
																	<td><?php echo $Fila['F_DTE'] ?></td>
																	<td><?php echo $Fila['CLI_NIT'] ?></td>
																	<td><?php echo $Fila['CLI_NOMBRE'] ?></td>
																	<td><?php echo number_format($Fila['F_TOTAL'], 2) ?></td>
																	<td><button onclick="InicioSesion('<?php echo $Fila['F_CODIGO']?>')" type="button" class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></button></td>
																</tr>
															<?php
														}
													?>
													</tbody>
												</table> 
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		<!-- END CONTENT -->

	
		
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
      	<input type="hidden" id="CodigoF" name="CodigoF">
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
		<?php include("../MenuUsers.html"); ?>
		<script>
			function InicioSesion(CodigoF)
			{
				 $("#CodigoF").val(CodigoF);
				 $("#ModalFacturas").modal('show');
				
			}

			function ValidarCredenciales(CodigoF)
			{
				var Codigo = $("#CodigoCierre").val();
				var Usuario = $("#usernameV").val();
				var Password = $("#passwordV").val();
				$.ajax({
					url: '../Otros_Reportes/Ajax/ComprobarUsuario.php',
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
							location.reload();
							window.open('Anulacion_Factura_Pro.php?Codigo='+CodigoF, '_blank'); 			
						}
					}
				}) 
				
			}
    </script>
	</div><!--end #base-->
	<!-- END BASE -->

	</body>
	</html>
