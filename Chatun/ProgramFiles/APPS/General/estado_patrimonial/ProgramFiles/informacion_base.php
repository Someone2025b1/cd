<?php
header('Content-Type:text/html;charset=utf-8');
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");

$UserID = $_SESSION["iduser"];

$Consulta = "SELECT * FROM Estado_Patrimonial.empleados WHERE id = ".$UserID;
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	$TipoIdentificacion = $row["TipoDocumentoIdentificacion"];
	$NoIdentificacion = $row["DocumentoIdentificacion"];
	$DocumentoExtendido = $row["extendida"];
	$PaisOrigen = $row["PaisOrigen"];
	$Departamento = $row["depto"];
	$LugarNacimiento = $row["LugarNacimiento"];
	$Nit = $row["NitEmpleado"];
	$Igss = $row["IgssEmpleado"];
	$Nombre1 = $row["Nombre1"];
	$Nombre2 = $row["Nombre2"];
	$Nombre3 = $row["Nombre3"];
	$Apellido1 = $row["Apellido1"];
	$Apellido2 = $row["Apellido2"];
	$ApellidoCasada = $row["ApellidoCasada"];
	$EstadoCivil = $row["EstadoCivil"];
    $TipoSangre = $row["TipoSangre"];
	$Sexo = $row["Sexo"];
	$FechaNacimiento = $row["FechaNacimiento"];
	$Puesto = $row["Puesto"];
	$NivelAcademico = $row["NivelAcademico"];
	$Profesion = $row["Profesion"];
	$Etnia = $row["Etnia"];
	$Idiomas = $row["Idiomas"];
	$Telefono = $row["Telefono"];
	$Celular = $row["Celular"];
	$Direccion = $row["Direccion"];
	$Email = $row["email"];
	$Propiedad = $row["propiedad"];
}

$sql = "SELECT * FROM Estado_Patrimonial.fotografia_colaborador WHERE FC_TIPO = 1 AND FC_COLABORADOR = ".$UserID;  // sentencia sql
$result = mysqli_query($db, $sql);
$NumeroFotografia1 = mysqli_num_rows($result); // obtenemos el número de filas
if($NumeroFotografia1 != 0)
{
    $Consulta1 = "SELECT * FROM Estado_Patrimonial.fotografia_colaborador WHERE FC_TIPO = 1 AND FC_COLABORADOR = ".$UserID;
    $Resultado1 = mysqli_query($db, $Consulta1);
    while($row = mysqli_fetch_array($Resultado1))
    {
        $IDFotografia1   = $row["FC_CODIGO"];
        $RutaFotografia1 = $row["FC_RUTA"];
        $TipoFotografia1 = $row["FC_TIPO"];
    }
}

$sql = "SELECT * FROM Estado_Patrimonial.fotografia_colaborador WHERE FC_TIPO = 2 AND FC_COLABORADOR = ".$UserID;  // sentencia sql
$result = mysqli_query($db, $sql);
$NumeroFotografia2 = mysqli_num_rows($result); // obtenemos el número de filas
if($NumeroFotografia2 != 0)
{
    $Consulta1 = "SELECT * FROM Estado_Patrimonial.fotografia_colaborador WHERE FC_TIPO = 2 AND FC_COLABORADOR = ".$UserID;
    $Resultado1 = mysqli_query($db, $Consulta1);
    while($row = mysqli_fetch_array($Resultado1))
    {
        $IDFotografia2   = $row["FC_CODIGO"];
        $RutaFotografia2 = $row["FC_RUTA"];
        $TipoFotografia2 = $row["FC_TIPO"];
    }
}

switch ($EstadoCivil) {
	case 0:
	$estado_civil_nombre = "Soltero";
	
	case 1:
	$estado_civil_nombre = "Casado(a) / Unido(a)";
	
	case 2:
	$estado_civil_nombre = "Viudo(a)";
	
	case 3:
	$estado_civil_nombre = "Divorciado(a)";
			
}


