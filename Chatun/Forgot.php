<?php
$ImagenAleatoria = rand(1, 3);
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
					<div class="col-sm-8" style="left: 125;" align="center">
						<br/>
						<br/>
						<h3><span class="text-lg text-bold text-primary text-center">Portal Institucional Chatún</span><br><small>Recuperar contraseña</small></h3>
						<br/>
						<form class="form floating-label" action="ForgotPro.php"  accept-charset="utf-8" method="post">
							<section>
								<div class="section-body contain-sm">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user"></i>
										</span>
										<input type="text" size="20" class="form-control" placeholder="Ingrese su usuario" name="username" id="username" required/>
										<span class="input-group-btn">
											<button class="btn btn-primary" type="subtmit">Recuperar</button>
										</span>
									</div>
								</div>
							</section>
						</form>
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
