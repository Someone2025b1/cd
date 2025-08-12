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
						$Cod        = uniqid("EV_");
						$NombreDueno = $_POST["NombreDueno"];
						$Celular = $_POST["Celular"];
						$Fecha = $_POST["Fecha"];
						$HoraIni = $_POST["HoraIni"];
						$HoraFin = $_POST["HoraFin"];
						$Personas = $_POST["Personas"];
						$Lugar = $_POST["Lugar"];
						$NombreEvento = $_POST["NombreEvento"];

						if($Lugar==1){
							$Lugar = $_POST["OtroLugar"];
						}
						$ObservacionesGen = $_POST["ObservacionesGen"];

						if(isset($_POST["Informativo"]))
								{
									$Informativo = 1;
								}
								else
								{
									$Informativo = 0;
								}



						$sqlGeneral = mysqli_query($db, "INSERT INTO Eventos.EVENTO (EV_CODIGO, EV_NOMBRE, EV_DUENO, EV_CEL, EV_ENCARGADO, EV_FECHA_EV, EV_FECHA_CRE, EV_HORA_INI, EV_HORA_FIN, EV_LUGAR, EV_CANTIDAD_PERSONAS, EV_OBSERVACIONES, EV_FECHAMOD, EV_HORAINGRESO, EV_HORAMOD, EV_INFORMATIVO)
											VALUES ('".$Cod."', '".$NombreEvento."', '".$NombreDueno."', '".$Celular."', '".$id_user."', '".$Fecha."', CURRENT_DATE(), '".$HoraIni."', '".$HoraFin."', '".$Lugar."', '".$Personas."', '".$ObservacionesGen."',  CURRENT_DATE(), CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), '".$Informativo."')");
						



	
						#DATOS MERCADEO
						

						if(isset($_POST["Bocina"]))
								{
									$Bocina = 1;
								}
								else
								{
									$Bocina = 0;
								}

						if(isset($_POST["Microfonos"]))
								{
									$Microfonos = 1;
								}
								else
								{
									$Microfonos = 0;
								}

						if(isset($_POST["Musica"]))
								{
									$Musica = 1;
								}
								else
								{
									$Musica = 0;
								}

						if(isset($_POST["MusicaInstrumental"]))
								{
									$MusicaInstrumental = 1;
								}
								else
								{
									$MusicaInstrumental = 0;
								}

								if(isset($_POST["Proyector"]))
								{
									$Proyector = 1;
								}
								else
								{
									$Proyector = 0;
								}

								if(isset($_POST["Extenciones"]))
								{
									$Extenciones = 1;
								}
								else
								{
									$Extenciones = 0;
								}

								$ObservacionesMerca = $_POST["ObservacionesMerca"];


						$sqlMercadeo = mysqli_query($db, "INSERT INTO Eventos.EV_DETALLE_MERCADEO (EV_CODIGO, EVDM_BOCINA, EVDM_MICROFONOS, EV_MUSICA_INSTRUMENTAL, EV_MUSICA, EV_OBSERVACIONES_MERCADEO, EV_PROYECTOR, EV_EXTENCIONES)
						VALUES ('".$Cod."', '".$Bocina."', '".$Microfonos."', '".$MusicaInstrumental."', '".$Musica."', '".$ObservacionesMerca."', '".$Proyector."', '".$Extenciones."')");
	




						#DATOS OPERACIONES

						$Montaje = $_POST["Montaje"];

						if($Montaje==1){
						
							$Montaje = $_POST["OtroMontaje"];

							if($Montaje == ""){
								$Montaje="SIN MONTAJE";
							}

						}

						if(isset($_POST["Pizarra"]))
								{
									$Pizarra = 1;
								}
								else
								{
									$Pizarra = 0;
								}

						if(isset($_POST["Pantalla"]))
								{
									$Pantalla = 1;
								}
								else
								{
									$Pantalla = 0;
								}

								if(isset($_POST["MesaSonido"]))
								{
									$MesaSonido = 1;
								}
								else
								{
									$MesaSonido = 0;
								}

						if(isset($_POST["ManteleriaCompleta"]))
								{
									$ManteleriaCompleta = 1;
								}
								else
								{
									$ManteleriaCompleta = 0;
								}

						if(isset($_POST["Tarima"]))
								{
									$Tarima = 1;
								}
								else
								{
									$Tarima = 0;
								}

						if(isset($_POST["SobreMantel"]))
								{
									$SobreMantel = 1;
								}
								else
								{
									$SobreMantel = 0;
								}

								if(isset($_POST["MesaAYB"]))
								{
									$MesaAyB = 1;
								}
								else
								{
									$MesaAyB = 0;
								}

								if(isset($_POST["MesaProyector"]))
								{
									$MesaProyector = 1;
								}
								else
								{
									$MesaProyector = 0;
								}

						
						$ColorSobremantel = $_POST["ColorSobremantel"];

						if(isset($_POST["MesasExtra"]))
								{
									$MesasExtra = 1;
								}
								else
								{
									$MesasExtra = 0;
								}


						$CantidadMesasExtra = $_POST["CantidadMesasExtra"];
						$DescripcionMesas = $_POST["DescripcionMesas"];
						$MesasSillas = $_POST["MesasSillas"];
						$ObsertvacionesOperaciones = $_POST["ObsertvacionesOperaciones"];

						$sqlOperaciones = mysqli_query($db, "INSERT INTO Eventos.EV_REQUERIMIENTOS_OPERACONES (EV_CODIGO, EVRO_PIZARRA, EVRO_TIPO_MONTAJE, EVRO_PANTALLA, EVRO_MESA_SONIDO, EVRO_MANTELERIA_COMPLETA, EVRO_TARIMA, EVRO_SOBREMANTEL, EVRO_COLOR_SOBREMANTEL, EVRO_SILLA, EVRO_OBSERVACIONES, EVRO_CANTIDAD_EXTRA, EVRO_MESA_PARA, EVRO_MESAPRYECTOR, EVRO_MESAAYB)
											VALUES ('".$Cod."', '".$Pizarra."', '".$Montaje."', '".$Pantalla."', '".$MesaSonido."', '".$ManteleriaCompleta."', '".$Tarima."', '".$SobreMantel."', '".$ColorSobremantel."', '".$MesasSillas."', '".$ObsertvacionesOperaciones."', '".$CantidadMesasExtra."', '".$DescripcionMesas."', '".$MesaProyector."', '".$MesaAyB."')");
						


						#DATOS ALIMENTOS Y BEBIDAS
						$AYBErro=0;
						$ObservacionesAyB = $_POST["ObservacionesAyB"];

						#DESAYUNO
						if(isset($_POST["CheckDesayuno"]))
								{
									$CodR        = uniqid("EVR_");
									if(isset($_POST["AdultoD"]))
								{
									$AdultoD = 1;
								}
								else
								{
									$AdultoD = 0;
								}

								$CantidadAdultoD = $_POST["CantidadAdultoD"];
								$MenuAdultoD = $_POST["MenuAdultoD"];


								if(isset($_POST["NinoD"]))
								{
									$NinoD = 1;
								}
								else
								{
									$NinoD = 0;
								}

								$CantidadNinoD = $_POST["CantidadNinoD"];
								$MenuNinoD = $_POST["MenuNinoD"];

								$HoraD = $_POST["HoraD"];
								$ServirEnD = $_POST["ServirEnD"];
								$EstiloD = $_POST["EstiloD"];
								$AdicionalesD = $_POST["AdicionalesD"];


								$sqlAyBDes = mysqli_query($db, "INSERT INTO Eventos.EV_REQUERIMIENTOS_AYB (EV_CODIGO, EV_CODIGO_REQUERIMIENTO, EVRA_TIPO, EVRA_ADULTO, EVRA_MENU_ADULTO, EVRA_CANTIDAD_ADULTO, EVRA_NINO, EVRA_CANTIDAD_NINO, EVRA_MENU_NINO, EVRA_HORA, EVRA_SERVIREN, EVRA_ESTILO, EVRA_ADICIONALES, EVRA_OBSERVACIONES)
											VALUES ('".$Cod."', '".$CodR."', 'DESAYUNO', '".$AdultoD."', '".$MenuAdultoD."', '".$CantidadAdultoD."', '".$NinoD."', '".$CantidadNinoD."', '".$MenuNinoD."', '".$HoraD."', '".$ServirEnD."', '".$EstiloD."', '".$AdicionalesD."', '".$ObservacionesAyB."')");
						


						if(!$sqlAyBDes)
						{
							$AYBErro=1;
						}

									
								}


								#REFAAM
						if(isset($_POST["CheckRefaAM"]))
						{
							$CodR        = uniqid("EVR_");

							if(isset($_POST["AdultoRAM"]))
						{
							$AdultoRAM = 1;
						}
						else
						{
							$AdultoRAM = 0;
						}

						$CantidadAdultoRAM = $_POST["CantidadAdultoRAM"];
						$MenuAdultoRAM = $_POST["MenuAdultoRAM"];


						if(isset($_POST["NinoRAM"]))
						{
							$NinoRAM = 1;
						}
						else
						{
							$NinoRAM = 0;
						}

						$CantidadNinoRAM = $_POST["CantidadNinoRAM"];
						$MenuNinoRAM = $_POST["MenuNinoRAM"];

						$HoraRAM = $_POST["HoraRAM"];
						$ServirEnAM = $_POST["ServirEnAM"];
						$EstiloRAM = $_POST["EstiloRAM"];
						$AdicionalesRAM = $_POST["AdicionalesRAM"];


						$sqlAyBRefaAM = mysqli_query($db, "INSERT INTO Eventos.EV_REQUERIMIENTOS_AYB (EV_CODIGO, EV_CODIGO_REQUERIMIENTO, EVRA_TIPO, EVRA_ADULTO, EVRA_MENU_ADULTO, EVRA_CANTIDAD_ADULTO, EVRA_NINO, EVRA_CANTIDAD_NINO, EVRA_MENU_NINO, EVRA_HORA, EVRA_SERVIREN, EVRA_ESTILO, EVRA_ADICIONALES, EVRA_OBSERVACIONES)
											VALUES ('".$Cod."', '".$CodR."', 'REFAAM', '".$AdultoRAM."', '".$MenuAdultoRAM."', '".$CantidadAdultoRAM."', '".$NinoRAM."', '".$CantidadNinoRAM."', '".$MenuNinoRAM."', '".$HoraRAM."', '".$ServirEnAM."', '".$EstiloRAM."', '".$AdicionalesRAM."', '".$ObservacionesAyB."')");
						

						if(!$sqlAyBRefaAM)
						{
							$AYBErro=1;
						}
							
						}
						
						#ALMUERZO
						if(isset($_POST["CheckAlmuerzo"]))
						{
							$CodR        = uniqid("EVR_");

							if(isset($_POST["AdultoA"]))
						{
							$AdultoA = 1;
						}
						else
						{
							$AdultoA = 0;
						}

						$CantidadAdultoA = $_POST["CantidadAdultoA"];
						$MenuAdultoA = $_POST["MenuAdultoA"];


						if(isset($_POST["NinoA"]))
						{
							$NinoA = 1;
						}
						else
						{
							$NinoA = 0;
						}

						$CantidadNinoA = $_POST["CantidadNinoA"];
						$MenuNinoA = $_POST["MenuNinoA"];

						$HoraA = $_POST["HoraA"];
						$ServirEnA = $_POST["ServirEnA"];
						$EstiloA = $_POST["EstiloA"];
						$AdicionalesA = $_POST["AdicionalesA"];

						
						$sqlAyBAlm = mysqli_query($db, "INSERT INTO Eventos.EV_REQUERIMIENTOS_AYB (EV_CODIGO, EV_CODIGO_REQUERIMIENTO, EVRA_TIPO, EVRA_ADULTO, EVRA_MENU_ADULTO, EVRA_CANTIDAD_ADULTO, EVRA_NINO, EVRA_CANTIDAD_NINO, EVRA_MENU_NINO, EVRA_HORA, EVRA_SERVIREN, EVRA_ESTILO, EVRA_ADICIONALES, EVRA_OBSERVACIONES)
						VALUES ('".$Cod."', '".$CodR."', 'ALMUERZO', '".$AdultoA."', '".$MenuAdultoA."', '".$CantidadAdultoA."', '".$NinoA."', '".$CantidadNinoA."', '".$MenuNinoA."', '".$HoraA."', '".$ServirEnA."', '".$EstiloA."', '".$AdicionalesA."', '".$ObservacionesAyB."')");
	
						if(!$sqlAyBAlm)
						{
							$AYBErro=1;
						}
							
						}

						#REFAPM
						if(isset($_POST["CheckRefaPM"]))
						{
							$CodR        = uniqid("EVR_");

							if(isset($_POST["AdultoRPM"]))
						{
							$AdultoRPM = 1;
						}
						else
						{
							$AdultoRPM = 0;
						}

						$CantidadAdultoRPM = $_POST["CantidadAdultoRPM"];
						$MenuAdultoRPM = $_POST["MenuAdultoRPM"];


						if(isset($_POST["NinoRPM"]))
						{
							$NinoRPM = 1;
						}
						else
						{
							$NinoRPM = 0;
						}

						$CantidadNinoRPM = $_POST["CantidadNinoRPM"];
						$MenuNinoRPM = $_POST["MenuNinoRPM"];

						$HoraRPM = $_POST["HoraRPM"];
						$ServirEnPM = $_POST["ServirEnPM"];
						$EstiloRPM = $_POST["EstiloRPM"];
						$AdicionalesRPM = $_POST["AdicionalesRPM"];


						
						$sqlAyBRefaPM = mysqli_query($db, "INSERT INTO Eventos.EV_REQUERIMIENTOS_AYB (EV_CODIGO, EV_CODIGO_REQUERIMIENTO, EVRA_TIPO, EVRA_ADULTO, EVRA_MENU_ADULTO, EVRA_CANTIDAD_ADULTO, EVRA_NINO, EVRA_MENU_NINO, EVRA_CANTIDAD_NINO, EVRA_HORA, EVRA_SERVIREN, EVRA_ESTILO, EVRA_ADICIONALES, EVRA_OBSERVACIONES)
						VALUES ('".$Cod."', '".$CodR."', 'REFAPM', '".$AdultoRPM."', '".$MenuAdultoRPM."', '".$CantidadAdultoRPM."', '".$NinoRPM."', '".$MenuNinoRPM."', '".$CantidadNinoRPM."', '".$HoraRPM."', '".$ServirEnPM."', '".$EstiloRPM."', '".$AdicionalesRPM."', '".$ObservacionesAyB."')");
	
						
							if(!$sqlAyBRefaPM)
							{
								$AYBErro=1;
							}

							
						}
						

						#CENA
						if(isset($_POST["CheckCena"]))
						{
							$CodR        = uniqid("EVR_");

							if(isset($_POST["AdultoC"]))
						{
							$AdultoC = 1;
						}
						else
						{
							$AdultoC = 0;
						}

						$CantidadAdultoC = $_POST["CantidadAdultoC"];
						$MenuAdultoC = $_POST["MenuAdultoC"];


						if(isset($_POST["NinoC"]))
						{
							$NinoC = 1;
						}
						else
						{
							$NinoC = 0;
						}

						$CantidadNinoC = $_POST["CantidadNinoC"];
						$MenuNinoC = $_POST["MenuNinoC"];

						$HoraC = $_POST["HoraC"];
						$ServirEnC = $_POST["ServirEnC"];
						$EstiloC = $_POST["EstiloC"];
						$AdicionalesC = $_POST["AdicionalesC"];

						
						$sqlAyBCena = mysqli_query($db, "INSERT INTO Eventos.EV_REQUERIMIENTOS_AYB (EV_CODIGO, EV_CODIGO_REQUERIMIENTO, EVRA_TIPO, EVRA_ADULTO, EVRA_MENU_ADULTO, EVRA_CANTIDAD_ADULTO, EVRA_NINO, EVRA_CANTIDAD_NINO, EVRA_MENU_NINO, EVRA_HORA, EVRA_SERVIREN, EVRA_ESTILO, EVRA_ADICIONALES, EVRA_OBSERVACIONES)
						VALUES ('".$Cod."', '".$CodR."', 'CENA', '".$AdultoC."', '".$MenuAdultoC."', '".$CantidadAdultoC."', '".$NinoC."', '".$CantidadNinoC."', '".$MenuNinoC."', '".$HoraC."', '".$ServirEnC."', '".$EstiloC."', '".$AdicionalesC."', '".$ObservacionesAyB."')");
	
							if(!$sqlAyBCena)
							{
								$AYBErro=1;
							}

							
						}

						
					 
					 
						
						if(!$sqlGeneral | !$sqlMercadeo | !$sqlOperaciones | $AYBErro==1)
						{
							echo '<div class="col-lg-12 text-center">
									<h1><span class="text-xxxl text-light">ERROR <i class="fa fa-exclamation-circle text-danger"></i></span></h1>
									<h2 class="text-light">Lo sentimos, no se pudo ingresar toda la información del Evento.</h2>
								</div>';
							echo mysqli_error($sq, $sql);
							
						}
						else
						{
							echo '<div class="col-lg-12 text-center">
								<h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
								<h2 class="text-light">El Evento se ingresó correctamente.</h2>
								<div class="row">
									<div class="col-lg-12 text-center"><a href="AgregarEvento.php"><button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a></div>
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