$sql = "SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id = '".$LugarNacimiento."'";
$result = mysqli_query($db, $sql);
$numero = mysqli_num_rows($result);
if($numero == 0)
{
    ?>
        <input type="hidden" id="Error" value="<?php echo $numero; ?>">
    <?php
}
else
{
    $Consulta = "SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id = '".$LugarNacimiento."'";
    $Resultado = mysqli_query($db, $Consulta);
    while($row = mysqli_fetch_array($Resultado))
    {
        $NombreMunicipio = $row["nombre_municipio"];
    }
    ?>
        <input type="hidden" id="Error" value="<?php echo $numero; ?>">
    <?php
}
echo '<input type="hidden" id="UsuarioID" value="'.$UserID.'">';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>PORTAL COOSAJO, R.L. - Estado Patrimonial</title>

    <!-- CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/mint-admin.css" rel="stylesheet" />
    <link href="css/alertify.core.css" rel="stylesheet" />
    <link href="css/alertify.bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/jquery-ui.css">

    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/alertify.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Mint Admin Scripts - Include with every page -->
    <script src="js/mint-admin.js"></script>

    <script language="JavaScript" type="text/JavaScript">
    	function ActualizarNoOrganizaciones()
    	{
    		var Paren = document.getElementById('parentescos2');

    		var Usuario = document.getElementById('UsuarioID').value;

    		$.ajax({
    			url: 'ActOrganizaciones.php',
    			type: 'post',
    			data: 'Usuario='+Usuario,
    			success: function(output)
    			{
    				
    				Paren.value = output;
    			},
    			error: function()
    			{
    				alertify.error('Algo salió mal');
    			}
    		});
    	}
    	function ActualizarNoParentescos()
    	{
    		var Paren = document.getElementById('parentescos');

    		var Usuario = document.getElementById('UsuarioID').value;

    		$.ajax({
    			url: 'ActParentesco.php',
    			type: 'post',
    			data: 'Usuario='+Usuario,
    			success: function(output)
    			{
    				Paren.value = output;
    			},
    			error: function()
    			{
    				alertify.error('Algo salió mal');
    			}
    		});
    	}
    	function ActualizarNoPasivoContingente()
    	{
    		var Paren = document.getElementById('parentescos3');

    		var Usuario = document.getElementById('UsuarioID').value;

    		$.ajax({
    			url: 'ActPasivoContingente.php',
    			type: 'post',
    			data: 'Usuario='+Usuario,
    			success: function(output)
    			{
    				Paren.value = output;
    			},
    			error: function()
    			{
    				alertify.error('Algo salió mal');
    			}
    		});
    	}
        function ObtenerMunicipios(Valor)
        {
            $('#country').html('<option value="">Cargando...</option>');
            $.ajax({
                url: 'BuscarMunicipio.php',
                type: 'POST',
                data: 'id='+Valor,
                success: function(opciones)
                {
                    $('#country').html(opciones)
                }
            })
        }
        function VerificarPropiedad(x)
        {
        	if(x == 'Otros')
        	{
        		document.getElementById('DivPropiedad').style.display = 'block';
        	}
        	else
        	{
        		document.getElementById('DivPropiedad').style.display = 'none';
        	}
        }
        function BusquedaCIF(x)
        {
            $.ajax({
                url: 'BusquedaCIF.php',
                type: 'POST',
                data: 'id='+x,
                success: function(response)
                {
                	if(response == 'null')
                	{
                		alertify.error('No se encontró ningún registro');
                	}
                	else
                	{
	                	var data = $.parseJSON(response);
	                	$.each(data, function(i, item) {
	                		$('#Nombre').val(item.nombre);

	                	});
                	}
                }
            })
        }
        function EliminarParentesco(x)
        {
        	var pariente = x.getAttribute('CIFPariente');
        	var Usuario = document.getElementById('UsuarioID').value;
        	alertify.confirm("¿Está seguro que desea eliminar el parentesco seleccionado?", function (e) {
        		if (e) {
        			$.ajax({
        				url: 'DelParentesco.php',
        				type: 'post',
        				data: 'CifCol='+Usuario+'&CifPar='+pariente,
        				success: function(output)
        				{
        					ActualizarTablaParentesco();
        					ActualizarNoParentescos();
        					alertify.success('El parentesco fue eliminado');
        				},
        				error: function()
        				{
        					alertify.error('Algo salió mal');
        				}
        			});
        		}
        	});

        }
        function EliminarOrganizacion(x)
        {
        	var Org = x.getAttribute('IDOrganizacion');
        	alertify.confirm("¿Está seguro que desea eliminar la organización seleccionada?", function (e) {
        		if (e) {
        			$.ajax({
        				url: 'DelOrganizacion.php',
        				type: 'post',
        				data: 'ID='+Org,
        				success: function(output)
        				{
        					ActualizarTablaOrganizaciones();
        					ActualizarNoOrganizaciones();
        					alertify.success('La organización fue eliminada exitósamente');
        				},
        				error: function()
        				{
        					alertify.error('Algo salió mal');
        				}
        			});
        		}
        	});

        }
        function EliminarPasivoContingente(x)
        {
        	var Org = x.getAttribute('IDPasivo');
        	alertify.confirm("¿Está seguro que desea eliminar la información seleccionada?", function (e) {
        		if (e) {
        			$.ajax({
        				url: 'DelPasivoContingente.php',
        				type: 'post',
        				data: 'ID='+Org,
        				success: function(output)
        				{
        					ActualizarTablaPasivoContingente();
        					ActualizarNoPasivoContingente();
        					alertify.success('La información fue eliminada exitósamente');
        				},
        				error: function()
        				{
        					alertify.error('Algo salió mal');
        				}
        			});
        		}
        	});

        }
        function ActualizarTablaParentesco()
        {
        	var Usuario = document.getElementById('UsuarioID').value;
            $.ajax({
                url: 'LlenarTablaParentescos.php',
                type: 'POST',
                data: 'id='+Usuario,
                success: function(opciones)
                {
                    $('#tablaDetalleParentescos').html(opciones)
                }
            })
        }
        function ActualizarTablaOrganizaciones()
        {
        	var Usuario = document.getElementById('UsuarioID').value;
            $.ajax({
                url: 'LlenarTablaOrganizaciones.php',
                type: 'POST',
                data: 'id='+Usuario,
                success: function(opciones)
                {
                    $('#tablaDetalleOrganizaciones').html(opciones)
                }
            })
        }
        function ActualizarTablaParentesco()
        {
        	var Usuario = document.getElementById('UsuarioID').value;
            $.ajax({
                url: 'LlenarTablaParentescos.php',
                type: 'POST',
                data: 'id='+Usuario,
                success: function(opciones)
                {
                    $('#tablaDetalleParentescos').html(opciones)
                }
            })
        }
        function ActualizarTablaPasivoContingente()
        {
        	var Usuario = document.getElementById('UsuarioID').value;
            $.ajax({
                url: 'LlenarTablaPasivoContingente.php',
                type: 'POST',
                data: 'id='+Usuario,
                success: function(opciones)
                {
                    $('#tablaDetallePasivoContingente').html(opciones)
                }
            })
        }
        function IngresarParentesco()
        {
            var TipoPersonaParentesco = document.getElementById('TipoPersonaParentesco').value;
			var CifParent             = document.getElementById('CIF').value;
			var NombreParent          = document.getElementById('Nombre').value;
			var Parent                = document.getElementById('a_parentesco').value;
			var FechaNacimientoParent = document.getElementById('FechaNacimiento').value;
			var ViveParent            = document.getElementById('Vive').value;
            var NombreNoAsociado      = document.getElementById('NombreNoAsociado').value;
			if(ViveParent == 1)
			{
				var DireccionhijoParent   = document.getElementById('direccion').value;
			}
			else if(ViveParent == 2)
			{
				var DireccionhijoParent   = document.getElementById('DireccionHijo').value;
			}
			else
			{
				var DireccionhijoParent = ''
			}
			var DependienteParent     = document.getElementById('dependiente').value;
			var OcupacionParent       = document.getElementById('OcupacionParentesco').value;
			var Usuario               = document.getElementById('UsuarioID').value;

            var inpObj = document.getElementById('ParentescosFORM');
            if(inpObj.checkValidity() == true)
            {
    			$.ajax({
                    url: 'LlenarParentesco.php',
                    type: 'POST',
                    data: 'CIFParent='+CifParent+'&Nombre='+NombreParent+'&Parentesco='+Parent+'&Fecha='+FechaNacimientoParent+'&Vive='+ViveParent+'&Direccion='+DireccionhijoParent+'&Dependiente='+DependienteParent+'&Ocupacion='+OcupacionParent+'&UsuarioID='+Usuario+'&TipoPersona='+TipoPersonaParentesco+'&NombreNoAsociado='+NombreNoAsociado,
                    success: function()
                    {
                    	$('#ModalParentescos').modal("hide");
                    	ActualizarTablaParentesco();
                    	ActualizarNoParentescos();
                    	document.getElementById("ParentescosFORM").reset();
                    	document.getElementById('ViveConUsted').style.display = 'none';
                    	document.getElementById('FechaNacimientoHijo').style.display = 'none';
                    	document.getElementById('DireccionHijo').style.display = 'none';
                        alertify.success('Se ingresó el pariente exitósamente');
                    },
                    error: function(opt)
                    {
                    	$('#ModalParentescos').modal("hide");
                    	alertify.error('Algo salió mal');
                    }
                })                
            }
            else
            {
                alertify.error('Por favor, llene todos los campos');
            }

        }
        function IngresarOrganizaciones()
        {
			var Usuario                  = document.getElementById('UsuarioID').value;
			var TipoOrganizacion         = document.getElementById('Organizaciones').value;
			var NombreOrganizacion       = document.getElementById('NombreOrganizacion').value;
			var CargoOrganizacion        = document.getElementById('CargoOrganizacion').value;
			var FechaIngresoOrganizacion = document.getElementById('FechaIngresoOrganizacion').value;

        	$.ajax({
                url: 'LlenarOrganizaciones.php',
                type: 'POST',
                data: 'Tipo='+TipoOrganizacion+'&Nombre='+NombreOrganizacion+'&Cargo='+CargoOrganizacion+'&Fecha='+FechaIngresoOrganizacion+'&UsuarioID='+Usuario,
                success: function()
                {
                	$('#ModalOroganizaciones').modal("hide");
                	ActualizarTablaOrganizaciones();
                	ActualizarNoOrganizaciones();
                	document.getElementById("OrganizacionesFORM").reset();
                    alertify.success('Se ingresó la información exitósamente');
                },
                error: function(opt)
                {
                	$('#ModalOroganizaciones').modal("hide");
                	alertify.error('Algo salió mal');
                }
            })
        }
        function IngresarPasivoContingente()
        {
			var Usuario                  = document.getElementById('UsuarioID').value;
			var Nombre         = document.getElementById('NombreFCA').value;
			var Institucion       = document.getElementById('Institucion').value;
			var Monto        = document.getElementById('Monto').value;
			var Vencimiento = document.getElementById('Vencimiento').value;

        	$.ajax({
                url: 'LlenarPasivoContingente.php',
                type: 'POST',
                data: 'Nombre='+Nombre+'&Institucion='+Institucion+'&Monto='+Monto+'&Vencimiento='+Vencimiento+'&UsuarioID='+Usuario,
                success: function()
                {
                	$('#ModalPasivoContingente').modal("hide");
                	ActualizarTablaPasivoContingente();
                	ActualizarNoPasivoContingente();
                	document.getElementById("PasivoContingenteFORM").reset();
                    alertify.success('Se ingresó la información exitósamente');
                },
                error: function(opt)
                {
                	$('#ModalPasivoContingente').modal("hide");
                	alertify.error('Algo salió mal');
                }
            })
        }
        function HabilitarHijos(x)
        {
        	if(x == 1)
        	{
                $('#FechaNacimiento').attr('required', 'required');
                $('#Vive').attr('required', 'required');
        		document.getElementById('ViveConUsted').style.display = 'block';
        		document.getElementById('FechaNacimientoHijo').style.display = 'block';
        	}
        	else
        	{
                $('#FechaNacimiento').removeAttr('required');
                $('#Vive').removeAttr('required');
        		document.getElementById('ViveConUsted').style.display = 'none';
        		document.getElementById('FechaNacimientoHijo').style.display = 'none';
        		document.getElementById('DireccionHijo').style.display = 'none';
        	}
        }
        function HabilitarDireccionHijo(x)
        {
        	if(x == 2)
        	{
                $('#DireccionHijo').attr('required', 'required');
        		document.getElementById('DireccionHijo').style.display = 'block';
        	}
        	else
        	{
                $('#DireccionHijo').removeAttr('required');
        		document.getElementById('DireccionHijo').style.display = 'none';
        	}
        }

    	$(document).ready(function(){
    		$('[data-toggle="popover"]').popover();
    	});
    	$(document).ready(function(){
    		ActualizarTablaParentesco();
    		ActualizarTablaOrganizaciones();
    		ActualizarTablaPasivoContingente();
    		ActualizarNoParentescos();
    		ActualizarNoOrganizaciones();
    		ActualizarNoPasivoContingente();
    	});

		$(document).ready(function() {
		    //Al escribr dentro del input con id="service"
		    $('#Nombre').change(function(){
		        //Obtenemos el value del input
		        var service = $(this).val();
		        var dataString = 'service='+service;

		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscar.php",
		            data: dataString,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../Imagenes/screens-preloader.gif" />');
		            },
		            success: function(data) {
		            	if(data == '')
		            	{
		            		alertify.error('No se encontró ningún registro');
		            		$('#suggestions').html('');
		            	}
		            	else
		            	{
			                //Escribimos las sugerencias que nos manda la consulta
			                $('#suggestions').fadeIn(1000).html(data);
			                //Al hacer click en algua de las sugerencias
			                $('.suggest-element').click(function(){
			                    $('#CIF').val($(this).attr('id'));
			                    $('#Nombre').val($(this).attr('data'));
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(1000);
			                });
		            	}
		            }
		        });
		    });
		});

