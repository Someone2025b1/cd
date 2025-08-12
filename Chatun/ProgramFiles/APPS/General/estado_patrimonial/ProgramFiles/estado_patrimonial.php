<?php
header('Content-Type:text/html;charset=utf-8');
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");

$UserID = $_SESSION["iduser"];
$Hoy = date('Y-m-d', strtotime('now'));

echo '<input type="hidden" id="UsuarioID" value="'.$UserID.'">';

$Consulta = "SELECT COUNT(id) AS TOTAL FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE id = ".$UserID." ORDER BY fecha DESC LIMIT 1";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
   $Registro = $row["TOTAL"];                   
}

if($Registro == 0)
{
    $Caja                       = 0;
    $DepositosCoosajo           = 0;
    $DepositosBancos            = 0;
    $FondoRetiro                = 0;
    $CuentasPorCobrar           = 0;
    $SubtotalActivoCirculante   = 0;

    $TerrenosConstrucciones     = 0;
    $Vehiculos                  = 0;
    $InversionesValoresAcciones = 0;
    $MobiliarioEquipo           = 0;
    $InversionesGanado          = 0;
    $OtrosActivos               = 0;
    $SubtotalActivoFijo         = 0;

    $ObligacionesCortoPlazoC    = 0;
    $ObligacionesCortoPlazoB    = 0;
    $TarjetasCredito            = 0;
    $AnticipoSueldo             = 0;
    $OtrosPrestamos             = 0;
    $CuentasDocumentosPorPagar  = 0;
    $Proveedores                = 0;
    $OtrosPasivoCirculante      = 0;
    $SubtotalPasivoCirculante   = 0;

    $ObligacionesLargoPlazoC    = 0;
    $ObligacionesLargoPlazoB    = 0;
    $OtrasDeudasPasivoFijo      = 0;
    $SubtotalPasivoFijo         = 0;

    $TotalActivo                = 0;
    $TotalPasivo                = 0;
    $TotalPatrimonio            = 0;
    $TotalPasivoPatrimonio      = 0;

}
elseif($Registro > 0)
{
    $Consulta = "SELECT * FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE id = ".$UserID." ORDER BY fecha DESC LIMIT 1";
    $Resultado = mysqli_query($db, $Consulta);
    while($row = mysqli_fetch_array($Resultado))
    {
         $Caja                       = $row['caja'];
         $DepositosCoosajo           = $row['depositos_coosajo'];
         $DepositosBancos            = $row['depositos_bancos'];
         $FondoRetiro                = $row['fondo_retiro'];
         $CuentasPorCobrar           = $row['cuentas_cobrar'];
         $SubtotalActivoCirculante   = $row['subtotal_activocirculante'];
         
         $TerrenosConstrucciones     = $row['terrenos'];
         $Vehiculos                  = $row['vehiculos'];
         $InversionesValoresAcciones = $row['inversiones_valores'];
         $MobiliarioEquipo           = $row['mobiliario'];
         $InversionesGanado          = $row['inversiones_ganado'];
         $OtrosActivos               = $row['otros_activos'];
         $SubtotalActivoFijo         = $row['subtotal_activofijo'];
         
         $ObligacionesCortoPlazoC    = $row['prestamos_coosajo_menor'];
         $ObligacionesCortoPlazoB    = $row['prestamos_bancos_menor'];
         $TarjetasCredito            = $row['tarjetas_credito'];
         $AnticipoSueldo             = $row['anticipo_sueldo'];
         $OtrosPrestamos             = $row['otros_prestamos'];
         $CuentasDocumentosPorPagar  = $row['cuentas_por_pagar'];
         $Proveedores                = $row['proveedores'];
         $OtrosPasivoCirculante      = $row['otros_pasivocirculante'];
         $SubtotalPasivoCirculante   = $row['subtotal_pasivocirculante'];
         
         $ObligacionesLargoPlazoC    = $row['prestamos_coosajo_mayores'];
         $ObligacionesLargoPlazoB    = $row['prestamos_bancos_mayores'];
         $OtrasDeudasPasivoFijo      = $row['otras_deudas'];
         $SubtotalPasivoFijo         = $row['subtotal_pasivofijo'];
         
         $TotalActivo                = $row['total_activo'];
         $TotalPasivo                = $row['total_pasivo'];
         $TotalPatrimonio            = $row['patrimonio'];
         $TotalPasivoPatrimonio      = $row['total_pasivo_patrimonio'];                   
    } 
}

$Consulta1 = "SELECT COUNT(colaborador) AS TOTAL FROM Estado_Patrimonial.proyeccion_ingresos_egresos_detalle WHERE colaborador = ".$UserID." ORDER BY fecha DESC LIMIT 1";
$Resultado1 = mysqli_query($db, $Consulta1);
while($row1 = mysqli_fetch_array($Resultado1))
{
   $Registro = $row1["TOTAL"];                   
}

if($Registro == 0)
{
    $SueldosSalarios       = 0;
    $GastosPersonales      = 0;
    $Bonificaciones        = 0;
    $GastosFamiliares      = 0;
    $AlquileresRentas      = 0;
    $DescuentosSalariales  = 0;
    $JubilacionesPensiones = 0;
    $AmortizacionCreditos  = 0;
    $BonoAguinaldo         = 0;
    $PagoTarjetaCredito    = 0;
    $OtrosIngresos         = 0;
    $OtrosEgresos          = 0;
    $TotalIngresosP        = 0;
    $TotalEgresosP         = 0;

}
elseif($Registro > 0)
{
    $Consulta = "SELECT * FROM Estado_Patrimonial.proyeccion_ingresos_egresos_detalle WHERE colaborador = ".$UserID." ORDER BY fecha DESC LIMIT 1";
    $Resultado = mysqli_query($db, $Consulta);
    while($row = mysqli_fetch_array($Resultado))
    {
       $SueldosSalarios       = $row['sueldos_salarios'];
       $GastosPersonales      = $row['gastos_personales'];
       $Bonificaciones        = $row['bonificaciones'];
       $GastosFamiliares      = $row['gastos_familiares'];
       $AlquileresRentas      = $row['alquileres_rentas'];
       $DescuentosSalariales  = $row['descuentos_salariales'];
       $JubilacionesPensiones = $row['jubilaciones_pensiones'];
       $AmortizacionCreditos  = $row['amortizacion_creditos'];
       $BonoAguinaldo         = $row['bono14_aguinaldo'];
       $PagoTarjetaCredito    = $row['pago_tarjetas_credito'];
       $OtrosIngresos         = $row['otros_ingresos'];
       $OtrosEgresos          = $row['otros_egresos'];
       $TotalIngresosP        = $row['total_ingresos'];
       $TotalEgresosP         = $row['total_egresos'];               
    } 
}


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
    <script src="js/bootstrapwizard.min.js"></script>

    <!-- Mint Admin Scripts - Include with every page -->
    <script src="js/mint-admin.js"></script>

    <style type="text/css">

        .stepwizard-step p {
            margin-top: 10px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 1px;
            background-color: #ccc;
            z-order: 0;

        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
          width: 30px;
          height: 30px;
          text-align: center;
          padding: 6px 0;
          font-size: 12px;
          line-height: 1.428571429;
          border-radius: 15px;
      }

  </style>

  <script>
    $(document).ready(function () {

        var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
            $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-primary').addClass('btn-default');
                $item.addClass('btn-primary');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function(){
            var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

            $(".form-group").removeClass("has-error");
            for(var i=0; i<curInputs.length; i++){
                if (!curInputs[i].validity.valid){
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if (isValid)
                nextStepWizard.removeAttr('disabled').trigger('click');
        });

        $('div.setup-panel div a.btn-primary').trigger('click');
    });
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
        ActualizarTablaTerrenos();
        ActualizarNoTerrenos();
        ActualizarTablaVehiculos();
        ActualizarNoVehiculos();
        ActualizarTablaValores();
        ActualizarNoValores();
        ActualizarTablaObligacionesCortoPlazoC();
        ActualizarTablaObligacionesCortoPlazoB();
        ActualizarNoObligacionesCortoPlazoC();
        ActualizarNoObligacionesCortoPlazoB();
        ActualizarTablaTarjetas();
        ActualizarNoTarjetas();
        ActualizarTablaObligacionesLargoPlazoC();
        ActualizarTablaObligacionesLargoPlazoB();
        ActualizarNoObligacionesLargoPlazoC();
        ActualizarNoObligacionesLargoPlazoB();
        ActActivoCirculante();
        ActActivoFijo();
        ActPasivoCirculante();
        ActPasivoFijo();
        ActualizarOtrosIngresos();
        ActualizarNoOtrosIngresos();
        ActualizarOtrosEgresos();
        ActualizarNoOtrosEgresos();
        CalcularProyeccionIE();
    });
</script>

