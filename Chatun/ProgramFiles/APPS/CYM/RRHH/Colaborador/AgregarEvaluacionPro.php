<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
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
				<form id="FormularioEnviar" action="EditarColaborador.php" method="POST">
					<div class="col-lg-12">
						<br>
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Evaluación de Desempeño</strong></h4>
							</div>
							<div class="card-body">
								<?php
								$CodigoColaborador   = $_POST["Codigo"];
								$CodEvaluacion   = uniqid("EVD_");
								
								$i=1;
						//Guardar los punteos de cada aspecto
				$query = "SELECT * FROM RRHH.AREA_EVALUAR WHERE AREA_EVALUAR.AR_CODIGO  ORDER BY AR_CODIGO";
				$result = mysqli_query($db, $query);
				while($row = mysqli_fetch_array($result))
				{
					$CodAre=$row["AR_CODIGO"];
					$NombreAre=$row["AR_NOMBRE"];

					

								$Aspecto   = $_POST["CodigoAspecto".$CodAre];
								$Punteo   = $_POST["Punteo".$CodAre];
								$Contador  = count($_POST["CodigoAspecto".$CodAre]);

								for($i=0; $i<$Contador; $i++)
								{

									$CodAs = $Aspecto[$i];
									$Pun = $Punteo[$i];

									


									$queryAbonoProd = mysqli_query($db, "INSERT INTO RRHH.EVALUACION_DETALLE (ED_CODIGO, AR_CODIGO, ARE_CODIGO, EDD_PUNTEO)
									VALUES('".$CodEvaluacion."', '".$CodAs."', '".$CodAre."', '".$Pun."')");


								}





							

				}

						//Guardar El Resumen
						$query = "SELECT * FROM RRHH.AREA_EVALUAR WHERE AREA_EVALUAR.AR_CODIGO  ORDER BY AR_CODIGO";
						$result = mysqli_query($db, $query);
						while($row = mysqli_fetch_array($result))
						{
							$CodAre=$row["AR_CODIGO"];
							$NombreAre=$row["AR_NOMBRE"];
		
							
		
										$Promedio   = $_POST["PromedioAreaR".$CodAre];
										$Punteo   = $_POST["ObtenidoAreaR".$CodAre];
										$Anterior  = $_POST["UltimoObtenido".$CodAre];
										$PuntosPosibles  = $_POST["EsperadoAreaR".$CodAre];
										$Observaciones  = $_POST["Observaciones".$CodAre];

		
											
		
		
											$$queryAbonoProd = mysqli_query($db, "INSERT INTO RRHH.EVALUACION_DES_RESUMEN (ED_CODIGO, AR_CODIGO, EVDR_PROMEDIO, EVDR_PUNTEO, EVDR_PUNTEO_POS, EVDR_OBSERVACIONES, EVDR_ANTERIOR)
											VALUES('".$CodEvaluacion."', '".$CodAre."', '".$Promedio."', '".$Punteo."', '".$PuntosPosibles."', '".$Observaciones."', '".$Anterior."')");
		
		
						}
				

						#Guardar Los Datos principales de la Evaluación

						$PromedioFinal   = $_POST["PromedioTotal"];

						$queryAbonoProd = mysqli_query($db, "INSERT INTO RRHH.EVALUACION_DESEMPENO (ED_CODIGO, C_CODIGO, ED_FECHA, ED_PROMEDIO, U_CODIGO)
											VALUES('".$CodEvaluacion."', '".$CodigoColaborador."', CURRENT_DATE(), '".$PromedioFinal."', '".$id_user."')");



							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
									<h2 class="text-light">La Evaluación se ingreso Correctamente.</h2>
									<div class="row">
										<div class="col-lg-6 text-right"><a href="ImpEvaluacion.php?Codigo='.$CodEvaluacion.'" target="_blank"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span> Imprimir</a></div>
										<div class="col-lg-6 text-left"><a href="AgregarEvaluacion.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Nueva Evaluación</a></div>
								</div>';

								?>



							

							</div>
						</div>
					</div>
					<br>
					<br>
				</form>
			</div>
		</div>
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
	</body>
	</html>