$(document).ready(function() {
            //Al escribr dentro del input con id="service"
            $('#NombreEditar').change(function(){
                //Obtenemos el value del input
                var service = $(this).val();
                var dataString = 'service='+service;

                //Le pasamos el valor del input al ajax
                $.ajax({
                    type: "POST",
                    url: "buscar.php",
                    data: dataString,
                    beforeSend: function()
                    {
                        $('#suggestionsEditar').html('<img src="../Imagenes/screens-preloader.gif" />');
                    },
                    success: function(data) {
                        if(data == '')
                        {
                            alertify.error('No se encontró ningún registro');
                            $('#suggestionsEditar').html('');
                        }
                        else
                        {
                            //Escribimos las sugerencias que nos manda la consulta
                            $('#suggestionsEditar').fadeIn(1000).html(data);
                            //Al hacer click en algua de las sugerencias
                            $('.suggest-element').click(function(){
                                $('#CIFEditar').val($(this).attr('id'));
                                $('#NombreEditar').val($(this).attr('data'));
                                //Hacemos desaparecer el resto de sugerencias
                                $('#suggestionsEditar').fadeOut(1000);
                            });
                        }
                    }
                });
            });
        });
        function LevantarModal()
        {
            if($('#Error').val() == 0)
            {
                $('#ModalAvisoActualizar').modal('show');
            }
             
        }
        function HabilitarTipoPersona(x)
        {
            if(x.value == 1)
            {   
                $('#CIF').attr('required', 'required');
                $('#NombreNoAsociado').removeAttr('required');
                $('#DIVTipoPersonaAsociado').show();
                $('#DIVTipoPersonaNoAsociado').hide();
            }
            else
            {
                $('#CIF').removeAttr('required');
                $('#NombreNoAsociado').attr('required', 'required');
                $('#DIVTipoPersonaAsociado').hide();
                $('#DIVTipoPersonaNoAsociado').show();
            }
        }
        function GuardarAntes()
        {
            $('#FormaGrabar').val(2);
            $('#FormGrabarDatos').submit();
        }
		</script>

    <style>
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


    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8899-1">

