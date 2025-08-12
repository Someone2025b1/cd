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

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Ingresar Nuevo Evento</strong><br></h1>
				<br>
				<form class="form" action="AgregarEventoPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
                        <div class="card-body">
                            <div class="card-head style-primary">
								<h4 class="text-center"> Datos Generales del Evento </h4>
                            </div>
							<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NombreDueno">Nombre del Dueño del Evento</label>
											<input class="form-control" type="text" name="NombreDueno" id="NombreDueno" required/>
											
										</div>
									</div>

									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NombreEvento">Nombre del Evento</label>
											<input class="form-control" type="text" name="NombreEvento" id="NombreEvento" required/>
											
										</div>
									</div>
								
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Celular">Número de Celular</label>
											<input class="form-control" type="text" name="Celular" id="Celular" required/>
											
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Fecha">Fecha del Evento</label>
											<input class="form-control" type="date" name="Fecha" id="Fecha" required/>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraIni">Hora de Inicio</label>
											<input class="form-control" type="time" name="HoraIni" id="HoraIni" required/>
											
										</div>
									</div>
                                    <div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraFin">Hora de Fiunalización</label>
											<input class="form-control" type="time" name="HoraFin" id="HoraFin" required/>
											
										</div>
									</div>
								</div>
								
								
								
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Personas">Cantidad de Personas</label>
											<input class="form-control" type="num" name="Personas" id="Personas"  required/>
										</div>
									</div>
								
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Lugar">Lugar</label>
										<select name="Lugar" id="Lugar" class="form-control" onchange="Otro(this.value)">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Rancho Raices">Rancho Raices</option>
                                                <option value="Rancho Jardín">Rancho Jardín</option>
                                                <option value="Rancho Terrazas">Rancho Terrazas</option>
                                                <option value="Rancho Chatun">Rancho Chatun</option>
                                                <option value="Área de Teatro">Área de Teatro</option>
                                                <option value="Aula Inovarte">Aula Inovarte</option>
                                                <option value="Salón Pilares">Salón Pilares</option>
                                                <option value="1">Otro</option>
											</select>
										</div>
									</div>
									
                                    <div class="col-lg-3">
                                    <div class="form-group floating-label" id="DIVOTRO" style="display: none;">
                                        <label for="Paga">Otro</label>
											<input class="form-control" type="text" name="OtroLugar" id="OtroLugar" />
											
										</div>
                                    </div>
									<div class="col-lg-2">
									<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Informativo" id="Informativo">
												<span>INFORMATIVO</span>
											</label>
										</div>
										</div>
								</div>
								
                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObservacionesGen">Observaciones Generales</label>
										<textarea class="form-control" name="ObservacionesGen" id="ObservacionesGen" rows="2" cols="40"></textarea>
											
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
												<input type="checkbox" name="Bocina" id="Bocina">
												<span>Bocina</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Microfonos" id="Microfonos">
												<span>Microfonos</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Musica" id="Musica">
												<span>Música</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MusicaInstrumental" id="MusicaInstrumental">
												<span>Música Instrumental</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Proyector" id="Proyector">
												<span>Proyector</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Extenciones" id="Extenciones">
												<span>Extenciones</span>
											</label>
										</div>
									</div>
                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObservacionesMerca">Observaciones Mercadeo</label>
										<textarea class="form-control" name="ObservacionesMerca" id="ObservacionesMerca" rows="2" cols="40"></textarea>
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
								<div class="card-head style-warning ?> collapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-2" aria-expanded="false">
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
										<select name="Montaje" id="Montaje" class="form-control" onchange="Otromontaje(this.value)">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Banquete">Banquete</option>
                                                <option value="Imperial">Imperial</option>
                                                <option value="Escuela">Escuela</option>
                                                <option value="Auditorio">Auditorio</option>
                                                <option value="1">Otro</option>
											</select>
										</div>
									</div>
									
                                    <div class="col-lg-3">
                                    <div class="form-group floating-label" id="DIVOTROMONTAJE" style="display: none;">
                                        <label for="OtroMontaje">Otro</label>
											<input class="form-control" type="text" name="OtroMontaje" id="OtroMontaje" />
											
										</div>
										</div>
                                    </div>
									<div class="row">
									<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Pizarra" id="Pizarra">
												<span>Pizarra</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Pantalla" id="Pantalla">
												<span>Pnatalla</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MesaSonido" id="MesaSonido">
												<span>Mesa Sonido</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="ManteleriaCompleta" id="ManteleriaCompleta">
												<span>Manteleria Completa</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Tarima" id="Tarima">
												<span>Tarima</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MesaProyector" id="MesaProyector">
												<span>Mesa Proyector</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MesaAYB" id="MesaAYB">
												<span>Mesa Para AyB</span>
											</label>
										</div>
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="SobreMantel" id="SobreMantel" onchange="Color(this)">
												<span>Sobre Mantel</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVCOLOR" style="display: none;">
                                        <label for="ColorSobremantel">Color Sobremantel</label>
											<input class="form-control" type="text" name="ColorSobremantel" id="ColorSobremantel" />
											
										
									</div>

									<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="MesasExtra" id="MesasExtra" onchange="Mesas(this)">
												<span>Mesas Extra</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVMESAS" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadMesasExtra">Cantidad</label>
											<input class="form-control" type="number" name="CantidadMesasExtra" id="CantidadMesasExtra" />
											</div>
											<div class="col-lg-4">
                                        <label for="DescripcionMesas">Descripción</label>
											<input class="form-control" type="text" name="DescripcionMesas" id="DescripcionMesas" />
											
											</div>
										</div>
									
									<div class="row">
									<div class="col-lg-12">
									<div class="form-group floating-label">
                                        <label for="MesasSillas">Descripción de Mesas y Sillas:</label>
										<textarea class="form-control" name="MesasSillas" id="MesasSillas" rows="2" cols="40"></textarea>
									</div>
										
									</div>
										</div>

										
									</div>
                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObsertvacionesOperaciones">Observaciones Operaciones</label>
										<textarea class="form-control" name="ObsertvacionesOperaciones" id="ObsertvacionesOperaciones" rows="2" cols="40"></textarea>
										</div>
										</div>
									</div>
									
										
										
									</div>
									</div>
								
							</div><!--end .panel -->



							

                            <div class="card panel"><!-- Requerimientos AyB -->
								<div class="card-head style-info  collapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-3" aria-expanded="false">
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
												<input type="checkbox" name="CheckDesayuno" id="CheckDesayuno" onchange="Desayuno(this)">
												<span>Desayuno</span>
											</label>
										</div>
										</div>
										<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CheckRefaAM" id="CheckRefaAM" onchange="RefaAM(this)">
												<span>Refacción a.m.</span>
											</label>
										</div>
										</div>
										<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CheckAlmuerzo" id="CheckAlmuerzo" onchange="Almuerz(this)">
												<span>Almuerzo</span>
											</label>
										</div>
										</div>
										<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CheckRefaPM" id="CheckRefaPM" onchange="RefaPM(this)">
												<span>Refacción p.m.</span>
											</label>
										</div>
										</div>
										<div class="col-lg-2">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="CheckCena" id="CheckCena" onchange="Cena(this)">
												<span>Cena</span>
											</label>
										</div>
										</div>
										</div>
										</div>
										<div class="row">

										<!--Divs Por Hora de menu -->
										




							<!--Desayuno -->
							
							<div class="card panel"  id="DIVDESAYUNO" style="display: none;">
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

											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoD" id="AdultoD" onchange="AdultoDes(this)">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTOD" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoD">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoD" id="CantidadAdultoD" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuAdultoD">Menu Adulto</label>
											<input class="form-control" type="text" name="MenuAdultoD" id="MenuAdultoD" />
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoD" id="NinoD" onchange="NinoDes(this)">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINOD" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoD">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoD" id="CantidadNinoD" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuNinoD">Menu Niño</label>
											<input class="form-control" type="text" name="MenuNinoD" id="MenuNinoD" />
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraD">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraD" id="HoraD" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnD">Servir En:</label>
										<select name="ServirEnD" id="ServirEnD" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable">Biodegradable</option>
                                                <option value="Cristaleria">Cristaleria</option>
                                                <option value="Melamina">Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloD">Estilo</label>
											<input class="form-control" type="text" name="EstiloD" id="EstiloD" />
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesD">Adicionales</label>
										<textarea class="form-control" name="AdicionalesD" id="AdicionalesD" rows="2" cols="40"></textarea>
											
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->

							<!--Refaccion AM -->
							<div class="card panel"  id="DIVREFAAM" style="display: none;">
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

											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoRAM" id="AdultoRAM" onchange="AdultoAM(this)">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTORAM" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoRAM">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoRAM" id="CantidadAdultoRAM" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuAdultoRAM">Menu Adulto</label>
											<input class="form-control" type="text" name="MenuAdultoRAM" id="MenuAdultoRAM" />
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoRAM" id="NinoRAM" onchange="NinoAM(this)">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINORAM" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoRAM">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoRAM" id="CantidadNinoRAM" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuNinoRAM">Menu Niño</label>
											<input class="form-control" type="text" name="MenuNinoRAM" id="MenuNinoRAM" />
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraRAM">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraRAM" id="HoraRAM" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnAM">Servir En:</label>
										<select name="ServirEnAM" id="ServirEnAM" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable">Biodegradable</option>
                                                <option value="Cristaleria">Cristaleria</option>
                                                <option value="Melamina">Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloRAM">Estilo</label>
											<input class="form-control" type="text" name="EstiloRAM" id="EstiloRAM" />
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesRAM">Adicionales</label>
										<textarea class="form-control" name="AdicionalesRAM" id="AdicionalesRAM" rows="2" cols="40"></textarea>
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->

							<!--Almuerzo -->
							
							<div class="card panel"  id="DIVALMUERZO" style="display: none;">
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

											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoA" id="AdultoA" onchange="AdultoAl(this)">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTOA" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoA">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoA" id="CantidadAdultoA" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuAdultoA">Menu Adulto</label>
											<input class="form-control" type="text" name="MenuAdultoA" id="MenuAdultoA" />
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoA" id="NinoA" onchange="NinoAl(this)">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINOA" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoA">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoA" id="CantidadNinoA" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuNinoA">Menu Niño</label>
											<input class="form-control" type="text" name="MenuNinoA" id="MenuNinoA" />
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraA">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraA" id="HoraA" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnA">Servir En:</label>
										<select name="ServirEnA" id="ServirEnA" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable">Biodegradable</option>
                                                <option value="Cristaleria">Cristaleria</option>
                                                <option value="Melamina">Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloA">Estilo</label>
											<input class="form-control" type="text" name="EstiloA" id="EstiloA" />
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesA">Adicionales</label>
										<textarea class="form-control" name="AdicionalesA" id="AdicionalesA" rows="2" cols="40"></textarea>
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->


							<!--Refaccion PM -->
							
							<div class="card panel"  id="DIVREFAPM" style="display: none;">
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

											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoRPM" id="AdultoRPM" onchange="AdultoPM(this)">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTORPM" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoRPM">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoRPM" id="CantidadAdultoRPM" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuAdultoRAM">Menu Adulto</label>
											<input class="form-control" type="text" name="MenuAdultoRPM" id="MenuAdultoRPM" />
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoRPM" id="NinoRPM" onchange="NinoPM(this)">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINORPM" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoRPM">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoRPM" id="CantidadNinoRPM" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuNinoRPM">Menu Niño</label>
											<input class="form-control" type="text" name="MenuNinoRPM" id="MenuNinoRPM" />
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraRPM">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraRPM" id="HoraRPM" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnPM">Servir En:</label>
										<select name="ServirEnPM" id="ServirEnPM" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable">Biodegradable</option>
                                                <option value="Cristaleria">Cristaleria</option>
                                                <option value="Melamina">Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloRPM">Estilo</label>
											<input class="form-control" type="text" name="EstiloRPM" id="EstiloRPM" />
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesRPM">Adicionales</label>
										<textarea class="form-control" name="AdicionalesRPM" id="AdicionalesRPM" rows="2" cols="40"></textarea>
											
											</div>
								
									</div>
											</div>
										</div>
									</div>
								
							</div><!--end .panel -->


							<!--Cena -->
							
							<div class="card panel"  id="DIVCENA" style="display: none;">
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

											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="AdultoC" id="AdultoC" onchange="AdultoCen(this)">
												<span>Adulto</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVADULTOC" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadAdultoC">Cantidad Adultos</label>
											<input class="form-control" type="number" name="CantidadAdultoC" id="CantidadAdultoC" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuAdultoC">Menu Adulto</label>
											<input class="form-control" type="text" name="MenuAdultoC" id="MenuAdultoC" />
											
											</div>
										</div>
										</div>
										<div class="col-lg-12">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="NinoC" id="NinoC" onchange="NinoCen(this)">
												<span>Niño</span>
											</label>
										</div>
										<div class="form-group floating-label" id="DIVNINOC" style="display: none;">
										
										<div class="col-lg-4">
                                        <label for="CantidadNinoC">Cantidad Niños</label>
											<input class="form-control" type="number" name="CantidadNinoC" id="CantidadNinoC" />
											</div>
											<div class="col-lg-4">
                                        <label for="MenuNinoC">Menu Niño</label>
											<input class="form-control" type="text" name="MenuNinoC" id="MenuNinoC" />
											
											</div>
											</div>
										</div>

										<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraC">Hora de Servir</label>
											<input class="form-control" type="time" name="HoraC" id="HoraC" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="ServirEnC">Servir En:</label>
										<select name="ServirEnC" id="ServirEnC" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Biodegradable">Biodegradable</option>
                                                <option value="Cristaleria">Cristaleria</option>
                                                <option value="Melamina">Melamina</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4">
                                        <label for="EstiloC">Estilo</label>
											<input class="form-control" type="text" name="EstiloC" id="EstiloC" />
											
											</div>

											<div class="col-lg-12">
                                        <label for="AdicionalesC">Adicionales</label>
										<textarea class="form-control" name="AdicionalesC" id="AdicionalesC" rows="2" cols="40"></textarea>
											
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
										<textarea class="form-control" name="ObservacionesAyB" id="ObservacionesAyB" rows="2" cols="40"></textarea>
										</div>
									</div>
									</div>



											</div>
										</div>
									</div>
								</div>
							</div><!--end .panel -->
                                </div>
				
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
					</div>
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
