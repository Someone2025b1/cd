<?php
$ImagenAleatoria = rand(1, 3);
include("conex.php");
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

</head>
<body class="menubar-hoverable header-fixed">

	<!-- BEGIN LOGIN SECTION -->
	<section class="section-account">
		<div class="img-backdrop" style="background-image: url('../img/background/<?php echo $ImagenAleatoria; ?>.jpg'); height: 40%"></div>
		<div class="spacer"></div>
		<div class="card contain-sm style-transparent">
			<div class="card-body">
				<div class="content-fluid">
					<div class="col-sm-6" style="left: 150px;" align="center">
						<br/>
						<br/>
						<?php
						if((isset($_POST["password"]) == isset($_POST["passwordconfimacion"])))
						{
							$password=$_POST["passwordconfimacion"];


							$salt = '**__Sup3rAdm1nCHT__**';
							$password = $salt.$password;
							$password = hash('sha256', $password);

							$passwordAct = hash('sha256', $salt.$_POST["passwordactual"]);

							$UserID = $_POST["username"];

							$sql = mysqli_query($db, "SELECT password FROM info_bbdd.usuarios WHERE login = '".$UserID."'"); 						
							$row=mysqli_fetch_array($sql);
							$PassAlmacenada = $row["password"];
							if($passwordAct == $PassAlmacenada)
							{
								$sqlcambiar = mysqli_query($db, "UPDATE info_bbdd.usuarios SET password = '".$password."' WHERE login = '".$UserID."'");
								if(!$sqlcambiar)
								{
									?>	
									<section>
										<div class="section-body contain-lg">
											<div class="row">
												<div class="col-lg-12 text-center">
													<h1><span class="text-xxxl text-light">Error <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
													<h4 class="text-light">No se puedo completar la actualización</h4>
												</div><!--end .col -->
											</div><!--end .row -->
										</div><!--end .section-body -->
										<div class="col-lg-12">
											<br>
											<a href="CambiarPass.php"><button class="btn btn-danger">Regresar</button></a>
										</div>
									</section>
									<?php
								}
								else
								{
									header('Location: ../index.php');
								}
							}
							else
							{
								?>	
								<section>
									<div class="section-body contain-lg">
										<div class="row">
											<div class="col-lg-12 text-center">
												<h1><span class="text-xxxl text-light">Error <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
												<h4 class="text-light">La contraseña actual no coincide con la almacenada en la base de datos</h4>
											</div><!--end .col -->
										</div><!--end .row -->
									</div><!--end .section-body -->
									<div class="col-lg-12">
										<br>
										<a href="CambiarPass.php"><button class="btn btn-danger">Regresar</button></a>
									</div>
								</section>
								<?php
							}
						}
						else
						{
							?>
							<section>
								<div class="section-body contain-lg">
									<div class="row">
										<div class="col-lg-12 text-center">
											<h1><span class="text-xxxl text-light">Error <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
											<h4 class="text-light">Las contraseña nueva y su confirmación no coinciden</h4>
										</div><!--end .col -->
									</div><!--end .row -->
								</div><!--end .section-body -->
								<div class="col-lg-12">
									<br>
									<a href="CambiarPass.php"><button class="btn btn-danger">Regresar</button></a>
								</div>
							</section>
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


	

	<!-- END JAVASCRIPT -->



</body>
</html>
