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
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
	<script src="../../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>

	<!-- END STYLESHEETS -->

<style>



h1{
  text-align: center;
  color: #1F5F74;
  border-bottom: 1px solid #C4CBCE;
  padding-bottom: .2em;
}



form img{
  width: 200px;
  border-radius: 10%;
  border: 2px solid #AAA;
}
.fila-base{
            display: none;
        }
    	.suggest-element{
    		margin-left:5px;
    		margin-top:5px;
    		width:350px;
    		cursor:pointer;
    	}
    	#suggestions {
    		width:auto;
    		height:auto;
    		overflow: auto;
    	}


	</style>
	<script>

function AgregarDocumento()
    	{
    		$('#ModalDocumento').modal('show');

    	}

		function AgregarFamiliar()
    	{
    		$('#ModalFamiliar').modal('show');

    	}



		function Carro(x)
        {
        	if(x.checked)
        	{
        		$('#DIVCARRO').show();
        	}
        	else
        	{
        		$('#DIVCARRO').hide();
        	}
        }
		function ObtenerJefe(Valor)
	{
		$.ajax({
			url: 'BuscarJefe.php',
			type: 'POST',
			data: 'id='+Valor,
			success: function(opciones)
			{
				$('#Jefe').html(opciones);
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
	}

	function ObtenerDepartamentosLaborales(Valor)
	{
		$.ajax({
			url: 'BuscarDepartamentosLaborales.php',
			type: 'POST',
			data: 'id='+Valor,
			success: function(opciones)
			{
				$('#Puesto').html(opciones);
			},
			error: function(opciones)
			{
				alert('Error'+opciones);
			}
		})
	}

	function GuardarDocumento1()
    	{
    		var CodigoEmpleado = $('#CodigoEmpleado').val();
			var documento = $('#documento').val();
			var TipoDocumento = $('#TipoDocumento').val();
			
    		
    		$.ajax({
    				url: 'GuardarDocumento.php',
    				type: 'post',
    				data: 'CodigoEmpleado='+CodigoEmpleado+'&documento='+documento+'&TipoDocumento='+TipoDocumento,
    				success: function (data) {
    					if(data == 1)
    					{
    						$('#FormularioDocumento')[0].reset();
							$('#ModalDocumento').modal('hide');
    						alertify.success('Docuemnto Guardado ');
    					}
    					else
    					{
    						alert(data);
    					}
    				}
    			});
    	}

		function GuardarDocumento()
		{
			var formulario = document.getElementById("FormularioDocumento");
			formulario.submit();
			return true;
		}

		function GuardarFamiliar()
		{
			var formulario = document.getElementById("FormularioFamiliar");
			formulario.submit();
			return true;
		}

		function VerDocumento(x)
    	{
    		var ModalAbierto=x.value;
    		$('#ModalVer-'+x).modal('show');

    	}

		function EditarDocumento(x)
    	{
    		var ModalAbierto=x.value;
    		$('#ModalEdi-'+x).modal('show');

    	}

		function VerFamiliar(x)
    	{
    		var ModalAbierto=x.value;
    		$('#ModalVerFam-'+x).modal('show');

    	}

		function EditarFamiliar(x)
    	{
    		var ModalAbierto=x.value;
    		$('#ModalEdiFam-'+x).modal('show');

    	}

		function GuardarEditado(x)
		{
			var formulario = document.getElementById("FormularioDocumento-"+x);
			formulario.submit();
			return true;
		}

		function GuardarFamEditado(x)
		{
			var formulario = document.getElementById("FormularioFamiliar-"+x);
			formulario.submit();
			return true;
		}

	
		</script>
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php


	

	$CodigoColaborador=$_POST["CodigoColaborador"];

	if(!$CodigoColaborador){

		$CodigoColaborador=$_GET["CodigoColaborador"];

	}
	

	$query = "SELECT * FROM RRHH.COLABORADOR
	WHERE  C_CODIGO = '$CodigoColaborador'
	ORDER BY C_CODIGO DESC
	LIMIT 1";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	

		$Nombres       =  $row["C_NOMBRES"];
		$Apellidos = $row["C_APELLIDOS"];
		$DPI        = $row["C_DPI"];
		
		$EstadoCivil        = $row["EC_CODIGO"];
		$FechaNacimiento        = $row["C_FECHA_NACIMIENTO"];
		$Celular        = $row["C_CELULAR"];
		$FechaInicio        = $row["C_FECHA_INICIO"];
		$Direccion        = $row["C_DIRECCION"];
		$IGSS        = $row["C_NO_IGSS"];
		$NIT        = $row["C_NIT"];
		$Vehiculo        = $row["C_VEHICULO"];
		$Automovil        = $row["C_AUTOMOVIL"];
		$Motocicleta        = $row["C_MOTOCICLETA"];
		$Casa        = $row["C_CASA"];
		$ExtensionFoto        = $row["C_EXTENCION_FOTO"];
		$Observaciones        = $row["C_OBSERVACIONES"];
		$Area        = $row["A_CODIGO"];
		$Estado        = $row["C_ACTIVO"];
		$TipoEmpleado        = $row["C_TIPO_EMPLEADO"];
		$Jefe        = $row["C_JEFE"];
		$TipoSangre        = $row["C_TIPO_SANGRE"];
		$Puesto        = $row["P_CODIGO"];
		$Extendido        = $row["C_EXTENDIDO"];
		$Nacido        = $row["C_NACIDO"];
		$Base        = number_format($row["C_BASE"], 2, '.', ',');
		$Bono        = number_format($row["C_BONOFICACION"], 2, '.', ',');
		$BonoLey        = number_format($row["C_BONO"], 2, '.', ',');

		$rutaFoto = "../../RRHH/Colaborador/files/".$CodigoColaborador."/Foto-".$CodigoColaborador.".".$ExtensionFoto;
	}

	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Editar Colaborador</strong><br></h1>
				<br>
				<form action="EditarColaboradorPro.php" method="POST" class="form" enctype="multipart/form-data">
					<div class="col-lg-12">
						<div class="card">
                        <div class="card-body">
                            <div class="card-head style-primary">
								<h4 class="text-center"> Datos Generales del Colaborador </h4>
                            </div>
							<br>
							<div class="row">
							<div class="col-lg-8">
									<div class="col-lg-12">
									<div class="col-lg-8">
										<div class="form-group floating-label">
                                        <label for="CodigoColaborador">Codigo unico del colaborador</label>
											<input class="form-control" type="text" name="CodigoColaborador" id="CodigoColaborador" value="<?php echo $CodigoColaborador ?>"  readonly/>
											
										</div>
										</div>
										<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="EstadoCol">Estado</label>
										<select name="EstadoCol" id="EstadoCol" class="form-control" disabled="true">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="1" <?php if($Estado=="1"){echo "selected";}?>>Activo</option>
                                                <option value="2" <?php if($Estado=="2"){echo "selected";}?>>Inactivo</option>
											</select>
										</div>
									</div>

									</div>
								
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="Nombres">Nombres</label>
											<input class="form-control" type="text" name="Nombres" id="Nombres" value="<?php echo $Nombres; ?>" readonly/>
											
										</div>
										
										<div class="form-group floating-label">
                                        <label for="Apellidos">Apellidos</label>
											<input class="form-control" type="text" name="Apellidos" id="Apellidos" value="<?php echo $Apellidos; ?>" readonly />
											
										
									</div>
									</div>
									
									
									
								</div>
								<div class="col-lg-4" align="center">
								<div>
									<?php if ($ExtensionFoto == "" | $ExtensionFoto == NULL){
										?>
								<img src="files/avatar.jpg" alt="avatar" id="img" />

								<?php }else{
									
										?>
								<img src="<?php echo $rutaFoto; ?>" alt="avatar" id="img" />

								<?php }
										?>
								<br>
								<br>
								
							</div>
							</div>
								</div>
								<div class="row">
								
								<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="DPI">DPI</label>
											<input class="form-control" type="text" name="DPI" id="DPI" value="<?php echo $DPI; ?>"  disabled="true"/>
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Extendido">Extendido En:</label>
											<input class="form-control" type="text" name="Extendido" id="Extendido" value="<?php echo $Extendido; ?>"  disabled="true"/>
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="DPI">Tipo Sangre</label>
											<input class="form-control" type="text" name="TipoSangre" id="TipoSangre" value="<?php echo $TipoSangre; ?>"  disabled="true"/>
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<select name="EstadoCivil" id="EstadoCivil" class="form-control"  disabled="true">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                $Selected="";
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM RRHH.ESTADO_CIVIL ORDER BY EC_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													if($EstadoCivil==$row["EC_CODIGO"]){
														$selected="selected";
													}else
													{$selected="";
													}
													echo '<option value="'.$row["EC_CODIGO"].'" '.$selected.'>'.$row["EC_NOMBRE"].'</option>';
												}

												

												?>
											</select>
											<label for="Bodega">Estado Civil</label>
										</div>
									</div>
								</div>
								
								
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group floating-label">
                                        <label for="FechaNacimiento">Fecha de Nacimiento</label>
											<input class="form-control" type="date" name="FechaNacimiento" id="FechaNacimiento" value="<?php echo $FechaNacimiento; ?>"  disabled="true"/>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Nacido">Lugar de Nacimineto</label>
											<input class="form-control" type="text" name="Nacido" id="Nacido" value="<?php echo $Nacido; ?>"  disabled="true" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<?php
										function obtener_edad_segun_fecha($fecha_nacimiento)
										{
											$nacimiento = new DateTime($fecha_nacimiento);
											$ahora = new DateTime(date("Y-m-d"));
											$diferencia = $ahora->diff($nacimiento);
											return $diferencia->format("%y");
										}

										$Edad =  obtener_edad_segun_fecha($FechaNacimiento);
										?>
										<div class="form-group floating-label">
                                        <label for="FechaNacimiento">Edad</label>
											<input class="form-control" type="text" name="Edad" id="Edad" value="<?php echo $Edad; ?> Años"  disabled="true"/>
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Celular">Celular</label>
											<input class="form-control" type="text" name="Celular" id="Celular" value="<?php echo $Celular; ?>"  disabled="true"/>
											
										</div>
									</div>
									
								</div>
								
								
								
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="Direccion">Dirección</label>
										<textarea class="form-control" name="Direccion" id="Direccion" rows="2" cols="40"  disabled="true"><?php echo $Direccion; ?></textarea>
											</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="IGSS">No. IGSS</label>
											<input class="form-control" type="num" name="IGSS" id="IGSS"  value="<?php echo $IGSS; ?>"  disabled="true"/>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NIT">NIT</label>
											<input class="form-control" type="num" name="NIT" id="NIT"  value="<?php echo $NIT; ?>" disabled="true"/>
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Casa">Casa</label>
										<select name="Casa" id="Casa" class="form-control"  disabled="true">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Propia" <?php if($Casa=="Propia"){echo "selected";}?>>Propia</option>
                                                <option value="Alquilada" <?php if($Casa=="Alquilada"){echo "selected";}?>>Alquilada</option>
											</select>
										</div>
									</div>
									
								</div>
								<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Vehiculo" id="Vehiculo" <?php if($Vehiculo==1){ echo 'checked';  } ?> onchange="Carro(this)"  disabled="true">
												<span>Vehiculo</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVCARRO" <?php if($Vehiculo==0){ echo 'style="display: none;"';  }?>  disabled="true">
										<div class="checkbox checkbox-styled">
                                        <label>
												<input type="checkbox" name="Automovil" id="Automovil" <?php if($Automovil==1){ echo 'checked';  } ?>  disabled="true">
												<span>Automovil</span>
											</label>
											</div>
											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Motocicleta" id="Motocicleta" <?php if($Motocicleta==1){ echo 'checked';  } ?>  disabled="true">
												<span>Motocicleta</span>
											</label>
										
									</div>
									</div>
									<br>
									<div class="card-head style-primary">
								<h4 class="text-center"> Datos Laborales </h4>
                            </div>

							<div class="row">
									<div class="col-lg-12">
							

									<div class="col-lg-6">
										<div class="form-group">
											<select name="Area" id="Area" onchange="ObtenerDepartamentosLaborales(this.value)" class="form-control" disabled="true">
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                $Selected="";
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM RRHH.AREAS ORDER BY A_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
													if($Area==$row["A_CODIGO"]){
														$selected="selected";
													}else
													{$selected="";
													}
													echo '<option value="'.$row["A_CODIGO"].'" '.$selected.'>'.$row["A_NOMBRE"].'</option>';
												}

												$sqlRet = mysqli_query($db,"SELECT A.P_NOMBRE 
												FROM RRHH.PUESTO AS A     
												WHERE A.P_CODIGO = ".$Puesto); 
												$rowret=mysqli_fetch_array($sqlRet);

												$NombrePuesto=$rowret["P_NOMBRE"];

												$sqlRet = mysqli_query($db,"SELECT A.C_NOMBRES, A.C_APELLIDOS 
												FROM RRHH.COLABORADOR AS A     
												WHERE A.C_CODIGO = '$Jefe'"); 
												$rowret=mysqli_fetch_array($sqlRet);

												$NombreJefe=$rowret["C_NOMBRES"]." ".$rowret["C_APELLIDOS"];

												?>
											</select>
											<label for="Area">Área de Trabajo</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<select name="Puesto" id="Puesto" class="form-control" onchange="ObtenerJefe(this.value)" disabled="true">
												<option value="<?php echo $Puesto; ?>"  selected><?php echo $NombrePuesto; ?></option>
											</select>
											<label for="Puesto">Puesto Laboral</label>
										</div>
									</div>
									</div>
									</div>
									<div class="row">
									<div class="col-lg-12">
									
									<div class="col-lg-2">
										<div class="form-group floating-label">
                                        <label for="FechaInicio">Fecha de Inicio Laboral</label>
											<input class="form-control" type="date" name="FechaInicio" id="FechaInicio" value="<?php echo $FechaInicio; ?>" disabled="true"/>
										</div>
									</div>

									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="TipoEmpleado">Tipo de Empleado</label>
										<select name="TipoEmpleado" id="TipoEmpleado" class="form-control" disabled="true">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Temporal" <?php if($TipoEmpleado=="Temporal"){echo "selected";}?>>Temporal</option>
                                                <option value="Planilla" <?php if($TipoEmpleado=="Planilla"){echo "selected";}?>>Planilla</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<select name="Jefe" id="Jefe" class="form-control" disabled="true">
												<option value="<?php echo $Jefe; ?>"  selected><?php echo $NombreJefe; ?></option>
											</select>
											<label for="Jefe">Jefe Inmediato</label>
										</div>
									</div>
									</div>
									</div>
									
									<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObservacionesGen">Observaciones</label>
										<textarea class="form-control" name="ObservacionesGen" id="ObservacionesGen" rows="2" cols="40" disabled="true"><?php echo $Observaciones; ?></textarea>
											
										</div>
									</div>
									</div>
								</div>
                                
								</div>
                                
								<div class="panel-group" id="accordion">
								<!-- Archivos -->
                                <div class="card panel" id="Documentos">
								<div class="card-head style-danger collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#accordion-1" aria-expanded="false">
									<header>Documentos</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion-1" class="collapse" aria-expanded="false" style="height: 5px;">
									<div class="card-body">
									<div class="col-lg-9">
									</div>
									
										<br>
										<div class="row">		
											<div class="col-lg-12">
											<div class="row">

											<table class="table" name="tabla-<?php echo $CONT."-".$TipoD; ?>" id="tabla-<?php echo $CONT."-".$TipoD; ?>" >
																<thead>
																	<tr>
																		<th>Codigo</th>
																		<th>Nombre</th>
																		<th>Ver</th>
																		
																	</tr>
																</thead>
																<tbody>
																<?php
																	
																	$sqlreq = "SELECT A.*
																	FROM RRHH.DOCUMENTOS_COLABORADOR AS A
																	WHERE A.C_CODIGO = '$CodigoColaborador'";
																	$resultreq = mysqli_query($db, $sqlreq);
																	while($rowreq = mysqli_fetch_array($resultreq))
																	{
																		$CodigoDoc = $rowreq["DC_CODIGO"];
																		$NombreDoc = $rowreq["DC_TIPO"];
																		$Extencion = $rowreq["DC_ARCHIVO"];
																		
																		
																		?>
																		<tr>
																	<td><h6><input type="text" class="form-control" name="CodigoDoc" id="CodigoDoc"  style="width: 400px" min="0" value="<?php echo $CodigoDoc ?>" disabled="disabled"></h6></td>
																	<td><h6> <input type="text" class="form-control" name="NombreDoc" id="NombreDoc" readonly disabled="disabled" style="width: 400px" value="<?php echo $NombreDoc ?>"></h6></td>
																	<td style="font-size: 24px"><button type="button" class="btn btn-info"  value="<?php echo $CodigoDoc; ?>" onclick="VerDocumento(this.value)">
																		<span class="fa fa-eye"></span>
																	</button> 
																	</td>
																			                                                
						                                                
						                                            </tr>

																	<!-- Modal Detalle Pasivo Contingente -->
																	<div id="ModalVer-<?php echo $CodigoDoc; ?>" class="modal fade" role="dialog" style="width: 100%">
																		
																		<div class="modal-dialog" style="width: 80%">
																		
																		<div class="card">
																		<div class="card-body">
																			
																		<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
																			<!-- Modal content-->
																			<div class="modal-content">
																			<div class="card-head style-primary">
																							<h2 class="text-center"> <?php echo $NombreDoc; ?> </h2>
																						</div>
																				<div class="modal-body">
																				<form class="form" id="FormularioVer" action="GuardarDocumento.php" method="POST" enctype="multipart/form-data">
																					<div id="suggestions" class="text-center"></div>
																					<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
																					
																					<embed 	src="../../RRHH/Colaborador/files/<?php echo $CodigoColaborador; ?>/<?php echo $NombreDoc."-".$CodigoColaborador; ?>.<?php echo $Extencion; ?>" style="width:100%; height:500px;" frameborder="0" >	

																				</form>

																						<div class="modal-footer">
																					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
																				</div>
																				</div>
																			</div>
																			</div>
																		</div>
																		</form>
																	</div>

																	</div>
																	<!-- /Modal Detalle Pasivo Contingente -->

																	<!-- Modal Editar -->
																	<div id="ModalEdi-<?php echo $CodigoDoc; ?>" class="modal fade" role="dialog">
																		
																		<div class="modal-dialog">
																		
																		<div class="card">
																		<div class="card-body">
																			
																		<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
																			<!-- Modal content-->
																			<div class="modal-content">
																			<div class="card-head style-primary">
																							<h2 class="text-center"> Datos Laborales </h2>
																						</div>
																				<div class="modal-body">
																				<form class="form" id="FormularioDocumento-<?php echo $CodigoDoc; ?>" action="GuardarDocumento.php" method="POST" enctype="multipart/form-data">
																					<div id="suggestions" class="text-center"></div>
																					<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
																					<div class="col-lg-8">
																									<div class="form-group floating-label">
																									<label for="TipoDocumento">Tipo de Documento</label>
																									<input class="form-control" type="text" name="TipoDocumento" id="TipoDocumento" value="<?php echo $NombreDoc ?>" readonly>
																									</div>
																								</div>
																								<div class="col-lg-8">
																								</div>
																					<div >
																							<input type="file" name="documento" id="documento">
																							
																							<label for="documento" 
																							style="background: #1F5F74;
																									color: white;
																									padding: 6px 20px;
																									cursor: pointer;
																									margin: 5 5;
																									text-align: center;
																									border-radius: 3px;">Seleccionar Documneto</label>
																						</div>
																				</form>

																						<div class="modal-footer">
																					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
																					<button type="button" class="btn btn-success" value="<?php echo $CodigoDoc; ?>" onclick="GuardarEditado(this.value)">Guardar</button>
																				</div>
																				</div>
																			</div>
																			</div>
																		</div>
																		</form>
																	</div>

																	</div>
																	<!-- /Modal Detalle Pasivo Contingente -->
																	  <?php
																	}
																	
																	?>		
																		</tbody>
																</table>
											
											</div>
										</div>
									</div>
									</div>
								</div>
							</div><!--end .panel -->
                            <div class="card panel" id="Familiares"><!-- Faliares -->
								<div class="card-head style-warning collapsed" data-toggle="collapse" data-parent="#accordion" data-target="#accordion-2" aria-expanded="false">
									<header>Familiares</header>
									<div class="tools">
										<a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
									</div>
								</div>
								<div id="accordion-2" class="collapse" aria-expanded="false" style="height: 5px;">
									<div class="card-body">
									<div class="col-lg-9">
									</div>
									


										<table class="table" name="tabla-<?php echo $CONT."-".$TipoD; ?>" id="tabla-<?php echo $CONT."-".$TipoD; ?>" >
																<thead>
																	<tr>
																		<th>Codigo</th>
																		<th>Parentesco</th>
																		<th>Ver</th>
																		
																	</tr>
																</thead>
																<tbody>
																<?php
																	
																	$sqlreq = "SELECT A.*
																	FROM RRHH.FAMILIAR_COLABORADOR AS A
																	WHERE A.C_CODIGO = '$CodigoColaborador'";
																	$resultreq = mysqli_query($db, $sqlreq);
																	while($rowreq = mysqli_fetch_array($resultreq))
																	{
																		$CodigoFam = $rowreq["FC_CODIGO"];
																		$Parentersco = $rowreq["FC_PARENTESCO"];
																		$NombresFamiliar = $rowreq["FC_NOMBRES"];
																		$ApellidosFamiliar = $rowreq["FC_APELLIDOS"];
																		$CelFamiliar = $rowreq["FC_CELULAR"];
																		
																		?>
																		<tr>
																	<td><h6><input type="text" class="form-control" name="CodigoFam" id="CodigoFam"  style="width: 400px" min="0" value="<?php echo $CodigoFam ?>" disabled="disabled"></h6></td>
																	<td><h6> <input type="text" class="form-control" name="NombreFam" id="NombreFam" readonly disabled="disabled" style="width: 400px" value="<?php echo $Parentersco ?>"></h6></td>
																	<td style="font-size: 24px"><button type="button" class="btn btn-info"  value="<?php echo $CodigoFam; ?>" onclick="VerFamiliar(this.value)">
																		<span class="fa fa-eye"></span>
																	</button> 
																	</td>
																			                                                
						                                                
						                                            </tr>

																	<!-- Modal Detalle Pasivo Contingente -->
																	<div id="ModalVerFam-<?php echo $CodigoFam; ?>" class="modal fade" role="dialog" style="width: 100%">
																		
																		<div class="modal-dialog" style="width: 80%">
																		
																		<div class="card">
																		<div class="card-body">
																			
																		<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
																			<!-- Modal content-->
																			<div class="modal-content">
																			<div class="card-head style-primary">
																							<h2 class="text-center"> <?php echo $CodigoFam; ?> </h2>
																						</div>
																				<div class="modal-body">
																				<form class="form" id="FormularioVer" action="GuardarDocumento.php" method="POST" enctype="multipart/form-data">
																				<div id="suggestions" class="text-center"></div>
																				<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
																				<div class="col-lg-12">
																				<div class="col-lg-8">
																								<div class="form-group floating-label">
																								<label for="Parentersco">Tipo de Parentesco</label>
																								<input class="form-control" type="text" name="TipoDocumento" id="TipoDocumento" value="<?php echo $Parentersco ?>" readonly>
																								</div>
																							</div>
																							
																																
																							
																							<div class="col-lg-8">
																							<div class="form-group floating-label">
																							<label for="NombresFamiliar">Nombres</label>
																							<input class="form-control" type="text" name="NombresFamiliar" id="NombresFamiliar" value="<?php echo $NombresFamiliar ?>" readonly>
																							</div>
																							</div>
																							<div class="col-lg-8">
																							<div class="form-group floating-label">
																							<label for="ApellidosFamiliar">Apellidos</label>
																							<input class="form-control" type="text" name="ApellidosFamiliar" id="ApellidosFamiliar" value="<?php echo $ApellidosFamiliar ?>" readonly>
																							</div>
																							</div>
																							<div class="col-lg-8">
																							<div class="form-group floating-label">
																							<label for="CelFamiliar">No. Celular</label>
																							<input class="form-control" type="text" name="CelFamiliar" id="CelFamiliar" value="<?php echo $CelFamiliar ?>" readonly >
																							</div>
																							</div>
																							</div>
																				</form>

																						<div class="modal-footer">
																					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
																				</div>
																				</div>
																			</div>
																			</div>
																		</div>
																		</form>
																	</div>

																	</div>
																	<!-- /Modal Detalle Pasivo Contingente -->

																	<!-- Modal Editar -->
																	<div id="ModalEdiFam-<?php echo $CodigoFam; ?>" class="modal fade" role="dialog">
																		
																		<div class="modal-dialog">
																		
																		<div class="card">
																		<div class="card-body">
																			
																		<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
																			<!-- Modal content-->
																			<div class="modal-content">
																			<div class="card-head style-primary">
																							<h2 class="text-center"> Datos Laborales </h2>
																						</div>
																				<div class="modal-body">
																				<form class="form" id="FormularioFamiliar-<?php echo $CodigoFam; ?>" action="GuardarFamiliar.php" method="POST" enctype="multipart/form-data">
																				<div id="suggestions" class="text-center"></div>
																				<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
																				<div class="col-lg-12">
																				<div class="col-lg-8">
																								<div class="form-group floating-label">
																								<label for="Parentersco">Tipo de Parentesco</label>
																								<input class="form-control" type="text" name="Parentersco" id="Parentersco" value="<?php echo $Parentersco ?>" readonly>
																								</div>
																							</div>
																							
																																
																							
																							<div class="col-lg-8">
																							<div class="form-group floating-label">
																							<label for="NombresFamiliar">Nombres</label>
																							<input class="form-control" type="text" name="NombresFamiliar" id="NombresFamiliar" value="<?php echo $NombresFamiliar ?>" >
																							</div>
																							</div>
																							<div class="col-lg-8">
																							<div class="form-group floating-label">
																							<label for="ApellidosFamiliar">Apellidos</label>
																							<input class="form-control" type="text" name="ApellidosFamiliar" id="ApellidosFamiliar" value="<?php echo $ApellidosFamiliar ?>" >
																							</div>
																							</div>
																							<div class="col-lg-8">
																							<div class="form-group floating-label">
																							<label for="CelFamiliar">No. Celular</label>
																							<input class="form-control" type="text" name="CelFamiliar" id="CelFamiliar" value="<?php echo $CelFamiliar ?>"  >
																							</div>
																							</div>
																							</div>
																				</form>

																						<div class="modal-footer">
																					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
																					<button type="button" class="btn btn-success" value="<?php echo $CodigoFam; ?>" onclick="GuardarFamEditado(this.value)">Guardar</button>
																				</div>
																				</div>
																			</div>
																			</div>
																		</div>
																		</form>
																	</div>

																	</div>
																	<!-- /Modal Detalle Pasivo Contingente -->
																	  <?php
																	}
																	
																	?>		
																		</tbody>
																</table>
												
									
                                <div class="row">
									
									</div>
									
										
										
									</div>
									</div>
								
							</div><!--end .panel -->
                        
                                </div>
                                
				
				
					<br>
					<br>
					</div>
				</form>
			</div>
		</div>
		<!-- END CONTENT -->
		
		<!-- Modal Detalle Pasivo Contingente -->
<div id="ModalDocumento" class="modal fade" role="dialog">
	
            <div class="modal-dialog">
			
			<div class="card">
			<div class="card-body">
				
			<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
                <!-- Modal content-->
                <div class="modal-content">
				<div class="card-head style-primary">
								<h2 class="text-center"> Datos Laborales </h2>
                            </div>
                    <div class="modal-body">
					<form class="form" id="FormularioDocumento" action="GuardarDocumento.php" method="POST" enctype="multipart/form-data">
                    	<div id="suggestions" class="text-center"></div>
						<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
						<div class="col-lg-8">
										<div class="form-group floating-label">
                                        <label for="TipoDocumento">Tipo de Documento</label>
										<select name="TipoDocumento" id="TipoDocumento" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="DPI">DPI</option>
                                                <option value="Ornato">Boleto de Ornato</option>
                                                <option value="SolicitudEmpleo">Solicitud de Empleo</option>
											</select>
										</div>
									</div>
									<div class="col-lg-8">
									</div>
						<div >
								<input type="file" name="documento" id="documento" >
								
								<label for="documento" 
								style="background: #1F5F74;
										color: white;
										padding: 6px 20px;
										cursor: pointer;
										margin: 5 5;
										text-align: center;
										border-radius: 3px;">Seleccionar Documneto</label>
							</div>
					</form>

							<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="GuardarDocumento()">Guardar</button>
					</div>
                    </div>
                </div>
                </div>
            </div>
			</form>
	</div>
	
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->
		<!-- Modal Detalle Pasivo Contingente -->
<div id="ModalFamiliar" class="modal fade" role="dialog">
	
	<div class="modal-dialog">
	
	<div class="card">
	<div class="card-body">
		
	<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
		<!-- Modal content-->
		<div class="modal-content">
		<div class="card-head style-primary">
						<h2 class="text-center"> Datos del Familiar </h2>
					</div>
			<div class="modal-body">
			<form class="form" id="FormularioFamiliar" action="GuardarFamiliar.php" method="POST" enctype="multipart/form-data">
				<div id="suggestions" class="text-center"></div>
				<input type="hidden" name="CodigoEmpleado" id="CodigoEmpleado" value="<?php echo $CodigoColaborador ?>">
				<div class="col-lg-12">
				<div class="col-lg-8">
								<div class="form-group floating-label">
								<label for="Parentersco">Tipo de Parentesco</label>
								<select name="Parentersco" id="Parentersco" class="form-control">
										<option value="" disabled selected>Seleccione una opción</option>
										<option value="Esposo/a">Esposo/a</option>
										<option value="Pareja">Pareja</option>
										<option value="Madre">Madre</option>
										<option value="Padre">Padre</option>
									</select>
								</div>
							</div>
							
																
							
							<div class="col-lg-8">
							<div class="form-group floating-label">
							<label for="NombresFamiliar">Nombres</label>
							<input class="form-control" type="text" name="NombresFamiliar" id="NombresFamiliar" >
							</div>
							</div>
							<div class="col-lg-8">
							<div class="form-group floating-label">
							<label for="ApellidosFamiliar">Apellidos</label>
							<input class="form-control" type="text" name="ApellidosFamiliar" id="ApellidosFamiliar" >
							</div>
							</div>
							<div class="col-lg-8">
							<div class="form-group floating-label">
							<label for="CelFamiliar">No. Celular</label>
							<input class="form-control" type="text" name="CelFamiliar" id="CelFamiliar" >
							</div>
							</div>
							</div>

			</form>

					<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-success" onclick="GuardarFamiliar()">Guardar</button>
			</div>
			</div>
		</div>
		</div>
	</div>
	</form>
</div>

</div>
<!-- /Modal Detalle Pasivo Contingente -->
		
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

<script>
const defaultFile = 'https://us.123rf.com/450wm/thesomeday123/thesomeday1231712/thesomeday123171200009/91087331-icono-de-perfil-de-avatar-predeterminado-para-hombre-marcador-de-posici%C3%B3n-de-foto-gris-vector-de.jpg';

const file = document.getElementById( 'archivo' );
const img = document.getElementById( 'img' );
file.addEventListener( 'change', e => {
  if( e.target.files[0] ){
    const reader = new FileReader( );
    reader.onload = function( e ){
      img.src = e.target.result;
    }
    reader.readAsDataURL(e.target.files[0])
  }else{
    img.src = defaultFile;
  }
} );
	</script>
	</body>
	</html>
