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
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Mantenimiento de Eventos</strong><br></h1>
				<br>
				<form class="form" method="POST" role="form">
					<?php
 
						#DATOS GENERALES
						$CodigoEv                =$_POST["CodigoEvento"];
						$ComentarioJefe         =$_POST["ComentarioJefe"];



						$sqlGeneral = mysqli_query($db, "UPDATE  Eventos.EVENTO SET EV_COM_JEFE=1 WHERE EV_CODIGO = '".$CodigoEv."'");

						

                        $sqlJefe = mysqli_query($db, "INSERT INTO Eventos.EV_COMENTARIOS (EV_CODIGO, EV_AREA, EV_COMETARIO, EV_FECHA, EV_HORA)
											VALUES ('".$CodigoEv."', 'Jefe', '".$ComentarioJefe."', CURRENT_DATE(), CURRENT_TIMESTAMP())");
						
                        
						
					 
					 
						
						if(!$sqlGeneral | !$sqlJefe)
						{
							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo Editar el Evento.</h2>
								</div>';
							echo mysqli_error($sq, $sql);
							
						}
						else
						{
							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El Evento se edito correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="ConsultarEvento.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
							</div>';
						}
					?>
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<?php include("../MenuUsers.html"); ?>

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
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<!-- END JAVASCRIPT -->

	</body>
	</html>
