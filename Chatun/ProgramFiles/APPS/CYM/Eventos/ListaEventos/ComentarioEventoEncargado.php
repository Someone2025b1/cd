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
					$Dueno=$row["EV_DUENO"];
					$NombreEvento=$row["EV_NOMBRE"];
					$Cel=$row["EV_CEL"];
					$Encargado=$row["EV_ENCARGADO"];
					$FechaEvento=$row["EV_FECHA_EV"];
					$FechaNacimineto=$row["CLIC_FECHA_NACIMIENTO"];
					$HoraIni=$row["EV_HORA_INI"];
					$HoraFin=$row["EV_HORA_FIN"];
					$Lugar=$row["EV_LUGAR"];
					$CantidadPersona=$row["EV_CANTIDAD_PERSONAS"];
					$ObservacionesGen=$row["EV_OBSERVACIONES"];
					
				}
				
				$Otro=1;
				$OtroEstilo= 1;
				?>

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Ingresar Nuevo Evento</strong><br></h1>
				<br>
				<form class="form" action="ComentarioEventoEncargadoPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
                        <div class="card-body">
                            <div class="card-head style-primary">
								<h4 class="text-center"> Datos Generales del Evento </h4>
                            </div>
							<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="CodigoEvento">Codigo del Evento</label>
											<input class="form-control" type="text" name="CodigoEvento" id="CodigoEvento" value="<?php echo $Codigo ?>" readonly/>
											
										</div>
									</div>
							</div>
							<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NombreDueno">Nombre del Dueño del Evento</label>
											<input class="form-control" type="text" name="NombreDueno" id="NombreDueno" value="<?php echo $Dueno ?>" disabled="disabled" required/>
											
										</div>
									</div>

									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NombreEvento">Nombre del Evento</label>
											<input class="form-control" type="text" name="NombreEvento" id="NombreEvento" value="<?php echo $NombreEvento ?>" disabled="disabled" required/>
											
										</div>
									</div>
								
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Celular">Número de Celular</label>
											<input class="form-control" type="text" name="Celular" id="Celular" value="<?php echo $Cel ?>" disabled="disabled" required/>
											
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Fecha">Fecha del Evento</label>
											<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo $FechaEvento ?>" disabled="disabled" required/>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraIni">Hora de Inicio</label>
											<input class="form-control" type="time" name="HoraIni" id="HoraIni" value="<?php echo $HoraIni ?>" disabled="disabled" required/>
											
										</div>
									</div>
                                    <div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="HoraFin">Hora de Fiunalización</label>
											<input class="form-control" type="time" name="HoraFin" id="HoraFin" value="<?php echo $HoraFin ?>" disabled="disabled" required/>
											
										</div>
									</div>
								</div>
								
								
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Personas">Cantidad de Personas</label>
											<input class="form-control" type="num" name="Personas" id="Personas" value="<?php echo $CantidadPersona ?>" disabled="disabled" required/>
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
                                    <div class="form-group floating-label" id="DIVOTRO" <?php if($Otro==0){ echo 'style="display: none;"';  }?>>
                                        <label for="Paga">Otro</label>
											<input class="form-control" type="text" name="OtroLugar" id="OtroLugar" value="<?php if($Otro==1){ echo $Lugar;}?>" disabled="disabled" />
											
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
									<header>Comentarios Mercadeo</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-1" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
										<div class="row">		
											<div class="col-lg-12">
											<div class="row">
											
                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ComentarioMerca">Comentario de Atención a este evento</label>
										<textarea class="form-control" name="ComentarioMerca" id="ComentarioMerca" rows="2" cols="40"><?php echo $ObservacionesMercadeo?></textarea>
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
									<header>Comentarios Operaciones</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-2" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">
												
										
                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ComentarioOpreciones">Comentario de Atención a este evento</label>
										<textarea class="form-control" name="ComentarioOpreciones" id="ComentarioOpreciones" rows="2" cols="40"><?php echo $ObservacionesOperaciones?></textarea>
											
										</div>
										</div>
									</div>
									
										
										
									</div>
									</div>
								
							</div><!--end .panel -->



							

                            <div class="card panel"><!-- Requerimientos AyB -->
								<div class="card-head style-info  collapsed" data-toggle="collapse" data-parent="#accordion6 " data-target="#accordion6-3" aria-expanded="false">
									<header>Comentarios AyB</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion6-3" class="collapse" aria-expanded="false" style="height: 0px;">
									<div class="card-body">

						

							<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ComentarioAyB">Comentario de Atención a este evento</label>
										<textarea class="form-control" name="ComentarioAyB" id="ComentarioAyB" rows="2" cols="40"><?php echo $ObservacionesAyB?></textarea>
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
