<?php
$ImagenAleatoria = rand(1, 3);
include("Script/conex.php");
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
	

	<script src="js/libs/alertify/alertify.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="css/alertify/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="css/alertify/alertify.bootstrap.css" />
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed">

	<!-- BEGIN LOGIN SECTION -->
	<section class="section-account">
		<div class="img-backdrop" style="background-image: url('img/background/<?php echo $ImagenAleatoria; ?>.jpg'); height: 40%"></div>
		<div class="spacer"></div>
		<div class="card contain-sm style-transparent">
			<div class="card-body">
				<div class="content-fluid">
					<div class="col-sm-12" style="left: 75;" align="center">
						<br/>
						<br/>
						<?php 
						if(isset($_POST["username"]))
						{
							$sql = mysql_query ("SELECT id_user FROM info_bbdd.usuarios WHERE login = '".$_POST["username"]."' ", $db) or die (mysql_error());	
							
							if (mysql_num_rows($sql)!=0)
							{
								$row=mysql_fetch_array($sql);
								$CIF = $row[0];

								$sql1 = mysql_query ("SELECT email_institucional FROM info_colaboradores.Vista_Colaboradores_Nueva WHERE cif = '".$CIF."' ", $db) or die (mysql_error());	
								$row1=mysql_fetch_array($sql1);

								$NuevaPass = uniqid();

								$sql2 = mysql_query("UPDATE info_colaboradores.datos_generales SET password = '".$NuevaPass."' WHERE login = '".$_POST["username"]."'");

								$Email = $row1[0];

								$msg = 'Este correo le llegó debido a que usted inició el proceso de recuperación de contraseña del Portal Institucional de Chatún. Si no ha iniciado usted el proceso por favor comuníquese con el departamento de IDT. <br><br>Su nueva contraseña es:'.$NuevaPass;
								mail($Email, 'Recuperación de Contraseña', $msg);

								?>
								<section>
									<div class="section-body contain-lg">
										<div class="row">
											<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">Bien <i class="fa fa-check-circle text-success"></i></span></h1>
												<h4 class="text-light">Se envió una nueva contraseña a su correo electrónico, por favor revise su bandeja de entrada.</h4>
											</div><!--end .col -->
										</div><!--end .row -->
									</div><!--end .section-body -->
									<div class="col-lg-12">
										<br>
										<a href="index.php"><button class="btn btn-primary">Inicio</button></a>
									</div>
								</section>
								<?php
							}
							else
							{
								?>
								<section>
									<div class="section-body contain-lg">
										<div class="row">
											<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">Error <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
												<h4 class="text-light">El usuario no coincide con ninguno otro registrado en la base de datos.</h4>
											</div><!--end .col -->
										</div><!--end .row -->
									</div><!--end .section-body -->
									<div class="col-lg-12">
										<br>
										<a href="Forgot.php"><button class="btn btn-danger">Regresar</button></a>
									</div>
								</section>
								<?php
							}
						}	
						else
						{
							?>
							<!-- BEGIN 500 MESSAGE -->
							<section>
								<div class="section-body contain-lg">
									<div class="row">
										<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Error <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h2 class="text-light">Debes ingresar un correo electrónico</h2>
										</div><!--end .col -->
									</div><!--end .row -->
								</div><!--end .section-body -->
								<div class="col-lg-12">
									<br>
									<a href="Forgot.php"><button class="btn btn-danger">Regresar</button></a>
								</div>
							</section>
							<!-- END 500 MESSAGE -->
							<?php
						}
						?>
					</div><!--end .col -->
				</div><!--end .row -->
			</div><!--end .card-body -->
		</div><!--end .card -->
	</section>
	<!-- END LOGIN SECTION -->

	<!-- BEGIN JAVASCRIPT -->
	<script src="js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="js/libs/spin.js/spin.min.js"></script>
	<script src="js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="js/core/source/App.js"></script>
	<script src="js/core/source/AppNavigation.js"></script>
	<script src="js/core/source/AppOffcanvas.js"></script>
	<script src="js/core/source/AppCard.js"></script>
	<script src="js/core/source/AppForm.js"></script>
	<script src="js/core/source/AppNavSearch.js"></script>
	<script src="js/core/source/AppVendor.js"></script>
	<script src="js/core/demo/Demo.js"></script>


	

	<!-- END JAVASCRIPT -->



</body>
</html>
