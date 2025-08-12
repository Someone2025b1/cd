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
		function MostrarMunicipios(Valor)
	{
		$.ajax({
			url: 'BuscarMunicipios.php',
			type: 'POST',
			data: 'id='+Valor,
			success: function(opciones)
			{
				$('#MunicipioResidencia').html(opciones)
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
	}

	function TieneRTU(x)
        {
        	if(x.checked)
        	{
        		$('#DIVRTU').show();
        	}
        	else
        	{
        		$('#DIVRTU').hide();
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
				<h1 class="text-center"><strong>Ingresar Cliente Credito</strong><br></h1>
				<br>
				<form class="form" action="IngresarClienteCreditoPro.php" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales Solicitante</strong></h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Nombre">Nombre Completo</label>
											<input class="form-control" type="text" name="Nombre" id="Nombre" required/>
											
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="DPI">DPI</label>
											<input class="form-control" type="text" name="DPI" id="DPI" required/>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="CalidadActua">Calidad En Que Actua</label>
										<select name="CalidadActua" id="CalidadActua" class="form-control" required>
												<option value="P">PROPIETARIO</option>
                                                <option value="RP">REPRESENTANTE LEGAL</option>
											</select>	
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="FechaNacimiento">Fecha de Nacimiento</label>
											<input class="form-control" type="date" name="FechaNacimiento" id="FechaNacimiento" required/>
											
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="PrecioVenta">Cel.</label>
											<input class="form-control" type="text" min="0" step="0.5" name="Cel" id="Cel" required/>
											
										</div>
								</div>   
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="PrecioVenta">Cel. #2</label>
											<input class="form-control" type="text" min="0" step="0.5" name="Cel2" id="Cel2"/>
											
										</div>
									</div>
								</div>
								<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Correo">Correo Electronico</label>
											<input class="form-control" type="email" name="Correo" id="Correo" required/>
											
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Direccion" id="Direccion"></textarea>
											<label for="Direccion">Dirección</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="DepartamentoResidencia" id="DepartamentoResidencia" class="form-control" onchange="MostrarMunicipios(this.value)">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT id_departamento, nombre_departamento FROM  info_base.departamentos_guatemala ORDER BY nombre_departamento";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$row["id_departamento"].'">'.$row["nombre_departamento"].'</option>';
                                                    }

                                                ?>
											</select>
											<label for="DepartamentoResidencia">Departamento de Residencia</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											<select name="MunicipioResidencia" id="MunicipioResidencia" class="form-control" id="MunicipioResidencia">												
											</select>
											<label for="MunicipioResidencia">Municipio de Residencia</label>
										</div>
									</div>
								</div>

                            <div class="card-head style-primary">
								<h4 class="text-center"> Datos de la Empresa </h4>
                            </div>
							<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Razon">Razón Social</label>
											<input class="form-control" type="text" name="Razon" id="Razon" required/>
											
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Actividad">Actividad Comercial</label>
											<input class="form-control" type="text" name="Actividad" id="Actividad" required/>
											
										</div>
									</div>
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="NombreCo">Nombre Comercial</label>
											<input class="form-control" type="text" name="NombreCo" id="NombreCo" required/>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="NIT">NIT</label>
											<input class="form-control" type="text" name="NIT" id="NIT" required/>
											
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="TelEmpresa">Tel. Empresa</label>
											<input class="form-control" type="text" name="TelEmpresa" id="TelEmpresa" required/>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Comprador">Nombre Completo Comprador</label>
											<input class="form-control" type="text" name="Comprador" id="Comprador" required/>
											
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="CelComprador">Cel. Comprador</label>
											<input class="form-control" type="text" name="CelComprador" id="CelComprador" required/>
											
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Paga">Nombre Completo Paga</label>
											<input class="form-control" type="text" name="Paga" id="Paga" required/>
											
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="CelPaga">Cel. Paga</label>
											<input class="form-control" type="text" name="CelPaga" id="CelPaga" required/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Monto">Monto Maximo del Credito</label>
											<input class="form-control" type="num" step="any" name="Monto" id="Monto" value="0.00" required/>
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="DiasCredito">Cantidad de Días</label>
										<select name="DiasCredito" id="DiasCredito" class="form-control" required>
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="8">8 Días</option>
                                                <option value="15">15 Días</option>
                                                <option value="21">21 Días</option>
                                                <option value="30">30 Días</option>
											</select>
										</div>
									</div>
								</div>
								<div class="card-head style-primary">
								<h4 class="text-center"> Documentos Entrego </h4>
                            </div>
                            <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="SolicitudCredito" id="SolicitudCredito">
												<span>Soliicitud de Credito</span>
											</label>
										</div>
									</div> 
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="FotocopiaDPI" id="FotocopiaDPI">
												<span>Fotocopia DPI</span>
											</label>
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="RepLegal" id="RepLegal">
												<span>Representación Legal</span>
											</label>
										</div>
									</div>
                                    
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Patente" id="Patenete">
												<span>Patente de Comercio</span>
											</label>
										</div>
									</div> 
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="RTU" id="RTU" onchange="TieneRTU(this)">
												<span>RTU Reciente</span>
											</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVRTU" style="display: none;">
                                        <label for="FechaRTU">Fecha de RTU</label>
											<input class="form-control" type="date" name="FechaRTU" id="FechaRTU" />
											
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="ReciboLuz" id="ReciboLuz">
												<span>Recibo Luz</span>
											</label>
										</div>
									</div>
						</div>
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
