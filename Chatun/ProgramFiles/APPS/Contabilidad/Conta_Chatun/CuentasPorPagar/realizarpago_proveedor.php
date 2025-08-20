<?php
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

// --- MODIFICADO: Recibir datos por POST y buscar la cuenta contable ---
$proveedor_desde_post = false;
$valorInput = '';

// Se verifica que los datos lleguen por POST
if (isset($_POST['proveedor']) && isset($_POST['NombreCuenta'])) {
    $proveedor_desde_post = true;

    $codigoProveedor = trim($_POST['proveedor']);
    $nombreProveedor = trim($_POST['NombreCuenta']);

    // --- Búsqueda de la cuenta contable en la base de datos ---
    $cuentaContable = '';
    $sql_cuenta = "SELECT P_CODIGO FROM Contabilidad.PROVEEDOR WHERE P_CODIGO = ? LIMIT 1";
    if ($stmt = mysqli_prepare($db, $sql_cuenta)) {
        mysqli_stmt_bind_param($stmt, 's', $codigoProveedor);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($fila = mysqli_fetch_assoc($res)) {
            $cuentaContable = $fila['P_CODIGO'];
        }
        mysqli_stmt_close($stmt);
    }

    // Preparar el valor para el input, usando la cuenta contable encontrada
    if ($cuentaContable) {
        $valorInput = htmlspecialchars($cuentaContable . '/' . $nombreProveedor, ENT_QUOTES, 'UTF-8');
    } else {
        // Si no se encuentra la cuenta, se puede poner un valor por defecto o un mensaje
        $valorInput = htmlspecialchars($nombreProveedor, ENT_QUOTES, 'UTF-8'); // Fallback
    }
}
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
    <link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css" />
    <!-- END STYLESHEETS -->

    <style type="text/css">
        .fila-base {
            display: none;
        }

        .suggest-element {
            margin-left: 5px;
            margin-top: 5px;
            width: 350px;
            cursor: pointer;
        }

        #suggestions {
            width: auto;
            height: auto;
            overflow: auto;
        }
    </style>
</head>