<script>
    function currency(value, decimals, separators) {
        decimals = decimals >= 0 ? parseInt(decimals, 0) : 2;
        separators = separators || ['.', "'", ','];
        var number = (parseFloat(value) || 0).toFixed(decimals);
        if (number.length <= (4 + decimals))
            return number.replace('.', separators[separators.length - 1]);
        var parts = number.split(/[-.]/);
        value = parts[parts.length > 1 ? parts.length - 2 : 0];
        var result = value.substr(value.length - 3, 3) + (parts.length > 1 ?
            separators[separators.length - 1] + parts[parts.length - 1] : '');
        var start = value.length - 6;
        var idx = 0;
        while (start > -3) {
            result = (start > 0 ? value.substr(start, 3) : value.substr(0, 3 + start))
            + separators[idx] + result;
            idx = (++idx) % 2;
            start -= 3;
        }
        return (parts.length == 3 ? '-' : '') + result;
    }
    function ChgEntidadFinanciera(x)
    {
        if(x == 'Coosajo R.L.')
        {
            $('#Acreedor').attr('readOnly', true);
            $('#Acreedor').val('Coosajo R.L.');
        }
        else
        {
            $('#Acreedor').attr('readOnly', false);
            $('#Acreedor').val('');
        }
    }
    function ChgEntidadFinancieraLP(x)
    {
        if(x == 'Coosajo R.L.')
        {
            $('#AcreedorLP').attr('readOnly', true);
            $('#AcreedorLP').val('Coosajo R.L.');
        }
        else
        {
            $('#AcreedorLP').attr('readOnly', false);
            $('#AcreedorLP').val('');
        }
    }
    function ActActivoCirculante()
    {
        var Total;
        var TotalMost;
        Total = parseFloat($('#Caja').val()) + parseFloat($('#DepositosCoosajo').val()) + parseFloat($('#DepositosBancos').val()) + parseFloat($('#FondoRetiro').val()) + parseFloat($('#CuentasPorCobrar').val());
        TotalMost = currency(Total, 2, [',', "'", '.']);
        Total = Total.toFixed(2);
        $('#SubtotalActivoCirculante').val(Total);
        $('#SubtotalActivoCirculanteMost').val(TotalMost);
        ActualizarTotalActivo();
    }
    function ActActivoFijo()
    {
        var Total;
        var TotalMost;
        Total = parseFloat($('#TerrenosConstrucciones').val()) + parseFloat($('#Vehiculos').val()) + parseFloat($('#InversionesValoresAcciones').val()) + parseFloat($('#MobiliarioEquipo').val()) + parseFloat($('#InversionesGanado').val()) + parseFloat($('#OtrosActivos').val());
        TotalMost = currency(Total, 2, [',', "'", '.']);
        Total = Total.toFixed(2);
        $('#SubtotalActivoFijo').val(Total);
        $('#SubtotalActivoFijoMost').val(TotalMost);
        ActualizarTotalActivo();
    }
    function ActPasivoCirculante()
    {
        var Total;
        var TotalMost;
        Total = parseFloat($('#ObligacionesCortoPlazoC').val()) + parseFloat($('#ObligacionesCortoPlazoB').val()) + parseFloat($('#TarjetasCredito').val()) + parseFloat($('#AnticipoSueldo').val()) + parseFloat($('#OtrosPrestamos').val()) + parseFloat($('#CuentasDocumentosPorPagar').val()) + parseFloat($('#Proveedores').val()) + parseFloat($('#OtrosPasivoCirculante').val());
        TotalMost = currency(Total, 2, [',', "'", '.']);
        Total = Total.toFixed(2);
        $('#SubtotalPasivoCirculante').val(Total);
        $('#SubtotalPasivoCirculanteMost').val(TotalMost);
        ActualizarTotalPasivo();
    }
    function ActPasivoFijo()
    {
        var Total;
        var TotalMost;
        Total = parseFloat($('#ObligacionesLargoPlazoC').val()) + parseFloat($('#ObligacionesLargoPlazoB').val()) + parseFloat($('#OtrasDeudasPasivoFijo').val());
        TotalMost = currency(Total, 2, [',', "'", '.']);
        Total = Total.toFixed(2);
        $('#SubtotalPasivoFijo').val(Total);
        $('#SubtotalPasivoFijoMost').val(TotalMost);
        ActualizarTotalPasivo();
    }
    function ActualizarTotalActivo()
    {
        var Total;
        var TotalMost;
        Total = parseFloat($('#SubtotalActivoCirculante').val()) + parseFloat($('#SubtotalActivoFijo').val());
        TotalMost = currency(Total, 2, [',', "'", '.']);
        Total = Total.toFixed(2);
        $('#TotalActivo').val(Total);
        $('#TotalActivoMost').val(TotalMost);
        ActualizarTotalPatrimonio();
    }
    function ActualizarTotalPasivo()
    {
        var Total;
        var TotalMost;
        Total = parseFloat($('#SubtotalPasivoCirculante').val()) + parseFloat($('#SubtotalPasivoFijo').val());
        TotalMost = currency(Total, 2, [',', "'", '.']);
        Total = Total.toFixed(2);
        $('#TotalPasivo').val(Total);
        $('#TotalPasivoMost').val(TotalMost);
        ActualizarTotalPatrimonio();
    }
    function ActualizarTotalPatrimonio()
    {
        var Total;
        var TotalMost;
        Total = parseFloat($('#TotalActivo').val()) - parseFloat($('#TotalPasivo').val());
        TotalMost = currency(Total, 2, [',', "'", '.']);
        Total = Total.toFixed(2);
        $('#TotalPatrimonio').val(Total);
        $('#TotalPatrimonioMost').val(TotalMost);
        ActualizarPasivoPatrimonio();
    }
    function ActualizarPasivoPatrimonio()
    {
        var Total;
        var TotalMost;
        Total = parseFloat($('#TotalPasivo').val()) + parseFloat($('#TotalPatrimonio').val());
        TotalMost = currency(Total, 2, [',', "'", '.']);
        Total = Total.toFixed(2);
        $('#TotalPasivoPatrimonio').val(Total);
        $('#TotalPasivoPatrimonioMost').val(TotalMost);
    }
    function IngresarTerrenos()
    {
        var TipoInmueble = $('#TipoInmueble').val();
        var Localizacion = $('#Localizacion').val();
        var Finca        = $('#Finca').val();
        var Folio        = $('#Folio').val();
        var Libro        = $('#Libro').val();
        var Departamento = $('#Departamento').val();
        var ValorMercado = $('#ValorMercado').val();
        var UsuarioID    = $('#UsuarioID').val();
        $.ajax({
            url: 'AddBienesInmuebles.php',
            type: 'post',
            data: 'TipoInmueble='+TipoInmueble+'&Finca='+Finca+'&Folio='+Folio+'&Libro='+Libro+'&Departamento='+Departamento+'&ValorMercado='+ValorMercado+'&UsuarioID='+UsuarioID+'&Localizacion='+Localizacion,
            success: function(output)
            {
                $('#ModalAddTerrenos').modal("hide");
                ActualizarTablaTerrenos();
                ActualizarNoTerrenos();
                ActActivoFijo();
                document.getElementById("BienesInmueblesFORM").reset();
                alertify.success('La información se actualizó con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarTablaTerrenos()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaBienesInmuebles.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaBienesInmuebles').html(opciones)
            }
        })
    }
    function EliminarBienesInmuebles(x)
    {
        var ID = x.getAttribute('ID');
        alertify.confirm("¿Está seguro que desea eliminar el inmueble seleccionado?", function (e) {
            if (e) {
                $.ajax({
                    url: 'DelBienesInmuebles.php',
                    type: 'post',
                    data: 'ID='+ID,
                    success: function(output)
                    {
                        ActualizarTablaTerrenos();
                        ActualizarNoTerrenos();
                        ActActivoFijo();
                        alertify.success('El inmueble fue eliminado con éxito');
                    },
                    error: function()
                    {
                        alertify.error('Algo salió mal');
                    }
                });
            }
        });
    }
    function ActualizarNoTerrenos()
    {
        var Terrenos = document.getElementById('TerrenosConstrucciones');
        var TerrenosMost = document.getElementById('TerrenosConstruccionesMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActTerrenos.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    Terrenos.value = 0;
                    TerrenosMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {
                    Terrenos.value = output;
                    TerrenosMost.value = currency(output, 2, [',', "'", '.']);
                }
                
                ActActivoFijo();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function IngresarVehiculos()
    {
        var Marca                = $('#Marca').val();
        var Modelo               = $('#Modelo').val();
        var Color                = $('#Color').val();
        var ValorMercadoVehiculo = $('#ValorMercadoVehiculo').val();
        var UsuarioID            = $('#UsuarioID').val();
        $.ajax({
            url: 'AddVehiculos.php',
            type: 'post',
            data: 'Marca='+Marca+'&Modelo='+Modelo+'&Color='+Color+'&ValorMercadoVehiculo='+ValorMercadoVehiculo+'&UsuarioID='+UsuarioID,
            success: function(output)
            {
                $('#ModalAddVehiculos').modal("hide");
                ActualizarTablaVehiculos();
                ActualizarNoVehiculos();
                ActActivoFijo();
                document.getElementById("VehiculosFORM").reset();
                alertify.success('La información se actualizó con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarTablaVehiculos()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaVehiculos.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaVehiculos').html(opciones)
            }
        })
    }
    function EliminarVehiculos(x)
    {
        var ID = x.getAttribute('ID');
        alertify.confirm("¿Está seguro que desea eliminar el vehículo seleccionado?", function (e) {
            if (e) {
                $.ajax({
                    url: 'DelVehiculo.php',
                    type: 'post',
                    data: 'ID='+ID,
                    success: function(output)
                    {
                        ActualizarTablaVehiculos();
                        ActualizarNoVehiculos();
                        ActActivoFijo();
                        alertify.success('El vehículo fue eliminado con éxito');
                    },
                    error: function()
                    {
                        alertify.error('Algo salió mal');
                    }
                });
            }
        });
    }
    function ActualizarNoVehiculos()
    {
        var Vehiculos = document.getElementById('Vehiculos');
        var VehiculosMost = document.getElementById('VehiculosMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActVehiculos.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    Vehiculos.value = 0;
                    VehiculosMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {
                    Vehiculos.value = output;
                    VehiculosMost.value = currency(output, 2, [',', "'", '.']);   
                }
                ActActivoFijo();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function IngresarValores()
    {
        var ClaseTitulo    = $('#ClaseTitulo').val();
        var Institucion    = $('#Institucion').val();
        var MontoInvertido = $('#MontoInvertido').val();
        var ValorComercial = $('#ValorComercial').val();
        var UsuarioID      = $('#UsuarioID').val();
        $.ajax({
            url: 'AddValores.php',
            type: 'post',
            data: 'ClaseTitulo='+ClaseTitulo+'&Institucion='+Institucion+'&MontoInvertido='+MontoInvertido+'&ValorComercial='+ValorComercial+'&UsuarioID='+UsuarioID,
            success: function(output)
            {
                $('#ModalAddValores').modal("hide");
                ActualizarTablaValores();
                ActualizarNoValores();
                ActActivoFijo();
                document.getElementById("ValoresFORM").reset();
                alertify.success('La información se actualizó con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarTablaValores()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaValores.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaValores').html(opciones)
            }
        })
    }
    function EliminarValores(x)
    {
        var ID = x.getAttribute('ID');
        alertify.confirm("¿Está seguro que desea eliminar la accion/valor seleccionado?", function (e) {
            if (e) {
                $.ajax({
                    url: 'DelValores.php',
                    type: 'post',
                    data: 'ID='+ID,
                    success: function(output)
                    {
                        ActualizarTablaValores();
                        ActualizarNoValores();
                        ActActivoFijo();
                        alertify.success('El vehículo fue eliminado con éxito');
                    },
                    error: function()
                    {
                        alertify.error('Algo salió mal');
                    }
                });
            }
        });
    }
    function ActualizarNoValores()
    {
        var InversionesValoresAcciones = document.getElementById('InversionesValoresAcciones');
        var InversionesValoresAccionesMost = document.getElementById('InversionesValoresAccionesMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActValores.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    InversionesValoresAcciones.value = 0;
                    InversionesValoresAccionesMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {
                    InversionesValoresAcciones.value = output;
                    InversionesValoresAccionesMost.value = currency(output, 2, [',', "'", '.']);
                }
                
                ActActivoFijo();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function IngresarObligaciones()
    {
        var EntidadFinanciera = $('#EntidadFinanciera').val();
        var Acreedor          = $('#Acreedor').val();
        var Garantia          = $('#Garantia').val();
        var Vencimiento       = $('#Vencimiento').val();
        var MontoOriginal     = $('#MontoOriginal').val();
        var SaldoActual       = $('#SaldoActual').val();
        var Frecuencia        = $('#Frecuencia').val();
        var MontoCortoPlazo   = $('#MontoCortoPlazo').val();
        var UsuarioID         = $('#UsuarioID').val();
        $.ajax({
            url: 'AddObligaciones.php',
            type: 'post',
            data: 'EntidadFinanciera='+EntidadFinanciera+'&Acreedor='+Acreedor+'&Garantia='+Garantia+'&Vencimiento='+Vencimiento+'&MontoOriginal='+MontoOriginal+'&SaldoActual='+SaldoActual+'&UsuarioID='+UsuarioID+'&Frecuencia='+Frecuencia+'&MontoCortoPlazo='+MontoCortoPlazo,
            success: function(output)
            {
                $('#ModalAddObligacionesCortoPlazo').modal("hide");
                ActualizarTablaObligacionesCortoPlazoC();
                ActualizarTablaObligacionesCortoPlazoB();
                ActualizarNoObligacionesCortoPlazoC();
                ActualizarNoObligacionesCortoPlazoB();
                ActPasivoCirculante();
                document.getElementById("ObligacionesCortoPlazoFORM").reset();
                alertify.success('La información se actualizó con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarTablaObligacionesCortoPlazoC()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaObligacionesCortoPlazoC.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaObligacionesCortoPlazoC').html(opciones)
            }
        })
    }
    function ActualizarTablaObligacionesCortoPlazoB()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaObligacionesCortoPlazoB.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaObligacionesCortoPlazoB').html(opciones)
            }
        })
    }
    function EliminarObligaciones(x)
    {
        var ID = x.getAttribute('ID');
        alertify.confirm("¿Está seguro que desea eliminar el elemento seleccionado?", function (e) {
            if (e) {
                $.ajax({
                    url: 'DelObligaciones.php',
                    type: 'post',
                    data: 'ID='+ID,
                    success: function(output)
                    {
                        ActualizarTablaObligacionesCortoPlazoC();
                        ActualizarTablaObligacionesCortoPlazoB();
                        ActualizarNoObligacionesCortoPlazoC();
                        ActualizarNoObligacionesCortoPlazoB();
                        ActPasivoCirculante();
                        alertify.success('El elemento fue eliminado con éxito');
                    },
                    error: function()
                    {
                        alertify.error('Algo salió mal');
                    }
                });
            }
        });
    }
    function ActualizarNoObligacionesCortoPlazoC()
    {
        var ObligacionesCortoPlazoC = document.getElementById('ObligacionesCortoPlazoC');
        var ObligacionesCortoPlazoCMost = document.getElementById('ObligacionesCortoPlazoCMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActObligacionesCortoPlazoC.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    ObligacionesCortoPlazoC.value = 0;
                    ObligacionesCortoPlazoCMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {

                    ObligacionesCortoPlazoC.value = output;
                    ObligacionesCortoPlazoCMost.value = currency(output, 2, [',', "'", '.']);
                }
                ActPasivoCirculante();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarNoObligacionesCortoPlazoB()
    {
        var ObligacionesCortoPlazoB = document.getElementById('ObligacionesCortoPlazoB');
        var ObligacionesCortoPlazoBMost = document.getElementById('ObligacionesCortoPlazoBMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActObligacionesCortoPlazoB.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    ObligacionesCortoPlazoB.value = 0;
                    ObligacionesCortoPlazoBMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {

                    ObligacionesCortoPlazoB.value = output;
                    ObligacionesCortoPlazoBMost.value = currency(output, 2, [',', "'", '.']);
                }
                ActPasivoCirculante();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function IngresarTarjetasCredito()
    {
        var AcreedorTarjetas      = $('#AcreedorTarjetas').val();
        var VencimientoTarjetas   = $('#VencimientoTarjetas').val();
        var MontoOriginalTarjetas = $('#MontoOriginalTarjetas').val();
        var SaldoActualTarjetas   = $('#SaldoActualTarjetas').val();
        var UsuarioID             = $('#UsuarioID').val();
        $.ajax({
            url: 'AddTarjetas.php',
            type: 'post',
            data: 'AcreedorTarjetas='+AcreedorTarjetas+'&VencimientoTarjetas='+VencimientoTarjetas+'&MontoOriginalTarjetas='+MontoOriginalTarjetas+'&SaldoActualTarjetas='+SaldoActualTarjetas+'&UsuarioID='+UsuarioID,
            success: function(output)
            {
                $('#ModalAddTarjetas').modal("hide");
                ActualizarTablaTarjetas();
                ActualizarNoTarjetas();
                ActPasivoCirculante();
                document.getElementById("TarjetasCreditoFORM").reset();
                alertify.success('La información se actualizó con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarTablaTarjetas()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaTarjetas.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaTarjetas').html(opciones)
            }
        })
    }
    function EliminarTarjetas(x)
    {
        var ID = x.getAttribute('ID');
        alertify.confirm("¿Está seguro que desea eliminar la tarjeta seleccionada?", function (e) {
            if (e) {
                $.ajax({
                    url: 'DelTarjetas.php',
                    type: 'post',
                    data: 'ID='+ID,
                    success: function(output)
                    {
                        ActualizarTablaTarjetas();
                        ActualizarNoTarjetas();
                        ActPasivoCirculante();
                        alertify.success('La tarjeta fue eliminada con éxito');
                    },
                    error: function()
                    {
                        alertify.error('Algo salió mal');
                    }
                });
            }
        });
    }
    function ActualizarNoTarjetas()
    {
        var TarjetasCredito = document.getElementById('TarjetasCredito');
        var TarjetasCreditoMost = document.getElementById('TarjetasCreditoMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActTarjetas.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    TarjetasCredito.value = 0;
                    TarjetasCreditoMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {
                    TarjetasCredito.value = output;
                    TarjetasCreditoMost.value = currency(output, 2, [',', "'", '.']);
                }
                
                ActPasivoCirculante();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function IngresarObligacionesLP()
    {
        var EntidadFinanciera = $('#EntidadFinancieraLP').val();
        var Acreedor          = $('#AcreedorLP').val();
        var Garantia          = $('#GarantiaLP').val();
        var Vencimiento       = $('#VencimientoLP').val();
        var MontoOriginal     = $('#MontoOriginalLP').val();
        var SaldoActual       = $('#SaldoActualLP').val();
        var Frecuencia        = $('#FrecuenciaLP').val();
        var MontoCortoPlazo   = $('#MontoCortoPlazoLP').val();
        var UsuarioID         = $('#UsuarioID').val();
        $.ajax({
            url: 'AddObligacionesLP.php',
            type: 'post',
            data: 'EntidadFinanciera='+EntidadFinanciera+'&Acreedor='+Acreedor+'&Garantia='+Garantia+'&Vencimiento='+Vencimiento+'&MontoOriginal='+MontoOriginal+'&SaldoActual='+SaldoActual+'&UsuarioID='+UsuarioID+'&Frecuencia='+Frecuencia+'&MontoCortoPlazo='+MontoCortoPlazo,
            success: function(output)
            {
                $('#ModalAddObligacionesLargoPlazo').modal("hide");
                ActualizarTablaObligacionesLargoPlazoC();
                ActualizarTablaObligacionesLargoPlazoB();
                ActualizarNoObligacionesLargoPlazoC();
                ActualizarNoObligacionesLargoPlazoB();
                ActPasivoFijo();
                document.getElementById("ObligacionesLargoPlazoFORM").reset();
                alertify.success('La información se actualizó con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarTablaObligacionesLargoPlazoC()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaObligacionesLargoPlazoC.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaObligacionesLargoPlazoC').html(opciones)
            }
        })
    }
    function ActualizarTablaObligacionesLargoPlazoB()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaObligacionesLargoPlazoB.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaObligacionesLargoPlazoB').html(opciones)
            }
        })
    }
    function EliminarObligacioneslp(x)
    {
        var ID = x.getAttribute('ID');
        alertify.confirm("¿Está seguro que desea eliminar el elemento seleccionado?", function (e) {
            if (e) {
                $.ajax({
                    url: 'DelObligacioneslp.php',
                    type: 'post',
                    data: 'ID='+ID,
                    success: function(output)
                    {
                        ActualizarTablaObligacionesLargoPlazoC();
                        ActualizarTablaObligacionesLargoPlazoB();
                        ActualizarNoObligacionesLargoPlazoC();
                        ActualizarNoObligacionesLargoPlazoB();
                        ActPasivoFijo();
                        alertify.success('El elemento fue eliminado con éxito');
                    },
                    error: function()
                    {
                        alertify.error('Algo salió mal');
                    }
                });
            }
        });
    }
    function ActualizarNoObligacionesLargoPlazoC()
    {
        var ObligacionesLargoPlazoC = document.getElementById('ObligacionesLargoPlazoC');
        var ObligacionesLargoPlazoCMost = document.getElementById('ObligacionesLargoPlazoCMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActObligacionesLargoPlazoC.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    ObligacionesLargoPlazoC.value = 0;
                    ObligacionesLargoPlazoCMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {
                    ObligacionesLargoPlazoC.value = output;
                    ObligacionesLargoPlazoCMost.value = currency(output, 2, [',', "'", '.']);
                }
                ActPasivoFijo();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarNoObligacionesLargoPlazoB()
    {
        var ObligacionesLargoPlazoB = document.getElementById('ObligacionesLargoPlazoB');
        var ObligacionesLargoPlazoBMost = document.getElementById('ObligacionesLargoPlazoBMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActObligacionesLargoPlazoB.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    ObligacionesLargoPlazoB.value = 0;
                    ObligacionesLargoPlazoBMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {
                    ObligacionesLargoPlazoB.value = output;
                    ObligacionesLargoPlazoBMost.value = currency(output, 2, [',', "'", '.']);
                }
                ActPasivoFijo();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function GuardarEstadoPatrimonial()
    {
        var Caja                       = $('#Caja').val();
        var DepositosCoosajo           = $('#DepositosCoosajo').val();
        var DepositosBancos            = $('#DepositosBancos').val();
        var FondoRetiro                = $('#FondoRetiro').val();
        var CuentasPorCobrar           = $('#CuentasPorCobrar').val();
        var SubtotalActivoCirculante   = $('#SubtotalActivoCirculante').val();
        
        var TerrenosConstrucciones     = $('#TerrenosConstrucciones').val();
        var Vehiculos                  = $('#Vehiculos').val();
        var InversionesValoresAcciones = $('#InversionesValoresAcciones').val();
        var MobiliarioEquipo           = $('#MobiliarioEquipo').val();
        var InversionesGanado          = $('#InversionesGanado').val();
        var OtrosActivos               = $('#OtrosActivos').val();
        var SubtotalActivoFijo         = $('#SubtotalActivoFijo').val();
        
        var ObligacionesCortoPlazoC    = $('#ObligacionesCortoPlazoC').val();
        var ObligacionesCortoPlazoB    = $('#ObligacionesCortoPlazoB').val();
        var TarjetasCredito            = $('#TarjetasCredito').val();
        var AnticipoSueldo             = $('#AnticipoSueldo').val();
        var OtrosPrestamos             = $('#OtrosPrestamos').val();
        var CuentasDocumentosPorPagar  = $('#CuentasDocumentosPorPagar').val();
        var Proveedores                = $('#Proveedores').val();
        var OtrosPasivoCirculante      = $('#OtrosPasivoCirculante').val();
        var SubtotalPasivoCirculante   = $('#SubtotalPasivoCirculante').val();
        
        var ObligacionesLargoPlazoC    = $('#ObligacionesLargoPlazoC').val();
        var ObligacionesLargoPlazoB    = $('#ObligacionesLargoPlazoB').val();
        var OtrasDeudasPasivoFijo      = $('#OtrasDeudasPasivoFijo').val();
        var SubtotalPasivoFijo         = $('#SubtotalPasivoFijo').val();
        
        var TotalActivo                = $('#TotalActivo').val();
        var TotalPasivo                = $('#TotalPasivo').val();
        var TotalPatrimonio            = $('#TotalPatrimonio').val();
        var TotalPasivoPatrimonio      = $('#TotalPasivoPatrimonio').val();
        
        var Usuario                    = $('#UsuarioID').val();

        $.ajax({
            url: 'IngresarEstadoPatrimonial.php',
            type: 'post',
            data: 'Caja='+Caja+'&DepositosCoosajo='+DepositosCoosajo+'&DepositosBancos='+DepositosBancos+'&FondoRetiro='+FondoRetiro+'&CuentasPorCobrar='+CuentasPorCobrar+'&SubtotalActivoCirculante='+SubtotalActivoCirculante+'&TerrenosConstrucciones='+TerrenosConstrucciones+'&Vehiculos='+Vehiculos+'&InversionesValoresAcciones='+InversionesValoresAcciones+'&MobiliarioEquipo='+MobiliarioEquipo+'&InversionesGanado='+InversionesGanado+'&OtrosActivos='+OtrosActivos+'&SubtotalActivoFijo='+SubtotalActivoFijo+'&ObligacionesCortoPlazoC='+ObligacionesCortoPlazoC+'&ObligacionesCortoPlazoB='+ObligacionesCortoPlazoB+'&TarjetasCredito='+TarjetasCredito+'&AnticipoSueldo='+AnticipoSueldo+'&OtrosPrestamos='+OtrosPrestamos+'&CuentasDocumentosPorPagar='+CuentasDocumentosPorPagar+'&Proveedores='+Proveedores+'&OtrosPasivoCirculante='+OtrosPasivoCirculante+'&SubtotalPasivoCirculante='+SubtotalPasivoCirculante+'&ObligacionesLargoPlazoC='+ObligacionesLargoPlazoC+'&ObligacionesLargoPlazoB='+ObligacionesLargoPlazoB+'&OtrasDeudasPasivoFijo='+OtrasDeudasPasivoFijo+'&SubtotalPasivoFijo='+SubtotalPasivoFijo+'&TotalActivo='+TotalActivo+'&TotalPasivo='+TotalPasivo+'&TotalPatrimonio='+TotalPatrimonio+'&TotalPasivoPatrimonio='+TotalPasivoPatrimonio+'&Usuario='+Usuario,
            beforeSend: function()
            {
                $('#ModalLOAD').modal("show");
                $('#suggestions').html('<img src="../Imagenes/screens-preloader.gif" />');
                $('#ModalLOAD').modal("hide");
            },
            success: function(output)
            {   
                alertify.success('Sus datos se han actualizado con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function IngresarOtrosIngresos()
    {
        var DescripcionIngreso  = $('#DescripcionIngreso').val();
        var MontoMensualIngreso = $('#MontoMensualIngreso').val();
        var UsuarioID           = $('#UsuarioID').val();
        $.ajax({
            url: 'AddOtrosIngresos.php',
            type: 'post',
            data: 'DescripcionIngreso='+DescripcionIngreso+'&MontoMensualIngreso='+MontoMensualIngreso+'&UsuarioID='+UsuarioID,
            success: function(output)
            {
                $('#ModalAddOtrosIngresos').modal("hide");
                ActualizarOtrosIngresos();
                ActualizarNoOtrosIngresos();
                //ActPasivoCirculante();
                document.getElementById("OtrosIngresosFORM").reset();
                alertify.success('La información se actualizó con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarOtrosIngresos()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaOtrosIngresos.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaOtrosIngresos').html(opciones)
            }
        })
    }
    function EliminarOtrosIngresos(x)
    {
        var ID = x.getAttribute('ID');
        alertify.confirm("¿Está seguro que desea eliminar el elemento seleccionado?", function (e) {
            if (e) {
                $.ajax({
                    url: 'DelOtrosIngresos.php',
                    type: 'post',
                    data: 'ID='+ID,
                    success: function(output)
                    {
                        ActualizarOtrosIngresos();
                        ActualizarNoOtrosIngresos();
                        //ActPasivoCirculante();
                        alertify.success('La tarjeta fue eliminada con éxito');
                    },
                    error: function()
                    {
                        alertify.error('Algo salió mal');
                    }
                });
            }
        });
    }
    function ActualizarNoOtrosIngresos()
    {
        var OtrosIngresos = document.getElementById('OtrosIngresos');
        var OtrosIngresosMost = document.getElementById('OtrosIngresosMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActOtrosIngresos.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    OtrosIngresos.value = 0;
                    OtrosIngresosMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {
                    OtrosIngresos.value = output;
                    OtrosIngresosMost.value = currency(output, 2, [',', "'", '.']);
                }
                CalcularProyeccionIE();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function IngresarOtrosEgresos()
    {
        var DescripcionEgreso  = $('#DescripcionEgreso').val();
        var MontoMensualEgreso = $('#MontoMensualEgreso').val();
        var UsuarioID           = $('#UsuarioID').val();
        $.ajax({
            url: 'AddOtrosEgresos.php',
            type: 'post',
            data: 'DescripcionEgreso='+DescripcionEgreso+'&MontoMensualEgreso='+MontoMensualEgreso+'&UsuarioID='+UsuarioID,
            success: function(output)
            {
                $('#ModalAddOtrosEgresos').modal("hide");
                ActualizarOtrosEgresos();
                ActualizarNoOtrosEgresos();
                CalcularProyeccionIE();
                document.getElementById("OtrosEgresosFORM").reset();
                alertify.success('La información se actualizó con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function ActualizarOtrosEgresos()
    {
        var Usuario = document.getElementById('UsuarioID').value;
        $.ajax({
            url: 'LlenarTablaOtrosEgresos.php',
            type: 'POST',
            data: 'id='+Usuario,
            success: function(opciones)
            {
                $('#tablaOtrosEgresos').html(opciones)
            }
        })
    }
    function EliminarOtrosEgresos(x)
    {
        var ID = x.getAttribute('ID');
        alertify.confirm("¿Está seguro que desea eliminar el elemento seleccionado?", function (e) {
            if (e) {
                $.ajax({
                    url: 'DelOtrosEgresos.php',
                    type: 'post',
                    data: 'ID='+ID,
                    success: function(output)
                    {
                        ActualizarOtrosEgresos();
                        ActualizarNoOtrosEgresos();
                        CalcularProyeccionIE();
                        alertify.success('La tarjeta fue eliminada con éxito');
                    },
                    error: function()
                    {
                        alertify.error('Algo salió mal');
                    }
                });
            }
        });
    }
    function ActualizarNoOtrosEgresos()
    {
        var OtrosEgresos = document.getElementById('OtrosEgresos');
        var OtrosEgresosMost = document.getElementById('OtrosEgresosMost');
        var Usuario = $('#UsuarioID').val();

        $.ajax({
            url: 'ActOtrosEgresos.php',
            type: 'post',
            data: 'Usuario='+Usuario,
            success: function(output)
            {
                if(output == '')
                {
                    OtrosEgresos.value = 0;
                    OtrosEgresosMost.value = currency(output, 2, [',', "'", '.']);
                }
                else
                {
                    OtrosEgresos.value = output;
                    OtrosEgresosMost.value = currency(output, 2, [',', "'", '.']);
                }
                CalcularProyeccionIE();
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
    function CalcularProyeccionIE()
    {
        var TotalCalculoIngresos  = 0;
        var TotalCalculoEngresos  = 0;
        
        var SueldosSalarios       = $('#SueldosSalarios').val();
        var GastosPersonales      = $('#GastosPersonales').val();
        var Bonificaciones        = $('#Bonificaciones').val();
        var GastosFamiliares      = $('#GastosFamiliares').val();
        var AlquileresRentas      = $('#AlquileresRentas').val();
        var DescuentosSalariales  = $('#DescuentosSalariales').val();
        var JubilacionesPensiones = $('#JubilacionesPensiones').val();
        var AmortizacionCreditos  = $('#AmortizacionCreditos').val();
        var BonoAguinaldo         = $('#BonoAguinaldo').val();
        var PagoTarjetaCredito    = $('#PagoTarjetaCredito').val();
        var OtrosIngresos         = $('#OtrosIngresos').val();
        var OtrosEgresos          = $('#OtrosEgresos').val();
        var TotalIngresos         = $('#TotalIngresosP');
        var TotalEgresosP         = $('#TotalEgresosP');
        var OtrosIngresosMost     = $('#OtrosIngresosMost').val();
        var OtrosEgresosMost      = $('#OtrosEgresosMost').val();
        var TotalIngresosPMost    = $('#TotalIngresosPMost').val();
        var TotalEgresosPMost     = $('#TotalEgresosPMost').val();

        TotalCalculoIngresos = parseFloat($('#SueldosSalarios').val()) + parseFloat($('#Bonificaciones').val()) + parseFloat($('#AlquileresRentas').val()) + parseFloat($('#JubilacionesPensiones').val()) + parseFloat($('#BonoAguinaldo').val()) + parseFloat($('#OtrosIngresos').val());
        TotalCalculoIngresosMost = currency(TotalCalculoIngresos, 2, [',', "'", '.']);
        TotalCalculoIngresos = TotalCalculoIngresos.toFixed(2);
        $('#TotalIngresosP').val(TotalCalculoIngresos);
        $('#TotalIngresosPMost').val(TotalCalculoIngresosMost);

        TotalCalculoEngresos = parseFloat($('#GastosPersonales').val()) + parseFloat($('#GastosFamiliares').val()) + parseFloat($('#DescuentosSalariales').val()) + parseFloat($('#AmortizacionCreditos').val()) + parseFloat($('#PagoTarjetaCredito').val()) + parseFloat($('#OtrosEgresos').val());
        TotalCalculoEngresosMost = currency(TotalCalculoEngresos, 2, [',', "'", '.']);
        TotalCalculoEngresos = TotalCalculoEngresos.toFixed(2);
        $('#TotalEgresosP').val(TotalCalculoEngresos);
        $('#TotalEgresosPMost').val(TotalCalculoEngresosMost);
    }
    function GuardarProyeccionIngresosEgresos()
    {
        var SueldosSalarios       = $('#SueldosSalarios').val();
        var GastosPersonales      = $('#GastosPersonales').val();
        var Bonificaciones        = $('#Bonificaciones').val();
        var GastosFamiliares      = $('#GastosFamiliares').val();
        var AlquileresRentas      = $('#AlquileresRentas').val();
        var DescuentosSalariales  = $('#DescuentosSalariales').val();
        var JubilacionesPensiones = $('#JubilacionesPensiones').val();
        var AmortizacionCreditos  = $('#AmortizacionCreditos').val();
        var BonoAguinaldo         = $('#BonoAguinaldo').val();
        var PagoTarjetaCredito    = $('#PagoTarjetaCredito').val();
        var OtrosIngresos         = $('#OtrosIngresos').val();
        var OtrosEgresos          = $('#OtrosEgresos').val();
        var TotalIngresosP         = $('#TotalIngresosP').val();
        var TotalEgresosP         = $('#TotalEgresosP').val();
        
        var Usuario               = $('#UsuarioID').val();

        $.ajax({
            url: 'GuardarProyeccionIngresosEgresos.php',
            type: 'post',
            data: 'SueldosSalarios='+SueldosSalarios+'&GastosPersonales='+GastosPersonales+'&Bonificaciones='+Bonificaciones+'&GastosFamiliares='+GastosFamiliares+'&AlquileresRentas='+AlquileresRentas+'&DescuentosSalariales='+DescuentosSalariales+'&JubilacionesPensiones='+JubilacionesPensiones+'&AmortizacionCreditos='+AmortizacionCreditos+'&BonoAguinaldo='+BonoAguinaldo+'&PagoTarjetaCredito='+PagoTarjetaCredito+'&OtrosIngresos='+OtrosIngresos+'&OtrosEgresos='+OtrosEgresos+'&TotalIngresosP='+TotalIngresosP+'&TotalEgresosP='+TotalEgresosP+'&Usuario='+Usuario,
            success: function(output)
            {   
                GuardarEstadoPatrimonial();
                alertify.success('Sus datos se han actualizado con éxito');
            },
            error: function()
            {
                alertify.error('Algo salió mal');
            }
        });
    }
</script>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8899-1">

</head>

<body style="background-color: #FFFFFF">
    <?php include("../../../../MenuTop.php") ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title" align="center">
				<h3 style="text-center"><strong>Estado Patrimonial</strong></h3>
			</div>
		</div>
		<div class="panel-body">
            <div class="container">
                <div class="stepwizard">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step">
                            <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                            <p>Activo Circulante</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-2" type="button" class="btn btn-default btn-circle">2</a>
                            <p>Activo Fijo</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-3" type="button" class="btn btn-default btn-circle">3</a>
                            <p>Pasivo Circulante</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-4" type="button" class="btn btn-default btn-circle">4</a>
                            <p>Pasivo Fijo</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-6" type="button" class="btn btn-default btn-circle">5</a>
                            <p>Proyección I/E</p>
                        </div>
                    </div>
                </div>
                <form role="form">
                    <div class="row setup-content" id="step-1">
                        <div class="col-xs-12">
                            <div class="col-md-12">
                                <br>
                                <h3 align="center">Activo Circulante</h3>
                                <br>
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Caja (Efectivo)</label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="number" min="0" id="Caja" class="form-control" value="<?php echo $Caja; ?>" onchange="ActActivoCirculante()" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Depósitos en Coosajo</label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="number" min="0" id="DepositosCoosajo" class="form-control" value="<?php echo $DepositosCoosajo; ?>" onchange="ActActivoCirculante()" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Depósitos en Bancos</label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="number" min="0" id="DepositosBancos" class="form-control" value="<?php echo $DepositosBancos; ?>" onchange="ActActivoCirculante()" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Fondo de Retiro</label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="number" min="0" id="FondoRetiro" class="form-control" value="<?php echo $FondoRetiro; ?>" onchange="ActActivoCirculante()" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Cuentas y Documentos por Cobrar</label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="number" min="0" id="CuentasPorCobrar" class="form-control" value="<?php echo $CuentasPorCobrar; ?>" onchange="ActActivoCirculante()" required/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"><h4><strong>SUBTOTAL</strong></h4></label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="hidden" min="0" id="SubtotalActivoCirculante" class="form-control" readonly value="0.00" required/>
                                            <input type="text" min="0" id="SubtotalActivoCirculanteMost" class="form-control" readonly value="0.00" required/>
                                        </div>
                                    </div>    
                                    <div class="container-fluid" align="center">
                                        <button type="button" class="btn btn-danger btn-md" onClick="GuardarProyeccionIngresosEgresos()">
                                            <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
                                        </button>
                                    </div>                  
                                </div>
                            </div>
                            <div class="container-fluid" align="center">
                            </div>
                        </div>
                        <div class="row setup-content" id="step-2">
                            <div class="col-xs-12">
                                <div class="col-md-12">
                                    <br>
                                    <h3 align="center">Activo Fijo</h3>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Terrenos y Construcciones</label>
                                        <div class="col-lg-4" align="left" >
                                            <div class="input-group">
                                                <input type="hidden" min="0" class="form-control" value="<?php echo $TerrenosConstrucciones; ?>" id="TerrenosConstrucciones" required/>
                                                <input type="text" min="0" class="form-control" id="TerrenosConstruccionesMost" disabled required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalAddTerrenos">Agregar</button>
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalConTerrenos">Consultar</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-5"></div>
                                    </div>
                                    <div class="row"><br></div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Vehículos</label>
                                        <div class="col-lg-4" align="left" >
                                            <div class="input-group">
                                                <input type="hidden" min="0" class="form-control" value="<?php echo $Vehiculos ?>" id="Vehiculos" value="0.00"  required/>
                                                <input type="text" min="0" class="form-control" id="VehiculosMost" value="0.00" disabled required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalAddVehiculos">Agregar</button>
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalConVehiculos">Consultar</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-5"></div>
                                    </div>
                                    <div class="row"><br></div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Inversiones en Valores y Acciones</label>
                                        <div class="col-lg-4" align="left" >
                                            <div class="input-group">
                                                <input type="hidden" min="0" class="form-control" value="<?php echo $InversionesValoresAcciones ?>" id="InversionesValoresAcciones" value="0.00"  required/>
                                                <input type="text" min="0" class="form-control" id="InversionesValoresAccionesMost" value="0.00" disabled required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalAddValores">Agregar</button>
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalConValores">Consultar</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-5"></div>
                                    </div>
                                    <div class="row"><br></div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Mobiliario y Equipo</label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="number" min="0" class="form-control" onchange="ActActivoFijo()" id="MobiliarioEquipo" value="<?php echo $MobiliarioEquipo; ?>"  required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Inversiones (Ganado, Cultivos, Etc.)</label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="number" min="0" class="form-control" onchange="ActActivoFijo()" id="InversionesGanado" value="<?php echo $InversionesGanado; ?>"  required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Otros Activos</label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="number" min="0" class="form-control" onchange="ActActivoFijo()" id="OtrosActivos" value="<?php echo $OtrosActivos; ?>"  required/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"><h4><strong>SUBTOTAL</strong></h4></label>
                                        <div class="col-lg-9" align="left" >
                                            <input type="hidden" min="0" class="form-control" id="SubtotalActivoFijo" value="0.00" readonly required/>
                                            <input type="text" min="0" class="form-control" id="SubtotalActivoFijoMost" value="0.00" readonly required/>
                                        </div>
                                    </div>   
                                    <div class="container-fluid" align="center">
                                        <button type="button" class="btn btn-danger btn-md" onClick="GuardarProyeccionIngresosEgresos()">
                                            <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
                                        </button>
                                    </div>    
                                </div>
                            </div>
                            <div class="container-fluid" align="center">
                            </div>
                        </div>
                        <div class="row setup-content" id="step-3">
                            <div class="col-xs-12">
                                <div class="col-md-12">
                                    <br>
                                    <h3 align="center">Pasivo Circulante (Corto Plazo)</h3>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Préstamos en Coosajo R.L. Menores a 1 Año</label>
                                        <div class="col-lg-4" align="left" >
                                            <div class="input-group">
                                                <input type="hidden" min="0" class="form-control" id="ObligacionesCortoPlazoC" value="0.00" disabled required/>
                                                <input type="text" min="0" class="form-control" id="ObligacionesCortoPlazoCMost" value="0.00" disabled required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalAddObligacionesCortoPlazo">Agregar</button>
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalConObligacionesCortoPlazoC">Consultar</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"></div>
                                    </div>
                                    <div class="row"><br></div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Préstamos en Otros Bancos Menores a 1 Año</label>
                                        <div class="col-lg-4" align="left" >
                                            <div class="input-group">
                                                <input type="hidden" min="0" class="form-control" id="ObligacionesCortoPlazoB" value="0.00" disabled required/>
                                                <input type="text" min="0" class="form-control" id="ObligacionesCortoPlazoBMost" value="0.00" disabled required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalAddObligacionesCortoPlazo">Agregar</button>
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalConObligacionesCortoPlazoB">Consultar</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"></div>
                                    </div>
                                    <div class="row"><br></div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Saldos de Tarjetas de Crédito</label>
                                        <div class="col-lg-4" align="left" >
                                            <div class="input-group">
                                                <input type="hidden" min="0" class="form-control" id="TarjetasCredito" value="0.00" disabled required/>
                                                <input type="text" min="0" class="form-control" id="TarjetasCreditoMost" value="0.00" disabled required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalAddTarjetas">Agregar</button>
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalConTarjetas">Consultar</button>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="help-block"><a title="Ayuda" data-toggle="popover" data-trigger="hover" data-content="Presione el botón de Agregar, para declarar sus Saldos de Tarjetas de Crédito."><i class="fa fa-question-circle fa-fw fa-2x"></i></a></span>
                                        <div class="col-lg-4"></div>
                                    </div>
                                    <div class="row"><br></div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Anticipo de Sueldo</label>
                                        <div class="col-lg-8" align="left" >
                                            <input type="number" min="0" class="form-control" id="AnticipoSueldo" onChange="ActPasivoCirculante()" value="<?php echo $AnticipoSueldo; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Otros Préstamos</label>
                                        <div class="col-lg-8" align="left" >
                                            <input type="number" min="0" class="form-control" id="OtrosPrestamos" onChange="ActPasivoCirculante()" value="<?php echo $OtrosPrestamos; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Cuentas y Documentos por Pagar</label>
                                        <div class="col-lg-8" align="left" >
                                            <input type="number" min="0" class="form-control" id="CuentasDocumentosPorPagar" onChange="ActPasivoCirculante()" value="<?php echo $CuentasDocumentosPorPagar; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Proveedores</label>
                                        <div class="col-lg-8" align="left" >
                                            <input type="number" min="0" class="form-control" id="Proveedores" onChange="ActPasivoCirculante()" value="<?php echo $Proveedores; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Otros</label>
                                        <div class="col-lg-8" align="left" >
                                            <input type="number" min="0" class="form-control" id="OtrosPasivoCirculante" onChange="ActPasivoCirculante()" value="<?php echo $OtrosPasivoCirculante; ?>" required/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label"><h4><strong>SUBTOTAL</strong></h4></label>
                                        <div class="col-lg-8" align="left" >
                                            <input type="hidden" min="0" id="SubtotalPasivoCirculante" class="form-control" value="0.00" readonly required/>
                                            <input type="text" min="0" id="SubtotalPasivoCirculanteMost" class="form-control" value="0.00" readonly required/>
                                        </div>
                                    </div>
                                    <div class="container-fluid" align="center">
                                        <button type="button" class="btn btn-danger btn-md" onClick="GuardarProyeccionIngresosEgresos()">
                                            <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
                                        </button>
                                    </div>      
                                </div>
                            </div>
                            <div class="container-fluid" align="center">
                            </div>
                        </div>
                        <div class="row setup-content" id="step-4">
                            <div class="col-xs-12">
                                <div class="col-md-12">
                                    <br>
                                    <h3 align="center">Pasivo Fijo</h3>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Préstamos en Coosajo R.L. Mayores a 1 Año</label>
                                        <div class="col-lg-4" align="left" >
                                            <div class="input-group">
                                                <input type="hidden" min="0" class="form-control" id="ObligacionesLargoPlazoC" value="0.00" disabled required/>
                                                <input type="text" min="0" class="form-control" id="ObligacionesLargoPlazoCMost" value="0.00" disabled required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalAddObligacionesLargoPlazo">Agregar</button>
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalConObligacionesLargoPlazoC">Consultar</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"></div>
                                    </div>
                                    <div class="row"><br></div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Préstamos en Otros Bancos Mayores a 1 Año</label>
                                        <div class="col-lg-4" align="left" >
                                            <div class="input-group">
                                                <input type="hidden" min="0" class="form-control" id="ObligacionesLargoPlazoB" value="0.00" disabled required/>
                                                <input type="text" min="0" class="form-control" id="ObligacionesLargoPlazoBMost" value="0.00" disabled required/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalAddObligacionesLargoPlazo">Agregar</button>
                                                    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#ModalConObligacionesLargoPlazoB">Consultar</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"></div>
                                    </div>
                                    <div class="row"><br></div>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Otras Deudas</label>
                                        <div class="col-lg-8" align="left" >
                                            <input type="number" min="0" class="form-control" id="OtrasDeudasPasivoFijo" onChange="ActPasivoFijo()" value="<?php echo $OtrasDeudasPasivoFijo; ?>" required/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-lg-4 control-label"><h4><strong>SUBTOTAL</strong></h4></label>
                                        <div class="col-lg-8" align="left" >
                                            <input type="hidden" min="0" id="SubtotalPasivoFijo" class="form-control" value="0.00" readonly required/>
                                            <input type="text" min="0" id="SubtotalPasivoFijoMost" class="form-control" value="0.00" readonly required/>
                                        </div>
                                    </div>                    
                                </div>
                            </div>
                            <div class="container-fluid" align="center">
                                <button type="button" class="btn btn-danger btn-md" onClick="GuardarEstadoPatrimonial()">
                                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
                                </button>
                            </div>
                        </div>
                    <div class="row setup-content" id="step-6">
                        <div class="col-xs-12">
                            <div class="col-md-12">
                                <br>
                                <h3 align="center">Proyección de Ingresos y Egresos</h3>
                                <div class="form-group">
                                    <label class="col-lg-6 control-label" align="center">INGRESOS MENSUALES</label>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-6 control-label" align="center">EGRESOS MENSUALES</label>
                                </div> 
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Sueldos y Salarios</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="SueldosSalarios" class="form-control" value="<?php echo $SueldosSalarios; ?>" required />
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Gastos Personales</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="GastosPersonales" class="form-control" value="<?php echo $GastosPersonales; ?>" required/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Bonificaciones</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="Bonificaciones" class="form-control" value="<?php echo $Bonificaciones; ?>" required />
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Gastos Familiares</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="GastosFamiliares" class="form-control" value="<?php echo $GastosFamiliares; ?>" required/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Alquileres/Rentas</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="AlquileresRentas" class="form-control" value="<?php echo $AlquileresRentas; ?>" required />
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Descuentos Salariales</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="DescuentosSalariales" class="form-control" value="<?php echo $DescuentosSalariales; ?>" required/>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Jubilaciones/Pensiones</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="JubilacionesPensiones" class="form-control" value="<?php echo $JubilacionesPensiones; ?>" required />
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Amortización Créditos</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="AmortizacionCreditos" class="form-control" value="<?php echo $AmortizacionCreditos; ?>" required/>
                                    </div>
                                </div>  
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Bono 14/Aguinaldo</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="BonoAguinaldo" class="form-control" value="<?php echo $BonoAguinaldo; ?>" required />
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Pago Tarjetas de Crédito</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="number" min="0" onchange="CalcularProyeccionIE()" id="PagoTarjetaCredito" class="form-control" value="<?php echo $PagoTarjetaCredito; ?>" required/>
                                    </div>
                                </div>  
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Otros Ingresos</label>
                                    <div class="col-lg-3" align="left" >
                                        <div class="input-group">
                                            <input type="hidden" min="0" id="OtrosIngresos" class="form-control" value="0.00" disabled required/>
                                            <input type="text" min="0" id="OtrosIngresosMost" class="form-control" value="0.00" disabled required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#ModalAddOtrosIngresos"><span class="glyphicon glyphicon-plus"></span></button>
                                                <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#ModalConOtrosIngresos"><span class="glyphicon glyphicon-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Otros Egresos</label>
                                    <div class="col-lg-3" align="left" >
                                        <div class="input-group">
                                            <input type="hidden" min="0" id="OtrosEgresos" class="form-control" value="0.00" disabled required/>
                                            <input type="text" min="0" id="OtrosEgresosMost" class="form-control" value="0.00" disabled required/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-success btn-sm" type="button" data-toggle="modal" data-target="#ModalAddOtrosEgresos"><span class="glyphicon glyphicon-plus"></span></button>
                                                <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#ModalConOtrosEgresos"><span class="glyphicon glyphicon-search"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Total de Ingresos</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="hidden" min="0" id="TotalIngresosP" class="form-control" value="0.00" required  readonly />
                                        <input type="text" min="0" id="TotalIngresosPMost" class="form-control" value="0.00" required  readonly />
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-lg-3 control-label" align="right">Total de Egresos</label>
                                    <div class="col-lg-3" align="left" >
                                        <input type="hidden" min="0" id="TotalEgresosP" class="form-control" value="0.00" required readonly />
                                        <input type="text" min="0" id="TotalEgresosPMost" class="form-control" value="0.00" required readonly />
                                    </div>
                                </div>
                                <div class="container-fluid" align="center">
                                </div>
                                <div class="container-fluid" align="center">
                                <button type="button" class="btn btn-danger btn-md" onClick="GuardarProyeccionIngresosEgresos()">
                                    <span class="glyphicon glyphicon-floppy-disk"></span> Guardar
                                </button>
                                <a href="imprimir.php" target="_blank"><button type="button" class="btn btn-info btn-md" >
                                    <span class="glyphicon glyphicon-print"></span> Imprimir
                                </button></a>
                            </div>                   
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xs-12" align="center">
                            <div><br></div>
                            <div><br></div>
                            <div class="form-group">
                            <label class="col-lg-6 control-label" align="right">Total Activo</label>
                                <div class="col-lg-6" align="left" >
                                    <input type="hidden" min="0" class="form-control" id="TotalActivo" value="0.00" required readonly/>
                                    <input type="text" min="0" class="form-control" id="TotalActivoMost" value="0.00" required readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="col-lg-6 control-label" align="right">Total Pasivo</label>
                                <div class="col-lg-6" align="left" >
                                    <input type="hidden" min="0" class="form-control" id="TotalPasivo" value="0.00" required readonly/>
                                    <input type="text" min="0" class="form-control" id="TotalPasivoMost" value="0.00" required readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="col-lg-6 control-label" align="right">Patrimonio</label>
                                <div class="col-lg-6" align="left" >
                                    <input type="hidden" min="0" class="form-control" id="TotalPatrimonio" value="0.00" required readonly/>
                                    <input type="text" min="0" class="form-control" id="TotalPatrimonioMost" value="0.00" required readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="col-lg-6 control-label" align="right">Total Pasivo + Patrimonio</label>
                                <div class="col-lg-6" align="left" >
                                    <input type="hidden" min="0" class="form-control" id="TotalPasivoPatrimonio" value="0.00" required readonly/>
                                    <input type="text" min="0" class="form-control" id="TotalPasivoPatrimonioMost" value="0.00" required readonly/>
                                </div>
                            </div>                   
                        </div>
                        <div class="row"></div>
                        <div class="row col-xs-12" align="center">
                        <br>
                        <br>
                            <a href="informacion_base.php"><button type="button" class="btn btn-info btn-lg">
                                <span class="glyphicon glyphicon-arrow-left"></span> Regresar
                            </button></a>
                        </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Terrenos y Construcciones -->
        <div id="ModalAddTerrenos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Bienes Inmuebles</h2>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="BienesInmueblesFORM">
                            <div class="form-group">
                                <label for="TipoInmueble" class="col-lg-3 control-label">Tipo de Inmueble</label>
                                <div class="col-lg-9" align="left" >
                                    <select name="TipoInmueble" id="TipoInmueble" class="form-control" >
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <?php
                                        $query = "SELECT * FROM Estado_Patrimonial.tipo_inmueble ORDER BY tipo_inmueble";
                                        $result = mysqli_query($db, $query);
                                        while($fila = mysqli_fetch_array($result))
                                        {
                                            echo '<option value="'.$fila["id_inmueble"].'">'.utf8_encode($fila["tipo_inmueble"]).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Localizacion" class="col-lg-3 control-label">Localización</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="Localizacion" id="Localizacion"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Finca" class="col-lg-3 control-label">Finca</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" class="form-control" name="Finca" id="Finca"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Folio" class="col-lg-3 control-label">Folio</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" class="form-control" name="Folio" id="Folio"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Libro" class="col-lg-3 control-label">Libro</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" class="form-control" name="Libro" id="Libro"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Departamento" class="col-lg-3 control-label">Departamento</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="Departamento" id="Departamento"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ValorMercado" class="col-lg-3 control-label">Valor de Mercado</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="ValorMercado" id="ValorMercado"  required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                        </button>
                        <button type="button" class="btn btn-primary btn-md" onClick="IngresarTerrenos()">
                            <span class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Terrenos y Construcciones -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConTerrenos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Bienes Inmuebles</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Tipo de Inmueble</strong></h6></th>
                                <th><h6><strong>Localización</strong></h6></th>
                                <th><h6><strong>Finca</strong></h6></th>
                                <th><h6><strong>Folio</strong></h6></th>
                                <th><h6><strong>Libro</strong></h6></th>
                                <th><h6><strong>Departamento</strong></h6></th>
                                <th><h6><strong>Valor de Mercado</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaBienesInmuebles">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->

        <!-- Modal Vehiculos -->
        <div id="ModalAddVehiculos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Vehículos</h2>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="VehiculosFORM">
                            <div class="form-group">
                                <label for="Marca" class="col-lg-3 control-label">Marca</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" class="form-control" name="Marca" id="Marca"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Modelo" class="col-lg-3 control-label">Modelo</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" class="form-control" name="Modelo" id="Modelo"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Color" class="col-lg-3 control-label">Color</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" class="form-control" name="Color" id="Color"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ValorMercadoVehiculo" class="col-lg-3 control-label">Valor de Mercado</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="ValorMercadoVehiculo" id="ValorMercadoVehiculo"  required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                        </button>
                        <button type="button" class="btn btn-primary btn-md" onClick="IngresarVehiculos()">
                            <span class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Vehiculos -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConVehiculos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Vehiculos</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Marca</strong></h6></th>
                                <th><h6><strong>Modelo</strong></h6></th>
                                <th><h6><strong>Color</strong></h6></th>
                                <th><h6><strong>Valor de Mercado</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaVehiculos">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->

        <!-- Modal Valores y Acciones -->
        <div id="ModalAddValores" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Valores y Acciones</h2>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="ValoresFORM">
                            <div class="form-group">
                                <label for="ClaseTitulo" class="col-lg-3 control-label">Clase de Título</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="ClaseTitulo" id="ClaseTitulo"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Institucion" class="col-lg-3 control-label">Institucion o Empresa</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="Institucion" id="Institucion"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoInvertido" class="col-lg-3 control-label">Monto Invertido</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="MontoInvertido" id="MontoInvertido"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ValorComercial" class="col-lg-3 control-label">Valor Comercial</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="ValorComercial" id="ValorComercial"  required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                        </button>
                        <button type="button" class="btn btn-primary btn-md" onClick="IngresarValores()">
                            <span class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Valores y Acciones -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConValores" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Valores y Acciones</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Clase de Título</strong></h6></th>
                                <th><h6><strong>Insitución o Empresa</strong></h6></th>
                                <th><h6><strong>Monto Invertido</strong></h6></th>
                                <th><h6><strong>Valor Comercial</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaValores">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->

        <!-- Modal Obligaciones a Corto Plazo -->
        <div id="ModalAddObligacionesCortoPlazo" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Obligaciones a Corto Plazo <br><small>Hasta 1 año</small></h2>
                        
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="ObligacionesCortoPlazoFORM">
                            <div class="form-group">
                                <label for="EntidadFinanciera" class="col-lg-3 control-label">Entidad Financiera</label>
                                <div class="col-lg-9" align="left" >
                                    <select class="form-control" name="EntidadFinanciera" id="EntidadFinanciera" onchange="ChgEntidadFinanciera(this.value)">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Coosajo R.L.">Coosajo R.L.</option>
                                        <option value="Bancos">Bancos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Acreedor" class="col-lg-3 control-label">Acreedor</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="Acreedor" id="Acreedor" readonly required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Garantia" class="col-lg-3 control-label">Garantía</label>
                                <div class="col-lg-9" align="left" >
                                    <select class="form-control" name="Garantia" id="Garantia">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Hipotecario">Hipotecario</option>
                                        <option value="Derecho de Posesión">Derecho de Posesión</option>
                                        <option value="Fiduciario">Fiduciario</option>
                                        <option value="Prendario">Prendario</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Vencimiento" class="col-lg-3 control-label">Vencimiento</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="date" class="form-control" name="Vencimiento" id="Vencimiento"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoOriginal" class="col-lg-3 control-label">Monto Original</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="MontoOriginal" id="MontoOriginal"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SaldoActual" class="col-lg-3 control-label">Saldo Actual</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="SaldoActual" id="SaldoActual"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-left"><h4>Datos de Amortización</h4></label>
                                <div class="col-lg-9"></div>
                            </div>
                            <div class="form-group">
                                <label for="Frecuencia" class="col-lg-3 control-label">Frecuencia</label>
                                <div class="col-lg-9" align="left" >
                                    <select class="form-control" name="Frecuencia" id="Frecuencia">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Diario">Diario</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Quincenal">Quincenal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Bimensual">Bimensual</option>
                                        <option value="Trimestral">Trimestral</option>
                                        <option value="Cuatrimestral">Cuatrimestral</option>
                                        <option value="Semestral">Semestral</option>
                                        <option value="Anual">Anual</option>
                                        <option value="Pago Único">Pago Único</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoCortoPlazo" class="col-lg-3 control-label">Monto</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="MontoCortoPlazo" id="MontoCortoPlazo"  required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                        </button>
                        <button type="button" class="btn btn-primary btn-md" onClick="IngresarObligaciones()">
                            <span class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Obligaciones a Corto Plazo -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConObligacionesCortoPlazoC" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Obligaciones a Corto Plazo en Coosajo R.L.</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Garantía</strong></h6></th>
                                <th><h6><strong>Vencimiento</strong></h6></th>
                                <th><h6><strong>Monto Original</strong></h6></th>
                                <th><h6><strong>Saldo Actual</strong></h6></th>
                                <th><h6><strong>Frecuencia</strong></h6></th>
                                <th><h6><strong>Monto</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaObligacionesCortoPlazoC">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConObligacionesCortoPlazoB" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Obligaciones a Corto Plazo en Otras Entidades Financieras</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Garantía</strong></h6></th>
                                <th><h6><strong>Vencimiento</strong></h6></th>
                                <th><h6><strong>Monto Original</strong></h6></th>
                                <th><h6><strong>Saldo Actual</strong></h6></th>
                                <th><h6><strong>Frecuencia</strong></h6></th>
                                <th><h6><strong>Monto</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaObligacionesCortoPlazoB">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->

        <!-- Modal Tarjetas -->
        <div id="ModalAddTarjetas" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Tarjetas de Crédito</h2>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="TarjetasCreditoFORM">
                            <div class="form-group">
                                <label for="AcreedorTarjetas" class="col-lg-3 control-label">Acreedor</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="AcreedorTarjetas" id="AcreedorTarjetas" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="VencimientoTarjetas" class="col-lg-3 control-label">Vencimiento</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="date" class="form-control" name="VencimientoTarjetas" id="VencimientoTarjetas"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoOriginalTarjetas" class="col-lg-3 control-label">Monto Original</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="MontoOriginalTarjetas" id="MontoOriginalTarjetas"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SaldoActualTarjetas" class="col-lg-3 control-label">Saldo Actual</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="SaldoActualTarjetas" id="SaldoActualTarjetas"  required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                        </button>
                        <button type="button" class="btn btn-primary btn-md" onClick="IngresarTarjetasCredito()">
                            <span class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Tarjetas -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConTarjetas" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Tarjetas de Crédito</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Acreedor</strong></h6></th>
                                <th><h6><strong>Vencimiento</strong></h6></th>
                                <th><h6><strong>Monto Original</strong></h6></th>
                                <th><h6><strong>Saldo Actual</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaTarjetas">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->

        <!-- Modal Obligaciones a Largo Plazo -->
        <div id="ModalAddObligacionesLargoPlazo" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Obligaciones a Largo Plazo <br><small>Mayores a 1 año</small></h2>
                        
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="ObligacionesLargoPlazoFORM">
                            <div class="form-group">
                                <label for="EntidadFinancieraLP" class="col-lg-3 control-label">Entidad Financiera</label>
                                <div class="col-lg-9" align="left" >
                                    <select class="form-control" name="EntidadFinancieraLP" id="EntidadFinancieraLP" onchange="ChgEntidadFinancieraLP(this.value)">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Coosajo R.L.">Coosajo R.L.</option>
                                        <option value="Bancos">Bancos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="AcreedorLP" class="col-lg-3 control-label">Acreedor</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="AcreedorLP" id="AcreedorLP" readonly required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="GarantiaLP" class="col-lg-3 control-label">Garantía</label>
                                <div class="col-lg-9" align="left" >
                                    <select class="form-control" name="GarantiaLP" id="GarantiaLP">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Hipotecario">Hipotecario</option>
                                        <option value="Derecho de Posesión">Derecho de Posesión</option>
                                        <option value="Fiduciario">Fiduciario</option>
                                        <option value="Prendario">Prendario</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="VencimientoLP" class="col-lg-3 control-label">Vencimiento</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="date" class="form-control" name="VencimientoLP" id="VencimientoLP"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoOriginalLP" class="col-lg-3 control-label">Monto Original</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="MontoOriginalLP" id="MontoOriginalLP"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SaldoActualLP" class="col-lg-3 control-label">Saldo Actual</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="SaldoActualLP" id="SaldoActualLP"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label text-left"><h4>Datos de Amortización</h4></label>
                                <div class="col-lg-9"></div>
                            </div>
                            <div class="form-group">
                                <label for="FrecuenciaLP" class="col-lg-3 control-label">Frecuencia</label>
                                <div class="col-lg-9" align="left" >
                                    <select class="form-control" name="FrecuenciaLP" id="FrecuenciaLP">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Diario">Diario</option>
                                        <option value="Semanal">Semanal</option>
                                        <option value="Quincenal">Quincenal</option>
                                        <option value="Mensual">Mensual</option>
                                        <option value="Bimensual">Bimensual</option>
                                        <option value="Trimestral">Trimestral</option>
                                        <option value="Cuatrimestral">Cuatrimestral</option>
                                        <option value="Semestral">Semestral</option>
                                        <option value="Anual">Anual</option>
                                        <option value="Pago Único">Pago Único</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoCortoPlazoLP" class="col-lg-3 control-label">Monto</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="MontoCortoPlazoLP" id="MontoCortoPlazoLP"  required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                        </button>
                        <button type="button" class="btn btn-primary btn-md" onClick="IngresarObligacionesLP()">
                            <span class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Obligaciones a Largo Plazo -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConObligacionesLargoPlazoC" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Obligaciones a Largo Plazo en Coosajo R.L.</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Garantía</strong></h6></th>
                                <th><h6><strong>Vencimiento</strong></h6></th>
                                <th><h6><strong>Monto Original</strong></h6></th>
                                <th><h6><strong>Saldo Actual</strong></h6></th>
                                <th><h6><strong>Frecuencia</strong></h6></th>
                                <th><h6><strong>Monto</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaObligacionesLargoPlazoC">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConObligacionesLargoPlazoB" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Obligaciones a Largo Plazo en Otras Entidades Financieras</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Garantía</strong></h6></th>
                                <th><h6><strong>Vencimiento</strong></h6></th>
                                <th><h6><strong>Monto Original</strong></h6></th>
                                <th><h6><strong>Saldo Actual</strong></h6></th>
                                <th><h6><strong>Frecuencia</strong></h6></th>
                                <th><h6><strong>Monto</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaObligacionesLargoPlazoB">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->


        <!-- Modal Otros Ingresos -->
        <div id="ModalAddOtrosIngresos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Otros Ingresos</h2>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="OtrosIngresosFORM">
                            <div class="form-group">
                                <label for="DescripcionIngreso" class="col-lg-3 control-label">Descripción del Ingreso</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="DescripcionIngreso" id="DescripcionIngreso" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoMensualIngreso" class="col-lg-3 control-label">Monto Mensual</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="MontoMensualIngreso" id="MontoMensualIngreso"  required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                        </button>
                        <button type="button" class="btn btn-primary btn-md" onClick="IngresarOtrosIngresos()">
                            <span class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Otros Ingresos -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConOtrosIngresos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Otros Ingresos</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Descripción</strong></h6></th>
                                <th><h6><strong>Monto</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaOtrosIngresos">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->

        <!-- Modal Otros Egresos -->
        <div id="ModalAddOtrosEgresos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Otros Egresos</h2>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form" id="OtrosEgresosFORM">
                            <div class="form-group">
                                <label for="DescripcionEgreso" class="col-lg-3 control-label">Descripción del Egreso</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="DescripcionEgreso" id="DescripcionEgreso" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoMensualEgreso" class="col-lg-3 control-label">Monto Mensual</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="MontoMensualEgreso" id="MontoMensualEgreso"  required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-md" class="close" data-dismiss="modal">
                            <span class="glyphicon glyphicon-ban-circle"></span> Cancelar
                        </button>
                        <button type="button" class="btn btn-primary btn-md" onClick="IngresarOtrosEgresos()">
                            <span class="glyphicon glyphicon-ok"></span> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Otros Egresos -->

        <!-- Modal Consulta Terrenos y Construcciones -->
        <div id="ModalConOtrosEgresos" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 80%">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" align="center">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Detalle de Otros Egresos</h2>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-condensed" >
                        <thead>
                            <tr>
                                <th><h6><strong>Descripción</strong></h6></th>
                                <th><h6><strong>Monto</strong></h6></th>
                            </tr>
                        </thead>
                        <tbody id="tablaOtrosEgresos">
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
        <!-- /Modal Consulta Terrenos y Construcciones -->

        <div id="ModalLOAD" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="suggestions" align="center"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Modal Otros Egresos -->


</body>

</html>
