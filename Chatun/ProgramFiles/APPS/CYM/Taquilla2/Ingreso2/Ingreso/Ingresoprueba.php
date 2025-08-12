<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$QueryLimpieza = mysqli_query($db, "DELETE FROM Taquilla.INGRESO_ASOCIADO_TEMPORAL WHERE IAT_CIF_COLABORADOR = ".$id_user);
$QueryLimpieza1 = mysqli_query($db, "DELETE FROM Taquilla.INGRESO_ACOMPANIANTE_TEMPORAL WHERE IAT_CIF_COLABORADOR = ".$id_user);

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

	<style type="text/css">
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
        function verAsociadosFormacion()
        { 

            if($('.verDatos').attr('checked'))
            {
                $('#CamposAsociadosFormacion').show();
            }
            else
            {
                $('#CamposAsociadosFormacion').hide();
            }
        }

        function guardarAsociadosFormacion()
        {
            var NombreEvento = $("#NombreEventoA").val();
            var programaActivo = $("#programaActivo").val();
            var tipoEvento = $("#tipoEventoA").val();
            var duenoEvento = $("#duenoEventoA").val();
            var noParticipantes = $("#noParticipantes").val();
            var clasificadorEvento = $("#clasificadorEventoA").val();
            var nomEmpresa = $("#nomEmpresaA").val();
            var areaUtilizada = $("#areaUtilizadaA").val();
            var telEmpresa = $("#telEmpresaA").val();
            var procedenciaEvento = $("#procedenciaEventoA").val();
            var fechaFormacion = $("#fechaFormacion").val();
            var procedenciaPais = $("#procedenciaPais").val();
            var otrosPaises = $("#otrosPaises").prop('checked');
            $.ajax({
                url: 'Ajax/GuardarAcosiadosFormacion.php',
                type: 'POST',
                dataType: 'html',
                data: {NombreEvento: NombreEvento,
                        programaActivo: programaActivo,
                        tipoEvento: tipoEvento,
                        duenoEvento: duenoEvento,
                        noParticipantes: noParticipantes,
                        clasificadorEvento: clasificadorEvento,
                        nomEmpresa: nomEmpresa,
                        areaUtilizada: areaUtilizada,
                        telEmpresa: telEmpresa,
                        procedenciaEvento: procedenciaEvento,
                        fechaFormacion: fechaFormacion, otrosPaises:otrosPaises, procedenciaPais: procedenciaPais},
                success: function(data)
                {
                    if (data==1) 
                    {
                        alert("Se ha almacenado correctamente"); 
                        $('#ModalBusquedaAsociados').modal('hide');
                        location.reload();

                    }
                    else if(data==2)
                    {
                    	alertify.error("Ya Existe Un Evento con esos datos revise listado");
                    }
					else
                    {
                    	alertify.error("Ha ocurrido un error");
                    }
                }
            })           
        }
    	function TipoPersona(x)
    	{
    		if(x == 1)
    		{
    			$('#CARDAsociado').addClass('card-outlined style-primary');
    			$('#CARDNoAsociado').removeClass('card-outlined style-primary');
    			$('#CriterioBusqueda').val('');
    			$('#ResultadoBusquedaAsociado').html('');
    			$('#ModalBusquedaAsociados').modal('show');
    			$('#CriterioBusqueda').focus();
    			$('#DIVNoAsociados').hide();
                $('#DIVReferenciacion').hide();
    		}
    		else if(x == 2)
    		{
    			$('#CARDAsociado').removeClass('card-outlined style-primary');
    			$('#CARDNoAsociado').addClass('card-outlined style-primary');
    			$('#CriterioBusqueda').val('');
    			$('#ResultadoBusquedaAsociado').html('');
    			$('#ModalBusquedaAsociados').modal('hide');
    			$('#DIVNoAsociados').show();
    			$('#DIVAsociados').hide();
    			$('#NombreNoAsociado').focus();
                $('#DIVReferenciacion').hide();
    		}
            else
            {
                $('#CARDAsociado').removeClass('card-outlined style-primary');
                $('#CARDNoAsociado').removeClass('card-outlined style-primary');
                $('#CARDReferenciacion').addClass('card-outlined style-primary');
                $('#CriterioBusqueda').val('');
                $('#ResultadoBusquedaAsociado').html('');
                $('#ModalBusquedaAsociados').modal('hide');
                $('#DIVNoAsociados').hide();
                $('#DIVAsociados').hide();
                $('#DIVReferenciacion').show();
            }
    	}
    	function BusquedaAsociado(x)
    	{
    		CriterioBusqueda = $(x).val();
    		
    		if($.isNumeric(CriterioBusqueda))
    		{
	    		$.ajax({
					url: 'BusquedaAsociado.php',
					type: 'POST',
					data: "Criterio="+CriterioBusqueda,
					beforeSend: function() {
				   		$('#div_cargando').show();
				  	},
					success: function (data) 
					{
						$('#div_cargando').hide('fast');
						$('#ResultadoBusquedaAsociado').html(data);
					},
					error: function (data)
					{
						$('#div_cargando').hide();
					}
				});
	    	}
	    	else
	    	{
	    		$.ajax({
					url: 'BusquedaNombre.php',
					type: 'POST',
					data: "Nombre="+CriterioBusqueda,
					beforeSend: function() {
				   		$('#div_cargando').show();
				  	},
					success: function (data) 
					{
						$('#div_cargando').hide('fast');
						$('#suggestions').fadeIn(1000).html(data);
		                //Al hacer click en algua de las sugerencias
		               	$('.suggest-element').click(function(){
		                    var CIF = $(this).attr('data');
		                    ComprobarListaNegra(CIF);
		                });
					},
					error: function (data)
					{
						$('#div_cargando').hide();
					}
				});
	    	}
    	}
    	function ComprobarListaNegra(x)
    	{
    		$.ajax({
    				url: 'ComprobarListaNegra.php',
    				type: 'post',
    				data: 'CIF='+x,
    				success: function (data) {
    					if(data != 0)
    					{
    						alertify.confirm("El asociado se encuentra en la lista negra. ¿Está seguro que desea registrar la entrada al parque?", function (e) {
							    if (e) {
							        AgregarAsociado(x);
							    }
							});
    					}
    					else
    					{
    						AgregarAsociado(x);
    					}
    				}
    			});
    		AgregarAsociado(CIF);
    	}
    	function AgregarAsociado(x)
    	{
    		$.ajax({
				url: 'AgregarAsociado.php',
				type: 'post',
				data: 'CIF='+x,
				success: function (data) {
					$('#ModalBusquedaAsociados').modal('hide');
					LlenarTablaAsociados();
				}
			});
    	}
    	function LlenarTablaAsociados()
    	{
    		$.ajax({
				url: 'LlenarTablaAsociados.php',
				type: 'post',
				success: function (data) {
					$('#DIVAsociados').show();
					$('#TablaAsociados').html(data);
				}
			});
    	}
    	function EliminarAsociado(x)
    	{
    		$.ajax({
				url: 'EliminarAsociado.php',
				type: 'post',
				data: 'ID='+x,
				success: function (data) 
				{
					LlenarTablaAsociados();
				}
			});
    	}
    	function AgregarAcompanante(x)
    	{
    		$('#CIFAsociado').val(x);
    		$('#ModalIngresoAsociados').modal('show');
    	}
		function AgregarAcompananteMenor(x)
    	{
    		$('#CIFAsociado').val(x);
    		$('#ModalIngresoAsociadosMenores').modal('show');
    	}
    	function OcultarMostrarPais(x)
    	{
    		if(x.value == 73)
    		{
    			$('#SIGuatemala').show();
				$('#SiSalvadorAcompaniante').hide();
    			$('#SiHondurasAcompaniante').hide();
    		}
    		if(x.value == 79)//si es honduras
    		{
    			$('#SiHondurasAcompaniante').show();
    			$('#SIGuatemala').hide();
    			$('#SiSalvadorAcompaniante').hide();

    		}
    		if(x.value == 54)// si es salvador
    		{
    			$('#SiSalvadorAcompaniante').show();
    			$('#SIGuatemala').hide();
    			$('#SiHondurasAcompaniante').hide();
    		}
    	}
    	function OcultarMostrarPaisNoAsociado(x)
    	{
    		if(x.value == 73)
    		{
    			$('#SIGuatemala').show();
    		}
    		else
    		{
    			$('#SIGuatemala').hide();
    		}
    	}
    	function ObtenerMunicipios(x)
    	{
    		$.ajax({
    				url: 'ObtenerMunicipios.php',
    				type: 'post',
    				data: 'Departamento='+x,
    				success: function (data) {
    					$('#MunicipioAsociado').html('');
    					$('#MunicipioAsociado').html(data);
    				}
    			});
    	}
		function ObtenerMunicipiosNoAsociado(x)
    	{
    		$.ajax({
    				url: 'ObtenerMunicipios.php',
    				type: 'post',
    				data: 'Departamento='+x,
    				success: function (data) {
    					$('#MunicipioNoAsociado').html('');
    					$('#MunicipioNoAsociado').html(data);
    				}
    			});
    	}
    	function DatosAcompananteMostrar(x)
    	{
    		if(x == 1)
    		{
    			$('#DatosDemograficosAsociados').show();
    		}
    		else
    		{
    			$('#DatosDemograficosAsociados').hide();
    		}
    	}


    	function IngresoAcompanante()
    	{
    		var CIFAsociado = $('#CIFAsociado').val();
    		var Pais = $('#PaisAsociado').val();
    		var Departamento = $('#DepartamentoAsociado').val();
    		var Municipio = $('#MunicipioAsociado').val();
    		var FrecuenciaVisita = $('#FrecuenciaVisitaAsociado').val();
    		var Enterado = $('#EnteradoAsociado').val();
    		var BusquedaCentro = $('#BuscaAsociado').val();
    		var Telefono = $('#NumeroTelefonoAcompanante').val();
    		var NombreAcompaniante = $('#NombreAcompaniante').val();
    		var CorreoAcompaniante = $('#CorreoAcompaniante').val();
    		var EdadAcompaniante = $('#EdadAcompaniante').val();
    		var DepartamentosSalvadorAcompaniante = $('#DepartamentosSalvadorAcompaniante').val();
    		var DepartamentosHondurasAcompaniante = $('#DepartamentosHondurasAcompaniante').val();
    		var SelectConociaParqueAcompaniante = $('#SelectConociaParqueAcompaniante').val();
    		var SelectAsisteconAcompaniante = $('#SelectAsisteconAcompaniante').val();
    		var SelectVisitaEsquipulasAcompaniante = $('#SelectVisitaEsquipulasAcompaniante').val();
    		if(Telefono == '')
    		{
    			Telefono = 0;
    		}
    		var Datos = $('input:radio[name=DatosAcompanante]:checked').val();

    		$.ajax({
    				url: 'AgregarAcompanante.php',
    				type: 'post',
    				data: 'CifAsignar='+CIFAsociado+'&SelectPais='+Pais+'&SelectDepartamento='+Departamento+'&Municipio='+Municipio+'&FrecuenciaVisita='+FrecuenciaVisita+'&Enterado='+Enterado+'&BusquedaCentro='+BusquedaCentro+'&Telefono='+Telefono+'&Datos='+Datos+'&NombreAcompaniante='+NombreAcompaniante+'&CorreoAcompaniante='+CorreoAcompaniante+'&EdadAcompaniante='+EdadAcompaniante+'&SelectConociaParqueAcompaniante='+SelectConociaParqueAcompaniante+'&SelectAsisteconAcompaniante='+SelectAsisteconAcompaniante+'&SelectVisitaEsquipulasAcompaniante='+SelectVisitaEsquipulasAcompaniante+'&SelectDepartamentoHonduras='+DepartamentosHondurasAcompaniante+'&SelectDepartamentoSalvador='+DepartamentosSalvadorAcompaniante,
    				success: function (data) {
    					if(data == 1)
    					{
    						$('#FormularioAcompanantes')[0].reset();
    						$('#DatosDemograficosAsociados').show();
    						$('#ModalIngresoAsociados').modal('hide');
							$('#ModalIngresoAsociadosMenores').modal('hide');
    						alertify.success('Acompañante Ingresado');
    						LlenarTablaAsociados();
    					}
    					else
    					{
    						alert(data);
    					}
    				}
    			});
    	}
		function IngresoAcompananteMenores()
    	{
    		var CantidadMenores = $('#CIFAsociado').val();
    		
    		$.ajax({
    				url: 'AgregarAcompanante.php',
    				type: 'post',
    				data: 'CifAsignar='+CIFAsociado+'&SelectPais='+Pais+'&SelectDepartamento='+Departamento+'&Municipio='+Municipio+'&FrecuenciaVisita='+FrecuenciaVisita+'&Enterado='+Enterado+'&BusquedaCentro='+BusquedaCentro+'&Telefono='+Telefono+'&Datos='+Datos+'&NombreAcompaniante='+NombreAcompaniante+'&CorreoAcompaniante='+CorreoAcompaniante+'&EdadAcompaniante='+EdadAcompaniante+'&SelectConociaParqueAcompaniante='+SelectConociaParqueAcompaniante+'&SelectAsisteconAcompaniante='+SelectAsisteconAcompaniante+'&SelectVisitaEsquipulasAcompaniante='+SelectVisitaEsquipulasAcompaniante+'&SelectDepartamentoHonduras='+DepartamentosHondurasAcompaniante+'&SelectDepartamentoSalvador='+DepartamentosSalvadorAcompaniante,
    				success: function (data) {
    					if(data == 1)
    					{
    						$('#FormularioAcompanantes')[0].reset();
    						$('#DatosDemograficosAsociados').show();
    						$('#ModalIngresoAsociados').modal('hide');
							$('#ModalIngresoAsociadosMenores').modal('hide');
    						alertify.success('Acompañante Ingresado');
    						LlenarTablaAsociados();
    					}
    					else
    					{
    						alert(data);
    					}
    				}
    			});
    	}
    	function MostrarAcompaniante(x)
    	{
    		var Codigo = x;
    		$.ajax({
    				url: 'LlenarTablaAcompaniante.php',
    				type: 'post',
    				data: 'Codigo='+Codigo,
    				success: function (data) {
    					$('#ResultadosAcompanantes').html(data);
    					$('#ModalVerAcompanantes').modal('show');
    				}
    			});
    	}
    	function EliminarAcompanante(x)
    	{
    		$.ajax({
    				url: 'EliminarAcompananteTemporal.php',
    				type: 'post',
    				data: 'Codigo='+x,
    				success: function (data) {
    					LlenarTablaAsociados();
    					MostrarAcompaniante();
    					$('#ModalVerAcompanantes').hide();
    					$('#ModalVerAcompanantes').show();
    				}
    			});
    	}
    	function GuardarAsociados()
    	{
            var observaciones = $("#observaciones").val();
           
    		$.ajax({
    				url: 'GuardarIngresoAsociado.php',
    				type: 'post',
                    data: {observaciones: observaciones},
    				success: function (data) {
    					alertify.confirm("¿Dese agregar algún servicio a su ingreso?", function (e) {
						    if (e) {
						       window.location.href="../Facturacion/Vta.php";
						    } else {
						       window.location.reload();
						    }
						});
    				}
    			});
    	}
    	function CalcularTotal()
    	{
    		var Cantidad   = document.getElementsByName('Cantidad[]');
			var Precio = document.getElementsByName('Precio[]');
			var SubTotal = document.getElementsByName('SubTotal[]');
			var Total = 0;
			var SubTotalCalculado = 0;
			for(i = 0; i < Precio.length; i++)
			{
				SubTotalCalculado = parseFloat(Cantidad[i].value) * parseFloat(Precio[i].value);
				SubTotal[i].value = SubTotalCalculado.toFixed(2);
				Total = Total + SubTotalCalculado;
			}
			$('#TDTotal').html(Total.toFixed(2));
    	}
        function VerIngresosActual(x)
        {
            $.ajax({
                    url: 'AcompanantesMesActual.php',
                    type: 'post',
                    data: 'CIF='+x,
                    success: function (data) {
                        $('#ResultadosAcompanantesMesAcual').html(data);
                        $('#ModalVerAcompanantesMesAcual').modal('show');
                    }
                });
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
				<div class="col-lg-12">
					<br>
					<div class="card" style="margin-left: -10%;width: 120%">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Ingreso de Asociados</strong></h4>
						</div>
						<div class="card-body">
                            <div class="col-lg-12">
    							<div class="col-lg-6">
    								<div class="card" id="CARDAsociado">
    									<div class="card-body no-padding">
    										<div class="alert alert-callout alert-success no-margin">
    											<div>
    												<div class="text-center">
    													<a style="text-decoration: none; cursor: pointer" onclick="TipoPersona(1)" ><h1><span class="text-light">Asociados <i class="fa fa-user text-success"></i></span></h1></a>
    												</div>
    											</div>
    										</div>
    									</div><!--end .card-body -->
    								</div><!--end .card -->
    							</div>
    							<div class="col-lg-6">
    								<div class="card" id="CARDNoAsociado">
    									<div class="card-body no-padding">
    										<div class="alert alert-callout alert-success no-margin">
    											<div>
    												<div class="text-center">
    													<a style="text-decoration: none; cursor: pointer" onclick="TipoPersona(2)" ><h1><span class="text-light">No Asociados <i class="fa fa-user-secret text-success"></i></span></h1></a>
    												</div>
    											</div>
    										</div>
    									</div><!--end .card-body -->
    								</div><!--end .card -->
    							</div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="card" id="CARDAsociado">
                                        <div class="card-body no-padding">
                                            <div class="alert alert-callout alert-success no-margin">
                                                <div>
                                                    <div class="text-center">
                                                        <a style="text-decoration: none; cursor: pointer" href="Busqueda_Tarjeta_Asociado.php" ><h1><span class="text-light">Tarjeta Soy Coosajo <i class="fa fa-drivers-license text-success"></i></span></h1></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div>
                                <div class="col-lg-6">
                                    <div class="card" id="CARDReferenciacion">
                                        <div class="card-body no-padding">
                                            <div class="alert alert-callout alert-success no-margin">
                                                <div>
                                                    <div class="text-center">
                                                        <a style="text-decoration: none; cursor: pointer" onclick="TipoPersona(3)"  ><h1><span class="text-light ">Referenciación <i class="fa fa-user-plus text-success"></i></span></h1></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end .card-body -->
                                    </div><!--end .card -->
                                </div>
                            </div>
							<br>
							<br>
							<br>
							<!-- 
							************************************************************************
							************************************************************************
												DIV PARA INGRESO PERSONAS ASOCIADAS
							************************************************************************
							************************************************************************
							-->
							<div id="DIVAsociados" style="display: none">
								<br>
								<br>
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>CIF</th>
											<th>Nombre</th>
											<th>Puntos Disponibles</th>
											<th>Agregar Acompañantes</th>
											<th>Agregar Menores de 5 Años</th>
											<th>Ver Acompañantes</th>
											<th>Eliminar Asociado</th>
                                            <th>Ingresos Mes Actual</th>
                                            <th>Observaciones</th> 
										</tr>
									</thead>
									<tbody id="TablaAsociados">
										
									</tbody>
								</table>
								<br>
								<br>
								<br>
								<div class="row text-center">
									<button type="button" class="btn btn-primary"  id="btnEnviar" onclick="GuardarAsociados()">Enviar</button>
								</div>
							</div>
                            <!-- 
                            ************************************************************************
                            ************************************************************************
                                            DIV PARA INGRESO DE REFERENCIACION
                            ************************************************************************
                            ************************************************************************
                            -->
                            <div id="DIVReferenciacion" style="display: none">
                                <form method="post" id="formReferencia">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="autorizadoPor">Nombre completo:</label>
                                            <input type="text" class="form-control" id="nombreCompletoReferencia" name="nombreCompletoReferencia">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="edadReferencia">Edad</label>
                                            <input type="number" class="form-control" id="edadReferencia" name="edadReferencia">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                    <label for="direccionReferencia">Lugar de Procedencia</label>
                                  <select class="form-control selectpicker" data-live-search="true" required id="direccionReferencia" name="direccionReferencia" >
                                                <?php
                                                $Query = "SELECT a.nombre_departamento, b.nombre_municipio, b.id_municipio, b.id_departamento FROM info_base.departamentos_guatemala a
                                                    INNER JOIN info_base.municipios_guatemala b ON a.id_departamento = b.id_departamento
                                                    ";
                                                $Result = mysqli_query($db, $Query);
                                                while($row = mysqli_fetch_array($Result))
                                                {
                                                    if($row["id"] == 73)
                                                    {
                                                        $Texto = 'selected';
                                                    }
                                                    else
                                                    {
                                                        $Texto = '';
                                                    }
                                                    $Dpto= $row["nombre_departamento"];
                                                    $Mun = $row["nombre_municipio"];
                                                    echo '<option data-tokens="'.$Mun.'" value="'.$row["id_municipio"].', '.$row["id_departamento"].'" '.$Texto.'>'.$Mun.",".$Dpto.'</option>';
                                                }
                                                ?>
                                    </select>
                                 </div>

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="telefonoReferencia">Teléfono</label>
                                            <input type="number" class="form-control" id="telefonoReferencia" name="telefonoReferencia">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="tipoRferencia">Tipo de Referencia</label>
                                            <select class="form-control selectpicker" required data-live-search="true" id="tipoRferencia" name="tipoRferencia">
                                        <?php 
                                            $tipoReferencia = mysqli_query($db, "SELECT * FROM Taquilla.TIPO_REFERENCIA A WHERE A.TR_ESTADO = 1");
                                            while($tipoReferencia_result = mysqli_fetch_array($tipoReferencia))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $tipoReferencia_result["TR_ID"]?>"><?php echo $tipoReferencia_result["TR_DESCRIPCION"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"><br>
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-4">
                                            <button onclick="guardarReferencia()" type="button" class="btn btn-rounded btn-block btn-success">GUARDAR</button>
                                        </div> 
                                    </div>
                                    </form>                                   
                                </div>

                            </div>
							<!-- 
							************************************************************************
							************************************************************************
											DIV PARA INGRESO PERSONAS NO ASOCIADAS
							************************************************************************
							************************************************************************
							-->
							<div id="DIVNoAsociados" style="display: none">
                                <div class="row"> 
                                    <div class="col-xs-3"></div>                         
                                    <div class="col-xs-6"> 
                                        <div class="form-group">
                                            <label for="ConociaParque">SELECCIONE UNA OPCIÓN</label>
                                            <select name="selectOpcionNoA" id="selectOpcionNoA" class="form-control selectpicker" onchange="opcionNoAsociado(this.value)">
                                                <option selected>---Seleccione---</option>
                                                <option value="1">No Asociados</option>
                                                <option value="2">Hoteles</option>
                                                <option value="3">Tarjetas Familiares</option>
                                                <option value="4">Eventos</option>
                                                <option value="5">Cortesías</option>
                                            </select>
                                          </div> 
                                    </div>
                                    <div class="col-lg-3"><br> 
                                       <button class="tst3 btn btn-success"  onclick="verListaEventos()"> Eventos<i class="fa fa-users"></i></button> 
                                    </div>
                                </div>
                                <!--div para los no asociados-->
                                <div id="noAsociados" style="display: none">                                      
								<form action="../Facturacion/VtaNew.php" method="POST" >
						<div class="row">
							<div class="col-lg-1"></div>
							<div class="col-lg-5">
								<div class="form-group">
									<label for="NombreNoAsociado">Nombre Completo</label>
								  <input type="text" class="form-control" id="NombreNoAsociado" name="NombreNoAsociado">
								 </div>
								 <div class="form-group">
											<label for="NumeroTelefonoNoAsociado">Teléfono</label>
											<input type="mail" class="form-control" id="NumeroTelefonoNoAsociado" name="NumeroTelefonoNoAsociado">
										  </div>
								 <div class="form-group">
									<label for="PaisNoAsociado">Lugar de Procedencia</label>
								  <select class="form-control selectpicker" data-live-search="true" required id="PaisNoAsociado" name="PaisNoAsociado"  >
												<?php
                                                $Query = "SELECT a.nombre_departamento, b.nombre_municipio, b.id_municipio, b.id_departamento FROM info_base.departamentos_guatemala a
                                                    INNER JOIN info_base.municipios_guatemala b ON a.id_departamento = b.id_departamento
                                                    ";
                                                $Result = mysqli_query($db, $Query);
                                                while($row = mysqli_fetch_array($Result))
                                                {
                                                    if($row["id"] == 73)
                                                    {
                                                        $Texto = 'selected';
                                                    }
                                                    else
                                                    {
                                                        $Texto = '';
                                                    }
                                                    $Dpto= $row["nombre_departamento"];
                                                    $Mun = $row["nombre_municipio"];
                                                    echo '<option data-tokens="'.$Mun.'" value="'.$row["id_municipio"].', '.$row["id_departamento"].'" '.$Texto.'>'.$Mun.",".$Dpto.'</option>';
                                                }
                                                ?>
                                    </select>
								 </div>

							   <div class="form-group col-lg-6" id="SIGuatemalaNoAsociado" style="display: none">
								<label for="DepartamentoNoAsociado">Departamento</label>
							  	<select class="form-control selectpicker" required id="DepartamentoNoAsociado" name="DepartamentoNoAsociado" onchange="ObtenerMunicipiosNoAsociado(this.value)">
												<?php
													$QueryDepartamentos = mysqli_query($db, "SELECT * FROM info_base.departamentos_guatemala ORDER BY nombre_departamento");
													while($FilaDepartamento = mysqli_fetch_array($QueryDepartamentos))
													{
														if($FilaDepartamento["id_departamento"] == 20)
														{
															$TextoDepartamento = 'selected';
														}
														else
														{
															$TextoDepartamento = '';
														}
														?>
														<option value="<?php echo $FilaDepartamento["id_departamento"] ?>" <?php echo $TextoDepartamento; ?>><?php echo $FilaDepartamento["nombre_departamento"] ?></option>
														<?php
													}
												?>
										</select>
						  		</div>

						  		<div class="form-group col-lg-6" style="display: none" id="DivMunicipioNoAsociado">
												<label for="MunicipioAsociado">Municipio</label>
												<select class="form-control selectpicker" id="MunicipioNoAsociado" name="MunicipioNoAsociado">
												<?php
													$QueryDepartamentos = mysqli_query($db, "SELECT * FROM info_base.municipios_guatemala WHERE id_departamento = 20 ORDER BY nombre_municipio");
													while($FilaDepartamento = mysqli_fetch_array($QueryDepartamentos))
													{
														if($FilaDepartamento["id"] == 310)
														{
															$TextoDepartamento = 'selected';
														}
														else
														{
															$TextoDepartamento = '';
														}
														?>
														<option value="<?php echo $FilaDepartamento["id"] ?>" <?php echo $TextoDepartamento; ?>><?php echo $FilaDepartamento["nombre_municipio"] ?></option>
														<?php
													}
												?>
												</select>
									</div>

								<div class="form-group" id="SiSalvador" style="display: none">
									<label for="DepartamentoNoAsociado">Departamento</label>
								  	<select class="form-control selectpicker" required id="DepartamentosSalvador" name="DepartamentosSalvador">
												<?php
													$QueryDepartamentos = mysqli_query($db, "SELECT * FROM info_base.departamentos_el_salvador ORDER BY nombre_departamento");
													while($FilaDepartamento = mysqli_fetch_array($QueryDepartamentos))
													{
														if($FilaDepartamento["id_departamento"] == 20)
														{
															$TextoDepartamento = 'selected';
														}
														else
														{
															$TextoDepartamento = '';
														}
														?>
														<option value="<?php echo $FilaDepartamento["id_departamento"] ?>" <?php echo $TextoDepartamento; ?>><?php echo $FilaDepartamento["nombre_departamento"] ?></option>
														<?php
													}
												?>
										</select>
						  		</div>

						  		<div class="form-group" id="SiHonduras" style="display: none">
									<label for="DepartamentoNoAsociado">Departamento</label>
								  	<select class="form-control selectpicker" required id="DepartamentosHonduras" name="DepartamentosHonduras">
												<?php
													$QueryDepartamentos = mysqli_query($db, "SELECT * FROM info_base.departamentos_honduras ORDER BY nombre_departamento");
													while($FilaDepartamento = mysqli_fetch_array($QueryDepartamentos))
													{
														if($FilaDepartamento["id_departamento"] == 20)
														{
															$TextoDepartamento = 'selected';
														}
														else
														{
															$TextoDepartamento = '';
														}
														?>
														<option value="<?php echo $FilaDepartamento["id_departamento"] ?>" <?php echo $TextoDepartamento; ?>><?php echo $FilaDepartamento["nombre_departamento"] ?></option>
														<?php
													}
												?>
										</select>
						  		   </div>

								 	<div class="form-group" id="DivVisitaEsquipulas" style="display: none">
										<label for="VisitaEsquipulas">Cada Cuánto Visita Esquipulas</label>						
										<select name="SelectVisitaEsquipulas" id="SelectVisitaEsquipulas" class="form-control selectpicker">
											<option value="1">Cada mes</option>
											<option value="2">Dos veces al año</option>
											<option value="3">Una vez al año</option>
											<option value="4">Otros</option>
										</select>			
									</div>
									<div class="form-group">
										<label for="EnteradoNoAsociado">¿Cómo se enteró del Parque?</label>
										<select class="form-control selectpicker" required id="EnteradoNoAsociado" name="EnteradoNoAsociado">
										<?php 
											$enterado = mysqli_query($db, "SELECT * FROM Taquilla.ENTERADO_PARQUE");
											while($enterado_result = mysqli_fetch_array($enterado))											
											{
												?>
													<option value="<?php echo $enterado_result["EP_ID"]?>"><?php echo $enterado_result["EP_NOMBRE"] ?></option>
												<?php 
											}
										?>
										</select>
									</div>

										</div><!-- fin col-lg-4 -->

										<div class="col-lg-2">

										  <div class="form-group">
											<label for="EdadNoAsociado">Edad</label>
											<input type="number" step="any" min="0" class="form-control" id="EdadNoAsociado" name="EdadNoAsociado">
										  </div>

								      <div class="form-group">
										<label for="ConociaParque">Asiste con:</label>
										<select name="SelectAsisteconNoAsociado" id="SelectAsisteconNoAsociado" class="form-control selectpicker">
											<option value="1">Familiares</option>
											<option value="2">Amigos</option>
										</select>
									  </div>

									   <div class="form-group">
										<label for="ConociaParque">Frecuencia Visita al Parque:</label>
										<select name="FrecuenciaVisitaNoAsociado" id="FrecuenciaVisitaNoAsociado" class="form-control selectpicker">
											<option value="1">Semanal</option>
											<option value="2">Quincenal</option>
											<option value="3">Mensual</option>
											<option value="4">Trimestral</option>
											<option value="5">Semestral</option>
											<option value="6">Anual</option>
											<option value="7">Otros</option>
										</select>
									  </div>	
							    

										</div>
										<div class="col-lg-3">

										  <div class="form-group">
											<label for="CorreoNoAsociado">Correo Electrónico</label>
											<input type="mail" class="form-control" id="CorreoNoAsociado" name="CorreoNoAsociado">
										  </div>
										  		
									   <div class="form-group">
										<label for="ConociaParque">¿Ya conocía el Parque?</label>
										<select name="SelectConociaParque" id="SelectConociaParque" class="form-control selectpicker">
											<option value="0">No</option>
											<option value="1">Si</option>
										</select>
									  </div>	


									  <div class="form-group">
										<label for="BuscaNoAsociado">¿Qué Busca en un Centro Turístico?</label>
										<select class="form-control selectpicker" required id="BuscaNoAsociado" name="BuscaNoAsociado">
											<option value="1">Piscinas</option>
											<option value="2">Área Verde</option>
											<option value="3">Juegos Extremos</option>
											<option value="4">Tranquilidad</option>
											<option value="5">Área Deportiva</option>
											<option value="6">Amplitud</option>
											<option value="7">Otro</option>
										</select>
									  </div>

										</div> 
									</div>
									<input type="text" class="form-control">
									<table class="table table-hover">
										<thead>
											<tr>
												<th>Tipo Ingreso</th>
												<th>Cantidad</th>
												<th>Precio</th>
												<th>Subtotal</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$QueryProductosIngreso = mysqli_query($db, "SELECT * FROM Bodega.PRODUCTO WHERE (P_CODIGO = 821 OR P_CODIGO = 822 OR P_CODIGO = 823 OR P_CODIGO = 1510) ORDER BY P_NOMBRE");
										while($FilaProducto = mysqli_fetch_array($QueryProductosIngreso))
										{
											?>
											<tr>
												<td><h5><b><?php echo $FilaProducto["P_NOMBRE"] ?></b></h5></td>
												<td class="text-right"><input type="hidden" name="CodigoProducto[]" id="CodigoProducto[]" class="form-control" value="<?php echo $FilaProducto["P_CODIGO"] ?>" required="required"><input type="number" name="Cantidad[]" id="Cantidad[]" class="form-control" value="0.00" required="required" onchange="CalcularTotal()"></td>
												<td class="text-right"><h5><b><input type="number" name="Precio[]" id="Precio[]" class="form-control" value="<?php echo $FilaProducto["P_PRECIO"] ?>" required="required" readonly></b></h5></td>
												<td class="text-right"><h5><b><input type="number" name="SubTotal[]" id="SubTotal[]" class="form-control" value="0.00" required="required" readonly></b></h5></td>
											</tr>
											<?php
										}
										?>
										</tbody>
										<tfoot>
											<tr>
												<td></td>
												<td></td>
												<td><h4><b>TOTAL</b></h4></td>
												<td><h4><b id="TDTotal">0.00</b></h4></td>
											</tr>
										</tfoot>
									</table>
									<br>
									<br>
									<dir class="row text-center">
										<button type="submit" class="btn btn-primary">Enviar</button>
									</dir>
								</form>
                                </div> 
                                <!--div para los hoteles -->
                                <div id="hoteles" style="display: none">
                                    <form method="post" id="formHotel">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="nombreHotel">Hotel</label>
                                            <select onchange="SaberVale(this.value)" class="form-control selectpicker" required data-live-search="true" id="nombreHotel" name="nombreHotel">
                                                <option selected="" disabled="">Seleccione</option>
                                        <?php 
                                            $hotel = mysqli_query($db, "SELECT * FROM Taquilla.HOTEL WHERE H_ESTADO = 1");
                                            while($hotel_result = mysqli_fetch_array($hotel))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $hotel_result["H_CODIGO"]?>"><?php echo $hotel_result["H_NOMBRE"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="adultos">Cantidad Adultos</label>
                                            <input type="number" step="any" min="0" class="form-control" id="adultos" name="adultos">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantNinos">Cantidad Niños</label>
                                            <input type="number" step="any" min="0" class="form-control" id="cantNinos" name="cantNinos">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantMen">Menores 5 años</label>
                                            <input type="number" step="any" min="0" class="form-control" id="cantMen" name="cantMen">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="vale">Número de Vale</label>
                                            <div id="DivVale"></div>
                                            </div>
                                        </div> 
                                    </div> 
                                     <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="fechaHotel">Fecha Realizo</label>
                                            <input type="date"  class="form-control" id="fechaHotel" name="fechaHotel">
                                            </div>
                                        </div> 
                                    </div>   
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <button onclick="guardarHotel()" type="button" class="btn btn-rounded btn-block btn-success">GUARDAR</button>
                                        </div> 
                                    </div>
                                    </form>                                   
                                </div>
                                <!--div para las tarjetas familiares -->
                                <div id="tarjetasFamiliares" style="display: none">
                                    <div id="divDetalleTarjeta" class="row">                                                  
                                    </div>
                                    <form method="post" id="formTarjetasFamiliares">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="noTarjeta">No. Tarjeta</label>
                                            <input type="number" step="any" min="0" class="form-control" id="noTarjeta" name="noTarjeta" onblur="detalleTarjeta(this.value)">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="adultosTarjeta">Cantidad Adultos</label>
                                            <input type="number" step="any" min="0" class="form-control" id="adultosTarjeta" name="adultosTarjeta">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantNinosTarjeta">Cantidad Niños</label>
                                            <input type="number" step="any" min="0" class="form-control" id="cantNinosTarjeta" name="cantNinosTarjeta">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantMenTarjeta">Menores 5 años</label>
                                            <input type="number" step="any" min="0" class="form-control" id="cantMenTarjeta" name="cantMenTarjeta">
                                            </div>
                                        </div>
                                    </div>  
                                    <!-- <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="fechaTarjeta">Fecha Realizo</label>
                                            <input type="date"  class="form-control" id="fechaTarjeta" name="fechaTarjeta">
                                            </div>
                                        </div> 
                                    </div>  -->  
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <button onclick="guardarTarjeta()" type="button" class="btn btn-rounded btn-block btn-success">GUARDAR</button>
                                        </div> 
                                    </div>
                                    </form>                                   
                                </div>
                                <!--div para los eventos -->
                                <div id="eventos" style="display: none">
                                    <form method="post" id="formEventos">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="duenoEvento">Nombre del Evento</label>
                                            <input type="text" class="form-control" id="NombreEvento" name="NombreEvento">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="tipoEvento">Tipo de Evento</label>
                                            <select class="form-control selectpicker" required data-live-search="true" id="tipoEvento" name="tipoEvento">
                                        <?php 
                                            $evento = mysqli_query($db, "SELECT * FROM Taquilla.EVENTO A WHERE A.E_TIPO = 1 and A.E_ESTADO = 1");
                                            while($evento_result = mysqli_fetch_array($evento))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $evento_result["E_ID"]?>"><?php echo $evento_result["E_DESCRIPCION"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="duenoEvento">Dueño de Evento</label>
                                            <input type="text" class="form-control" id="duenoEvento" name="duenoEvento">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantPersonas">Cantidad de personas</label>
                                            <input type="number" step="any" min="0" class="form-control" id="cantPersonas" name="cantPersonas">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantMen">Clasificador</label>
                                            <select class="form-control selectpicker" required data-live-search="true" id="clasificadorEvento" name="clasificadorEvento">
                                        <?php 
                                            $clasificador = mysqli_query($db, "SELECT * FROM Taquilla.CLASIFICADOR_EVENTO WHERE CE_ESTADO = 1");
                                            while($clasificador_result = mysqli_fetch_array($clasificador))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $clasificador_result["CE_ID"]?>"><?php echo $clasificador_result["CE_DESCRIPCION"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantPersonas">Nombre de la Empresa</label>
                                            <input type="text" class="form-control" id="nomEmpresa" name="nomEmpresa">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantMen">Área 
                                            utilizada</label>
                                            <select class="form-control selectpicker" required data-live-search="true" id="areaUtilizada" name="areaUtilizada">
                                        <?php 
                                            $areas = mysqli_query($db, "SELECT * FROM Taquilla.AREA_UTILIZAR WHERE AU_ESTADO = 1");
                                            while($areas_result = mysqli_fetch_array($areas))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $areas_result["AU_ID"]?>"><?php echo $areas_result["AU_DESCRIPCION"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="telEmpresa">Contacto (tel)</label>
                                            <input type="number" step="any" min="0" class="form-control" id="telEmpresa" name="telEmpresa">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                        	<div id="DivProcedenciaGuatemalaE">
                                            <div class="form-group">
                                            <label for="cantMen">Procedencia</label>
                                           <select class="form-control selectpicker" data-live-search="true" required id="procedenciaEvento" name="procedenciaEvento">
												<?php
												$QueryP = "SELECT a.nombre_departamento, b.nombre_municipio, b.id_municipio, b.id_departamento FROM info_base.departamentos_guatemala a
                                                    INNER JOIN info_base.municipios_guatemala b ON a.id_departamento = b.id_departamento
                                                    ";
												$ResultP = mysqli_query($db, $QueryP);
												while($rowP = mysqli_fetch_array($ResultP))
												{
													if($rowP["id"] == 73)
													{
														$Texto = 'selected';
													}
													else
													{
														$Texto = '';
													}
													 $Dpto= $rowP["nombre_departamento"];
                                                    $Mun = $rowP["nombre_municipio"];
                                                    echo '<option data-tokens="'.$Mun.'" value="'.$rowP["id_municipio"].', '.$rowP["id_departamento"].'" '.$Texto.'>'.$Mun.",".$Dpto.'</option>';
												}
												?>
									</select>
                                            </div>
                                         </div>
                                            <div id="DivProcedenciaExtE" style="display: none">
                                            <div class="form-group">
                                            <label for="cantMen">Procedencia</label>
                                           <select class="form-control selectpicker" data-live-search="true" required id="procedenciaPaisE" name="procedenciaPaisE">
                                                <?php
                                                $QueryP = "SELECT *FROM info_base.lista_paises_mundo 
                                                    ";
                                                $ResultP = mysqli_query($db, $QueryP);
                                                while($rowP = mysqli_fetch_array($ResultP))
                                                {                                                     $Mun = $rowP["pais"];
                                                    echo '<option data-tokens="'.$Mun.'" value="'.$rowP["id"].'" >'.$Mun.'</option>';
                                                }
                                                ?>
                                    </select>
                                            </div>
                                            </div>
                                            <label for="">Otros Países
                                    <span><input class="form-control otrosPaisesEventos" type="checkbox" id="otrosPaisesE" onclick="mostrarPaisE()" name="otrosPaisesE"></span></label> 
                                    </div>  
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantNinos">Fecha Evento</label>
                                            <input type="date"  class="form-control" id="fechaEvento" name="fechaEvento">
                                            </div>
                                        </div> 
                                    </div>  
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <button onclick="guardarEvento()" type="button" class="btn btn-rounded btn-block btn-success">GUARDAR</button>
                                        </div> 
                                    </div>
                                    </form>                                   
                                </div>
                                <!--div para las cortesias -->
                                <div id="cortesias" style="display: none">
                                    <form method="post" id="formCortesia">
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="autorizadoPor">Autorizado por:</label>
                                            <select class="form-control selectpicker" required data-live-search="true" id="autorizadoPor" name="autorizadoPor">
                                        <?php 
                                            $autorizadores = mysqli_query($db, "SELECT * FROM Taquilla.AUTORIZADOR_EVENTOS");
                                            while($autorizadores_result = mysqli_fetch_array($autorizadores))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $autorizadores_result["AE_ID"]?>"><?php echo $autorizadores_result["AE_NOMBRE"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="lugarProcedencia">Lugar o Institución Procedencia</label>
                                            <input type="text" class="form-control" id="lugarProcedencia" name="lugarProcedencia">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantPersonas">Cantidad de personas</label>
                                            <input type="number" step="any" min="0" class="form-control" id="cantPersonas" name="cantPersonas">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="tipoEventoCortesia">Tipo de Evento</label>
                                            <select class="form-control selectpicker" required data-live-search="true" id="tipoEventoCortesia" name="tipoEventoCortesia">
                                        <?php 
                                            $eventoCortesia = mysqli_query($db, "SELECT * FROM Taquilla.EVENTO A WHERE A.E_TIPO = 2");
                                            while($eventoCortesia_result = mysqli_fetch_array($eventoCortesia))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $eventoCortesia_result["E_ID"]?>"><?php echo $eventoCortesia_result["E_DESCRIPCION"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div> 
<!--                                      <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="fechaCortesia">Fecha Realizo</label>
                                            <input type="date"  class="form-control" id="fechaCortesia" name="fechaCortesia">
                                            </div>
                                        </div> 
                                    </div>  
 -->                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <button onclick="guardarCortesia()" type="button" class="btn btn-rounded btn-block btn-success">GUARDAR</button>
                                        </div> 
                                    </div>
                                    </form>                                   
                                </div>
							</div>
						</div>
					</div>
				</div>
				<br>
				<br>
			</div>
		</div>
		<!-- END CONTENT -->

<div class="modal fade in" id="modalEventos"  >
    <div class="modal-dialog modal-full-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Eventos en curso</h4>
            </div> 
            <div id="divEventosCurso"></div> 
        </div>
    </div>
</div>
<script>
    function guardarReferencia()
    {
        var form = $("#formReferencia").serialize();
        $.ajax({
            url: 'Ajax/GuardarReferencia.php',
            type: 'POST',
            dataType: 'html',
            data: form,
            success: function(data)
            {
                if (data==1) 
                {
                alertify.success("Se ha almacenado correctamente!");
                $("#formReferencia")[0].reset();
                $('#DIVReferenciacion').hide();
                }
            }
        })
                 
    }

    function verListaEventos()
    {
        $.ajax({
            url: 'Ajax/ListadoEventosAgg.php',
            type: 'POST',
            dataType: 'html',
            data: {param1: 'value1'},
            success: function(data)
            {
            	$("#modalEventos").modal('show');
                $("#divEventosCurso").html(data);
            }
        })
                
    }
    function opcionNoAsociado(x)
    {
        if(x==1)
        {
             $('#noAsociados').show();
             $('#hoteles').hide();
             $('#tarjetasFamiliares').hide();
             $('#eventos').hide();
             $('#cortesias').hide();
        }
        else if(x==2)
        {
            $('#noAsociados').hide();
            $('#hoteles').show();
            $('#tarjetasFamiliares').hide();
            $('#eventos').hide();
            $('#cortesias').hide();
        }
        else if(x==3)
        {
            $('#noAsociados').hide();
            $('#hoteles').hide();
            $('#tarjetasFamiliares').show(); 
            $('#eventos').hide();
            $('#cortesias').hide();
        }
        else if(x==4)
        {
            $('#noAsociados').hide();
            $('#hoteles').hide();
            $('#tarjetasFamiliares').hide(); 
            $('#eventos').show();
            $('#cortesias').hide();
        }
        else if(x==5)
        {
            $('#noAsociados').hide();
            $('#hoteles').hide();
            $('#tarjetasFamiliares').hide(); 
            $('#eventos').hide();
            $('#cortesias').show();
        }
    }

    function detalleTarjeta(tarjeta)
    {
         $.ajax({
             url: 'Ajax/DetalleTarjeta.php',
             type: 'POST',
             dataType: 'html',
             data: {tarjeta: tarjeta},
             success: function(data)
             {
                $("#divDetalleTarjeta").html(data);
             }
         })
    }
    function guardarTarjeta()
    {
        var cantMenTarjeta = $("#cantMenTarjeta").val();
        var cantNinosTarjeta = $("#cantNinosTarjeta").val();
        var adultosTarjeta = $("#adultosTarjeta").val();
        var ingresoDisp = $("#ingresoDisp").val(); 
        var total =  parseInt(cantNinosTarjeta) + parseInt(adultosTarjeta);
        if (total>ingresoDisp) 
        {
            alertify.error("La cantidad es mayor de lo disponible");
        }
        else
        {
            var form = $("#formTarjetasFamiliares").serialize();
            $.ajax({
                url: 'Ajax/GuardarTarjetasFamiliares.php',
                type: 'POST',
                dataType: 'html',
                data: form,
                success: function(data)
                {
                	if(data==1)
            		{
                    alertify.success("Se ha almacenado correctamente!");
                    $("#formTarjetasFamiliares")[0].reset();
                    $('#tarjetasFamiliares').hide();
                    setTimeout(function() {location.reload();}, 2000);
                    }
                    else
                    {
                     alertify.error("Ha ocurrido un error");	
                    }

                }
            })
        }                
    }

    function SaberVale(Hotel)
    {
        $.ajax({
            url: 'Ajax/DetalleVale.php',
            type: 'POST',
            dataType: 'html',
            data: {Hotel:Hotel},
            success: function(data)
            {
                $("#DivVale").html(data);
            }
        }) 
        
    }
    function guardarHotel()
    {
        var form = $("#formHotel").serialize();
        $.ajax({
            url: 'Ajax/GuardarHotel.php',
            type: 'POST',
            dataType: 'html',
            data: form,
            success: function(data)
            {
            	if(data==1)
            	{
                alertify.success("Se ha almacenado correctamente!");
                $("#formHotel")[0].reset();
                $('#hoteles').hide();
                setTimeout(function() {location.reload();}, 2000);
                }
                else
                {
                 alertify.error("Ha ocurrido un error");	
                }
            }
        })
                 
    }

    function guardarCortesia()
    {
        var form = $("#formCortesia").serialize();
        $.ajax({
            url: 'Ajax/GuardarCortesia.php',
            type: 'POST',
            dataType: 'html',
            data: form,
            success: function(data)
            {
            	if(data==1)
            	{
                alertify.success("Se ha almacenado correctamente!");
                $("#formCortesia")[0].reset();
                $('#cortesias').hide();
            	setTimeout(function() {location.reload();}, 2000);
                }
                else
                {
                 alertify.error("Ha ocurrido un error");	
                }
            }
        })
                 
    }

    function guardarEvento()
    {
        	var NombreEvento = $("#NombreEvento").val(); 
            var tipoEvento = $("#tipoEvento").val();
            var duenoEvento = $("#duenoEvento").val();
            var cantPersonas = $("#cantPersonas").val();
            var clasificadorEvento = $("#clasificadorEvento").val();
            var nomEmpresa = $("#nomEmpresa").val();
            var areaUtilizada = $("#areaUtilizada").val();
            var telEmpresa = $("#telEmpresa").val();
            var procedenciaEvento = $("#procedenciaEvento").val();
            var fechaEvento = $("#fechaEvento").val();
            var procedenciaPais = $("#procedenciaPaisE").val();
            var otrosPaises = $("#otrosPaisesE").prop('checked');
            
        $.ajax({
            url: 'Ajax/GuardarEventoRealizar.php',
            type: 'POST',
            dataType: 'html',
            data: {NombreEvento: NombreEvento, 
                        tipoEvento: tipoEvento,
                        duenoEvento: duenoEvento,
                        cantPersonas: cantPersonas,
                        clasificadorEvento: clasificadorEvento,
                        nomEmpresa: nomEmpresa,
                        areaUtilizada: areaUtilizada,
                        telEmpresa: telEmpresa,
                        procedenciaEvento: procedenciaEvento,
                        fechaEvento: fechaEvento, otrosPaises:otrosPaises, procedenciaPais: procedenciaPais},
            success: function(data)
            {
            	if(data==1)
            	{
                alertify.success("Se ha almacenado correctamente!");
                $("#formEventos")[0].reset();
                $('#eventos').hide();
                setTimeout(function() {location.reload();}, 2000);
                }else if(data==2)
                {
                 alertify.error("Ya Existe Un Evento con esos datos revise listado");	
                }
                else
                {
                 alertify.error("Ha ocurrido un error");	
                }
            }
        })
                 
    }

	function OcultarMostrarDepartamentoNoAsociado(x)
	{
		$('#SiSalvador').hide();
		$('#SIGuatemalaNoAsociado').hide();
		$('#SiHonduras').hide();
		$('#DivMunicipioNoAsociado').hide();
		if(x == 73)
		{
			$('#SIGuatemalaNoAsociado').show();
			$('#DivMunicipioNoAsociado').show();
			$('#SiHonduras').hide();
			$('#SiSalvador').hide();
		}
		if(x == 79)
		{
			$('#SiHonduras').show();
			$('#SIGuatemalaNoAsociado').hide();
			$('#SiSalvador').hide();
			$('#DivVisitaEsquipulas').hide();
		}
		if(x == 54)
		{
			$('#SiSalvador').show();
			$('#SIGuatemalaNoAsociado').hide();
			$('#SiHonduras').hide();
			$('#DivVisitaEsquipulas').hide();
		}	
	}

	$('#MunicipioNoAsociado').change(function(event) {
		var MunicipioEsquipulas = $('#MunicipioNoAsociado').val();
		if(MunicipioEsquipulas != 310)
		{
			$('#DivVisitaEsquipulas').show();
		}
		else
		{
			$('#DivVisitaEsquipulas').hide();
		}
	});
</script>

		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>
	
		<!-- 
		************************************************************************
		************************************************************************
								MODAL PARA INGRESO DE ASOCIADOS
		************************************************************************
		************************************************************************
		-->
		<div class="modal fade" id="ModalBusquedaAsociados" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" style="width: 90%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title text-center"><b>Búsqueda de Asociados</b></h3>
					</div>
					<div class="modal-body">
						<form class="form">
							<div class="row"> 
								<div class="col-lg-6">
									<div class="form-group floating-label">
										<input class="form-control" type="text" name="CriterioBusqueda" id="CriterioBusqueda" onchange="BusquedaAsociado(this)"/>
										<label for="CriterioBusqueda">Criterio Búsqueda</label>
										<div id="suggestions" class="text-center"></div>
									</div>
								</div>
                                <div class="col-lg-6">
                                    <div class="alert alert-callout alert-success no-margin">
                                    <div class="text-center">
                                        <h4><strong>Asociados Formación</strong><input type="checkbox" class="form-control verDatos" name="verDatos" id="verDatos" onclick="verAsociadosFormacion()"></h4>
                                    </div>
                                    </div>
                                </div>
							</div>
                            <div id="CamposAsociadosFormacion" style="display: none;">
                                <form id="formAsociados" name="formAsociados">
                                <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="duenoEvento">Nombre del Evento</label>
                                            <input type="text" class="form-control" id="NombreEventoA" name="NombreEventoA">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="programaActivo">Programa</label>
                                            <select name="programaActivo" id="programaActivo" class="form-control">
                                        <option value="x">Seleccione</option>
                                        <?php 
                                        $Consulta = "SELECT * 
                                                FROM Taquilla.PROGRAMAS_ACTIVOS
                                                WHERE PA_ESTADO = 1
                                                ORDER BY PA_DESCRIPCION";
                                            $Resultado = mysqli_query($db, $Consulta);
                                            while($row = mysqli_fetch_array($Resultado))
                                            {
                                            ?>
                                            <option value="<?php echo $row["PA_ID"] ?>"><?php echo $row["PA_DESCRIPCION"] ?></option>
                                            <?php 
                                            }
                                        ?>
                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="tipoEvento">Tipo de Evento</label>
                                            <select class="form-control selectpicker" required data-live-search="true" id="tipoEventoA" name="tipoEventoA">
                                        <?php 
                                            $evento = mysqli_query($db, "SELECT * FROM Taquilla.EVENTO A WHERE A.E_TIPO = 1 and A.E_ESTADO = 1");
                                            while($evento_result = mysqli_fetch_array($evento))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $evento_result["E_ID"]?>"><?php echo $evento_result["E_DESCRIPCION"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="duenoEvento">Dueño de Evento</label>
                                            <input type="text" class="form-control" id="duenoEventoA" name="duenoEventoA">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="noParticipantes">Cantidad de personas</label>
                                            <input type="number" step="any" min="0" class="form-control" id="noParticipantes" name="noParticipantes">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantMen">Clasificador</label>
                                            <select class="form-control selectpicker" required data-live-search="true" id="clasificadorEventoA" name="clasificadorEventoA">
                                        <?php 
                                            $clasificador = mysqli_query($db, "SELECT * FROM Taquilla.CLASIFICADOR_EVENTO WHERE CE_ESTADO = 1");
                                            while($clasificador_result = mysqli_fetch_array($clasificador))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $clasificador_result["CE_ID"]?>"><?php echo $clasificador_result["CE_DESCRIPCION"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantPersonas">Nombre de la Empresa</label>
                                            <input type="text" class="form-control" id="nomEmpresaA" name="nomEmpresaA">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="cantMen">Área 
                                            utilizada</label>
                                            <select class="form-control selectpicker" required data-live-search="true" id="areaUtilizadaA" name="areaUtilizadaA">
                                        <?php 
                                            $areas = mysqli_query($db, "SELECT * FROM Taquilla.AREA_UTILIZAR WHERE AU_ESTADO = 1");
                                            while($areas_result = mysqli_fetch_array($areas))                                          
                                            {
                                                ?>
                                                    <option value="<?php echo $areas_result["AU_ID"]?>"><?php echo $areas_result["AU_DESCRIPCION"] ?></option>
                                                <?php 
                                            }
                                        ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                            <label for="telEmpresa">Contacto (tel)</label>
                                            <input type="number" step="any" min="0" class="form-control" id="telEmpresaA" name="telEmpresaA">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                        	<div id="DivProcedenciaGuatemala">
                                            <div class="form-group">
                                            <label for="cantMen">Procedencia</label>
                                           <select class="form-control selectpicker" data-live-search="true" required id="procedenciaEventoA" name="procedenciaEventoA">
                                                <?php
                                                $QueryP = "SELECT a.nombre_departamento, b.nombre_municipio, b.id_municipio, a.id_departamento FROM info_base.departamentos_guatemala a
                                                    INNER JOIN info_base.municipios_guatemala b ON a.id_departamento = b.id_departamento
                                                    ";
                                                $ResultP = mysqli_query($db, $QueryP);
                                                while($rowP = mysqli_fetch_array($ResultP))
                                                {
                                                    if($rowP["id"] == 73)
                                                    {
                                                        $Texto = 'selected';
                                                    }
                                                    else
                                                    {
                                                        $Texto = '';
                                                    }
                                                    $Dpto= $rowP["nombre_departamento"];
                                                    $Mun = $rowP["nombre_municipio"];
                                                    echo '<option data-tokens="'.$Mun.'" value="'.$rowP["id_municipio"].', '.$rowP["id_departamento"].'" '.$Texto.'>'.$Mun.",".$Dpto.'</option>';
                                                }
                                                ?>
                                    </select>
                                            </div>
                                            </div>
                                            <div id="DivProcedenciaExt" style="display: none">
                                            <div class="form-group">
                                            <label for="cantMen">Procedencia</label>
                                           <select class="form-control selectpicker" data-live-search="true" required id="procedenciaPais" name="procedenciaPais">
                                                <?php
                                                $QueryP = "SELECT *FROM info_base.lista_paises_mundo 
                                                    ";
                                                $ResultP = mysqli_query($db, $QueryP);
                                                while($rowP = mysqli_fetch_array($ResultP))
                                                {                                                     $Mun = $rowP["pais"];
                                                    echo '<option data-tokens="'.$Mun.'" value="'.$rowP["id"].'" >'.$Mun.'</option>';
                                                }
                                                ?>
                                    </select>
                                            </div>
                                            </div>
                                            <label for="">Otros Países
                                    <span><input class="form-control otrosPaises" type="checkbox" id="otrosPaises" onclick="mostrarPais()" name="otrosPaises"></span></label>
                                        </div>
                                    </div>  
                                <div class="row">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-4">
                                    <label for="">Fecha realizo</label>
                                    <input class="form-control" type="date" id="fechaFormacion" name="fechaFormacion">
                                </div>
                            </div>
                            
                            <div class="row text-center">
                                <div class="col-lg-6"></div>
                                 <div class="col-lg-6">
                                    <button onclick="guardarAsociadosFormacion()" type="button" class="btn btn-block btn-lg btn-success">GUARDAR</button>
                                </div>
                            </div>
                            </form>
                            </div>
							<div class="row text-center">
								<div align="center" id="div_cargando" style="display: none">
									<img src="../../../../../img/Preloader.gif" alt="" width="75px">
								</div>
							</div>
							<div id="ResultadoBusquedaAsociado">
								
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	
		
		<!-- 
		************************************************************************
		************************************************************************
							MODAL PARA INGRESO DE ACOMPAÑANTES
		************************************************************************
		************************************************************************
		-->
		<div class="modal fade" id="ModalIngresoAsociados" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" style="width: 80%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title text-center"><b>Ingreso de Acompañantes</b></h3>
					</div>
					<div class="modal-body">
						<form class="form" id="FormularioAcompanantes">
							<input type="hidden" name="CIFAsociado" id="CIFAsociado">
							<div class="row">
								<div class="form-group col-lg-6">
									<label >¿Desea Capturar Datos del Acompañante?</label>
									<div class="col-lg-12">
										<label class="radio-inline radio-styled">
											<input type="radio" name="DatosAcompanante" value="1" checked onchange="DatosAcompananteMostrar(this.value)"><span>SÍ</span>
										</label>
										<label class="radio-inline radio-styled">
											<input type="radio" name="DatosAcompanante" value="2" onchange="DatosAcompananteMostrar(this.value)"><span>NO</span>
										</label>
									</div><!--end .col -->
								</div>
							</div>

							
						

							<div id="DatosDemograficosAsociados">
								<div class="row">
									<div class="col-lg-6">
									  <div class="form-group">
										<label for="NombreAcompaniante">Nombre Completo</label>
									    <input type="text" class="form-control" id="NombreAcompaniante" name="NombreAcompaniante">
									  </div>

									  <div class="row">
										<div class="col-lg-7">
											<div class="form-group">
											<label for="CorreoAcompaniante">Correo Electrónico</label>
											<input type="mail" class="form-control" id="CorreoAcompaniante" name="CorreoNoAsociado">
								  			</div>
										</div>									  	
										<div class="col-lg-3">
										   <div class="form-group">
											<label for="EdadAcompaniante">Edad</label>
											<input type="number" step="any" min="0" class="form-control" id="EdadAcompaniante" name="EdadAcompaniante">
										   </div>
										</div>	
									  </div>									    

							  		   <div class="form-group">
										<input class="form-control" type="number" id="NumeroTelefonoAcompanante" name="NumeroTelefonoAcompanante">
										<label for="BuscaAsociado">Número de Teléfono</label>
									  </div>

										<div class="row">
											<div class="col-lg-6">
											  <div class="form-group">
												<label for="ConociaParque">¿Ya conocía el Parque?</label>
												<select name="SelectConociaParqueAcompaniante" id="SelectConociaParqueAcompaniante" class="form-control selectpicker">
													<option value="0">No</option>
													<option value="1">Si</option>
												</select>
											  </div>	
											</div>
											<div class="col-lg-6">
											  <div class="form-group">
												<label for="ConociaParque">Asiste con:</label>
												<select name="SelectAsisteconAcompaniante" id="SelectAsisteconAcompaniante" class="form-control selectpicker">
													<option value="1">Familiares</option>
													<option value="2">Amigos</option>
												</select>
											  </div>
											</div>
										</div>
									  								 
									
									  <div class="form-group">
											<select class="form-control selectpicker" data-live-search="true" required id="PaisAsociado" name="PaisAsociado" onchange="OcultarMostrarPais(this)">
												<?php
												$Query = "SELECT * FROM info_base.lista_paises_mundo ORDER BY pais";
												$Result = mysqli_query($db, $Query);
												while($row = mysqli_fetch_array($Result))
												{
													if($row["id"] == 73)
													{
														$Texto = 'selected';
													}
													else
													{
														$Texto = '';
													}
													$Nombre = $row["pais"];
													echo '<option data-tokens="'.$Nombre.'" value="'.$row["id"].'" '.$Texto.'>'.$Nombre.'</option>';
												}
												?>
											</select>
											<label for="PaisAsociado">¿De qué País Nos Visita?</label>
										</div>
										
										

									</div>
									
									<div class="col-lg-6">

									  <div class="form-group" id="SiHondurasAcompaniante" style="display: none">
										<label for="DepartamentoNoAsociado">Departamento</label>
									  	<select class="form-control selectpicker" required id="DepartamentosHondurasAcompaniante" name="DepartamentosHondurasAcompaniante">
													<?php
														$QueryDepartamentos = mysqli_query($db, "SELECT * FROM info_base.departamentos_honduras ORDER BY nombre_departamento");
														while($FilaDepartamento = mysqli_fetch_array($QueryDepartamentos))
														{
															if($FilaDepartamento["id_departamento"] == 20)
															{
																$TextoDepartamento = 'selected';
															}
															else
															{
																$TextoDepartamento = '';
															}
															?>
															<option value="<?php echo $FilaDepartamento["id_departamento"] ?>" <?php echo $TextoDepartamento; ?>><?php echo $FilaDepartamento["nombre_departamento"] ?></option>
															<?php
														}
													?>
											</select>
							  		   </div>

							  		   <div class="form-group" id="SiSalvadorAcompaniante" style="display: none">
											<label for="DepartamentoNoAsociado">Departamento</label>
										  	<select class="form-control selectpicker" required id="DepartamentosSalvadorAcompaniante" name="DepartamentosSalvadorAcompaniante">
														<?php
															$QueryDepartamentos = mysqli_query($db, "SELECT * FROM info_base.departamentos_el_salvador ORDER BY nombre_departamento");
															while($FilaDepartamento = mysqli_fetch_array($QueryDepartamentos))
															{
																if($FilaDepartamento["id_departamento"] == 20)
																{
																	$TextoDepartamento = 'selected';
																}
																else
																{
																	$TextoDepartamento = '';
																}
																?>
																<option value="<?php echo $FilaDepartamento["id_departamento"] ?>" <?php echo $TextoDepartamento; ?>><?php echo $FilaDepartamento["nombre_departamento"] ?></option>
																<?php
															}
														?>
												</select>
								  		</div>
									</div>

									<div class="col-lg-6">
										<div id="SIGuatemala">										
											<div class="form-group">
												<select class="form-control" required id="DepartamentoAsociado" name="DepartamentoAsociado" onchange="ObtenerMunicipios(this.value)">
												<?php
													$QueryDepartamentos = mysqli_query($db, "SELECT * FROM info_base.departamentos_guatemala ORDER BY nombre_departamento");
													while($FilaDepartamento = mysqli_fetch_array($QueryDepartamentos))
													{
														if($FilaDepartamento["id_departamento"] == 20)
														{
															$TextoDepartamento = 'selected';
														}
														else
														{
															$TextoDepartamento = '';
														}
														?>
														<option value="<?php echo $FilaDepartamento["id_departamento"] ?>" <?php echo $TextoDepartamento; ?>><?php echo $FilaDepartamento["nombre_departamento"] ?></option>
														<?php
													}
												?>
												</select>
												<label for="DepartamentoAsociado">Departamento</label>
											</div>

											<div class="form-group">
												<select class="form-control" required id="MunicipioAsociado" name="MunicipioAsociado" onchange="MostrarVisitaEsquipulas(this.value)">
												<?php
													$QueryDepartamentos = mysqli_query($db, "SELECT * FROM info_base.municipios_guatemala WHERE id_departamento = 20 ORDER BY nombre_municipio");
													while($FilaDepartamento = mysqli_fetch_array($QueryDepartamentos))
													{
														if($FilaDepartamento["id"] == 310)
														{
															$TextoDepartamento = 'selected';
														}
														else
														{
															$TextoDepartamento = '';
														}
														?>
														<option value="<?php echo $FilaDepartamento["id"] ?>" <?php echo $TextoDepartamento; ?>><?php echo $FilaDepartamento["nombre_municipio"] ?></option>
														<?php
													}
												?>
												</select>
												<label for="MunicipioAsociado">Municipio</label>
											</div>

										<div class="form-group" id="DivVisitaEsquipulasAcompaniante" style="display: none">
											<label for="VisitaEsquipulas">Cada Cuánto Visita Esquipulas</label>						
											<select name="SelectVisitaEsquipulasAcompaniante" id="SelectVisitaEsquipulasAcompaniante" class="form-control selectpicker">
												<option value="1">Cada mes</option>
												<option value="2">Dos veces al año</option>
												<option value="3">Una vez al año</option>
												<option value="4">Otros</option>
											</select>			
										</div>

											<div class="form-group">
												<select class="form-control selectpicker" required id="FrecuenciaVisitaAsociado" name="FrecuenciaVisitaAsociado">
													<option value="1">Semanal</option>
													<option value="2">Quincenal</option>
													<option value="3">Mensual</option>
													<option value="4">Trimestral</option>
													<option value="5">Semestral</option>
													<option value="6">Anual</option>
													<option value="7">Otros</option>
												</select>
												<label for="FrecuenciaVisitaAsociado">¿Con Qué Frecuencia Visita el Parque?</label>
											</div>

											<div class="form-group">
												<select class="form-control selectpicker" required id="EnteradoAsociado" name="EnteradoAsociado">
													<?php 
											$enterado = mysqli_query($db, "SELECT * FROM Taquilla.ENTERADO_PARQUE");
											while($enterado_result = mysqli_fetch_array($enterado))											{
													?>
													<option value="<?php echo $enterado_result["EP_ID"]?>"><?php echo $enterado_result["EP_NOMBRE"] ?></option>
												<?php 
													}
												?>
												</select>
												<label for="EnteradoAsociado">¿Cómo se enteró del Parque?</label>
											</div>

											<div class="form-group">
												<select class="form-control selectpicker" required id="BuscaAsociado" name="BuscaAsociado">
													<option value="1">Piscinas</option>
													<option value="2">Área Verde</option>
													<option value="3">Juegos Extremos</option>
													<option value="4">Tranquilidad</option>
													<option value="5">Área Deportiva</option>
													<option value="6">Amplitud</option>
													<option value="7">Otro</option>
												</select>
												<label for="BuscaAsociado">¿Qué Busca en un Centro Turístico?</label>
											</div>

										</div><!-- Fin Div SIGuatemala -->	
									</div>

								</div><!-- Fin div row  -->
							</div> <!-- DatosDemograficosAsociados -->
						</form>
						<br>
						<br>
						<br>
						<br>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="IngresoAcompanante()">Agregar</button>
					</div>
				</div>
			</div>
		</div>
<script>
function MostrarVisitaEsquipulas(x)
{
	if(x != 310)
	{
		$('#DivVisitaEsquipulasAcompaniante').show();
	}
	else
	{
		$('#DivVisitaEsquipulasAcompaniante').hide();
	}
}

function mostrarPais()
{
	if($('.otrosPaises').attr('checked'))
	{
		$('#DivProcedenciaExt').show();
		$('#DivProcedenciaGuatemala').hide();
	}
	else
	{
		$('#DivProcedenciaExt').hide();
		$('#DivProcedenciaGuatemala').show();
	}
}

function mostrarPaisE()
{
	if($('.otrosPaisesEventos').attr('checked'))
	{
		$('#DivProcedenciaExtE').show();
		$('#DivProcedenciaGuatemalaE').hide();
	}
	else
	{
		$('#DivProcedenciaExtE').hide();
		$('#DivProcedenciaGuatemalaE').show();
	}
}
	// jQuery(document).ready(function($) {
	// 	$('#ModalIngresoAsociados').modal('show');
	// });
</script>

<!-- 
		************************************************************************
		************************************************************************
						MODAL PARA INGRESO DE MENORES DE 5 AÑOS
		************************************************************************
		************************************************************************
		-->
		<div class="modal fade" id="ModalIngresoAsociadosMenores" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" style="width: 80%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title text-center"><b>Ingreso de Menores de 5 Años</b></h3>
					</div>
					<div class="modal-body">
						<form class="form" id="FormularioAcompanantes">
							<input type="hidden" name="CIFAsociado" id="CIFAsociado">
							<div class="row">
								<div class="form-group col-lg-6">
									<label >Cantidad de niños Menores a 5 años</label>
									<div class="col-lg-12">
										<label>
											<input type="number" class="form-control" name="CantidadaNiñosMenores">
										</label>
									</div><!--end .col -->
									
								</div>
								
							</div>
						</form>
	</div>
	<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="IngresoAcompananteMenores()">Agregar</button>
					</div>
	</div>
	
	</div>
	
	</div>
		<!-- 
		************************************************************************
		************************************************************************
							MODAL PARA VER ACOMPAÑANTES
		************************************************************************
		************************************************************************
		-->

		<div class="modal fade" id="ModalVerAcompanantes"  data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" style="width: 80%">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title text-center"><b>Ingreso de Acompañantes</b></h3>
					</div>
					<div class="modal-body" id="ResultadosAcompanantes">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

        <div class="modal fade" id="ModalVerAcompanantesMesAcual"  data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" style="width: 80%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title text-center"><b>Ingreso de Mes Acual</b></h3>
                    </div>
                    <div class="modal-body" id="ResultadosAcompanantesMesAcual">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>


	<script>
    var btn = document.querySelector('#btnEnviar');
    var btnlbl = btn.textContent;

    btn.addEventListener('click', function(e) {
    e.preventDefault();
    
    // deshabilita el botón y previene un doble clic
    this.disabled = true;
    this.textContent = 'Espere unos segundos...';
    
    // simula el proceso y reactiva el clic despues de 3 segundos
    setTimeout(function(){ btn.disabled=false; btn.textContent = btnlbl; }, 2000);
    });
</script>
