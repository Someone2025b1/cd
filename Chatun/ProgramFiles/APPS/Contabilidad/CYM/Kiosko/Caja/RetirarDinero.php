<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->


<script>
    function EditarCuadre()
		{
			var Usuario = $("#username").val();
			var Password = $("#password").val();
			$.ajax({
				url: 'ComprobarUsuarioRetiro.php',
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
						
						data: Form,
						beforeSend: function() {
					        // setting a timeout
					       $("#mensaje").show();
					    },
						success:function(data)
						{
							if(data)
							{
								var Opcion = $('#TipoCierre').val();
                                var Formulario = $('#FormularioEnviar');
                                $(Formulario).attr('action', 'RetirarDineroPro.php');
                                $(Formulario).submit();
                                                        
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
    </script>
    
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
			<div class="container">
            <form class="form" method="POST" role="form" id="FormularioEnviar">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Retiro de Efectivo</strong></h4>
							</div>
							<div class="card-body">
								<?php

							$Query = "SELECT ACC_FECHA FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_ESTADO = 1 AND ACC_FECHA < CURRENT_DATE() AND ACC_TIPO = 1";
									$ResultQuery = mysqli_query($db,$Query);
									$RegistrosQuery = mysqli_num_rows($ResultQuery);
									
									if($RegistrosQuery == 0)
									{ 
										?>
										<div class="row">
											<div class="col-lg-2">
												<div class="form-group floating-label">
													<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" required readonly/>
													<label for="Fecha">Fecha de Retiro</label>
												</div>
                                                <input type="hidden" id="UsuarioContabiliza" name="UsuarioContabiliza">
											</div>
										</div>
										<div class="row">
											<div class="col-lg-2">
												<div class="form-group floating-label">
													<input class="form-control" type="number" step="any" name="MontoInicial" id="MontoInicial" value="0.00" required />
													<label for="MontoInicial">Monto A Retirar</label>
												</div>
											</div>
										</div>
										 
													</div>
												</div>
										</div>
										<div class="row">
											<br>
										</div>
										<div class="row">
											<div class="row text-center">
                                            <button  data-toggle="modal" data-target="#ModalFacturas2" type="button" class="btn waves-effect waves-light btn-success">
												<span class="glyphicon glyphicon-ok"></span>  Retirar
												</button>
											</div>
										</div>
										<?php
									}
									
								 
								?>
							


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
                    

				</form>
			</div>
            
		</div><!--end #content-->
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
	<script src="../../../../../js/core/demo/DemoFormWizard.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/additional-methods.min.js"></script>
	<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>
	<script src="../../../../../libs/alertify/js/alertify.js"></script>

	<!-- END JAVASCRIPT -->
	

</body>

</html>

