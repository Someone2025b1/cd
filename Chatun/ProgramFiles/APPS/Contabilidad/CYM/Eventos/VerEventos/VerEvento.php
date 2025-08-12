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

	<script>

function Otro(x)
		{
            if(x == 1)
			{
            $('#DIVOTRO').show();
			}else{
				$('#DIVOTRO').hide();
			}
        	
        }

		function Otromontaje(x)
		{
            if(x == 1)
			{
            $('#DIVOTROMONTAJE').show();
			}else{
				$('#DIVOTROMONTAJE').hide();
			}
        	
        }

		function Color(x)
        {
        	if(x.checked)
        	{
        		$('#DIVCOLOR').show();
        	}
        	else
        	{
        		$('#DIVCOLOR').hide();
        	}
        }
		function Mesas(x)
        {
        	if(x.checked)
        	{
        		$('#DIVMESAS').show();
        	}
        	else
        	{
        		$('#DIVMESAS').hide();
        	}
        }

		function RefaAM(x)
        {
        	if(x.checked)
        	{
        		$('#DIVREFAAM').show();
        	}
        	else
        	{
        		$('#DIVREFAAM').hide();
        	}
        }
		function AdultoAM(x)
        {
        	if(x.checked)
        	{
        		$('#DIVADULTORAM').show();
        	}
        	else
        	{
        		$('#DIVADULTORAM').hide();
        	}
        }

		function NinoAM(x)
        {
        	if(x.checked)
        	{
        		$('#DIVNINORAM').show();
        	}
        	else
        	{
        		$('#DIVNINORAM').hide();
        	}
        }


		function Desayuno(x)
        {
        	if(x.checked)
        	{
        		$('#DIVDESAYUNO').show();
        	}
        	else
        	{
        		$('#DIVDESAYUNO').hide();
        	}
        }

		function AdultoDes(x)
        {
        	if(x.checked)
        	{
        		$('#DIVADULTOD').show();
        	}
        	else
        	{
        		$('#DIVADULTOD').hide();
        	}
        }

		function NinoDes(x)
        {
        	if(x.checked)
        	{
        		$('#DIVNINOD').show();
        	}
        	else
        	{
        		$('#DIVNINOD').hide();
        	}
        }


		function Almuerz(x)
        {
        	if(x.checked)
        	{
        		$('#DIVALMUERZO').show();
        	}
        	else
        	{
        		$('#DIVALMUERZO').hide();
        	}
        }

		function AdultoAl(x)
        {
        	if(x.checked)
        	{
        		$('#DIVADULTOA').show();
        	}
        	else
        	{
        		$('#DIVADULTOA').hide();
        	}
        }

		function NinoAl(x)
        {
        	if(x.checked)
        	{
        		$('#DIVNINOA').show();
        	}
        	else
        	{
        		$('#DIVNINOA').hide();
        	}
        }


		function RefaPM(x)
        {
        	if(x.checked)
        	{
        		$('#DIVREFAPM').show();
        	}
        	else
        	{
        		$('#DIVREFAPM').hide();
        	}
        }

		function AdultoPM(x)
        {
        	if(x.checked)
        	{
        		$('#DIVADULTORPM').show();
        	}
        	else
        	{
        		$('#DIVADULTORPM').hide();
        	}
        }

		function NinoPM(x)
        {
        	if(x.checked)
        	{
        		$('#DIVNINORPM').show();
        	}
        	else
        	{
        		$('#DIVNINORPM').hide();
        	}
        }



		function Cena(x)
        {
        	if(x.checked)
        	{
        		$('#DIVCENA').show();
        	}
        	else
        	{
        		$('#DIVCENA').hide();
        	}
        }

		function AdultoCen(x)
        {
        	if(x.checked)
        	{
        		$('#DIVADULTOC').show();
        	}
        	else
        	{
        		$('#DIVADULTOC').hide();
        	}
        }

		function NinoCen(x)
        {
        	if(x.checked)
        	{
        		$('#DIVNINOC').show();
        	}
        	else
        	{
        		$('#DIVNINOC').hide();
        	}
        }

	
		</script>
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

	<?php
				$Codigo=$_GET["Codigo"];
				$Consulta = "SELECT A.*
				FROM Eventos.EVENTO AS A
				WHERE A.EV_CODIGO = '$Codigo'
				ORDER BY A.EV_CODIGO";
				$Resultado = mysqli_query($db, $Consulta);
				while($row = mysqli_fetch_array($Resultado))
				{
					$Codigo=$row["EV_CODIGO"];
					$FechaCreo=$row["EV_FECHA_CRE"];
					$FechaMod=$row["EV_FECHAMOD"];
					$HoraCreo=$row["EV_HORAINGRESO"];
					$HoraMod=$row["EV_HORAMOD"];
					$Dueno=$row["EV_DUENO"];
					$Cel=$row["EV_CEL"];
					$Encargado=$row["EV_ENCARGADO"];
					$FechaEvento=$row["EV_FECHA_EV"];
					$FechaNacimineto=$row["CLIC_FECHA_NACIMIENTO"];
					$HoraIni=$row["EV_HORA_INI"];
					$HoraFin=$row["EV_HORA_FIN"];
					$Lugar=$row["EV_LUGAR"];
					$CantidadPersona=$row["EV_CANTIDAD_PERSONAS"];
					$ObservacionesGen=$row["EV_OBSERVACIONES"];
					$NombreEvento=$row["EV_NOMBRE"];
					$EstadoEv =$row["EV_ESTADO"];
					$ComentarioJefe =$row["EV_COM_JEFE"];
					$Factura =$row["F_CODIGO"];
					
					
				}
				
				$ConsultaMerca = "SELECT A.*
				FROM Eventos.EV_DETALLE_MERCADEO AS A
				WHERE A.EV_CODIGO = '$Codigo'
				ORDER BY A.EV_CODIGO";
				$ResultadoMerca = mysqli_query($db, $ConsultaMerca);
				while($rowMer = mysqli_fetch_array($ResultadoMerca))
				{
					$Bocina=$rowMer["EVDM_BOCINA"];
					$Microfonos=$rowMer["EVDM_MICROFONOS"];
					$MusicaInstrumental=$rowMer["EV_MUSICA_INSTRUMENTAL"];
					$Musica=$rowMer["EV_MUSICA"];
					$ObservacionesMercadeo=$rowMer["EV_OBSERVACIONES_MERCADEO"];
					$Proyector=$rowMer["EV_PROYECTOR"];
					$Extenciones=$rowMer["EV_EXTENCIONES"];
					
				}

				$ConsultaOperaciones = "SELECT A.*
				FROM Eventos.EV_REQUERIMIENTOS_OPERACONES AS A
				WHERE A.EV_CODIGO = '$Codigo'
				ORDER BY A.EV_CODIGO";
				$ResultadoOp = mysqli_query($db, $ConsultaOperaciones);
				while($rowOp = mysqli_fetch_array($ResultadoOp))
				{
					$Pizarra=$rowOp["EVRO_PIZARRA"];
					$TipoMontaje=$rowOp["EVRO_TIPO_MONTAJE"];
					$Pantalla=$rorowOpw["EVRO_PANTALLA"];
					$MesaSonido=$rowOp["EVRO_MESA_SONIDO"];
					$ManteleriaCompleta=$rowOp["EVRO_MANTELERIA_COMPLETA"];
					$SobreMantel=$rowOp["EVRO_SOBREMANTEL"];
					$ColorSobremantel=$rowOp["EVRO_COLOR_SOBREMANTEL"];
					$MesasSillas=$rowOp["EVRO_SILLA"];
					$Tarima=$rowOp["EVRO_TARIMA"];
					$ObservacionesOperaciones=$rowOp["EVRO_OBSERVACIONES"];
					$MesasExtra=$rowOp["EVRO_CANTIDAD_EXTRA"];
					$MesasPara=$rowOp["EVRO_MESA_PARA"];
					$MesaProyector=$rowOp["EVRO_MESAPRYECTOR"];
					$MesaAyB=$rowOp["EVRO_MESAAYB"];

					
				}

				#Desayuno
				$ConsultaDes = "SELECT A.*
				FROM Eventos.EV_REQUERIMIENTOS_AYB AS A
				WHERE A.EV_CODIGO = '$Codigo' AND A.EVRA_TIPO = 'DESAYUNO'
				ORDER BY A.EV_CODIGO";
				$ResultadoDes = mysqli_query($db, $ConsultaDes);
				while($rowDes = mysqli_fetch_array($ResultadoDes))
				{
					$CodigoDes=$rowDes["EV_CODIGO_REQUERIMIENTO"];
					$TipoD=$rowDes["EVRA_TIPO"];
					$AdultoD=$rowDes["EVRA_ADULTO"];
					$MenuAdultoD=$rowDes["EVRA_MENU_ADULTO"];
					$CantidadAdultoD=$rowDes["EVRA_CANTIDAD_ADULTO"];
					$NinoD=$rowDes["EVRA_NINO"];
					$CantidadNinoD=$rowDes["EVRA_CANTIDAD_NINO"];
					$MenuNinoD=$rowDes["EVRA_MENU_NINO"];
					$HoraD=$rowDes["EVRA_HORA"];
					$ServirEnD=$rowDes["EVRA_SERVIREN"];
					$EstiloD=$rowDes["EVRA_ESTILO"];
					$AdicionalesD=$rowDes["EVRA_ADICIONALES"];
					$ObservacionesAyB=$rowDes["EVRA_OBSERVACIONES"];
					
				}

				#RefaAM
				$ConsultaRefaAM = "SELECT A.*
				FROM Eventos.EV_REQUERIMIENTOS_AYB AS A
				WHERE A.EV_CODIGO = '$Codigo' AND A.EVRA_TIPO = 'REFAAM'
				ORDER BY A.EV_CODIGO";
				$ResultadoRefaAM = mysqli_query($db, $ConsultaRefaAM);
				while($rowAM = mysqli_fetch_array($ResultadoRefaAM))
				{
					$CodigoRefaAM=$rowAM["EV_CODIGO_REQUERIMIENTO"];
					$TipoRefaAM=$rowAM["EVRA_TIPO"];
					$AdultoRAM=$rowAM["EVRA_ADULTO"];
					$MenuAdultoRAM=$rowAM["EVRA_MENU_ADULTO"];
					$CantidadAdultoRAM=$rowAM["EVRA_CANTIDAD_ADULTO"];
					$NinoRAM=$rowAM["EVRA_NINO"];
					$CantidadNinoRAM=$rowAM["EVRA_CANTIDAD_NINO"];
					$MenuNinoRAM=$rowAM["EVRA_MENU_NINO"];
					$HoraRAM=$rowAM["EVRA_HORA"];
					$ServirEnAM=$rowAM["EVRA_SERVIREN"];
					$EstiloRAM=$rowAM["EVRA_ESTILO"];
					$AdicionalesRAM=$rowAM["EVRA_ADICIONALES"];
					$ObservacionesAyB=$rowAM["EVRA_OBSERVACIONES"];
					
				}

				#Almuerzo
				$ConsultaAl = "SELECT A.*
				FROM Eventos.EV_REQUERIMIENTOS_AYB AS A
				WHERE A.EV_CODIGO = '$Codigo' AND A.EVRA_TIPO = 'ALMUERZO'
				ORDER BY A.EV_CODIGO";
				$ResultadoAl = mysqli_query($db, $ConsultaAl);
				while($rowDAl = mysqli_fetch_array($ResultadoAl))
				{
					$CodigoAl=$rowDAl["EV_CODIGO_REQUERIMIENTO"];
					$TipoA=$rowDAl["EVRA_TIPO"];
					$AdultoA=$rowDAl["EVRA_ADULTO"];
					$MenuAdultoA=$rowDAl["EVRA_MENU_ADULTO"];
					$CantidadAdultoA=$rowDAl["EVRA_CANTIDAD_ADULTO"];
					$NinoA=$rowDAl["EVRA_NINO"];
					$CantidadNinoA=$rowDAl["EVRA_CANTIDAD_NINO"];
					$MenuNinoA=$rowDAl["EVRA_MENU_NINO"];
					$HoraA=$rowDAl["EVRA_HORA"];
					$ServirEnA=$rowDAl["EVRA_SERVIREN"];
					$EstiloA=$rowDAl["EVRA_ESTILO"];
					$AdicionalesA=$rowDAl["EVRA_ADICIONALES"];
					$ObservacionesAyB=$rowDAl["EVRA_OBSERVACIONES"];
					
				}

				#RefaPM
				$ConsultaRefaPM = "SELECT A.*
				FROM Eventos.EV_REQUERIMIENTOS_AYB AS A
				WHERE A.EV_CODIGO = '$Codigo' AND A.EVRA_TIPO = 'REFAPM'
				ORDER BY A.EV_CODIGO";
				$ResultadoRefaPM = mysqli_query($db, $ConsultaRefaPM);
				while($rowPM = mysqli_fetch_array($ResultadoRefaPM))
				{
					$CodigoRefaPM=$rowPM["EV_CODIGO_REQUERIMIENTO"];
					$TipoRefaPM=$rowPM["EVRA_TIPO"];
					$AdultoRPM=$rowPM["EVRA_ADULTO"];
					$MenuAdultoRPM=$rowPM["EVRA_MENU_ADULTO"];
					$CantidadAdultoRPM=$rowPM["EVRA_CANTIDAD_ADULTO"];
					$NinoRPM=$rowPM["EVRA_NINO"];
					$CantidadNinoRPM=$rowPM["EVRA_CANTIDAD_NINO"];
					$MenuNinoRPM=$rowPM["EVRA_MENU_NINO"];
					$HoraRPM=$rowPM["EVRA_HORA"];
					$ServirEnPM=$rowPM["EVRA_SERVIREN"];
					$EstiloRPM=$rowPM["EVRA_ESTILO"];
					$AdicionalesRPM=$rowPM["EVRA_ADICIONALES"];
					$ObservacionesAyB=$rowPM["EVRA_OBSERVACIONES"];
					
				}

				#Cena
				$ConsultaCen = "SELECT A.*
				FROM Eventos.EV_REQUERIMIENTOS_AYB AS A
				WHERE A.EV_CODIGO = '$Codigo' AND A.EVRA_TIPO = 'CENA'
				ORDER BY A.EV_CODIGO";
				$ResultadoCen = mysqli_query($db, $ConsultaCen);
				while($rowCen = mysqli_fetch_array($ResultadoCen))
				{
					$CodigoCen=$rowCen["EV_CODIGO_REQUERIMIENTO"];
					$TipoC=$rowCen["EVRA_TIPO"];
					$AdultoC=$rowCen["EVRA_ADULTO"];
					$MenuAdultoC=$rowCen["EVRA_MENU_ADULTO"];
					$CantidadAdultoC=$rowCen["EVRA_CANTIDAD_ADULTO"];
					$NinoC=$rowCen["EVRA_NINO"];
					$CantidadNinoC=$rowCen["EVRA_CANTIDAD_NINO"];
					$MenuNinoC=$rowCen["EVRA_MENU_NINO"];
					$HoraC=$rowCen["EVRA_HORA"];
					$ServirEnC=$rowCen["EVRA_SERVIREN"];
					$EstiloC=$rowCen["EVRA_ESTILO"];
					$AdicionalesC=$rowCen["EVRA_ADICIONALES"];
					$ObservacionesAyB=$rowCen["EVRA_OBSERVACIONES"];
					
				}
				$Otro=1;
				$OtroEstilo= 1;
				?>

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div>
		<a href="ConsultarEvento.php"><button type="button" class="btn ink-reaction btn-raised btn-warning"><span class="glyphicon glyphicon-chevron-left"></span> Regresar</a>
			</div>	
		<div class="container">
				<h1 class="text-center"><strong>Evento</strong><br></h1>
				<br>
				<form class="form" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
                        <div class="card-body">
                            <div class="card-head style-primary">
								<h4 class="text-center"> Datos Generales del Evento </h4>
                            </div>
							<div class="row">
									<div class="col-lg-12">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Codigo del Evento</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $Codigo ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-2">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Fecha Creo</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $FechaCreo ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-2">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Hora Creo</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $HoraCreo ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-2">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Fecha Modificado</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $FechaMod ?>" readonly/>
											
										</div>
										</div>
										<div class="col-lg-2">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Hora Modificado</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $HoraMod ?>" readonly/>
											
										</div>
										</div>
									</div>
							</div>
							<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NombreDueno">Nombre del Dueño del Evento</label>
											<input class="form-control" type="text" name="NombreDueno" id="NombreDueno" value="<?php echo $Dueno ?>" required disabled="disabled"/>
											
										</div>
									</div>

									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NombreEvento">Nombre del Evento</label>
											<input class="form-control" type="text" name="NombreEvento" id="NombreEvento" value="<?php echo $NombreEvento ?>" required/>
											
										</div>
									</div>
								
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Celular">Número de Celular</label>
											<input class="form-control" type="text" name="Celular" id="Celular" value="<?php echo $Cel ?>" required disabled="disabled"/>
											
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Fecha">Fecha del Evento</label>
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $FechaEvento ?>" required disabled="disabled"/>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraIni">Hora de Inicio</label>
											<input class="form-control" type="time" name="HoraIni" id="HoraIni" value="<?php echo $HoraIni ?>" required disabled="disabled"/>
											
										</div>
									</div>
                                    <div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraFin">Hora de Fiunalización</label>
											<input class="form-control" type="time" name="HoraFin" id="HoraFin" value="<?php echo $HoraFin ?>" required disabled="disabled"/>
											
										</div>
									</div>
								</div>
								
								
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Personas">Cantidad de Personas</label>
											<input class="form-control" type="num" name="Personas" id="Personas" value="<?php echo $CantidadPersona ?>" required disabled="disabled"/>
										</div>
									</div>
								
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Lugar">Lugar</label>
										<select name="Lugar" id="Lugar" class="form-control" onchange="Otro(this.value)" disabled="disabled">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Rancho Raices" <?php if($Lugar=="Rancho Raices"){echo "selected"; $Otro=0;}?>>Rancho Raices</option>
                                                <option value="Rancho Jardín" <?php if($Lugar=="Rancho Jardín"){echo "selected"; $Otro=0;}?>>Rancho Jardín</option>
                                                <option value="Rancho Terrazas" <?php if($Lugar=="Rancho Terrazas"){echo "selected"; $Otro=0;}?>>Rancho Terrazas</option>
                                                <option value="Rancho Chatun" <?php if($Lugar=="Rancho Chatun"){echo "selected"; $Otro=0;}?>>Rancho Chatun</option>
                                                <option value="Área de Teatro" <?php if($Lugar=="Área de Teatro"){echo "selected"; $Otro=0;}?>>Área de Teatro</option>
                                                <option value="Aula Inovarte" <?php if($Lugar=="Aula Inovarte"){echo "selected"; $Otro=0;}?>>Aula Inovarte</option>
                                                <option value="1" <?php if($Otro==1){echo "selected";}?>>Otro</option>
											</select>
										</div>
									</div>
                                    <div class="col-lg-3">
                                    <div class="form-group floating-label" id="DIVOTRO" <?php if($Otro==0){ echo 'style="display: none;"';  }?> disabled="disabled">
                                        <label for="Paga">Otro</label>
											<input class="form-control" type="text" name="OtroLugar" id="OtroLugar" value="<?php if($Otro==1){ echo $Lugar;}?>" disabled="disabled"/>
											
										</div>
                                    </div>
								</div>
                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObservacionesGen">Observaciones Generales</label>
										<textarea class="form-control" name="ObservacionesGen" id="ObservacionesGen" rows="2" cols="40" disabled="disabled"><?php echo $ObservacionesGen?></textarea>
											
										</div>
									</div>
									</div>
								</div>

								<!-- Requerimientos Mercadeo -->
                                <div class="card panel">
								<div class="card-head style-danger ?> collapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-1" aria-expanded="false">
									<header>Requerimientos Mercadeo</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-1" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<div class="row">
											<div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Bocina" id="Bocina" <?php if($Bocina==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Bocina</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Microfonos" id="Microfonos" <?php if($Microfonos==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Microfonos</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Musica" id="Musica" <?php if($Musica==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Música</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MusicaInstrumental" id="MusicaInstrumental" <?php if($MusicaInstrumental==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Música Instrumental</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Proyector" id="Proyector" <?php if($Proyector==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Proyector</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Extenciones" id="Extenciones" <?php if($Extenciones==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Extenciones</span>
											</label>
										</div>
									</div>
                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObservacionesMerca">Observaciones Mercadeo</label>
										<textarea class="form-control" name="ObservacionesMerca" id="ObservacionesMerca" rows="2" cols="40" disabled="disabled"><?php echo $ObservacionesMercadeo?></textarea>
										</div>
									</div>
									</div>
											</div>
										</div>
									</div>
									</div>
								</div>
							</div><!--end .panel -->
                            <div class="card panel"><!-- Requerimientos Operaciones -->
								<div class="card-head style-warning ?> collapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-2" aria-expanded="false" disabled="disabled">
									<header>Requerimientos Operaciones</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-2" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
												
											
											<div class="row">
									
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Montaje">Tipo Montaje</label>
										<select name="Montaje" id="Montaje" class="form-control" onchange="Otromontaje(this.value)" disabled="disabled">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Banquete" <?php if($TipoMontaje=="Banquete"){echo "selected"; $OtroEstilo=0;}?>>Banquete</option>
                                                <option value="Imperial" <?php if($TipoMontaje=="Imperial"){echo "selected"; $OtroEstilo=0;}?>>Imperial</option>
                                                <option value="Escuela" <?php if($TipoMontaje=="Escuela"){echo "selected"; $OtroEstilo=0;}?>>Escuela</option>
                                                <option value="Auditorio" <?php if($TipoMontaje=="Auditorio"){echo "selected"; $OtroEstilo=0;}?>>Auditorio</option>
                                                <option value="1"  <?php if($OtroEstilo==1){echo "selected";}?>>Otro</option>
											</select>
										</div>
									</div>
									
                                    <div class="col-lg-3">
                                    <div class="form-group floating-label" id="DIVOTROMONTAJE" <?php if($OtroEstilo==0){ echo 'style="display: none;"';  }?>>
                                        <label for="OtroMontaje">Otro</label>
											<input class="form-control" type="text" name="OtroMontaje" id="OtroMontaje"  value="<?php echo $TipoMontaje?>" disabled="disabled"/>
											
										</div>
										</div>
                                    </div>
									<div class="row">
									<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Pizarra" id="Pizarra" <?php if($Pizarra==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Pizarra</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Pantalla" id="Pantalla" <?php if($Pantalla==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Pnatalla</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MesaSonido" id="MesaSonido" <?php if($MesaSonido==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Mesa Sonido</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="ManteleriaCompleta" id="ManteleriaCompleta" <?php if($ManteleriaCompleta==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Manteleria Completa</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Tarima" id="Tarima" <?php if($Tarima==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Tarima</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MesaProyector" id="MesaProyector" <?php if($MesaProyector==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Mesa Proyector</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MesaAYB" id="MesaAYB" <?php if($MesaAyB==1){ echo 'checked';  } ?> disabled="disabled">
												<span>Mesa Para AyB</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="SobreMantel" id="SobreMantel" <?php if($SobreMantel==1){ echo 'checked';  } ?> onchange="Color(this)" disabled="disabled">
												<span>Sobre Mantel</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVCOLOR" <?php if($SobreMantel==0){ echo 'style="display: none;"';  }?>>
                                        <label for="ColorSobremantel">Color Sobremantel</label>
											<input class="form-control" type="text" name="ColorSobremantel" id="ColorSobremantel" value="<?php echo $ColorSobremantel?>" disabled="disabled"/>
											
										
									</div>

									<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MesasExtra" id="MesasExtra" <?php if($MesasExtra>0){ echo 'checked';  } ?> onchange="Mesas(this)" disabled="disabled">
												<span>Mesas Extra</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVMESAS" <?php if($MesasExtra==0){ echo 'style="display: none;"';  }?>>
										
										<div class="col-lg-4">
                                        <label for="CantidadMesasExtra">Cantidad</label>
											<input class="form-control" type="number" name="CantidadMesasExtra" id="CantidadMesasExtra" value="<?php echo $MesasExtra?>" disabled="disabled"/>
											</div>
											<div class="col-lg-4">
                                        <label for="DescripcionMesas">Descripción</label>
											<input class="form-control" type="text" name="DescripcionMesas" id="DescripcionMesas" value="<?php echo $MesasPara?>" disabled="disabled"/>
											
											</div>
										</div>
									
									<div class="row">
									<div class="col-lg-12">
									<div class="form-group floating-label">
                                        <label for="MesasSillas">Descripción de Mesas y Sillas:</label>
										<textarea class="form-control" name="MesasSillas" id="MesasSillas" rows="2" cols="40" disabled="disabled"><?php echo $MesasSillas?></textarea>
									</div>
										
									</div>
										</div>

										
									</div>
                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObsertvacionesOperaciones">Observaciones Operaciones</label>
										<textarea class="form-control" name="ObservacionesOperaciones" id="ObservacionesOperaciones" rows="2" cols="40" disabled="disabled"><?php echo $ObservacionesOperaciones?></textarea>
											
										</div>
										</div>
									</div>
									
										
										
									</div>
									</div>
								
							</div><!--end .panel -->



							

                            <div class="card panel"><!-- Requerimientos AyB -->
								<div class="card-head style-info  collapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-3" aria-expanded="false" disabled="disabled">
									<header>Requerimientos AyB</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-3" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">
										<div class="col-lg-12">	
										
										<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CheckDesayuno" id="CheckDesayuno" <?php if($CodigoDes){ echo 'checked';  } ?> onchange="Desayuno(this)" disabled="disabled">
												<span>Desayuno</span>
											</label>
										</div>
										</div>
										<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CheckRefaAM" id="CheckRefaAM" <?php if($CodigoRefaAM){ echo 'checked';  } ?> onchange="RefaAM(this)" disabled="disabled">
												<span>Refacción a.m.</span>
											</label>
										</div>
										</div>
										<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CheckAlmuerzo" id="CheckAlmuerzo" <?php if($CodigoAl){ echo 'checked';  } ?> onchange="Almuerz(this)" disabled="disabled">
												<span>Almuerzo</span>
											</label>
										</div>
										</div>
										<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CheckRefaPM" id="CheckRefaPM" <?php if($CodigoRefaPM){ echo 'checked';  } ?> onchange="RefaPM(this)" disabled="disabled">
												<span>Refacción p.m.</span>
											</label>
										</div>
										</div>
										<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CheckCena" id="CheckCena" <?php if($CodigoCen){ echo 'checked';  } ?> onchange="Cena(this)" disabled="disabled">
												<span>Cena</span>
											</label>
										</div>
										</div>
										</div>
										</div>
										<div class="row">

										<!--Divs Por Hora de menu -->
										




							<!--Desayuno -->
							
							<div class="card panel"  id="DIVDESAYUNO" <?php if(!$CodigoDes){ echo 'style="display: none;"';  }?>>
								<div class="card-head style-success  collapsed" data-toggle="collapse" style="background:#E3C1F3; color: #000000; font-weight: bold;" data-parent="#accordion" data-target="#accordion-2" aria-expanded="false">
									<header>Desayuno</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion-2" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<div class="col-lg-12">
											<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="CodigoDes">Codigo del Desayuno</label>
											<input class="form-control" type="text" name="CodigoDes" id="CodigoDes" value="<?php echo $CodigoDes ?>" disabled="disabled"/>
											
										</div>
									</div>
							</div>
											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoD" id="AdultoD" <?php if($AdultoD==1){ echo 'checked';  } ?> onchange="AdultoDes(this)" disabled="disabled">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTOD" <?php if($AdultoD==0){ echo 'style="display: none;"';  }?> disabled="disabled">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoD">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoD" id="CantidadAdultoD" value="<?php echo $CantidadAdultoD?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
                                        <label for="MenuAdultoD">Menu Adulto</label>
											<textarea class="form-control" name="MenuAdultoD" id="MenuAdultoD" rows="2" cols="40" disabled="disabled"><?php echo $MenuAdultoD?></textarea>
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoD" id="NinoD" <?php if($NinoD==1){ echo 'checked';  } ?> onchange="NinoDes(this)" disabled="disabled">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINOD" <?php if($NinoD==0){ echo 'style="display: none;"';  }?>>
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoD">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoD" id="CantidadNinoD" value="<?php echo $CantidadNinoD?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
                                        <label for="MenuNinoD">Menu Niño</label>
											<textarea class="form-control" name="MenuNinoD" id="MenuNinoD" rows="2" cols="40" disabled="disabled"><?php echo $MenuNinoD?></textarea>
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraD">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraD" id="HoraD" value="<?php echo $HoraD?>" disabled="disabled"/>
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnD">Servir En:</label>
										<select name="ServirEnD" id="ServirEnD" class="form-control" disabled="disabled">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable" <?php if($ServirEnD=="Biodegradable"){echo "selected";}?>>Biodegradable</option>
                                                <option value="Cristaleria" <?php if($ServirEnD=="Cristaleria"){echo "selected";}?>>Cristaleria</option>
                                                <option value="Melamina" <?php if($ServirEnD=="Melamina"){echo "selected";}?>>Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloD">Estilo</label>
											<input class="form-control" type="text" name="EstiloD" id="EstiloD" value="<?php echo $EstiloD?>" disabled="disabled"/>
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesD">Adicionales</label>
										<textarea class="form-control" name="AdicionalesD" id="AdicionalesD" rows="2" cols="40" disabled="disabled"><?php echo $AdicionalesD?></textarea>
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->

							<!--Refaccion AM -->
							<div class="card panel"  id="DIVREFAAM"<?php if(!$CodigoRefaAM){ echo 'style="display: none;"';  }?> disabled="disabled">
								<div class="card-head style-success  collapsed" data-toggle="collapse" style="background:#D08FF0; color: #000000; font-weight: bold;" data-parent="#accordion" data-target="#accordion-1" aria-expanded="false">
									<header>Refacción a.m.</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion-1" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<div class="col-lg-12">

											<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="CodigoRefaAM">Codigo de la Refa a.m.</label>
											<input class="form-control" type="text" name="CodigoRefaAM" id="CodigoRefaAM" value="<?php echo $CodigoRefaAM ?>" disabled="disabled"/>
											
										</div>
									</div>
							</div>

											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoRAM" id="AdultoRAM" <?php if($AdultoRAM==1){ echo 'checked';  } ?> onchange="AdultoAM(this)" disabled="disabled">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTORAM" <?php if($AdultoRAM==0){ echo 'style="display: none;"';  }?> disabled="disabled">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoRAM">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoRAM" id="CantidadAdultoRAM"  value="<?php echo $CantidadAdultoRAM?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
                                        <label for="MenuAdultoRAM">Menu Adulto</label>
										<textarea class="form-control" name="MenuAdultoRAM" id="MenuAdultoRAM" rows="2" cols="40" disabled="disabled"><?php echo $MenuAdultoRAM?></textarea>
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoRAM" id="NinoRAM" <?php if($NinoRAM==1){ echo 'checked';  } ?> onchange="NinoAM(this)" disabled="disabled">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINORAM" <?php if($NinoRAM==0){ echo 'style="display: none;"';  }?> disabled="disabled">
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoRAM">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoRAM" id="CantidadNinoRAM" value="<?php echo $CantidadNinoRAM?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
										<textarea class="form-control" name="MenuNinoRAM" id="MenuNinoRAM" rows="2" cols="40" disabled="disabled"><?php echo $MenuNinoRAM?></textarea>
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraRAM">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraRAM" id="HoraRAM" value="<?php echo $HoraRAM?>" disabled="disabled"/>
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnAM">Servir En:</label>
										<select name="ServirEnAM" id="ServirEnAM" class="form-control" disabled="disabled">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable" <?php if($ServirEnAM=="Biodegradable"){echo "selected";}?>>Biodegradable</option>
                                                <option value="Cristaleria" <?php if($ServirEnAM=="Cristaleria"){echo "selected";}?>>Cristaleria</option>
                                                <option value="Melamina" <?php if($ServirEnAM=="Melamina"){echo "selected";}?>>Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloRAM">Estilo</label>
											<input class="form-control" type="text" name="EstiloRAM" id="EstiloRAM" value="<?php echo $EstiloRAM?>" disabled="disabled"/>
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesRAM">Adicionales</label>
										<textarea class="form-control" name="AdicionalesRAM" id="AdicionalesRAM" rows="2" cols="40" disabled="disabled"><?php echo $AdicionalesRAM?></textarea>
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->

							<!--Almuerzo -->
							
							<div class="card panel"  id="DIVALMUERZO" <?php if(!$CodigoAl){ echo 'style="display: none;"';  }?>>
								<div class="card-head style-success  collapsed" style="background:#C772F2; color: #000000; font-weight: bold;" data-toggle="collapse" data-parent="#accordion" data-target="#accordion-3" aria-expanded="false">
									<header>Almuerzo</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion-3" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<div class="col-lg-12">

											<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="CodigoAl">Codigo del Almuerzo</label>
											<input class="form-control" type="text" name="CodigoAl" id="CodigoAl" value="<?php echo $CodigoAl ?>" disabled="disabled"/>
											
										</div>
									</div>
							</div>
											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoA" id="AdultoA"<?php if($AdultoA==1){ echo 'checked';  } ?> onchange="AdultoAl(this)" disabled="disabled">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTOA" <?php if($AdultoA==0){ echo 'style="display: none;"';  }?> disabled="disabled">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoA">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoA" id="CantidadAdultoA" value="<?php echo $CantidadAdultoA?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
                                        <label for="MenuAdultoA">Menu Adulto</label>
										<textarea class="form-control" name="MenuAdultoA" id="MenuAdultoA" rows="2" cols="40" disabled="disabled"><?php echo $MenuAdultoA?></textarea>
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoA" id="NinoA" <?php if($NinoA==1){ echo 'checked';  } ?> onchange="NinoAl(this)" disabled="disabled">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINOA" <?php if($NinoA==0){ echo 'style="display: none;"';  }?> disabled="disabled">
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoA">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoA" id="CantidadNinoA" value="<?php echo $CantidadNinoA?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
                                        <label for="MenuNinoA">Menu Niño</label>
										<textarea class="form-control" name="MenuNinoA" id="MenuNinoA" rows="2" cols="40" disabled="disabled"><?php echo $MenuNinoA?></textarea>
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraA">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraA" id="HoraA" value="<?php echo $HoraA?>" disabled="disabled"/>
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnA">Servir En:</label>
										<select name="ServirEnA" id="ServirEnA" class="form-control" disabled="disabled">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable" <?php if($ServirEnA=="Biodegradable"){echo "selected";}?>>Biodegradable</option>
                                                <option value="Cristaleria" <?php if($ServirEnA=="Cristaleria"){echo "selected";}?>>Cristaleria</option>
                                                <option value="Melamina" <?php if($ServirEnA=="Melamina"){echo "selected";}?>>Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloA">Estilo</label>
											<input class="form-control" type="text" name="EstiloA" id="EstiloA" value="<?php echo $EstiloA?>" disabled="disabled"/>
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesA">Adicionales</label>
										<textarea class="form-control" name="AdicionalesA" id="AdicionalesA" rows="2" cols="40" disabled="disabled"><?php echo $AdicionalesA?></textarea>
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->


							<!--Refaccion PM -->
							
							<div class="card panel"  id="DIVREFAPM" <?php if(!$CodigoRefaPM){ echo 'style="display: none;"';  }?>>
								<div class="card-head style-success  collapsed" style="background:#BD51F3; color: #000000; font-weight: bold;" data-toggle="collapse" data-parent="#accordion" data-target="#accordion-4" aria-expanded="false">
									<header>Refacción p.m.</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion-4" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<div class="col-lg-12">

											<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="CodigoRefaPM">Codigo de la Refa p.m.</label>
											<input class="form-control" type="text" name="CodigoRefaPM" id="CodigoRefaPM" value="<?php echo $CodigoRefaPM ?>" disabled="disabled"/>
											
										</div>
									</div>
							</div>

											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoRPM" id="AdultoRPM" <?php if($AdultoRPM==1){ echo 'checked';  } ?> onchange="AdultoPM(this)" disabled="disabled">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTORPM" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoRPM">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoRPM" id="CantidadAdultoRPM" value="<?php echo $CantidadAdultoRPM?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
                                        <label for="MenuAdultoRAM">Menu Adulto</label>
										<textarea class="form-control" name="MenuAdultoRPM" id="MenuAdultoRPM" rows="2" cols="40" disabled="disabled"><?php echo $MenuAdultoRPM?></textarea>
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoRPM" id="NinoRPM" <?php if($NinoRPM==1){ echo 'checked';  } ?> onchange="NinoPM(this)" disabled="disabled">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINORPM" <?php if($NinoRPM==0){ echo 'style="display: none;"';  }?> disabled="disabled">
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoRPM">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoRPM" id="CantidadNinoRPM" value="<?php echo $CantidadNinoRPM?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
                                        <label for="MenuNinoRPM">Menu Niño</label>
										<textarea class="form-control" name="MenuNinoRPM" id="MenuNinoRPM" rows="2" cols="40" disabled="disabled"><?php echo $MenuNinoRPM?></textarea>
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraRPM">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraRPM" id="HoraRPM" value="<?php echo $HoraRPM?>" disabled="disabled"/>
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnPM">Servir En:</label>
										<select name="ServirEnAM" id="ServirEnAM" class="form-control" disabled="disabled">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable" <?php if($ServirEnPM=="Biodegradable"){echo "selected";}?>>Biodegradable</option>
                                                <option value="Cristaleria" <?php if($ServirEnPM=="Cristaleria"){echo "selected";}?>>Cristaleria</option>
                                                <option value="Melamina" <?php if($ServirEnPM=="Melamina"){echo "selected";}?>>Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloRPM">Estilo</label>
											<input class="form-control" type="text" name="EstiloRPM" id="EstiloRPM" value="<?php echo $EstiloRPM?>" disabled="disabled"/>
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesRPM">Adicionales</label>
										<textarea class="form-control" name="AdicionalesRPM" id="AdicionalesRPM" rows="2" cols="40" disabled="disabled"><?php echo $AdicionalesRPM?></textarea>
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->


							<!--Cena -->
							
							<div class="card panel"  id="DIVCENA" <?php if(!$CodigoCen){ echo 'style="display: none;"';  }?> >
								<div class="card-head style-success  collapsed" style="background:#AD20F4; color: #000000; font-weight: bold;" data-toggle="collapse" data-parent="#accordion" data-target="#accordion-5" aria-expanded="false">
									<header>Cena</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion-5" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<div class="col-lg-12">

											<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="CodigoCen">Codigo de la Cena</label>
											<input class="form-control" type="text" name="CodigoCen" id="CodigoCen" value="<?php echo $CodigoCen ?>" disabled="disabled" disabled="disabled"/>
											
										</div>
									</div>
							</div>

											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoC" id="AdultoC" <?php if($AdultoC==1){ echo 'checked';  } ?> onchange="AdultoCen(this)" disabled="disabled">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTOC" <?php if($AdultoC==0){ echo 'style="display: none;"';  }?> disabled="disabled">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoC">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoC" id="CantidadAdultoC" value="<?php echo $CantidadAdultoC?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
                                        <label for="MenuAdultoC">Menu Adulto</label>
										<textarea class="form-control" name="MenuAdultoC" id="MenuAdultoC" rows="2" cols="40" disabled="disabled"><?php echo $MenuAdultoC?></textarea>
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoC" id="NinoC" <?php if($NinoC==1){ echo 'checked';  } ?> onchange="NinoCen(this)" disabled="disabled">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINOC" <?php if($NinoC==0){ echo 'style="display: none;"';  }?> disabled="disabled">
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoC">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoC" id="CantidadNinoC" value="<?php echo $CantidadNinoC?>" disabled="disabled"/>
											</div>
											<div class="col-lg-8">
                                        <label for="MenuNinoC">Menu Niño</label>
										<textarea class="form-control" name="MenuNinoC" id="MenuNinoC" rows="2" cols="40" disabled="disabled"><?php echo $MenuNinoC?></textarea>
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraC">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraC" id="HoraC" value="<?php echo $HoraC?>" disabled="disabled"/>
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnC">Servir En:</label>
										<select name="ServirEnC" id="ServirEnC" class="form-control" disabled="disabled">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable" <?php if($ServirEnC=="Biodegradable"){echo "selected";}?>>Biodegradable</option>
                                                <option value="Cristaleria" <?php if($ServirEnC=="Cristaleria"){echo "selected";}?>>Cristaleria</option>
                                                <option value="Melamina" <?php if($ServirEnC=="Melamina"){echo "selected";}?>>Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloC">Estilo</label>
											<input class="form-control" type="text" name="EstiloC" id="EstiloC" value="<?php echo $EstiloC?>" disabled="disabled"/>
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesC">Adicionales</label>
										<textarea class="form-control" name="AdicionalesC" id="AdicionalesC" rows="2" cols="40" disabled="disabled"><?php echo $AdicionalesC?></textarea>
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->

						

							<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObservacionesAyB">Observaciones AyB</label>
										<textarea class="form-control" name="ObservacionesAyB" id="ObservacionesAyB" rows="2" cols="40" disabled="disabled"><?php echo $ObservacionesAyB?></textarea>
										</div>
									</div>
									</div>



											</div>
										</div>
									</div>
								</div>

								

								<?php if($EstadoEv == 1 | $ComentarioJefe == 1){

?>

		<div class="card-body">
	<div class="card-head style-primary">
		<h4 class="text-center"> Comentarios de Cierre </h4>
	</div>
	<?php 
	$ConsultComentario = "SELECT A.*
	FROM Eventos.EV_COMENTARIOS AS A
	WHERE EV_AREA='Jefe'
	AND A.EV_CODIGO = '$Codigo'
	ORDER BY A.EV_CODIGO";
	$ResultCome = mysqli_query($db, $ConsultComentario);
	while($rowCome = mysqli_fetch_array($ResultCome))
	{
		$Comentario=$rowCome["EV_COMETARIO"];
		$Fecha=$rowCome["EV_FECHA"];
		$Hora=$rowCome["EV_HORA"];
		
	}

	?>
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group floating-label">
				<label for="ComentarioJefe">¿Cómo atendio este evento <?php echo $NombreRet; ?> ? </label>
				<textarea class="form-control" name="ComentarioJefe" id="ComentarioJefe" rows="2" cols="40" readonly><?php echo $Comentario?></textarea>
				</div>
			</div>
			</div>

			<?php 
	$ConsultComentario = "SELECT A.*
	FROM Eventos.EV_COMENTARIOS AS A
	WHERE EV_AREA='Mercadeo'
	AND A.EV_CODIGO = '$Codigo'
	ORDER BY A.EV_CODIGO";
	$ResultCome = mysqli_query($db, $ConsultComentario);
	while($rowCome = mysqli_fetch_array($ResultCome))
	{
		$Comentario=$rowCome["EV_COMETARIO"];
		$Fecha=$rowCome["EV_FECHA"];
		$Hora=$rowCome["EV_HORA"];
		
	}

	?>
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group floating-label">
				<label for="ComentarioJefe">¿Cómo atendio este evento Mercadeo? </label>
				<textarea class="form-control" name="ComentarioJefe" id="ComentarioJefe" rows="2" cols="40" readonly><?php echo $Comentario?></textarea>
				</div>
			</div>
			</div>

			<?php 
	$ConsultComentario = "SELECT A.*
	FROM Eventos.EV_COMENTARIOS AS A
	WHERE EV_AREA='Operaciones'
	AND A.EV_CODIGO = '$Codigo'
	ORDER BY A.EV_CODIGO";
	$ResultCome = mysqli_query($db, $ConsultComentario);
	while($rowCome = mysqli_fetch_array($ResultCome))
	{
		$Comentario=$rowCome["EV_COMETARIO"];
		$Fecha=$rowCome["EV_FECHA"];
		$Hora=$rowCome["EV_HORA"];
		
	}

	?>
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group floating-label">
				<label for="ComentarioJefe">¿Cómo atendio este evento Operaciones? </label>
				<textarea class="form-control" name="ComentarioJefe" id="ComentarioJefe" rows="2" cols="40" readonly><?php echo $Comentario?></textarea>
				</div>
			</div>
			</div>
			

			<?php 
	$ConsultComentario = "SELECT A.*
	FROM Eventos.EV_COMENTARIOS AS A
	WHERE EV_AREA='AyB'
	AND A.EV_CODIGO = '$Codigo'
	ORDER BY A.EV_CODIGO";
	$ResultCome = mysqli_query($db, $ConsultComentario);
	while($rowCome = mysqli_fetch_array($ResultCome))
	{
		$Comentario=$rowCome["EV_COMETARIO"];
		$Fecha=$rowCome["EV_FECHA"];
		$Hora=$rowCome["EV_HORA"];
		
	}

	?>
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group floating-label">
				<label for="ComentarioJefe">¿Cómo atendio este evento Alimentos y Bebidas? </label>
				<textarea class="form-control" name="ComentarioJefe" id="ComentarioJefe" rows="2" cols="40" readonly><?php echo $Comentario?></textarea>
				</div>
			</div>
			</div>

			</div>

			<?php } 
			
			############## FACTURA ########?>
			<?php if($Factura != NULL){

				
			$QueryDatosFactura = mysqli_query($db, "SELECT * 
			FROM Bodega.FACTURA_EV AS A
			INNER JOIN Bodega.CLIENTE AS B ON A.CLI_NIT = B.CLI_NIT
			WHERE A.F_CODIGO = '".$Factura."'");

			


			$FilaDatosFactura = mysqli_fetch_array($QueryDatosFactura);

			$DirImprimir = "../Facturacion/FactImpNew.php?Codigo=".$Factura;

			if(!$FilaDatosFactura){

				$QueryDatosFactura = mysqli_query($db, "SELECT * 
			FROM Bodega.FACTURA_KS AS A
			INNER JOIN Bodega.CLIENTE AS B ON A.CLI_NIT = B.CLI_NIT
			WHERE A.F_CODIGO = '".$Factura."'");
			$FilaDatosFactura = mysqli_fetch_array($QueryDatosFactura);

			$DirImprimir = "../../Kiosko/Facturacion/FactImpNew.php?Codigo=".$Factura;

			}

			if(!$FilaDatosFactura){

				$QueryDatosFactura = mysqli_query($db, "SELECT * 
			FROM Bodega.FACTURA AS A
			INNER JOIN Bodega.CLIENTE AS B ON A.CLI_NIT = B.CLI_NIT
			WHERE A.F_CODIGO = '".$Factura."'");
			$FilaDatosFactura = mysqli_fetch_array($QueryDatosFactura);
			$DirImprimir = "../../Restaurant/Facturacion/FactImpNew.php?Codigo=".$Factura;

			}


			$ImporteBruto = ($FilaDatosFactura['F_TOTAL']) - (($FilaDatosFactura['F_TOTAL'] * 0.12) / 1.12);
			$Impuesto = ($FilaDatosFactura['F_TOTAL'] * 0.12) / 1.12; 
			$FechaCertificacion = $FilaDatosFactura["F_FECHA_CERTIFICACION"]; 
			$FechaCertiExplode = explode("T", $FechaCertificacion); 
			$FechaDepuradaCertificacion = $FechaCertiExplode[0]; 
			$NumeroAutorizacion = $FilaDatosFactura["F_DTE"];
			$Nit = $FilaDatosFactura['CLI_NIT'];
			$Nombre = $FilaDatosFactura['CLI_NOMBRE'];
			$Total = $FilaDatosFactura['F_TOTAL'];
			$Codigo  = $FilaDatosFactura['F_CODIGO'];
			$Direccion1 = $FilaDatosFactura['CLI_DIRECCION'];

				?>

						<div class="card-body">
					<div class="card-head style-primary">
						<h4 class="text-center"> Datos de Facturación </h4>
					</div>
					
					<div class="row">
					
					<div class="col-lg-3">
						<label for="FechaCertificacion">Fecha Certificacion</label>
						<input type="text" name="FechaCertificacion" id="FechaCertificacion" class="form-control" required value="<?php echo date('Y-m-d', strtotime($FechaDepuradaCertificacion)) ?>" readonly>
						<input type="hidden" name="FechaCertificacionCompleta" id="FechaCertificacionCompleta" class="form-control" required value="<?php echo $FechaCertificacion ?>" readonly>
					</div>
					<div class="col-lg-6">
						<label for="NumeroAutorizacion">Autorizacion</label>
						<input type="text" name="NumeroAutorizacion" id="NumeroAutorizacion" class="form-control" required value="<?php echo $NumeroAutorizacion ?>" readonly>
					</div>
					<div class="col-lg-3">
					<a href="<?php echo $DirImprimir ?>" Target="_blank"><button type="button" class="btn btn-info">
									<span class="glyphicon glyphicon-print"></span> IMPRIMIR
								  </button></a>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3">
						<label for="NIT">NIT</label>
						<input type="text" name="NIT" id="NIT" class="form-control" required value="<?php echo $Nit; ?>" readonly>
					</div>
					<div class="col-lg-6">
						<label for="Nombre">Nombre</label>
						<input type="text" name="Nombre" id="Nombre" class="form-control" required value="<?php echo $Nombre; ?>" readonly>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<label for="Direccion">Dirección</label>
						<input type="text" name="Direccion" id="Direccion" class="form-control" required value="<?php echo $Direccion1 ?>" readonly>
					</div>
				</div>
				<table class="table table-hover" id="TblTicketsHotel">
				<thead>
			
				</thead>
				<tbody> 
				<tr>
				<td align="center" colspan="7" ><b>DESCARGA DEL INVENTARIO</b></td>
			</tr>

				<tr>
			<td><b>#</b></td>
			<td><b>Codigo</b></td>
			<td><b>Fecha</b></td>
			<td><b>Hora</b></td>
			<td><b>Nombre</b></td>
			<td><b>Cantidad</b></td>
			<td><b>Punto de Venta</b></td>
		</tr>
		<?php

		$Correlativo=1;

		$NomTitulo = mysqli_query($db, "SELECT KARDEX.*, PRODUCTO.P_NOMBRE, PUNTO_VENTA.PV_NOMBRE
		FROM Productos.KARDEX, Productos.PRODUCTO, CompraVenta.PUNTO_VENTA
		WHERE KARDEX.P_CODIGO = PRODUCTO.P_CODIGO
		AND PUNTO_VENTA.PV_CODIGO = KARDEX.K_PUNTO_VENTA
		AND KARDEX.TRA_CODIGO ='$Factura'
		");
		while($row1 = mysqli_fetch_array($NomTitulo))
				{
					$Cod=$row1["K_CODIGO"];
					$CodTra=$row1["TRA_CODIGO"];
					$Fecha=$row1["K_FECHA"];
					$Hora=$row1["K_HORA"];
					$Descripcion=$row1["K_DESCRPCION"];
					$ExiGAnt=$row1["K_EXISTENCIA_ANTERIOR"];
					$ExiGAct=$row1["K_EXISTENCIA_ACTUAL"];
					$ExiPAnt=$row1["K_EXISTENCIA_ANTERIOR_PUNTO"];
					$ExiPAct=$row1["K_EXISTENCIA_ACTUAL_PUNTO"];
					$CostoAn=$row1["K_COSTO_ANTERIOR"];
					$CostoEn=$row1["K_COSTO_ENTRO"];
					$CostoPo=$row1["K_COSTO_PONDERADO"];
					$Punto=$row1["PV_NOMBRE"];
					$Prod=$row1["P_NOMBRE"];
					
					if($row1["K_EXISTENCIA_ANTERIOR_PUNTO"]>$row1["K_EXISTENCIA_ACTUAL_PUNTO"]){

						$Cantidad=$row1["K_EXISTENCIA_ANTERIOR_PUNTO"]-$row1["K_EXISTENCIA_ACTUAL_PUNTO"];
					}else{
						$Cantidad=$row1["K_EXISTENCIA_ACTUAL_PUNTO"]-$row1["K_EXISTENCIA_ANTERIOR_PUNTO"];
					}
		?>
						<tr>
						<td><?php echo $Correlativo ?></td>
						<td><?php echo $Cod ?></td>
						<td><?php echo date($Fecha) ?></td>
						<td><?php echo date($Hora)?></td>
						<td><?php echo $Prod ?></td>
						<td><?php echo number_format($Cantidad, 2, ".", "") ?></td>
						<td><?php echo $Punto ?></td>
					</tr>
		<?php
				$Correlativo+=1;

}

?>
</tbody>
</table>
						

						
							


							</div>

							<?php } ?>
							
							</div><!--end .panel -->
                                </div>
				
					<br>
					<br>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->

		<?php include("../MenuUsersG.html"); ?>

		


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

	