</head>

<body style="background-color: #FFFFFF" onload="LevantarModal()">
    <?php include("../../../../MenuTop.php") ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title" align="center">
				<h3><strong>Información Colaboradores</strong></h3>
			</div>
		</div>
		<div class="panel-body">
			<form  role="form" method="POST" action="Grabar.php" enctype="multipart/form-data" id="FormGrabarDatos">
                <input type="hidden" id="FormaGrabar" name="FormaGrabar" value="1">
				<input type="hidden" id="cuenta_llevar" name="cuenta_llevar" value="<?php echo $UserID; ?>">
				<div class="form-group">
					<label for="tipo_documento" class="col-lg-3 control-label">Tipo Documento</label>
					<div class="col-lg-3" align="left">
						<select name="tipo_documento" id="tipo_documento" class="form-control" required>
							<?php
								$query = "SELECT * FROM Estado_Patrimonial.tipodocumento WHERE id <> 1 ORDER BY tipodocumentoidentificacion";
								$result = mysqli_query($db, $query);
								while($fila = mysqli_fetch_array($result))
								{
									if($fila["id"] == $TipoIdentificacion)
									{
										$Seleccionado = 'selected';
									}
									else
									{
										$Seleccionado = '';
									}
									echo '<option value="'.$fila["id"].'" '.$Seleccionado.'>'.$fila["tipodocumentoidentificacion"].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="no_identificacion" class="col-lg-3 control-label" align="right">No. Documento Identificación</label>
					<div class="col-lg-3" align="left" >
						<input type="number" min="0" size="25" class="form-control" name="no_identificacion" value="<?php echo $NoIdentificacion; ?>" id="no_identificacion" required>
					</div>
				</div>
				<div class="form-group">
					<label for="ext" class="col-lg-3 control-label">Extendida En</label>
					<div class="col-lg-9" align="left" >
						<input type="text" size="25" class="form-control" name="ext" id="ext" value="<?php echo $DocumentoExtendido; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="ext" class="col-lg-3 control-label">País de Origen</label>
					<div class="col-lg-3" align="left" >
						<select name="pais" id="pais" class="form-control">
							<?php
								$query = "SELECT * FROM Estado_Patrimonial.paises ORDER BY nombrepais";
								$result = mysqli_query($db, $query);
								while($fila = mysqli_fetch_array($result))
								{
									if($fila["id"] == $PaisOrigen)
									{
										$Seleccionado = 'selected';
									}
									else
									{
										$Seleccionado = '';
									}
									echo '<option value="'.$fila["id"].'" '.$Seleccionado.'>'.$fila["nombrepais"].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="region" class="col-lg-3 control-label" align="right">Departamento</label>
					<div class="col-lg-3" align="left" >
						<select name="region" id="region" class="form-control" onchange="ObtenerMunicipios(this.value)">
							<?php
								$query = "SELECT * FROM info_base.departamentos_guatemala ORDER BY nombre_departamento";
								$result = mysqli_query($db, $query);
								while($fila = mysqli_fetch_array($result))
								{
									if($fila["id_departamento"] == $Departamento)
									{
										$Seleccionado = 'selected';
									}
									else
									{
										$Seleccionado = '';
									}
									echo '<option value="'.$fila["id_departamento"].'" '.$Seleccionado.'>'.utf8_encode($fila["nombre_departamento"]).'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="country" class="col-lg-3 control-label">Municipio</label>
					<div class="col-lg-9" align="left" >
						<select name="country" id="country" class="form-control">
                            <option value="" disabled selected>Seleccione un Municipio</option>}
                            option
							<?php
                                $consulta = "SELECT id, nombre_municipio FROM info_base.municipios_guatemala WHERE id_departamento = ".$Departamento;
                                $result1 = mysqli_query($db, $consulta);
                                while($fila = mysqli_fetch_array($result1))
                                {
                                    if($fila["id"] == $LugarNacimiento)
                                    {
                                        $Seleccionado = 'selected';
                                    }
                                    else
                                    {
                                        $Seleccionado = '';
                                    }
                                    echo '<option value="'.$fila["id"].'" '.$Seleccionado.'>'.$fila["nombre_municipio"].'</option>';
                                }
                            ?>
						<select>
					</div>
				</div>
				<div class="form-group">
					<label for="fecha_nacimiento" class="col-lg-3 control-label">Fecha Nacimiento</label>
					<div class="col-lg-9" align="left" >
						<input type="date" size="25" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $FechaNacimiento; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="nit" class="col-lg-3 control-label">NIT</label>
					<div class="col-lg-9" align="left" >
						<input type="text" size="25" class="form-control" name="nit" id="nit" value="<?php echo $Nit; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="nombre1" class="col-lg-3 control-label">Primer Nombre</label>
					<div class="col-lg-3" align="left" >
						<input type="text" size="25" class="form-control" name="nombre1" id="nombre1" value="<?php echo $Nombre1; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="nombre2" class="col-lg-3 control-label" align="right">Segundo Nombre</label>
					<div class="col-lg-3" align="left" >
						<input type="text" size="25" class="form-control" name="nombre2" id="nombre2" value="<?php echo $Nombre2; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="nombre3" class="col-lg-3 control-label">Tercer Nombre</label>
					<div class="col-lg-3" align="left" >
						<input type="text" size="25" class="form-control" name="nombre3" id="nombre3" value="<?php echo $Nombre3; ?>" >
					</div>
				</div>
				<div class="form-group">
					<label for="apellido1" class="col-lg-3 control-label" align="right">Primer Apellido</label>
					<div class="col-lg-3" align="left" >
						<input type="text" size="25" class="form-control" name="apellido1" id="apellido1" value="<?php echo $Apellido1; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="apellido2" class="col-lg-3 control-label">Segundo Apellido</label>
					<div class="col-lg-3" align="left" >
						<input type="text" size="25" class="form-control" name="apellido2" id="apellido2" value="<?php echo $Apellido2; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="apellidocasada" class="col-lg-3 control-label" align="right">Apellido Casada</label>
					<div class="col-lg-3" align="left" >
						<input type="text" size="25" class="form-control" name="apellidocasada" id="apellidocasada" value="<?php echo $ApellidoCasada; ?>" >
					</div>
				</div>
                <div class="form-group">
                    <label for="TipoSangre" class="col-lg-3 control-label">Tipo de Sangre</label>
                    <div class="col-lg-9" align="left" >
                        <select name="TipoSangre" id="TipoSangre" class="form-control">
                            <option value="AB+" <?php if($TipoSangre == 'AB+'){echo 'selected';} ?>>AB+</option>
                            <option value="AB-" <?php if($TipoSangre == 'AB-'){echo 'selected';} ?>>AB-</option>
                            <option value="A+" <?php if($TipoSangre == 'A+'){echo 'selected';} ?>>A+</option>
                            <option value="A-" <?php if($TipoSangre == 'A-'){echo 'selected';} ?>>A-</option>
                            <option value="B+" <?php if($TipoSangre == 'B+'){echo 'selected';} ?>>B+</option>
                            <option value="B-" <?php if($TipoSangre == 'B-'){echo 'selected';} ?>>B-</option>
                            <option value="O+" <?php if($TipoSangre == 'O+'){echo 'selected';} ?>>O+</option>
                            <option value="O-" <?php if($TipoSangre == 'O-'){echo 'selected';} ?>>O-</option>
                        </select>
                    </div>
                </div>
				<div class="form-group">
					<label for="estado_civil" class="col-lg-3 control-label">Estado Civil</label>
					<div class="col-lg-9" align="left" >
						<select name="estado_civil" id="estado_civil" class="form-control" required>
						<?php
							echo '<option value="'.$EstadoCivil.'" selected>'.$estado_civil_nombre.'</option>';
						?>
							<option value="" disabled>Seleccione una Opción</option>
							<option value="0">Soltero(a)</option>
							<option value="1">Casado(a)/Unido(a)</option>
							<option value="2">Viudo(a)</option>
							<option value="3">Divorciado(a)</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="igss" class="col-lg-3 control-label">No. Afiliación al IGSS</label>
					<div class="col-lg-9" align="left" >
						<input type="text" size="25" class="form-control" name="igss" id="igss" value="<?php echo $Igss; ?>" >
					</div>
				</div>
				<div class="form-group">
					<label for="sexo" class="col-lg-3 control-label">Sexo</label>
					<div class="col-lg-9" align="left" >
						<select name="sexo" id="sexo" class="form-control" required>
						<?php
							if($Sexo == 'M')
							{
								$NombreSexo = 'Masculino';
							}
							else
							{
								$NombreSexo = 'Femenino';
							}
							echo '<option value="'.$Sexo.'">'.$NombreSexo.'</option>';
						?>
							<option value="" disabled>Seleccione una Opción</option>
							<option value="M">Masculino</option>
							<option value="F">Femenino</option>
						</select>
					</div>
				</div>
				<div class="form-group" style="display: none">
					<label for="puesto_origen" class="col-lg-3 control-label">Puesto</label>
					<div class="col-lg-9" align="left" >
						<input type="text" size="75" class="form-control" name="profesion" id="profesion" value="<?php echo utf8_encode(saber_puesto($UserID)); ?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="profesion" class="col-lg-3 control-label">Profesión</label>
					<div class="col-lg-9" align="left" >
						<input type="text" size="75" class="form-control" name="profesion" id="profesion" value="<?php echo $Profesion; ?>" >
					</div>
				</div>
				<div class="form-group">
					<label for="nivel_academico" class="col-lg-3 control-label">Nivel Académico</label>
					<div class="col-lg-9" align="left" >
						<select name="nivel_academico" id="nivel_academico" class="form-control">
							<?php
								$query = "SELECT * FROM Estado_Patrimonial.nivelacademico ORDER BY nivelacademico";
								$result = mysqli_query($db, $query);
								while($fila = mysqli_fetch_array($result))
								{
									if($fila["id"] == $NivelAcademico)
									{
										$Seleccionado = 'selected';
									}
									else
									{
										$Seleccionado = '';
									}
									echo '<option value="'.$fila["id"].'" '.$Seleccionado.'>'.$fila["nivelacademico"].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="etnia" class="col-lg-3 control-label">Etnia</label>
					<div class="col-lg-3" align="left" >
						<select name="etnia" id="etnia" class="form-control">
							<?php
								$query = "SELECT * FROM Estado_Patrimonial.etnia ORDER BY etnia";
								$result = mysqli_query($db, $query);
								while($fila = mysqli_fetch_array($result))
								{
									if($fila["id"] == $Etnia)
									{
										$Seleccionado = 'selected';
									}
									else
									{
										$Seleccionado = '';
									}
									echo '<option value="'.$fila["id"].'" '.$Seleccionado.'>'.$fila["etnia"].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="idiomas" class="col-lg-3 control-label" align="right">Idioma</label>
					<div class="col-lg-3" align="left" >
						<select name="idiomas" id="idiomas" class="form-control" >
							<?php
								$query = "SELECT * FROM Estado_Patrimonial.idiomas ORDER BY idioma";
								$result = mysqli_query($db, $query);
								while($fila = mysqli_fetch_array($result))
								{
									if($fila["id"] == $Idiomas)
									{
										$Seleccionado = 'selected';
									}
									else
									{
										$Seleccionado = '';
									}
									echo '<option value="'.$fila["id"].'" '.$Seleccionado.'>'.utf8_encode($fila["idioma"]).'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="direccion" class="col-lg-3 control-label">Dirección</label>
					<div class="col-lg-9" align="left" >
						<textarea name="direccion" id="direccion" cols="75" rows="5" class="form-control" required><?php echo $Direccion; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="telefono" class="col-lg-3 control-label">Teléfono</label>
					<div class="col-lg-9" align="left" >
						<input type="number" min="0" size="10" class="form-control" name="telefono" id="telefono" value="<?php echo $Telefono; ?>" >
					</div>
				</div>
				<div class="form-group">
					<label for="celular" class="col-lg-3 control-label">Celular</label>
					<div class="col-lg-9" align="left" >
						<input type="number" min="0" size="10" class="form-control" name="celular" id="celular" value="<?php echo $Celular; ?>" required>
					</div>
				</div>
				<div class="form-group">
					<label for="correo_electronico" class="col-lg-3 control-label">Correo Electrónico</label>
					<div class="col-lg-9" align="left" >
						<input type="email" size="50" class="form-control" name="correo_electronico" id="correo_electronico" value="<?php echo $Email; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="parentescos" class="col-lg-3 control-label">Parentescos</label>
					<div class="col-lg-3">
						<div class="input-group">
							<input type="text" class="form-control" id="parentescos" name="parentescos" readonly>
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalParentescos">Agregar</button>
								<button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalDetalleParentescos" id="BtnConsParentescos">Consultar</button>
							</span>
						</div>
					</div>
					<div class="col-lg-6"></div>
				</div>
                <div class="row"><br></div>
				<div class="form-group">
					<label for="parentescos2" class="col-lg-3 control-label">Organizaciones Civiles</label>
					<div class="col-lg-3">
						<div class="input-group">
							<input type="text" class="form-control" id="parentescos2" name="parentescos2" readonly>
							<span class="input-group-btn">
							<button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalOroganizaciones">Agregar</button>
							<button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalDetalleOrganizaciones" id="BtnConsOrganizaciones">Consultar</button>
							</span>
						</div>
					</div>
					<div class="col-lg-6"></div>
				</div>

                <div class="row"><br></div>
				<div class="form-group">
					<label for="propiedad_inmueble" class="col-lg-3 control-label">Propiedad del Inmueble</label>
					<div class="col-lg-9" align="left" >
						<select name="propiedad_inmueble" id="propiedad_inmueble" class="form-control" required onchange="VerificarPropiedad(this.value)">
							<?php
								echo '<option value="'.$Propiedad.'" selected>'.$Propiedad.'</option>';
							?>
							<option value="" disabled>Seleccione una Opción</option>
							<option value="Alquila">Alquila</option>
							<option value="Propio">Propio</option>
							<option value="Otros">Otros</option>
						</select>
					</div>
				</div>
				<div class="form-group" style="display: none" id="DivPropiedad">
					<label for="observaciones_adicionales" class="col-lg-3 control-label">Especifique</label>
					<div class="col-lg-9" align="left" >
						<textarea name="observaciones_adicionales" id="observaciones_adicionales" cols="75" rows="5" class="form-control"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="parentescos3" class="col-lg-3 control-label">Pasivo Contingente</label>
					<div class="col-lg-3">
						<div class="input-group">
							<input type="text" class="form-control" id="parentescos3" name="parentescos3" readonly>
							<span class="input-group-btn">
							<button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalPasivoContingente">Agregar</button>
							<button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalDetallePasivoContingente" id="BtnConsPasivoContingente">Consultar</button>
							</span>
						</div>
					</div>
					<div class="col-lg-6"> </div>
				</div>

                <div class="row"><br></div>
                <?php if($NumeroFotografia1 == 0)
                {
                    ?>
                        <div class="form-group">
                            <label for="FotoCedula" class="col-lg-3 control-label">Fotografía Tipo Cédula</label>
                            <div class="col-lg-9">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="FotoCedula" name="FotoCedula" accept="image/*">
                                </div>
                            </div>
                        </div>
                    <?php
                }
                else
                {
                    ?>
                        <div class="form-group">
                            <label for="FotoCedula" class="col-lg-3 control-label">Fotografía Tipo Cédula</label>
                            <div class="col-lg-9">
                                <a href="<?php echo $RutaFotografia1 ?>" target="_blank"><img src="<?php echo $RutaFotografia1 ?>" alt=""  class="img-thumbnail" width="200" height="100"></a>
                                <a href="EliminarFotografia.php?ID=<?php echo $IDFotografia1; ?>"><button type="button" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button></a>
                            </div>
                        </div>
                    <?php
                }
                ?>
                <?php if($NumeroFotografia2 == 0)
                {
                    ?>
                        <div class="form-group">
                            <label for="FotoCuerpoCompleto" class="col-lg-3 control-label">Fotografía Cuerpo Completo</label>
                            <div class="col-lg-9">
                                <div class="input-group" align="left">
                                    <input type="file" class="form-control" id="FotoCuerpoCompleto" name="FotoCuerpoCompleto" accept="image/*">
                                </div>
                            </div>
                        </div>
                    <?php
                }
                else
                {
                    ?>
                        <div class="form-group">
                            <label for="FotoCedula" class="col-lg-3 control-label">Fotografía Cuerpo Completo</label>
                            <div class="col-lg-9">
                                <a href="<?php echo $RutaFotografia2 ?>" target="_blank"><img src="<?php echo $RutaFotografia2 ?>" alt="" class="img-thumbnail" width="200" height="100"></a>
                                <a href="EliminarFotografia.php?ID=<?php echo $IDFotografia2; ?>"><button type="button" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button></a>
                            </div>
                        </div>
                    <?php
                }
                ?>
				<div align="center" class="form-group col-lg-12">
					<br>
					<button type="submit" class="btn btn-lg btn-primary">Actualizar</button>
				</div>
			</form>
		</div>
		<div class="panel-footer">
			<div class="content" align="center">
				<a href="menu.php"><button type="button" class="btn btn-info btn-lg">
					<span class="glyphicon glyphicon-arrow-left"></span> Anterior
				</button></a>
				<button type="button" class="btn btn-success btn-lg" onclick="GuardarAntes()">
					Siguiente <span class="glyphicon glyphicon-arrow-right"></span>
				</button>
			</div>
		</div>
	</div>

	<!-- Modal Ingreso de Parentescos -->
        <div id="ModalParentescos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Datos Familiares</h2>
                        <h3 class="modal-title"><small>Núcleo Familiar</small></h3>
                    </div>
                    <div class="modal-body">
	                    <form class="form-horizontal" role="form" id="ParentescosFORM">
                            <div class="form-group">
                                <label for="TipoPersonaParentesco" class="col-lg-3 control-label">¿Su familiar es asociado?</label>
                                <div class="col-lg-9">
                                    <select name="TipoPersona" id="TipoPersonaParentesco" class="form-control" onChange="HabilitarTipoPersona(this)">
                                        <option value="" disabled selected>Elige una opción</option>
                                        <option value="1">Sí</option>
                                        <option value="2">No</option>
                                    </select>
                                </div>
                            </div>
                            <div id="DIVTipoPersonaAsociado" style="display: none">
    	                    	<div class="form-group">
    								<label for="CIF" class="col-lg-3 control-label">CIF</label>
    								<div class="col-lg-9" align="left" >
    									<input type="tel" size="10" class="form-control" name="CIF" id="CIF" onchange="BusquedaCIF(this.value)" title="Ayuda" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Si no conoce el CIF de la persona, puede realizar su búsqueda por medio del nombre, en el campo de abajo.">
    									<span class="help-block text-left">Búsqueda por CIF</span>
    								</div>
    							</div>
    							<div class="form-group">
    								<label for="Nombre" class="col-lg-3 control-label">Nombre</label>
    								<div class="col-lg-9" align="left" >
    									<input type="tel" size="75" class="form-control" name="Nombre" id="Nombre" title="Ayuda" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Su búsqueda puede ser por nombres o apellidos, respetando el orden de los mismos (apellidos,nombres). ">
    									<div id="suggestions"></div>
    									<span class="help-block text-left">Búsqueda por nombre</span>
    								</div>
    							</div>
                            </div>
                            <div id="DIVTipoPersonaNoAsociado" style="display: none">
                                <div class="form-group">
                                    <label for="NombreNoAsociado" class="col-lg-3 control-label">Nombre</label>
                                    <div class="col-lg-9" align="left" >
                                        <input type="tel" size="75" class="form-control" name="NombreNoAsociado" id="NombreNoAsociado" >
                                    </div>
                                </div>
                            </div>
							<div class="form-group">
								<label for="a_parentesco" class="col-lg-3 control-label">Parentesco</label>
								<div class="col-lg-9">
									<select name="parentesco" id="a_parentesco" class="form-control" onChange="HabilitarHijos(this.value)">
								        <option value="" disabled selected>Elige una opción</option>
								        <option value="1">Hijo / Hija</option>
								        <option value="2">Padre / Madre</option>
								        <option value="3">Hermano / Hermana</option>
								        <option value="4">Nieto / Nieta</option>
								        <option value="5">Abuelo / Abuela</option>
								        <option value="6">Suegro / Suegra</option>
								        <option value="7">Yerno / Nuera</option>
								        <option value="8">Cuñado / Cuñada</option>
								        <option value="9">Cónyuge</option>
                                        <option value="10">Tio/Tia</option>
                                        <option value="11">Sobrino/Sobrina</option>
                                        <option value="12">Biznieto/Biznieta</option>
                                        <option value="13">Bisabuela/Bisabuelo</option>
                                        <option value="14">Primo / Prima</option>
							        </select>
								</div>
							</div>
							<div class="form-group" id="FechaNacimientoHijo" style="display: none">
								<label for="FechaNacimiento" class="col-lg-3 control-label">Fecha Nacimiento</label>
								<div class="col-lg-9" align="left" >
									<input type="date" class="form-control" name="FechaNacimiento" id="FechaNacimiento">
								</div>
							</div>
							<div class="form-group" id="ViveConUsted" style="display: none">
								<label for="Vive" class="col-lg-3 control-label">Vive con usted?</label>
								<div class="col-lg-9" align="left" >
									<select name="Vive" id="Vive" class="form-control" onChange="HabilitarDireccionHijo(this.value)">
								        <option value="" disabled selected>Elige una opción</option>
								        <option value="1">Si</option>
								        <option value="2">No</option>
							        </select>
								</div>
							</div>
							<div class="form-group" id="DireccionHijo" style="display: none">
								<label for="DireccionHijo" class="col-lg-3 control-label">Dirección</label>
								<div class="col-lg-9" align="left" >
									<textarea name="DireccionHijo" id="DireccionHijo" cols="75" rows="5" class="form-control" ></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="dependiente" class="col-lg-3 control-label">Depende de usted?</label>
								<div class="col-lg-9" align="left" >
									<select name="dependiente" id="dependiente" class="form-control">
								        <option value="" disabled selected>Elige una opción</option>
								        <option value="1">Si</option>
								        <option value="2">No</option>
							        </select>
								</div>
							</div>
							<div class="form-group">
								<label for="OcupacionParentesco" class="col-lg-3 control-label">Ocupación</label>
								<div class="col-lg-9" align="left" >
									<input type="text" size="75" class="form-control" name="OcupacionParentesco" id="OcupacionParentesco">
								</div>
							</div>
							<div id="resultado"></div>
	                    </form>
                    </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
	                		<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
	                	</button>
	                	<button type="button" class="btn btn-primary btn-md" onClick="IngresarParentesco()">
	                		<span class="glyphicon glyphicon-ok"></span> Guardar
	                	</button>
	                </div>
                </div>
            </div>
        </div>
        <!-- /Modal Ingreso de Parentescos -->

        <!-- Modal Organizaciones -->
        <div id="ModalOroganizaciones" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Participación en Organizaciones Civiles</h2>
                    </div>
                    <div class="modal-body">
                    	<form class="form-horizontal" role="form" id="OrganizacionesFORM">
	                    	<div class="form-group">
	                    		<label for="Organizaciones" class="col-lg-3 control-label">Tipo de Organización</label>
	                    		<div class="col-lg-9" align="left" >
	                    			<select name="Organizaciones" id="Organizaciones" class="form-control" >
	                    			<option value="" disabled selected>Seleccione una Opción</option>
	                    				<option value="Consejos Comunitarios de Desarrollo (COCODE)">Consejos Comunitarios de Desarrollo (COCODE)</option>
	                    				<option value="Consejos Municipales de Desarrollo (COMUDE)">Consejos Municipales de Desarrollo (COMUDE)</option>
	                    				<option value="Consejos Departamentales de Desarrollo (CODEDE)">Consejos Departamentales de Desarrollo (CODEDE)</option>
	                    				<option value="Cooperativas">Cooperativas</option>
	                    				<option value="Asociones No Lucrativas">Asociones No Lucrativas</option>
	                    				<option value="Organizaciones No Gubernamentales (ONG)">Organizaciones No Gubernamentales (ONG)</option>
	                    				<option value="Comite">Comités</option>
	                    				<option value="Patronato">Patronato</option>
	                    				<option value="Congregación">Congregación</option>
	                    				<option value="Mesa">Mesa</option>
	                    				<option value="Instancia">Instancia</option>
	                    				<option value="Junta">Junta</option>
	                    				<option value="Grupo">Grupo</option>
	                    				<option value="Fundaciones">Fundaciones</option>
	                    				<option value="Comunidades y Pueblos Indígenas">Comunidades y Pueblos Indígenas</option>
	                    				<option value="Sindicatos">Sindicatos</option>
									</select>
	                    		</div>
	                    	</div>
	                    	<div class="form-group">
								<label for="NombreOrganizacion" class="col-lg-3 control-label">Nombre de la Organización</label>
								<div class="col-lg-9" align="left" >
									<input type="text" size="75" class="form-control" name="NombreOrganizacion" id="NombreOrganizacion"  required>
									<div id="suggestions"></div>
								</div>
							</div>
							<div class="form-group">
								<label for="CargoOrganizacion" class="col-lg-3 control-label">Cargo</label>
								<div class="col-lg-9" align="left" >
									<input type="text" size="50" class="form-control" name="CargoOrganizacion" id="CargoOrganizacion"  required>
									<div id="suggestions"></div>
								</div>
							</div>
							<div class="form-group">
								<label for="FechaIngresoOrganizacion" class="col-lg-3 control-label">Fecha de Ingreso</label>
								<div class="col-lg-9" align="left" >
									<input type="date" class="form-control" name="FechaIngresoOrganizacion" id="FechaIngresoOrganizacion"  required>
									<div id="suggestions"></div>
								</div>
							</div>
	                    </form>
                    </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
	                		<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
	                	</button>
	                	<button type="button" class="btn btn-primary btn-md" onClick="IngresarOrganizaciones()">
	                		<span class="glyphicon glyphicon-ok"></span> Guardar
	                	</button>
	                </div>
                </div>
            </div>
        </div>
        <!-- /Modal Organizaciones -->

        <!-- Modal Pasivo Contingente -->
        <div id="ModalPasivoContingente" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Pasivo Contingente</h2>
                    </div>
                    <div class="modal-body">
                    	<form class="form-horizontal" role="form" id="PasivoContingenteFORM">
	                    	<div class="form-group">
								<label for="NombreFCA" class="col-lg-3 control-label">Fiador, Codeudor Avalista de</label>
								<div class="col-lg-9" align="left" >
									<input type="text" size="75" class="form-control" name="NombreFCA" id="NombreFCA"  required>
									<div id="suggestions"></div>
								</div>
							</div>
							<div class="form-group">
								<label for="Institucion" class="col-lg-3 control-label">Institución</label>
								<div class="col-lg-9" align="left" >
									<input type="text" size="50" class="form-control" name="Institucion" id="Institucion"  required>
									<div id="suggestions"></div>
								</div>
							</div>
							<div class="form-group">
								<label for="Monto" class="col-lg-3 control-label">Monto</label>
								<div class="col-lg-9" align="left" >
									<input type="text" size="50" class="form-control" name="Monto" id="Monto"  required>
									<div id="suggestions"></div>
								</div>
							</div>
							<div class="form-group">
								<label for="Vencimiento" class="col-lg-3 control-label">Vencimiento</label>
								<div class="col-lg-9" align="left" >
									<input type="date" class="form-control" name="Vencimiento" id="Vencimiento"  required>
									<div id="suggestions"></div>
								</div>
							</div>
	                    </form>
                    </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
	                		<span class="glyphicon glyphicon-ban-circle"></span> Cancelar
	                	</button>
	                	<button type="button" class="btn btn-primary btn-md" onClick="IngresarPasivoContingente()">
	                		<span class="glyphicon glyphicon-ok"></span> Guardar
	                	</button>
	                </div>
                </div>
            </div>
        </div>
        <!-- /Modal Pasivo Contingente -->

        <!-- Modal Detalle de Parentescos -->
        <div id="ModalDetalleParentescos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Parentescos</h2>
                    </div>
                    <div class="modal-body">
                    	<table class="table table-hover table-condensed" >
                    	<thead>
                    		<tr>
                    			<th><h6><strong>CIF</strong></h6></th>
                    			<th><h6><strong>Nombre</strong></h6></th>
                    			<th><h6><strong>Parentesco</strong></h6></th>
                    			<th><h6><strong>Grado de Consanguinidad</strong></h6></th>
                    			<th><h6><strong>Fecha Nacimiento</strong></h6></th>
                    			<th><h6><strong>Vive con Usted</strong></h6></th>
                    			<th><h6><strong>Dirección</strong></h6></th>
                    			<th><h6><strong>Depende de Usted</strong></h6></th>
                    			<th><h6><strong>Ocupación</strong></h6></th>
                    		</tr>
                    	</thead>
                    	<tbody id="tablaDetalleParentescos">
                    	</tbody>
	                   	</table>
                    </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
	                		<span class="glyphicon glyphicon-ban-circle"></span> Cerrar
	                	</button>
	                </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle de Parentescos -->

        <!-- Modal Detalle Organizaciones -->
        <div id="ModalDetalleOrganizaciones" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Organizaciones Civiles</h2>
                    </div>
                    <div class="modal-body">
                    	<table class="table table-hover table-condensed" >
                    	<thead>
                    		<tr>
                    			<th><h6><strong>Tipo de Organización</strong></h6></th>
                    			<th><h6><strong>Nombre</strong></h6></th>
                    			<th><h6><strong>Cargo</strong></h6></th>
                    			<th><h6><strong>Fecha de Ingreso</strong></h6></th>
                    		</tr>
                    	</thead>
                    	<tbody id="tablaDetalleOrganizaciones">
                    	</tbody>
	                   	</table>
                    </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
	                		<span class="glyphicon glyphicon-ban-circle"></span> Cerrar
	                	</button>
	                </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Organizaciones -->

        <!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalDetallePasivoContingente" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Pasivo Contingente</h2>
                    </div>
                    <div class="modal-body">
                    	<table class="table table-hover table-condensed" >
                    	<thead>
                    		<tr>
                    			<th><h6><strong>Fiador de</strong></h6></th>
                    			<th><h6><strong>Institución</strong></h6></th>
                    			<th><h6><strong>Monto</strong></h6></th>
                    			<th><h6><strong>Fecha de Vencimiento</strong></h6></th>
                    		</tr>
                    	</thead>
                    	<tbody id="tablaDetallePasivoContingente">
                    	</tbody>
	                   	</table>
                    </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
	                		<span class="glyphicon glyphicon-ban-circle"></span> Cerrar
	                	</button>
	                </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

        <!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalAvisoActualizar" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 40%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Alerta!</h2>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger text-center">Necesitas actualizar tu información</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

</body>

</html>
