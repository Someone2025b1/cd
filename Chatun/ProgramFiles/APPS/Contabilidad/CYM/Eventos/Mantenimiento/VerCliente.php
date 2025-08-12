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
		var municipio = $("#Municipio").val();
		$.ajax({
			url: 'BuscarMunicipios.php',
			type: 'POST',
			data:'id='+Valor, 'municipio='
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
				<?php
				$Codigo=$_GET["Codigo"];
				$Consulta = "SELECT A.*
				FROM Contabilidad.CLIENTE_CREDITO AS A
				WHERE A.CLIC_NUM = $Codigo
				ORDER BY A.CLIC_NOMBRE_COMPLETO";
				$Resultado = mysqli_query($db, $Consulta);
				while($row = mysqli_fetch_array($Resultado))
				{
					$NIT=$row["CLIC_NIT"];
					$FechaAgrego=$row["FECHA_AGREGO"];
					$Nombre=$row["CLIC_NOMBRE_COMPLETO"];
					$Calidad=$row["CLIC_CALIDAD_ACTUA"];
					$DPI=$row["CLIC_DPI"];
					$FechaNacimineto=$row["CLIC_FECHA_NACIMIENTO"];
					$Telefono=$row["CLIC_TELFONO_EMPRESA"];
					$Cel1=$row["CLIC_CEL"];
					$Cel2=$row["CLIC_CEL2"];
					$Email=$row["CLIC_EMAIL"];
					$Direccion=$row["CLIC_DIRECCION"];
					$Municipio=$row["CLIC_MUCIPIO"];
					$Departamento=$row["CLIC_DEPARTAMAENTO"];
					$Razon=$row["CLIC_RAZON_SOCIAL"];
					$NombreComercial=$row["CLIC_NOMBRE_COMERCIAL"];
					$Actividad=$row["CLIC_ACTIVIDAD_COMERCIAL"];
					$Compra=$row["CLIC_NOMBRE_COMPRA"];
					$CompraCel=$row["CLIC_CEL_COMPRA"];
					$Paga=$row["CLIC_NOMBRE_COBRO"];
					$CelPaga=$row["CLIC_CEL_COBRO"];
					$Monto=$row["CLIC_MONTO_CREDITO"];
					$Dias=$row["CLIC_DIAS"];
					$Solitud=$row["CLIC_SOLICITUD"];
					$FDPI=$row["CLIC_FDPI"];
					$RepLegal=$row["CLIC_REP_LEGAL"];
					$Patente=$row["CLIC_PATENTE_COMERCIO"];
					$RTU=$row["CLIC_RTU"];
					$RTUFecha=$row["CLIC_RTU_FECHA"];
					$ReciboLuz=$row["CLIC_RECIBO_LUZ"];
					$Estado=$row["CLIC_ESTADO"];
				}
				?>
				<h1 class="text-center"><strong>Ingresar Cliente Credito</strong><br></h1>
				<?php
				if($id_user==53711 | $id_user==10345){
					?>
				<a href="EditarClienteCredito.php?Codigo=<?php echo $Codigo; ?>">
				<button type="button" class="btn btn-success btn-lg">
					<span class="fa fa-pencil-square-o"></span> Editar
				</button>
			</a>
			<?php
				}
				?>
				<br>
				<form class="form" method="POST" role="form">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Datos Generales Solicitante</strong></h4>
							</div>
							<div class="card-body">
							<div class="row">
									<div class="col-lg-12">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="Estado">ESTADO</label>
												<?php if($Estado==1){ 
												echo '<input class="form-control" type="text" name="Nombre" id="Nombre" value="ACTIVO" required readonly/>';
												}else{
													echo '<input class="form-control" type="text" name="Nombre" id="Nombre" value="INACTIVO" required readonly/>';
												}?>
										</div>
									</div>
									<div class="col-lg-4">
									<div class="form-group floating-label" id="DIVCIF">
                                        <label for="Nombre">Codigo Cliente</label>
										<input class="form-control" type="text" name="Nombre" id="Nombre" value="#<?php echo $Codigo ?>" required readonly/>
										</div>
										</div>
										<div class="col-lg-4">
									<div class="form-group floating-label" id="DIVCIF">
                                        <label for="Nombre">Fecha Agrego</label>
										<input class="form-control" type="date" name="Nombre" id="Nombre" value="<?php echo $FechaAgrego ?>" required readonly/>
										</div>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Nombre">Nombre Completo</label>
											<input class="form-control" type="text" name="Nombre" id="Nombre" value="<?php echo $Nombre ?>" required readonly/>
											
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="DPI">DPI</label>
											<input class="form-control" type="text" name="DPI" id="DPI" value="<?php echo $DPI ?>" required readonly/>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="CalidadActua">Calidad En Que Actua</label>
										<?php  if($Calidad=="P"){echo "selected"; 
												echo '<input class="form-control" type="text" name="Nombre" id="Nombre" value="PROPIETARIO" required readonly/>';
												}
												if($Calidad=="RP"){
													echo '<input class="form-control" type="text" name="Nombre" id="Nombre" value="REPRESENTANTE LEGAL" required readonly/>';
												}?>	
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="FechaNacimiento">Fecha de Nacimiento</label>
											<input class="form-control" type="date" name="FechaNacimiento" id="FechaNacimiento" value="<?php echo $FechaNacimineto ?>" required readonly/>
											
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="PrecioVenta">Cel.</label>
											<input class="form-control" type="text" min="0" step="0.5" name="Cel" id="Cel" value="<?php echo $Cel1 ?>" required readonly/>
											
										</div>
								</div>   
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVCIF">
                                        <label for="PrecioVenta">Cel. #2</label>
											<input class="form-control" type="text" min="0" step="0.5" name="Cel2" id="Cel2" value="<?php echo $Cel2 ?>" readonly/>
											
										</div>
									</div>
								</div>
								<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Correo">Correo Electronico</label>
											<input class="form-control" type="email" name="Correo" id="Correo" value="<?php echo $Email ?>" required readonly/>
											
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-lg-6 col-lg-6">
										<div class="form-group floating-label">
											<textarea class="form-control" name="Direccion" id="Direccion" value="<?php echo $Direccion ?>" readonly></textarea>
											<label for="Direccion">Dirección</label>
										</div>
									</div>
								</div>
								<input class="form-control" type="hidden" name="Municipio" id="Municipio" value="<?php echo $Municipio ?>" readonly/>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
											
											<label for="DepartamentoResidencia">Departamento de Residencia</label>
												<?php
                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                    $query = "SELECT id_departamento, nombre_departamento FROM  info_base.departamentos_guatemala ORDER BY nombre_departamento";
                                                    $result = mysqli_query($db, $query);
                                                    while($row = mysqli_fetch_array($result))
                                                    {
														if($Departamento==$row["id_departamento"]){
															echo '<input class="form-control" type="text" name="Departamento" id="Departamento" value="'.$row["nombre_departamento"].'" required readonly/>';
														}
                                                    }

                                                ?>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 col-lg-8">
										<div class="form-group">
										<label for="MunicipioResidencia">Municipio de Residencia</label>
												<?php
												
												$consulta = "SELECT id_municipio, nombre_municipio FROM info_base.municipios_guatemala WHERE id_departamento = ".$Departamento;
												$result1 = mysqli_query($db, $consulta);
												while($fila = mysqli_fetch_array($result1))
												{
													if($fila["id_municipio"]==$Municipio){
														echo '<input class="form-control" type="text" name="Departamento" id="Departamento" value="'.$fila["nombre_municipio"].'" required readonly/>';
													}

												}
												?>												
										
											
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
											<input class="form-control" type="text" name="Razon" id="Razon" value="<?php echo $Razon ?>" required readonly/>
											
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Actividad">Actividad Comercial</label>
											<input class="form-control" type="text" name="Actividad" id="Actividad" value="<?php echo $Actividad ?>" required readonly/>
											
										</div>
									</div>
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="NombreCo">Nombre Comercial</label>
											<input class="form-control" type="text" name="NombreCo" id="NombreCo" value="<?php echo $NombreComercial ?>" required readonly/>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="NIT">NIT</label>
											<input class="form-control" type="text" name="NIT" id="NIT" value="<?php echo $NIT ?>" requiredb readonly/>
											
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="TelEmpresa">Tel. Empresa</label>
											<input class="form-control" type="text" name="TelEmpresa" id="TelEmpresa" value="<?php echo $Telefono ?>" required readonly/>
											
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Comprador">Nombre Completo Comprador</label>
											<input class="form-control" type="text" name="Comprador" id="Comprador" value="<?php echo $Compra ?>" required readonly/>
											
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="CelComprador">Cel. Comprador</label>
											<input class="form-control" type="text" name="CelComprador" id="CelComprador" value="<?php echo $CompraCel ?>" required readonly/>
											
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Paga">Nombre Completo Paga</label>
											<input class="form-control" type="text" name="Paga" id="Paga" value="<?php echo $Paga ?>" required readonly/>
											
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="CelPaga">Cel. Paga</label>
											<input class="form-control" type="text" name="CelPaga" id="CelPaga" value="<?php echo $CelPaga ?>" required readonly/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="Monto">Monto Maximo del Credito</label>
											<input class="form-control" type="num" step="any" name="Monto" id="Monto" value="<?php echo  number_format($Monto, 2, '.', ',') ?>" required readonly/>
										</div>
									</div>
								
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="DiasCredito">Cantidad de Días</label>
										<select name="DiasCredito" id="DiasCredito" class="form-control" required readonly>
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="8" <?php if($Dias==8){echo "selected"; }?>>8 Días</option>
                                                <option value="15" <?php if($Dias==15){echo "selected"; }?>>15 Días</option>
                                                <option value="21" <?php if($Dias==21){echo "selected"; }?>>21 Días</option>
                                                <option value="30" <?php if($Dias==30){echo "selected"; }?>>30 Días</option>
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
												<input type="checkbox" name="SolicitudCredito" id="SolicitudCredito" <?php if($Solitud==1){ echo 'checked';  } ?> readonly>
												<span>Soliicitud de Credito</span>
											</label>
										</div>
									</div> 
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="FotocopiaDPI" id="FotocopiaDPI" <?php if($FDPI==1){ echo 'checked';  } ?> readonly>
												<span>Fotocopia DPI</span>
											</label>
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="RepLegal" id="RepLegal" <?php if($RepLegal==1){ echo 'checked';  } ?> readonly>
												<span>Representación Legal</span>
											</label>
										</div>
									</div>
                                    
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Patente" id="Patenete" <?php if($Patente==1){ echo 'checked';  } ?> readonly>
												<span>Patente de Comercio</span>
											</label>
										</div>
									</div> 
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="RTU" id="RTU" <?php if($RTU==1){ echo 'checked';  } ?> onchange="TieneRTU(this)" readonly>
												<span>RTU Reciente</span>
											</label>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label" id="DIVRTU" <?php if($RTU==0){ echo 'style="display: none;"';  } ?>>
                                        <label for="FechaRTU">Fecha de RTU</label>
											<input class="form-control" type="date" name="FechaRTU" id="FechaRTU" value="<?php echo $RTUFecha ?>" readonly/>
											
										</div>
									</div>
                                    <div class="col-lg-4">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="ReciboLuz" id="ReciboLuz" <?php if($ReciboLuz==1){ echo 'checked';  } ?> readonly>
												<span>Recibo Luz</span>
											</label>
										</div>
									</div>
						</div>
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
