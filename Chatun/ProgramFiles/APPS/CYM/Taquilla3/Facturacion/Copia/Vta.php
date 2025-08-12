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
	<!-- END META -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->

	<style type="text/css">
        .fila-base{
            display: none;
        }
        .fila-base1{
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

    <script language=javascript type=text/javascript>
		function stopRKey(evt) {
		var evt = (evt) ? evt : ((event) ? event : null);
		var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
		if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
		}
		document.onkeypress = stopRKey; 
	</script>

	<script>
		function BuscarProducto(x)
        {

				//Obtenemos el value del input
		        var Precio = document.getElementsByName('Precio[]');
		        var Producto = document.getElementsByName('Producto[]');
		        var TipoProducto = document.getElementsByName('TipoProducto[]');
		        var service = x.value;
		        var dataString = 'service='+service;
		        var Indice = $(x).closest('tr').index();
		        //Le pasamos el valor del input al ajax
		        $.ajax({
		            type: "POST",
		            url: "buscarProducto.php",
		            data: dataString,
		            beforeSend: function()
		            {
		            	$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
		            },
		            success: function(data) {
		            	if(data == 0)
		            	{
		            		alertify.error('No se encontró ningún registro');
		            		$('#suggestions').html('');
		            	}
		            	else
		            	{
		            		$('#ModalSugerencias').modal('show');
			                //Escribimos las sugerencias que nos manda la consulta
			                $('#suggestions').fadeIn(1000).html(data);
			                //Al hacer click en algua de las sugerencias
			                $('.suggest-element').click(function(){
			                    x.value = $(this).attr('data');
			                    Precio[Indice].value = $(this).attr('dataPrecio');
			                    Producto[Indice].value = $(this).attr('id');
			                    TipoProducto[Indice].value = $(this).attr('dataTipoProducto');
			                    //Hacemos desaparecer el resto de sugerencias
			                    $('#suggestions').fadeOut(500);
			                    $('#ModalSugerencias').modal('hide');
			                    CalcularTotal();			                    
			                });
			            }
		            }
		        });
			}
		function CRD()
		{
			var Total = 0;
			var TotalDescuento = 0
			var TotalFactura = parseFloat($('#BoldTotal').val());
			var Descuento    = parseFloat($('#BoldDescuento').val());

			
			Total = Descuento;
			TotalDescuento = TotalFactura;
			$('#BoldDescuento').val(Total.toFixed(2));
			$('#BoldTotal').val(TotalDescuento.toFixed(2));
			if($('#MonedaPagoInput').val() == 1)
			{
				$('#TotalFacturaCobrarEfectivoQuetzales').val(TotalDescuento.toFixed(2));
			}
			else if($('#MonedaPagoInput').val() == 2)
			{
				$('#TotalFacturaCobrarEfectivoDolares').val(TotalDescuento.toFixed(2));
				var TotalDolaresFactura = (TotalDescuento.toFixed(2) / $('#TasaCambioDolar').val());
				$('#TotalFacturaCobrarEfectivoDolaresQuetzalizado').val(TotalDolaresFactura.toFixed(2));
			}
			else if($('#MonedaPagoInput').val() == 3)
			{
				$('#TotalFacturaCobrarEfectivoLempira').val(TotalDescuento.toFixed(2));
				var TotalLempirasFactura = (TotalDescuento.toFixed(2) / $('#TasaCambioLempira').val());
				$('#TotalFacturaCobrarEfectivoLempiraQuetzalizado').val(TotalLempirasFactura.toFixed(2));
			}
			$('#TotalFacturaCobrarTCredito').val(TotalDescuento.toFixed(2));
			$('#TotalFacturaCobrarCredito').val(TotalDescuento.toFixed(2));
			$('#TotalFacturaCobrarDeposito').val(TotalDescuento.toFixed(2));
		}
		function AgregarLinea()
		{
			$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
		}
		function AddLine()
		{
			$("#TablaSabores tr:eq(0)").clone().removeClass('fila-base1').appendTo("#TablaSabores");
		}
		function EliminarLinea(x)
		{
			var Indice = $(x).closest('tr').index();
			var parent = $(x).parents().get(1);
                $(parent).remove();
                CalcularTotal();
            DelSabor(Indice);
		}
		function DelSabor(x)
		{
			$.ajax({
				type: "POST",
				url: "DelSabor.php",
				data: "Fila="+x,
				beforeSend: function()
				{
					$('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
				},
				error: function(data) {
					alert('Algo Salió Mal!!!!');
				}
			});
		}
		function TipoPago(x)
		{
			if(x == 1)
			{
				$('#TipoPago').val(1);
				
				$('#FormaPagoTCredito').hide();
				$('#SeleccionarMoneda').show();
				$('#FormaPagoCredito').hide();
				$('#FormaPagoDeposito').hide();
				$('#NombreCredito').hide();
				$('#NumeroAutorizacion').hide();
			}
			else if(x == 2)
			{
				$('#TipoPago').val(2);
				$('#SeleccionarMoneda').hide();
				$('#FormaPagoEfectivo').hide();
				$('#FormaPagoTCredito').show();
				$('#FormaPagoCredito').hide();
				$('#FormaPagoDeposito').hide();
				$('#NombreCredito').hide();
				$('#FormaPagoEfectivoQuetzales').hide();
				$('#FormaPagoEfectivoDolar').hide();
				$('#FormaPagoEfectivoLempiras').hide();
				$('#NumeroAutorizacion').show();
			}
			else if(x == 3)
			{
				$('#TipoPago').val(3);
				$('#SeleccionarMoneda').hide();
				$('#FormaPagoEfectivo').hide();
				$('#FormaPagoTCredito').hide();
				$('#FormaPagoCredito').show();
				$('#FormaPagoDeposito').hide();
				$('#NombreCredito').show();
				$('#FormaPagoEfectivoQuetzales').hide();
				$('#FormaPagoEfectivoDolar').hide();
				$('#FormaPagoEfectivoLempiras').hide();
				$('#NumeroAutorizacion').hide();
			}
			else if(x == 4)
			{
				$('#TipoPago').val(4);
				$('#SeleccionarMoneda').hide();
				$('#FormaPagoEfectivo').hide();
				$('#FormaPagoTCredito').hide();
				$('#FormaPagoCredito').hide();
				$('#FormaPagoDeposito').show();
				$('#NombreCredito').hide();
				$('#FormaPagoEfectivoQuetzales').hide();
				$('#FormaPagoEfectivoDolar').hide();
				$('#FormaPagoEfectivoLempiras').hide();
				$('#NumeroAutorizacion').hide();
			}
		}
		function ComprobarNIT(x)
		{
			$.ajax({
				url: 'BuscarNIT.php',
				type: 'POST',
				data: 'id='+x,
				success: function(opciones)
				{
					var Datos = JSON.parse(opciones);

					if(parseFloat(opciones) != 0)
					{
						$('#Nombre').val(Datos['Nombre']);
						$('#Direccion').val(Datos['Direccion']);

						$('#DIVCIF').removeClass('has-success has-error has-feedback');
						$('#SpanNIT').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

						$('#DIVCIF').addClass('has-success has-feedback');
						$('#SpanNIT').addClass('glyphicon glyphicon-ok form-control-feedback');
						$('#EMNIT').html('');

						$('#ClienteRegistrado').val(1);
						
					}
					else if(parseFloat(opciones) == 0)
					{	
						$('#DIVCIF').removeClass('has-success has-error has-feedback');
						$('#SpanNIT').removeClass('glyphicon glyphicon-remove glyphicon-ok form-control-feedback');

						$('#DIVCIF').addClass('has-error has-feedback');
						$('#SpanNIT').addClass('glyphicon glyphicon-remove form-control-feedback');
						$('#EMNIT').html('El Número de NIT no está registrado');	
						$('#ClienteRegistrado').val(2);					
					}
				},
				error: function(opciones)
				{
					alert('Error'+opciones);
				}
			})
		}
		function AbrirModalPrincipal(x)
		{
			$('#ModalPrincipal').modal('show');
			var Indice = $(x).closest('tr').index();
			$('#ROWControl').val(Indice);
			$(x).blur();
		}
		function RegresarAPrincipal()
		{
			$('#ModalResultados').modal('hide');
			$('#ModalPrincipal').modal('show');
		}
		function AbrirModalResultados(x)
		{
			$('#ModalPrincipal').modal('hide');

			$.ajax({
				url: 'ObtenerProductos.php',
				type: 'POST',
				data: 'id='+x,
				success: function(opciones)
				{
					$('#Resultados').html(opciones)
				},
				error: function(opciones)
				{
					alert('Error'+opciones);
				}
			});
			$('#ModalResultados').modal('show');
		}
		function AgregarProducto(x)
		{	
			var ProductoNombre = document.getElementsByName('ProductoNombre[]');
			var Producto = document.getElementsByName('Producto[]');
			var Precio = document.getElementsByName('Precio[]');
			var Indice = $('#ROWControl').val();
			Producto[Indice].value = $(x).attr('dataProducto');
			ProductoNombre[Indice].value = $(x).attr('dataNombre');
			Precio[Indice].value = $(x).attr('dataPrecio');
			$('#ModalResultados').modal('hide');
			CalcularTotal();
		}
		function CalcularTotal()
		{
			var Precio   = document.getElementsByName('Precio[]');
			var Cantidad = document.getElementsByName('Cantidad[]');
			var Descuento = document.getElementsByName('Descuento[]');
			var SubTotal = document.getElementsByName('SubTotal[]');
			var Total = 0;
			var SubTotalCalculado = 0;
			var TotalDescuentoFac = 0;
			for(i = 1; i < Precio.length; i++)
			{
				SubTotalCalculado = parseFloat(Cantidad[i].value) * parseFloat(Precio[i].value) - parseFloat(Descuento[i].value);
				SubTotal[i].value = SubTotalCalculado.toFixed(2);
				TotalDescuentoFac = parseFloat(TotalDescuentoFac) + parseFloat(Descuento[i].value);
				Total = Total + SubTotalCalculado;
			}
			$('#BoldTotal').val(Total.toFixed(2));
			$('#TotalDescuentoFactura').val(TotalDescuentoFac.toFixed(2));
			//CalcularTotalDescuento();
			CalcularCambio();
			CalcularCambioDolares();
			CalcularCambioLempiras();
		}
		function CalcularCambio()
		{
			var TotalFactura = $('#TotalFacturaCobrarEfectivoQuetzales').val();
			var Efectivo     = $('#TotalEfectivo').val();
			var TotalCambio  = 0;
			var Cambio       = document.getElementById('Cambio');

			TotalCambio =  parseFloat(Efectivo) - parseFloat(TotalFactura);

			Cambio.value = TotalCambio.toFixed(2);
		}
		function CalcularCambioDolares()
		{
			var TotalFactura = $('#TotalFacturaCobrarEfectivoDolaresQuetzalizado').val();
			var Efectivo     = $('#TotalEfectivoDolares').val();
			var TotalCambio  = 0;
			var Cambio       = document.getElementById('CambioDolaresQuetzalizados');

			TotalCambio = (Efectivo -TotalFactura) * $('#TasaCambioDolar').val();
			Cambio.value = TotalCambio.toFixed(2);
		}
		function CalcularCambioLempiras()
		{
			var TotalFactura = $('#TotalFacturaCobrarEfectivoLempiraQuetzalizado').val();
			var Efectivo     = $('#TotalEfectivoLempira').val();
			var TotalCambio  = 0;
			var Cambio       = document.getElementById('CambioLempirasQuetzalizados');

			TotalCambio = (Efectivo -TotalFactura) * $('#TasaCambioLempira').val();
			Cambio.value = TotalCambio.toFixed(2);
		}
		function AgregarDescuento()
		{

			$('#ModalDescuentos').modal('show');
		}
		function AgregarDescuentoData(x)
		{
			var NombreDescuento = $(x).attr('dataNombre');
			var PorcentajeDescuento = $(x).attr('dataDescuento');
			var DescuentoCodigo = $(x).attr('dataCodigoDesc');

			var Cadena = '<h3><b>'+NombreDescuento+'</b></h3>';

			$('#NombreDescunto').html(Cadena);
			$('#PorcientoDescuento').val(PorcentajeDescuento);
			$('#DescuentoCodigo').val(DescuentoCodigo);
			$('#ModalDescuentos').modal('hide');

			CalcularTotal();
		}
		function AgregarDescuentoPrev()
		{
			$('#ModalDescuentoPrev').modal('show');			
		}
		function CalcularTotalDescuento()
		{
			var Total = 0;
			var TotalDescuento = 0
			var TotalFactura = parseFloat($('#BoldTotal').val());
			var Descuento    = parseFloat($('#PorcientoDescuento').val());

			
			Total = TotalFactura *(Descuento / 100);
			TotalDescuento = parseFloat($('#BoldTotal').val()) - Total;
			$('#BoldDescuento').val(Total.toFixed(2));
			$('#BoldTotal').val(TotalDescuento.toFixed(2));
			if($('#MonedaPagoInput').val() == 1)
			{
				$('#TotalFacturaCobrarEfectivoQuetzales').val(TotalDescuento.toFixed(2));
			}
			else if($('#MonedaPagoInput').val() == 2)
			{
				$('#TotalFacturaCobrarEfectivoDolares').val(TotalDescuento.toFixed(2));
				var TotalDolaresFactura = (TotalDescuento.toFixed(2) / $('#TasaCambioDolar').val());
				$('#TotalFacturaCobrarEfectivoDolaresQuetzalizado').val(TotalDolaresFactura.toFixed(2));
			}
			else if($('#MonedaPagoInput').val() == 3)
			{
				$('#TotalFacturaCobrarEfectivoLempira').val(TotalDescuento.toFixed(2));
				var TotalLempirasFactura = (TotalDescuento.toFixed(2) / $('#TasaCambioLempira').val());
				$('#TotalFacturaCobrarEfectivoLempiraQuetzalizado').val(TotalLempirasFactura.toFixed(2));
			}
			
			$('#TotalFacturaCobrarTCredito').val(TotalDescuento.toFixed(2));
			$('#TotalFacturaCobrarCredito').val(TotalDescuento.toFixed(2));
			$('#TotalFacturaCobrarDeposito').val(TotalDescuento.toFixed(2));

		}
		function SelMoneda(x)
		{
			if(x == 1)
			{
				$('#MonedaPagoInput').val(1);
				$('#FormaPagoEfectivoQuetzales').show();
				$('#FormaPagoEfectivoDolar').hide();
				$('#FormaPagoEfectivoLempiras').hide();
				CRD();
			}
			else if(x == 2)
			{
				$('#MonedaPagoInput').val(2);
				$('#FormaPagoEfectivoDolar').show();
				$('#FormaPagoEfectivoQuetzales').hide();
				$('#FormaPagoEfectivoLempiras').hide();
				CRD();
			}
			else
			{
				$('#MonedaPagoInput').val(3);
				$('#FormaPagoEfectivoLempiras').show();
				$('#FormaPagoEfectivoQuetzales').hide();
				$('#FormaPagoEfectivoDolar').hide();
				CRD();
			}
		}
		
		function AperturaCaja()
		{
			alert('Debe aperturar caja para poder iniciar operaciones');
			window.location.replace('../Caja/Apertura.php');
		}
		function CierreCaja()
		{
			alert('La Caja ya fue cerrada');
			window.location.replace('../index.php');
		}
		function ComprobarPass()
		{
			$('#ModalDescuentoPrev').modal('hide');	
			var Pass = $('#PassDescuento').val();
			var UserID = $('#UserID').val();
			$.ajax({
				url: 'ComprobarContra.php',
				type: 'POST',
				data: 'id='+Pass+'&user='+UserID,
				success: function(opciones)
				{
					if(opciones == 1)
					{
						var Pass = $('#PassDescuento').val('');
						
						$('.InputDescuento').prop('readonly', false);
					}
					else
					{
						var Pass = $('#PassDescuento').val('');
						alertify.error('La contraseña es incorrecta');
					}
					
				},
				error: function(opciones)
				{
					alert('Error'+opciones);
				}
			})
		}
		function ErrorResolucion()
		{
			alert("No existe una resolución activa!");
			window.location = '../index.php';
		}
		function ValidarFormulario()
		{
			$('#BotonFinalizar').attr('disabled', true);
			var Valido = false;
			

			if($('#TipoPago').val() == '')
			{
				alertify.alert('Debe Seleccionar un tipo de pago antes de finalizar la factura');
				Valido = false;
				$('#BotonFinalizar').attr('disabled', false);
			}
			else
			{
				if($('#TipoPago').val() == 1)
				{
					if($('#MonedaPagoInput').val() == 1)
					{
						if($('#TotalEfectivo').val() == '')
						{
							alertify.alert('Debe ingresar Cuanto dinero en efectivo recibió en Quetzales');
							document.getElementById('TotalEfectivo').focus();
							Valido = false;
							$('#BotonFinalizar').attr('disabled', false);
						}
						else
						{
							Valido = true;
							$('#BotonFinalizar').attr('disabled', true);
						}
					}
					else if($('#MonedaPagoInput').val() == 2)
					{
						if($('#TotalEfectivoDolares').val() == '')
						{
							alertify.alert('Debe ingresar Cuanto dinero en efectivo recibió en Dólares');
							document.getElementById('TotalEfectivoDolares').focus();
							Valido = false;
							$('#BotonFinalizar').attr('disabled', false);
						}
						else
						{
							Valido = true;
							$('#BotonFinalizar').attr('disabled', true);
						}
					}
					else if($('#MonedaPagoInput').val() == 3)
					{
						if($('#TotalEfectivoLempira').val() == '')
						{
							alertify.alert('Debe ingresar Cuanto dinero en efectivo recibió en Lempiras');
							document.getElementById('TotalEfectivoLempira').focus();
							Valido = false;
							$('#BotonFinalizar').attr('disabled', false);
						}
						else
						{
							Valido = true;
							$('#BotonFinalizar').attr('disabled', true);
						}
					}
					else
					{
						alertify.alert('Debe seleccionar un Tipo de Moneda');
						document.getElementById('TotalEfectivo').focus();
						Valido = false;
						$('#BotonFinalizar').attr('disabled', false);
					}
				}
				else if($('#TipoPago').val() == 2)
				{
					if($('#NumeroAutorizacionTXT').val() == '')
					{
						alertify.alert('Debes llenar el número de autorización antes de continuar con la factura');
						document.getElementById('NumeroAutorizacionTXT').focus();
						Valido = false;
						$('#BotonFinalizar').attr('disabled', false);
					}
					else
					{
						Valido = true;
						$('#BotonFinalizar').attr('disabled', true);
					}
				}
				else if($('#TipoPago').val() == 3)
				{
					if($('#NombreCreditoTXT').val() == '')
					{
						alertify.alert('Debes ingresar el menos un nombre y un apellido para el nombre del crédito');
						document.getElementById('NombreCreditoTXT').focus();
						Valido = false;
						$('#BotonFinalizar').attr('disabled', false);
					}
					else
					{
						Valido = true;
						$('#BotonFinalizar').attr('disabled', true);
					}
				}
				else if($('#TipoPago').val() == 4)
				{
					if($('#CuentaBancaria').val() == '')
					{
						alertify.alert('Debes seleccionar a que cuenta bancaria caerá el depósito ');
						document.getElementById('CuentaBancaria').focus();
						Valido = false;
						$('#BotonFinalizar').attr('disabled', false);
					}
					else
					{
						Valido = true;
						$('#BotonFinalizar').attr('disabled', true);
					}
				}
			}

			if(Valido == true)
			{
				$('#FormularioPrincipal').submit();
			}
		}
		function ComprobarAcentos(inputtext)
		{
		  if(!inputtext) return false;
		  if(inputtext.value.match('[á,é,í,ó,ú]|[Á,É,Í,Ó,Ú]'))
		  {
		    alert('No se permiten acentos');
		    inputtext.value = '';
		    inputtext.focus();
		    return true;
		  }
		  return false;
		}
	</script>

</head>
<body class="menubar-hoverable header-fixed menubar-pin " onload="CalcularTotal()">

	<?php include("../../../../MenuTop.php") ?>

	<?php

	$ConsultaSerie = "SELECT RES_SERIE, RES_NUMERO FROM Bodega.RESOLUCION WHERE RES_ESTADO = 1 AND RES_TIPO = 'HS'";
	$ResultSerie = mysqli_query($db, $ConsultaSerie);
	$ExisteResolucion = mysqli_num_rows($ResultSerie);
	if($ExisteResolucion == 0)
	{
		echo '<script>ErrorResolucion()</script>';
	}

	$ConsultaOrden = "SELECT F_ORDEN FROM Bodega.FACTURA_HS WHERE F_FECHA_TRANS = CURRENT_DATE ORDER BY F_ORDEN DESC LIMIT 1";
	$ResultOrden = mysqli_query($db, $ConsultaOrden);
	$RegistrosOrden = mysqli_num_rows($ResultOrden);
	if($RegistrosOrden == 0)
	{
		$NumeroOrden = 1;
	}
	else
	{
		while($filaO = mysqli_fetch_array($ResultOrden))
		{
			$NumeroOrden = $filaO["F_ORDEN"] + 1;
		}
	}

	$ConsultaApertura = "SELECT ACC_CODIGO FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_FECHA = CURRENT_DATE AND ACC_TIPO = 5";
	$ResultApertura = mysqli_query($db, $ConsultaApertura);
	$RegistrosApertura = mysqli_num_rows($ResultApertura);
	if($RegistrosApertura == 0)
	{
		?>
		<script>
			AperturaCaja();
		</script>
		<?php
	}

	$ConsultaCierre = "SELECT ACC_CODIGO FROM Bodega.APERTURA_CIERRE_CAJA WHERE ACC_FECHA = CURRENT_DATE AND ACC_TIPO = 5 AND ACC_ESTADO = 2";
	$ResultCierre = mysqli_query($db, $ConsultaCierre);
	$RegistrosCierre = mysqli_num_rows($ResultCierre);
	if($RegistrosCierre > 0)
	{
		?>
		<script>
			CierreCaja();
		</script>
		<?php
	}
	
	$queryTasaCambioLempira = "SELECT TC_TASA FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 1";
	$resultTasaCambioLempira = mysqli_query($db, $queryTasaCambioLempira);
	while($FilaTCL = mysqli_fetch_array($resultTasaCambioLempira))
	{
		$TasaCambioLempira = $FilaTCL["TC_TASA"];
	}

	$queryTasaCambioDolar = "SELECT TC_TASA FROM Contabilidad.TASA_CAMBIO WHERE TC_CODIGO = 2";
	$resultTasaCambioDolar = mysqli_query($db, $queryTasaCambioDolar);
	while($FilaTCL = mysqli_fetch_array($resultTasaCambioDolar))
	{
		$TasaCambioDolar = $FilaTCL["TC_TASA"];
	}

	$QueryTS = mysqli_query($db, "DELETE FROM Bodega.TEMPORAL_SABORES");



	echo '<input type="text" id="UserID" value="'.$id_user.'" >';

	echo '<input type="text" id="TasaCambioDolar" value="'.$TasaCambioDolar.'" >';
	echo '<input type="text" id="TasaCambioLempira" value="'.$TasaCambioLempira.'" >';
	?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
				<section>
					<div class="section-header">
						<ol class="breadcrumb">
							<li class="active"></li>
						</ol>
					</div>
					<div class="section-body contain-lg">
						<!-- BEGIN VALIDATION FORM WIZARD -->
						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-body ">
										<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
											<form class="form form-validation" role="form" novalidate="novalidate" action="VtaPro.php" method="POST" role="form" id="FormularioPrincipal">
												<div class="form-wizard-nav">
													<div class="progress"><div class="progress-bar progress-bar-primary"></div></div>
													<ul class="nav nav-justified" style="display: none">
														<li class="active"><a href="#step1" data-toggle="tab"><span class="step">1</span> <span class="title">ORDEN</span></a></li>
														<li><a href="#step2" data-toggle="tab"><span class="step">2</span> <span class="title">COMPRA</span></a></li>
														<li><a href="#step3" data-toggle="tab"><span class="step">3</span> <span class="title">PAGO</span></a></li>
													</ul>
												</div><!--end .form-wizard-nav -->
												<div class="row">
													<br>
													<br>
													<br>
												</div>
												<div class="tab-content clearfix">
													<div class="tab-pane active" id="step1">
														<div class="row">
															<div class="col-lg-10"></div>
															<div class="col-lg-2 text-center">
																<div class="form-group floating-label">
																	<input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" required readonly/>
																	<label for="Fecha">Fecha</label>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-3">
																<div class="form-group" id="DIVCIF">
																	<input class="form-control" type="text" name="NIT" id="NIT" onchange="ComprobarNIT(this.value)" value="CF" autofocus required/>
																	<label for="NIT">Número de NIT</label>
																	<span id="SpanNIT"></span>
																</div>
																<div id="EMNIT"></div>
															</div>
															<div class="col-lg-9">
																<div class="form-group" id="DIVCIF">
																	<input class="form-control" type="text" name="Nombre" id="Nombre" value="Consumidor Final" onkeyup="ComprobarAcentos(this)" required readonly/>
																	<label for="Nombre">Nombre</label>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-12">
																<div class="form-group" id="DIVCIF">
																	<input class="form-control" type="text" name="Direccion" id="Direccion" value="Ciudad" onkeyup="ComprobarAcentos(this)"  required readonly />
																	<label for="Direccion">Dirección</label>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-10">
																<div class="form-group">
																	<input class="form-control" type="text" name="Observaciones" id="Observaciones"/>
																	<label for="Observaciones">Observaciones</label>
																</div>
															</div>
														</div>
														<div class="form-group">
															<div class="col-lg-3">
																<button type="button" class="btn btn-success btn-md" onclick="AgregarDescuentoPrev()">
						                                            <span class="glyphicon glyphicon-plus"></span> Descuento
						                                        </button>
															</div>
														</div>
														<input class="form-control" type="hidden" name="DescuentoCodigo" id="DescuentoCodigo" value="0"  required/>
														<input class="form-control" type="hidden" name="ClienteRegistrado" id="ClienteRegistrado"  required/>
														<div class="row">
															<br>
														</div>
														<div class="row">
															<br>
															<br>
														</div>
														<div class="row">
															<table class="table" name="tabla" id="tabla">
																<thead>
																	<tr>
																		<th>Cantidad</th>
																		<th>Producto</th>
																		<th>Precio</th>
																		<th>Descuento</th>
																		<th>Subtotal</th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="fila-base">
						                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onChange="CalcularTotal()" style="width: 100px" min="0"><input type="hidden" class="form-control" name="TipoProducto[]" id="TipoProducto[]"></h6></td>
						                                                <input type="hidden" class="form-control" name="Producto[]" id="Producto[]">						                                                
						                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="Precio[]" id="Precio[]" onChange="CalcularTotal()"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
						                                                <td><h6><input type="number" class="form-control InputDescuento" name="Descuento[]" id="Descuento[]" readonly style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" onchange="CalcularTotal()"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly></h6></td>
						                                                <td class="eliminar">
						                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
						                                                        <span class="glyphicon glyphicon-trash"></span>
						                                                    </button>
						                                                </td>
						                                            </tr>
						                                            <?php
																	if(isset($_POST["CodigoProducto"]) && isset($_POST["Cantidad"]) && isset($_POST["Valor"]) && isset($_POST["Total"]))
																	{
																		$CodigoProducto = $_POST["CodigoProducto"];
																		$Cantidad     = $_POST["Cantidad"];
																		$Valor        = $_POST["Valor"];
																		$Total        = $_POST["Total"];
																		
																		?>
																		<tr>
							                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" value="<?php echo $Cantidad[0] ?>" readonly onChange="CalcularTotal()" style="width: 100px" min="0"><input type="hidden" class="form-control" name="TipoProducto[]" id="TipoProducto[]"></h6></td>
							                                                <input type="hidden" class="form-control" name="Producto[]" id="Producto[]" value="821">
							                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" value="Ingreso Adultos" readonly style="width: 500px" onchange="BuscarProducto(this)"></h6></td>
							                                                <td><h6><input type="number" class="form-control" name="Precio[]" id="Precio[]" value="<?php echo $Valor[0] ?>" onChange="CalcularTotal()" style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
							                                                <td><h6><input type="number" class="form-control InputDescuento" name="Descuento[]" id="Descuento[]" readonly style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" onchange="CalcularTotal()"></h6></td>
							                                                <td><h6><input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]" value="<?php echo $Total[0] ?>"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly></h6></td>
							                                            </tr>
							                                            <tr>
							                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" value="<?php echo $Cantidad[1] ?>" readonly onChange="CalcularTotal()" style="width: 100px" min="0"><input type="hidden" class="form-control" name="TipoProducto[]" id="TipoProducto[]"></h6></td>
							                                                <input type="hidden" class="form-control" name="Producto[]" id="Producto[]" value="822">
							                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" value="Ingreso Niños" readonly style="width: 500px" onchange="BuscarProducto(this)"></h6></td>
							                                                <td><h6><input type="number" class="form-control" name="Precio[]" id="Precio[]" value="<?php echo $Valor[1] ?>" onChange="CalcularTotal()" style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
							                                                <td><h6><input type="number" class="form-control InputDescuento" name="Descuento[]" id="Descuento[]" readonly style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" onchange="CalcularTotal()"></h6></td>
							                                                <td><h6><input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]" value="<?php echo $Total[1] ?>"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly></h6></td>
							                                            </tr>
							                                            <tr>
							                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" value="<?php echo $Cantidad[2] ?>" readonly onChange="CalcularTotal()" style="width: 100px" min="0"><input type="hidden" class="form-control" name="TipoProducto[]" id="TipoProducto[]"></h6></td>
							                                                <input type="hidden" class="form-control" name="Producto[]" id="Producto[]" value="823">
							                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" value="Ingreso Niños Menores a 5 Años" readonly style="width: 500px" onchange="BuscarProducto(this)"></h6></td>
							                                                <td><h6><input type="number" class="form-control" name="Precio[]" id="Precio[]" value="<?php echo $Valor[2] ?>" onChange="CalcularTotal()" style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
							                                                <td><h6><input type="number" class="form-control InputDescuento" name="Descuento[]" id="Descuento[]" readonly style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" onchange="CalcularTotal()"></h6></td>
							                                                <td><h6><input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]" value="<?php echo $Total[2] ?>"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly></h6></td>
							                                            </tr>
							                                            <?php
																	}
																	?>
						                                            <tr>
						                                                <td><h6><input type="number" class="form-control" name="Cantidad[]" id="Cantidad[]" onChange="CalcularTotal()" style="width: 100px" min="0"><input type="hidden" class="form-control" name="TipoProducto[]" id="TipoProducto[]"></h6></td>
						                                                <input type="hidden" class="form-control" name="Producto[]" id="Producto[]">
						                                                <td><h6><input type="text" class="form-control" name="ProductoNombre[]" id="ProductoNombre[]" style="width: 500px" onchange="BuscarProducto(this)"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="Precio[]" id="Precio[]" onChange="CalcularTotal()"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00"></h6></td>
						                                                <td><h6><input type="number" class="form-control InputDescuento" name="Descuento[]" id="Descuento[]" readonly style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" onchange="CalcularTotal()"></h6></td>
						                                                <td><h6><input type="number" class="form-control" name="SubTotal[]" id="SubTotal[]"  style="width: 100px" min="0" step="any" style="text-align: right" value="0.00" readonly></h6></td>
						                                                <td class="eliminar">
						                                                    <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
						                                                        <span class="glyphicon glyphicon-trash"></span>
						                                                    </button>
						                                                </td>
						                                            </tr>
																</tbody>
																<tfoot>
																	<tr style="display: none">
						                                                <td></td>
						                                                <td></td>
						                                                <td style="text-align: right; vertical-align: text-top; font-size: 18px"><b>Descuento Q.</b></td>
						                                                <td style="text-align: left; vertical-align: text-top; font-size: 18px"><input class="form-control" type="text" id="BoldDescuento" name="TotalFacturaConDescuento" value="0.00" readonly></td>
						                                                <td></td>
						                                            </tr>
																	<tr>
						                                                <td></td>
						                                                <td></td>
						                                                <td style="text-align: right; vertical-align: text-top; font-size: 20px"><b>Total Q.</b></td>
						                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="BoldTotal" name="TotalFacturaFinal" value="0.00" readonly></td>
						                                                <td></td>
						                                            </tr> 
																</tfoot>
															</table>
															<div class="col-lg-12" align="left">
						                                        <button type="button" class="btn btn-success btn-md" id="agregar" onclick="AgregarLinea()">
						                                            <span class="glyphicon glyphicon-plus"></span> Agregar
						                                        </button>
						                                    </div>
														</div>
														<input type="hidden" id="ROWControl" />
													</div><!--end #step1 -->
													<div class="tab-pane" id="step2">
														<div class="col-lg-3">
															<div class="card">
																<div class="card-body no-padding">
																	<div class="alert alert-callout alert-success no-margin">
																		<div>
																			<div class="text-center">
																				<a style="text-decoration: none; cursor: pointer" onclick="TipoPago(1)" ><h1><span class="text-light">Efectivo <i class="fa fa-money text-success"></i></span></h1></a>
																			</div>
																		</div>
																	</div>
																</div><!--end .card-body -->
															</div><!--end .card -->
														</div>
														<div class="col-lg-3">
															<div class="card">
																<div class="card-body no-padding">
																	<div class="alert alert-callout alert-success no-margin">
																		<div>
																			<div class="text-center">
																				<a style="text-decoration: none; cursor: pointer" onclick="TipoPago(2)" ><h1><span class="text-light">Tarjeta <i class="fa fa-credit-card text-success"></i></span></h1></a>
																			</div>
																		</div>
																	</div>
																</div><!--end .card-body -->
															</div><!--end .card -->
														</div>
														<div class="col-lg-3">
															<div class="card">
																<div class="card-body no-padding">
																	<div class="alert alert-callout alert-success no-margin">
																		<div>
																			<div class="text-center">
																				<a style="text-decoration: none; cursor: pointer" onclick="TipoPago(3)" ><h1><span class="text-light">Crédito <i class="md md-account-balance-wallet text-success"></i></span></h1></a>
																			</div>
																		</div>
																	</div>
																</div><!--end .card-body -->
															</div><!--end .card -->
														</div>
														<div class="col-lg-3">
															<div class="card">
																<div class="card-body no-padding">
																	<div class="alert alert-callout alert-success no-margin">
																		<div>
																			<div class="text-center">
																				<a style="text-decoration: none; cursor: pointer" onclick="TipoPago(4)" ><h1><span class="text-light">Depósito <i class="fa fa-ticket text-success"></i></span></h1></a>
																			</div>
																		</div>
																	</div>
																</div><!--end .card-body -->
															</div><!--end .card -->
														</div>
														<div id="SeleccionarMoneda" style="display: none">
															<div class="row">
																<div class="container"></div>
																<br>
																<br>
															</div>
															<div class="row col-lg-12">
																<div class="col-lg-4">
																	<a style="text-decoration: none; cursor: pointer" onClick="SelMoneda(1)">
																		<div class="card">
																			<div class="card-body no-padding">
																				<div class="alert alert-callout alert-danger no-margin">
																					<div>
																						<div class="text-center" >
																							<h1><span class="text-ultra-bold text-danger">Q</i></span></h1>
																							<h4 class="text-bold">Quetzales</h4>
																						</div>
																					</div>
																				</div>
																			</div><!--end .card-body -->
																		</div><!--end .card -->
																	</a>
																</div>
																<div class="col-lg-4">
																	<a style="text-decoration: none; cursor: pointer" onClick="SelMoneda(2)">
																		<div class="card">
																			<div class="card-body no-padding">
																				<div class="alert alert-callout alert-danger no-margin">
																					<div>
																						<div class="text-center" >
																							<h1><span class="text-ultra-bold text-danger">$</i></span></h1>
																							<h4 class="text-bold">Dólares</h4>
																						</div>
																					</div>
																				</div>
																			</div><!--end .card-body -->
																		</div><!--end .card -->
																	</a>
																</div>
																<div class="col-lg-4">
																	<a style="text-decoration: none; cursor: pointer" onClick="SelMoneda(3)">
																		<div class="card">
																			<div class="card-body no-padding">
																				<div class="alert alert-callout alert-danger no-margin">
																					<div>
																						<div class="text-center" >
																							<h1><span class="text-ultra-bold text-danger">L</i></span></h1>
																							<h4 class="text-bold">Lempiras</h4>
																						</div>
																					</div>
																				</div>
																			</div><!--end .card-body -->
																		</div><!--end .card -->
																	</a>
																</div>
															</div>
														</div>
													</div><!--end #step2 -->
													<div class="tab-pane" id="step3">
														<input type="HIDDEN" class="form-control" id="MonedaPagoInput" name="MonedaPagoInput" readonly required>
														<input type="HIDDEN" name="TipoPago" id="TipoPago" />
														<div class="col-lg-12" id="FormaPagoEfectivoQuetzales" style="display: none">
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				
																				<input type="text" class="form-control" id="NombreMonedaPago" name="NombreMonedaPago" value="Quetzales" readonly required>
																				<label for="NombreMonedaPago">Moneda</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalFacturaCobrarEfectivoQuetzales" name="TotalFacturaCobrarEfectivoQuetzales" readonly required>
																				<label for="TotalFacturaCobrarEfectivoQuetzales">Total Factura</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalEfectivo" name="TotalEfectivo" onchange="CalcularCambio()" required>
																				<label for="TotalEfectivo">Efectivo</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="Cambio" name="Cambio" readonly required>
																				<label for="Cambio">Cambio</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<br>
																<br>
															</div>
														</div>
														<div class="col-lg-12" id="FormaPagoEfectivoDolar" style="display: none">
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">$.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="NombreMonedaPago" name="NombreMonedaPago" value="Dólares"  readonly required>
																				<label for="NombreMonedaPago">Moneda</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalFacturaCobrarEfectivoDolares" name="TotalFacturaCobrarEfectivoDolares" readonly required>
																				<label for="TotalFacturaCobrarEfectivoDolares">Total Factura</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">$.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalFacturaCobrarEfectivoDolaresQuetzalizado" name="TotalFacturaCobrarEfectivoDolaresQuetzalizado" readonly required>
																				<label for="TotalFacturaCobrarEfectivoDolaresQuetzalizado">Total Factura</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">$.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalEfectivoDolares" name="TotalEfectivoDolares" onchange="CalcularCambioDolares()" required>
																				<label for="TotalEfectivoDolares">Efectivo</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="CambioDolaresQuetzalizados" name="CambioDolaresQuetzalizados" readonly required>
																				<label for="CambioDolaresQuetzalizados">Cambio</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<br>
																<br>
															</div>
														</div>
														<div class="col-lg-12" id="FormaPagoEfectivoLempiras" style="display: none">
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">L.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="NombreMonedaPago" name="NombreMonedaPago" value="Lempira"  readonly required>
																				<label for="NombreMonedaPago">Moneda</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalFacturaCobrarEfectivoLempira" name="TotalFacturaCobrarEfectivoLempira" readonly required>
																				<label for="TotalFacturaCobrarEfectivoLempira">Total Factura</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">L.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalFacturaCobrarEfectivoLempiraQuetzalizado" name="TotalFacturaCobrarEfectivoLempiraQuetzalizado" readonly required>
																				<label for="TotalFacturaCobrarEfectivoLempiraQuetzalizado">Total Factura</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">L.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalEfectivoLempira" name="TotalEfectivoLempira" onchange="CalcularCambioLempiras()" required>
																				<label for="TotalEfectivoLempira">Efectivo</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="CambioLempirasQuetzalizados" name="CambioLempirasQuetzalizados" readonly required>
																				<label for="CambioLempirasQuetzalizados">Cambio</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<br>
																<br>
															</div>
														</div>
														<div class="col-lg-12" id="FormaPagoDeposito" style="display: none">
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalFacturaCobrarDeposito" name="TotalFacturaCobrarDeposito" readonly required>
																				<label for="TotalFacturaCobrarDeposito">Total Factura</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="NumeroBoleta" name="NumeroBoleta" >
																				<label for="NumeroBoleta">No. Boleta</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>

																<div class="row">
																<div class="col-lg-4"></div>
																<div class="col-lg-4 text-center">
																	<div class="form-group">
																		<select name="CuentaBancaria" id="CuentaBancaria" class="form-control" required>
																			<option value="" selected disabled>Seleccione una Opción</option>
																			<?php

																			$QueryCB = "SELECT N_CODIGO, N_NOMBRE FROM Contabilidad.NOMENCLATURA WHERE N_CODIGO BETWEEN '1.01.02.001' AND '1.01.02.999' ORDER BY N_NOMBRE";
																			$ResultCB = mysqli_query($db, $QueryCB);
																			while($FilaCB = mysqli_fetch_array($ResultCB))
																			{
																				echo '<option value="'.$FilaCB["N_CODIGO"].'">'.$FilaCB["N_NOMBRE"].'</option>';
																			}

																			?>
																		</select>
																	</div>
																</div>
																</div>
														</div>
														<div class="col-lg-12" id="FormaPagoCredito" style="display: none">
															<div class="row">
															<div class="col-lg-5"></div>
																<div class="col-lg-2 text-center">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon">Q.</span>
																			<div class="input-group-content">
																				<input type="text" class="form-control" id="TotalFacturaCobrarCredito" name="TotalFacturaCobrarCredito" readonly required>
																				<label for="TotalFacturaCobrarCredito">Total Factura</label>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														
														<div id="NombreCredito" style="display: none">
															<div class="row">
																<div class="col-lg-3 text-center"></div>
																<div class="col-lg-5 text-center">
																	<div class="form-group">
																	<input class="form-control" type="text" name="NombreCreditoTXT" id="NombreCreditoTXT" required/>
																	<label for="NombreCreditoTXT">Nombre del Crédito</label>
																</div>
																</div>
															</div>
														</div>
														<div id="NumeroAutorizacion" style="display: none">
															<div class="row">
																<div class="col-lg-3 text-center"></div>
																<div class="col-lg-5 text-center">
																	<div class="form-group">
																	<input class="form-control" type="text" name="NumeroAutorizacionTXT" id="NumeroAutorizacionTXT" required/>
																	<label for="NumeroAutorizacionTXT">Número de Autorización</label>
																</div>
																</div>
															</div>
															<div class="row">
																<div class="col-lg-3 text-center"></div>
																<div class="col-lg-5 text-center">
																	<div class="form-group">
																	<select class="form-control" name="TipoTarjeta" id="TipoTarjeta" 	required>
																		<option value="1">VISA</option>
																		<option value="2">CREDOMATIC</option>
																    </select>
																	<label for="TipoTarjeta">Tipo Tarjeta</label>
																</div>
																</div>
															</div>
														</div>
														<div class="row text-center">
															<button type="button" class="btn btn-success btn-lg" onclick="ValidarFormulario()" id="BotonFinalizar">
																<span class="glyphicon glyphicon-ok"></span>  Finalizar
															</button>
														</div>
													</div>
												</div><!--end .tab-content -->
												<ul class="pager wizard">
													<li class="previous disabled"><button type="button" class="btn ink-reaction btn-raised btn-lg btn-accent-dark" href="javascript:void(0);">Anterior</button></li>
													<li class="next"><button type="button" class="btn ink-reaction btn-raised btn-lg btn-accent-dark" href="javascript:void(0);">Siguiente</button></li>
												</ul>

											
												<table id="TablaSabores">
													<tr class="fila-base1">
														<td><input type="hidden" class="form-control" name="id[]" id="id[]"></td>
														<td><input type="hidden" class="form-control" name="Producto[]" id="Producto[]"></td>
													</tr>
												</table>



											</form>
										</div><!--end #rootwizard -->
									</div><!--end .card-body -->
								</div><!--end .card -->
							</div><!--end .col -->
						</div><!--end .row -->

					</div><!--end .section-body -->
				</section>
			</div><!--end #content-->
			<!-- END CONTENT -->
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>


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
	<script src="../../../../../js/core/demo/DemoFormWizard.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../../../../../js/libs/jquery-validation/dist/additional-methods.min.js"></script>
	<script src="../../../../../js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>

	<script src="../../../../../libs/alertify/js/alertify.js"></script>

	<!-- END JAVASCRIPT -->

	<!-- Modal Detalle Pasivo Contingente -->
	<div id="ModalPrincipal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 80%">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
					<?php

						//Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
						$query = "SELECT CATEGORIA_MENU.CM_NOMBRE, CATEGORIA_MENU.CM_CODIGO 
									FROM Bodega.CATEGORIA_MENU, Bodega.RECETA_SUBRECETA
									WHERE CATEGORIA_MENU.CM_CODIGO = RECETA_SUBRECETA.CM_CODIGO
									AND RECETA_SUBRECETA.RS_TIPO = 1
									GROUP BY RECETA_SUBRECETA.CM_CODIGO";
						$result = mysqli_query($db, $query);
						while($row = mysqli_fetch_array($result))
						{
							?>
								<div class="col-lg-3 col-md-6">
				                    <div class="panel panel-primary">
				                        <div class="panel-heading">
				                            <div class="row">
				                                <div class="col-xs-12 text-center">
				                                    <a onClick="AbrirModalResultados(<?php echo $row["CM_CODIGO"]; ?>)" style="text-decoration: none; cursor: pointer"><div><?php echo $row["CM_NOMBRE"] ?></div></a>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
							<?php
						}

					?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign" ></span> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Detalle Pasivo Contingente -->

	<!-- Modal Detalle Pasivo Contingente -->
	<div id="ModalResultados" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 80%">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row" id="Resultados">
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning btn-md" onclick="RegresarAPrincipal()">
					<span class="glyphicon glyphicon-arrow-left" ></span> Principal
					</button>
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove-sign" ></span> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Detalle Pasivo Contingente -->

	<!-- Modal Detalle Pasivo Contingente -->
	<div id="ModalDescuentos" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 50%">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" align="center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
					<?php

						//Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
					$query = "SELECT * FROM Bodega.DESCUENTO WHERE D_TIPO = 1 ORDER BY D_NOMBRE";
					$result = mysqli_query($db, $query);
					while($row = mysqli_fetch_array($result))
					{
						?>
						<div class="col-lg-3 col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-12 text-center">
											<a style="text-decoration: none; cursor: pointer" dataNombre="<?php echo $row["D_NOMBRE"] ?>" dataDescuento="<?php echo $row["D_PORCENTAJE"] ?>" dataCodigoDesc="<?php echo $row["D_CODIGO"] ?>" onClick="AgregarDescuentoData(this)"><div><?php echo $row["D_NOMBRE"] ?></div></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
					}

					?>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">
						<span class="glyphicon glyphicon-remove-sign" ></span> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Detalle Pasivo Contingente -->

	<!-- Modal Detalle Pasivo Contingente -->
	<div id="ModalDescuentoPrev" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 50%">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header" align="center"><h4><strong>Ingrese Contraseña Para Agregar Descuento</strong></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-2 text-center">
							<div class="form-group">
							<div class="input-group">
									<div class="input-group-content">
										<input type="password" class="form-control" id="PassDescuento" name="PassDescuento" minlenght="4">
										<label for="PassDescuento">Contraseña</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success btn-md" onClick="ComprobarPass()">
						<span class="glyphicon glyphicon-ok" ></span> Enviar
					</button>
					<button type="button" class="btn btn-danger btn-md" data-dismiss="modal">
						<span class="glyphicon glyphicon-remove-sign" ></span> Cerrar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- /Modal Detalle Pasivo Contingente -->

	<!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSugerencias" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Resultados de su búsqueda</h2>
                    </div>
                    <div class="modal-body">
                    	<div id="suggestions" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->

        <!-- Modal Detalle Pasivo Contingente -->
        <div id="ModalSabores" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <h2 class="modal-title">Elegir sabor de las bolas de helado</h2>
                    </div>
                    <div class="modal-body">
                    	<form class="form" role="form" id="FormularioSabores">
	                    	<div id="SelectsSabores">

	                    	</div>
	                    	<button type="submit" id="BtnEvniarSabor" style="display: none"></button>
	                    </form>
                    </div>
                    <div class="modal-footer">
                    	<button type="button" class="btn btn-primary" onclick="AgregarSabores()">
                    	<span class="glyphicon glyphicon-check"></span> Agregar
                    	</button>
                    	
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Detalle Pasivo Contingente -->
	
</body>
</html>