<body class="menubar-hoverable header-fixed menubar-pin ">

    <?php include("../../../../MenuTop.php") ?>

    <!-- BEGIN BASE-->
    <div id="base">

        <!-- BEGIN CONTENT-->
        <div id="content">
            <div class="container">
                <form class="form" action="IngresoPro.php" method="POST" role="form">
                    <div class="col-lg-12">
                        <br>
                        <div class="card">
                            <div class="card-head style-primary">
                                <h4 class="text-center"><strong>Pago a Proveedor</strong></h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="Comprobante" id="Comprobante" required />
                                            <label for="Comprobante">No. de Comprobante</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d'); ?>" required onChange="Comprovante()" />
                                            <label for="Fecha">Fecha</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <select name="Periodo" id="Periodo" class="form-control" onchange="SaberMesPeriodo(this)" required>
                                                <option value="" disabled selected>Seleccione</option>
                                                <?php
                                                $QueryPeriodo = "SELECT * FROM Contabilidad.PERIODO_CONTABLE WHERE EPC_CODIGO = 1";
                                                $ResultPeriodo = mysqli_query($db, $QueryPeriodo);
                                                while ($FilaP = mysqli_fetch_array($ResultPeriodo)) {
                                                    echo '<option value="' . $FilaP["PC_CODIGO"] . '">' . $FilaP["PC_MES"] . "-" . $FilaP["PC_ANHO"] . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <label for="Periodo">Periodo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <input class="form-control" maxlength="255" type="text" name="Concepto" id="Concepto" required />
                                            <label for="Concepto">Concepto</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="DIVFuncionariosEmpleados" style="display: none">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group ">
                                                <input class="form-control" type="text" name="CIFSolicitante" id="CIFSolicitante" readonly onclick="SelColaborador()" />
                                                <label for="CIFSolicitante">CIF del Solicitante</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group ">
                                                <input class="form-control" type="text" name="NombreSolicitante" id="NombreSolicitante" readonly onclick="SelColaborador()" />
                                                <label for="NombreSolicitante">Nombre Solicitante</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group floating-label">
                                                <button type="button" class="btn btn-success btn-sm" onclick="SelColaborador()">Seleccionar Solicitante</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <table class="table table-hover table-condensed" name="tabla" id="tabla">
                                        <thead>
                                            <tr>
                                                <td><strong>Cuenta</strong></td>
                                                <td><strong>Cargos</strong></td>
                                                <td><strong>Abonos</strong></td>
                                                <td><strong>Razón</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="fila-base">
                                                <td>
                                                    <input type="text" class="form-control" name="Cuenta[]" style="width: 500px" onChange="BuscarCuenta(this)">
                                                </td>
                                                <td>
                                                    <input type="number" step="any" class="form-control" name="Cargos[]" onChange="Calcular()" style="width: 100px" value="0.00" min="0">
                                                </td>
                                                <td>
                                                    <input type="number" step="any" class="form-control" name="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00" min="0">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="Razon[]">
                                                </td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr>
                                                 <?php
// Se asume que $_POST["proveedor"] contiene el P_CODIGO del proveedor
if (isset($_POST["proveedor"])) {
    $codigoProveedor = $_POST["proveedor"];

    // CORRECCIÓN: Se busca P_CODIGO_CUENTA en lugar de P_CODIGO para el valor del input.
    $query = "SELECT P_CODIGO, P_NOMBRE FROM Contabilidad.PROVEEDOR WHERE P_CODIGO = ?"; 
    
    if ($stmt = mysqli_prepare($db, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $codigoProveedor);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_array($result)) {
            // Se prepara el valor para el input, sanitizando y decodificando
            $valor_final = htmlspecialchars($row["P_CODIGO"] . '/' . urldecode($row["P_NOMBRE"]), ENT_QUOTES, 'UTF-8');

            echo '<tr>';
            echo '<td><input type="text" class="form-control" name="Cuenta[]" id="cuentaInicial" style="width: 500px" onChange="BuscarCuenta(this)" value="' . $valor_final . '"></td>';
            echo '<td><input type="number" step="any" class="form-control" name="Cargos[]" onChange="Calcular()" style="width: 100px" value="0.00" min="0"></td>';
            echo '<td><input type="number" step="any" class="form-control" name="Abonos[]" onChange="Calcular()" style="width: 100px" value="0.00" min="0"></td>';
            echo '<td><input type="text" class="form-control" name="Razon[]"></td>';
            echo '</tr>';
        }
        mysqli_stmt_close($stmt);
    }
}
?>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-right">Total</td>
                                                <td>
                                                    <input type="number" step="any" class="form-control" name="TotalCargos" id="TotalCargos" readonly style="width: 100px" value="0.00">
                                                </td>
                                                <td>
                                                    <input type="number" step="any" class="form-control" name="TotalAbonos" id="TotalAbonos" readonly style="width: 100px" value="0.00">
                                                </td>
                                                <td>
                                                    <div style="height: 45px" id="ResultadoPartida" role="alert"><strong id="NombreResultado"></strong></div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <input class="form-control" type="hidden" name="Tipo" id="Tipo" value="NE" required />
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" align="center">
                        <button type="submit" class="btn ink-reaction btn-raised btn-primary" id="btnGuardar" onclick="return IngresarPolizaSi()" disabled>Guardar</button>
                    </div>
                    <br>
                    <br>
                </form>
            </div>
        </div>
        <!-- END CONTENT -->

        <?php include("../MenuUsers.html"); ?>

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
    <script src="../../../../../libs/alertify/js/alertify.js"></script>
    <!-- END JAVASCRIPT -->

    <script type="text/javascript">
        // --- Bloque de ejecución automática al cargar la página ---
        $(document).ready(function() {
            // Esta parte del script solo se ejecutará si PHP recibió los parámetros por POST
            <?php if ($proveedor_desde_post): ?>
                var cuentaInicialInput = document.getElementById('cuentaInicial');
                if (cuentaInicialInput) {
                    // Usamos un pequeño retraso para asegurar que toda la página esté lista.
                    setTimeout(function() {
                        console.log("Ejecutando búsqueda automática para:", cuentaInicialInput.value);
                        BuscarCuenta(cuentaInicialInput);
                    }, 100);
                }
            <?php endif; ?>

            // --- Tu código original se mantiene aquí ---
            $("form").keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });

            $("#agregar").on('click', function() {
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            $(document).on("click", ".eliminar", function() {
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });

            Comprovante(); // Llamar a esta función para que se ejecute al cargar
        });

        function BuscarCuenta(x) {
            var service = x.value;
            var dataString = 'service=' + service;
            $.ajax({
                type: "POST",
                url: "buscarCuenta.php",
                data: dataString,
                beforeSend: function() {
                    $('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
                },
                success: function(data) {
                    if (data == '') {
                        alertify.error('No se encontró ningún registro');
                        $('#suggestions').html('');
                    } else {
                        $('#ModalSugerencias').modal('show');
                        $('#suggestions').fadeIn(1000).html(data);
                        $('.suggest-element').click(function() {
                            x.value = $(this).attr('id') + "/" + $(this).attr('data');
                            $('#suggestions').fadeOut(500);
                            $('#ModalSugerencias').modal('hide');
                            RevisarCuentas();
                        });
                    }
                }
            });
        }

        function Calcular() {
            var TotalCargos = 0;
            var TotalAbonos = 0;
            var Contador = document.getElementsByName('Cargos[]');
            var Cargos = document.getElementsByName('Cargos[]');
            var Abonos = document.getElementsByName('Abonos[]');

            for (i = 0; i < Contador.length; i++) {
                TotalCargos += parseFloat(Cargos[i].value) || 0;
                TotalAbonos += parseFloat(Abonos[i].value) || 0;
            }

            $('#TotalCargos').val(TotalCargos.toFixed(2));
            $('#TotalAbonos').val(TotalAbonos.toFixed(2));

            if (TotalCargos.toFixed(2) == TotalAbonos.toFixed(2)) {
                $('#ResultadoPartida').removeClass('alert alert-callout alert-danger').addClass('alert alert-callout alert-success');
                $('#NombreResultado').html('Partida Completa');
                $('#btnGuardar').prop("disabled", false);
            } else {
                $('#ResultadoPartida').removeClass('alert alert-callout alert-success').addClass('alert alert-callout alert-danger');
                $('#NombreResultado').html('Partida Incompleta');
                $('#btnGuardar').prop("disabled", true);
            }
        }

        function RevisarCuentas() {
            var i = 0;
            var Centinela = false;
            var Contador = document.getElementsByName('Cargos[]');
            var Cuenta = document.getElementsByName('Cuenta[]');

            for (i = 0; i < Contador.length; i++) {
                if (Cuenta[i].value == '1.01.04.006/Funcionarios y Empleados') {
                    $('#DIVFuncionariosEmpleados').show();
                    $('#Tipo').val('FE');
                    $('#CIFSolicitante').attr("required", "required");
                    $('#NombreSolicitante').attr("required", "required");
                } else {
                    $('#DIVFuncionariosEmpleados').hide();
                    $('#Tipo').val('NE');
                    $('#CIFSolicitante').removeAttr("required");
                    $('#NombreSolicitante').removeAttr("required");
                }
            }
        }

        function SelColaborador(x) {
            window.open('SelColaborador.php', 'popup', 'width=750, height=700');
        }

        var Periodo; // Variable global para el periodo
        function SaberMesPeriodo(x) {
            var service = $(x).val();
            var dataString = 'service=' + service;
            $.ajax({
                type: "POST",
                url: "VerFechaConPeriodo.php",
                data: dataString,
                success: function(data) {
                    Periodo = data;
                }
            });
        }

        function Comprovante() {
            var fecha = document.getElementById('Fecha').value;
            $.ajax({
                url: 'ObtenerNoHojaSin.php',
                type: 'POST',
                data: {
                    fecha: fecha
                },
                success: function(data) {
                    if (data) {
                        $('#Comprobante').val(data);
                    }
                }
            });
        }

        function IngresarPolizaSi() {
            if (!Periodo) {
                alert("Por favor, seleccione un período contable.");
                return false;
            }
            var mesperiodo1 = Periodo;
            var mesperiodo2 = new Date(mesperiodo1);
            var mesperiodo3 = mesperiodo2.getMonth();

            var mesfecha1 = document.getElementById('Fecha').value;
            var mesfecha2 = new Date(mesfecha1);
            var mesfecha3 = mesfecha2.getMonth();

            var mesfecha = mesfecha3 + 1;
            var mesperiodo = mesperiodo3 + 1;

            if (mesfecha != mesperiodo) {
                var respuesta = confirm("La Fecha no coincide con el Periodo Contable, ¿Quieres continuar con el ingreso de la Poliza?");
                return respuesta;
            }
            return true;
        }
    </script>
</body>

</html>