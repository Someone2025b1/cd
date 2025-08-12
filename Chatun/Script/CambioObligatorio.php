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
	
	<style type="text/css">
.progress-bar {
    color: #333;
} 


* {
    -webkit-box-sizing: border-box;
	   -moz-box-sizing: border-box;
	        box-sizing: border-box;
	outline: none;
}

    .form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
		@include box-sizing(border-box);

		&:focus {
		  z-index: 2;
		}
	}

.login-form {
	margin-top: 60px;
}

form[role=login] {
	color: #5d5d5d;
	background: #f2f2f2;
	padding: 26px;
	border-radius: 10px;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
}
	form[role=login] img {
		display: block;
		margin: 0 auto;
		margin-bottom: 35px;
	}
	form[role=login] input,
	form[role=login] button {
		font-size: 18px;
		margin: 16px 0;
	}
	form[role=login] > div {
		text-align: center;
	}
	
.form-links {
	text-align: center;
	margin-top: 1em;
	margin-bottom: 50px;
}
	.form-links a {
		color: #fff;
	}
	</style>

	<script src="../js/libs/alertify/alertify.js"></script>

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../css/alertify/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../css/alertify/alertify.bootstrap.css" />
	<!-- END STYLESHEETS -->

	<script>
	function VerificarPass()
	{

		var Pass1 = document.getElementById('password').value;
		var Pass2 = document.getElementById('passwordconfimacion').value;
		
		if(Pass1.length <1)
		{
			alert('Debes Llenar ambos campos para poder compararlos');
			$('#btnActualizar').prop('disabled', true);
		}
		else
		{
			if(Pass1 == Pass2)
			{
				$('#btnActualizar').prop('disabled', false);
			}
			else
			{
				alert('Las contraseñas no coinciden');
				$('#btnActualizar').prop('disabled', true);
			}
		}

	}
	</script>

</head>
<body class="menubar-hoverable header-fixed">

	<!-- BEGIN LOGIN SECTION -->
	<section class="section-account">
		<div class="img-backdrop" style="background-image: url('../img/background/<?php echo $ImagenAleatoria; ?>.jpg'); height: 40%"></div>
		<div class="spacer"></div>
		<div class="card contain-sm style-transparent">
			<div class="card-body">
				<div class="content-fluid">
					<div class="col-sm-6" style="left: 150px;" align="center" id="pwd-container">
						<br/>
						<br/>
						<h3><span class="text-lg text-bold text-primary text-center" style="font-size: 18px">Cambio Obligatorio de Contraseña</span></h3>
						<br/>
						<form class="form floating-label" action="CambioObligatorioPro.php"  accept-charset="utf-8" method="post">
							<div class="form-group">
								<input type="password" class="form-control Evaluar" id="password" name="password" autofocus required>
								<label for="password">Contraseña Nueva</label>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="passwordconfimacion" name="passwordconfimacion" onchange="VerificarPass()" required>
								<label for="password">Confirmar Contraseña Nueva</label>
							</div>
							<div class="form-group">
								<div class="pwstrength_viewport_progress"></div>
								<input type="hidden" class="form-control" id="username" name="username" value="<?php echo $_GET["User"] ?>" required>
							</div>
							<div class="row">
								<div class="col-xs-12 text-center">
									<button class="btn btn-primary btn-raised" type="submit" disabled id="btnActualizar">Actualizar</button>
								</div><!--end .col -->
							</div><!--end .row -->
						</form>
					</div><!--end .col -->
					<div class="col-sm-6" style="left: 200px; top: 70px" align="center">
						<img class="img-rounded" height="100%" width="100%" src="../img/logo.png"></img>
					</div>
				</div><!--end .row -->
			</div><!--end .card-body -->
		</div><!--end .card -->
	</section>
	<!-- END LOGIN SECTION -->
	
	<div class="alert alert-danger text-center">Su contraseña no ha sido cambiada, necesita actualizarla.</div>
	
	<!-- BEGIN JAVASCRIPT -->
	<script src="../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../js/libs/spin.js/spin.min.js"></script>
	<script src="../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../js/core/source/App.js"></script>
	<script src="../js/core/source/AppNavigation.js"></script>
	<script src="../js/core/source/AppOffcanvas.js"></script>
	<script src="../js/core/source/AppCard.js"></script>
	<script src="../js/core/source/AppForm.js"></script>
	<script src="../js/core/source/AppNavSearch.js"></script>
	<script src="../js/core/source/AppVendor.js"></script>
	<script src="../js/core/demo/Demo.js"></script>
	<script src="../js/PasswordMeter.js"></script>


	

	<!-- END JAVASCRIPT -->



</body>
</html>
