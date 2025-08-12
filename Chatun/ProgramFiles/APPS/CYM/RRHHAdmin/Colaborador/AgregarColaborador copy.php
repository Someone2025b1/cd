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

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
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

	
		</script>
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<?php


	$Anho2 = date("y");

	$query = "SELECT * FROM RRHH.COLABORADOR 
	ORDER BY C_CODIGO DESC
	LIMIT 1";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{	
		$CodigoAnt = $row["C_CODIGO"];
	}
if($CodigoAnt==NULL){

	$CodigoNuevo="CHA-".$Anho2."-0001";
}else{

	$correlativoante = explode("-", $CodigoAnt);
	$correlatinuev=$correlativoante[2]+1;
	$CodigoNuevo="CHA-".$Anho2."-".sprintf("%04d",$correlatinuev);

}
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<h1 class="text-center"><strong>Ingresar Nuevo Colaborador</strong><br></h1>
				<br>
				<form action="AgregarColaboradorPro.php" method="POST" class="form" enctype="multipart/form-data">
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
										<div class="form-group floating-label">
                                        <label for="CodigoColaborador">Codigo unico del colaborador</label>
											<input class="form-control" type="text" name="CodigoColaborador" id="CodigoColaborador" value="<?php echo $CodigoNuevo ?>"  readonly/>
											
										</div>
									</div>
								
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="Nombres">Nombres</label>
											<input class="form-control" type="text" name="Nombres" id="Nombres" />
											
										</div>
										
										<div class="form-group floating-label">
                                        <label for="Apellidos">Apellidos</label>
											<input class="form-control" type="text" name="Apellidos" id="Apellidos" />
											
										
									</div>
									</div>
									
									
									
								</div>
								<div class="col-lg-4" align="center">
								<div>
								<img src="files/avatar.jpg" alt="avatar" id="img" />
								<br>
								<br>
								<div >
								<input type="file" name="archivo" id="archivo" style="display: none;">
								
								<label for="archivo" 
								style="background: #1F5F74;
										color: white;
										padding: 6px 20px;
										cursor: pointer;
										margin: 5 5;
										text-align: center;
										border-radius: 3px;">Agregar Foto</label>
							</div>
							</div>
							</div>
								</div>
								<div class="row">
								
								<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="DPI">DPI</label>
											<input class="form-control" type="text" name="DPI" id="DPI" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Extendido">Extendido En:</label>
											<input class="form-control" type="text" name="Extendido" id="Extendido" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="DPI">Tipo Sangre</label>
											<input class="form-control" type="text" name="TipoSangre" id="TipoSangre" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<select name="EstadoCivil" id="EstadoCivil" class="form-control" >
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                $Selected="";
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM RRHH.ESTADO_CIVIL ORDER BY EC_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
        
													echo '<option value="'.$row["EC_CODIGO"].'">'.$row["EC_NOMBRE"].'</option>';
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
											<input class="form-control" type="date" name="FechaNacimiento" id="FechaNacimiento" />
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Nacido">Lugar de Nacimineto</label>
											<input class="form-control" type="text" name="Nacido" id="Nacido" />
											
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group floating-label">
                                        <label for="Celular">Celular</label>
											<input class="form-control" type="text" name="Celular" id="Celular" />
											
										</div>
									</div>
								</div>
								
								
								
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="Direccion">Dirección</label>
										<textarea class="form-control" name="Direccion" id="Direccion" rows="2" cols="40"></textarea>
											</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="IGSS">No. IGSS</label>
											<input class="form-control" type="num" name="IGSS" id="IGSS"  />
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="NIT">NIT</label>
											<input class="form-control" type="num" name="NIT" id="NIT"  />
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Casa">Casa</label>
										<select name="Casa" id="Casa" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Propia">Propia</option>
                                                <option value="Alquilada">Alquilada</option>
											</select>
										</div>
									</div>
									
								</div>
								<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Vehiculo" id="Vehiculo" onchange="Carro(this)">
												<span>Vehiculo</span>
											</label>
										</div>
										
										<div class="form-group floating-label" id="DIVCARRO" style="display: none;">
										<div class="checkbox checkbox-styled">
                                        <label>
												<input type="checkbox" name="Automovil" id="Automovil">
												<span>Automovil</span>
											</label>
											</div>
											<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="Motocicleta" id="Motocicleta">
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
											<select name="Area" id="Area" onchange="ObtenerDepartamentosLaborales(this.value)" class="form-control" >
												<option value="" disabled selected>Seleccione una opción</option>
												<?php
                                                $Selected="";
	                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
												$query = "SELECT * FROM RRHH.AREAS ORDER BY A_NOMBRE";
												$result = mysqli_query($db, $query);
												while($row = mysqli_fetch_array($result))
												{
        
													echo '<option value="'.$row["A_CODIGO"].'">'.$row["A_NOMBRE"].'</option>';
												}

												?>
											</select>
											<label for="Area">Área de Trabajo</label>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<select name="Puesto" id="Puesto" class="form-control" onchange="ObtenerJefe(this.value)">
												<option value="" disabled selected>Seleccione un área</option>
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
											<input class="form-control" type="date" name="FechaInicio" id="FechaInicio" />
										</div>
									</div>

									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="TipoEmpleado">Tipo de Empleado</label>
										<select name="TipoEmpleado" id="TipoEmpleado" class="form-control">
												<option value="" disabled selected>Seleccione una opción</option>
												<option value="Temporal">Temporal</option>
                                                <option value="Planilla">Planilla</option>
											</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<select name="Jefe" id="Jefe" class="form-control">
												<option value="" disabled selected>Seleccione un Puesto</option>
											</select>
											<label for="Jefe">Jefe Inmediato</label>
										</div>
									</div>
									</div>
									</div>
									<div class="row">
									<div class="col-lg-12">
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Base">Salario Base</label>
											<input class="form-control" type="num" name="Base" id="Base"  />
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="BonoLey">Bono Ley</label>
											<input class="form-control" type="num" name="BonoLey" id="BonoLey"  />
										</div>
									</div>
									<div class="col-lg-4">
										<div class="form-group floating-label">
                                        <label for="Bono">Bonificación Insentivo</label>
											<input class="form-control" type="num" name="Bono" id="Bono"  />
										</div>
									</div>
									</div>
									</div>

                                <div class="row">
									<div class="col-lg-12">
										<div class="form-group floating-label">
                                        <label for="ObservacionesGen">Observaciones</label>
										<textarea class="form-control" name="ObservacionesGen" id="ObservacionesGen" rows="2" cols="40"></textarea>
											
										</div>
									</div>
									</div>
								</div>

                        
                                </div>
				
					<div class="col-lg-12" align="center">
						<button type="submit" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
					</div>
					<br>
					<br>
					</div>
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
