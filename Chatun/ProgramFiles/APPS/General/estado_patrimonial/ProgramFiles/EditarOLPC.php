<?php
header('Content-Type:text/html;charset=utf-8');
//session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");

$UserID = $_SESSION["iduser"];
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

    <!-- Core Scripts - Include with every page -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/alertify.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Mint Admin Scripts - Include with every page -->
    <script src="js/mint-admin.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8899-1">

    <script>
        function ChgEntidadFinanciera(x)
        {
            $('#Acreedor').val(x);
        }
    </script>

</head>

<body style="background-color: #FFFFFF" onload="LevantarModal()">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title" align="center">
				<h3><strong>Editar Obligaciones a Largo Plazo</strong></h3>
			</div>
		</div>
		<div class="panel-body">
			<div class="container">
                <?php
                    $sql = "SELECT * 
                            FROM  `Estado_Patrimonial`.`obligacioneslp_detalle` 
                            WHERE  `id` ='".$_GET["ID"]."'";
                    $Resultados = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_array($Resultados))
                    {
                        $EntidadFinanciera = $row["entidad_financiera"];
                        $Acreedor          = $row["acreedor"];
                        $Garantia          = $row["garantia"];
                        $Vencimiento       = $row["vencimiento"];
                        $MontoOriginal     = $row["monto_original"];
                        $SaldoActual       = $row["saldo_actual"];
                        $Frecuencia        = $row["frecuencia"];
                        $MontoAmortizacion = $row["monto_amortizacion"];
                    }
                ?>

                        <form class="form-horizontal" role="form" id="ParentescosFORM" action="ActualizarOLPCEditar.php" method="POST">
                            <div class="form-group">
                                <label for="EntidadFinanciera" class="col-lg-3 control-label">Entidad Financiera</label>
                                <div class="col-lg-9" align="left" >
                                    <select class="form-control" name="EntidadFinanciera" id="EntidadFinanciera" onchange="ChgEntidadFinanciera(this.value)">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Coosajo R.L." <?php if($EntidadFinanciera == 'Coosajo R.L.'){echo 'selected';} ?>>Coosajo R.L.</option>
                                        <option value="Bancos" <?php if($EntidadFinanciera == 'Bancos'){echo 'selected';} ?>>Bancos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Acreedor" class="col-lg-3 control-label">Acreedor</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="Acreedor" id="Acreedor" value="<?php echo $Acreedor; ?>" readonly required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Garantia" class="col-lg-3 control-label">Garantía</label>
                                <div class="col-lg-9" align="left" >
                                    <select class="form-control" name="Garantia" id="Garantia">
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="Hipotecario" <?php if($Garantia == 'Hipotecario'){echo 'selected';} ?>>Hipotecario</option>
                                        <option value="Derecho de Posesión" <?php if($Garantia == 'Derecho de Posesión'){echo 'selected';} ?>>Derecho de Posesión</option>
                                        <option value="Fiduciario" <?php if($Garantia == 'Fiduciario'){echo 'selected';} ?>>Fiduciario</option>
                                        <option value="Prendario" <?php if($Garantia == 'Prendario'){echo 'selected';} ?>>Prendario</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Vencimiento" class="col-lg-3 control-label">Vencimiento</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="date" class="form-control" name="Vencimiento" id="Vencimiento" value="<?php echo $Vencimiento ?>"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoOriginal" class="col-lg-3 control-label">Monto Original</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" step="any" name="MontoOriginal" id="MontoOriginal" value="<?php echo $MontoOriginal ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="SaldoActual" class="col-lg-3 control-label">Saldo Actual</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" step="any" name="SaldoActual" id="SaldoActual" value="<?php echo $SaldoActual ?>"  required>
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
                                        <option value="Diario" <?php if($Frecuencia == 'Diario'){echo 'selected';} ?>>Diario</option>
                                        <option value="Semanal" <?php if($Frecuencia == 'Semanal'){echo 'selected';} ?>>Semanal</option>
                                        <option value="Quincenal" <?php if($Frecuencia == 'Quincenal'){echo 'selected';} ?>>Quincenal</option>
                                        <option value="Mensual" <?php if($Frecuencia == 'Mensual'){echo 'selected';} ?>>Mensual</option>
                                        <option value="Bimensual" <?php if($Frecuencia == 'Bimensual'){echo 'selected';} ?>>Bimensual</option>
                                        <option value="Trimestral" <?php if($Frecuencia == 'Trimestral'){echo 'selected';} ?>>Trimestral</option>
                                        <option value="Cuatrimestral" <?php if($Frecuencia == 'Cuatrimestral'){echo 'selected';} ?>>Cuatrimestral</option>
                                        <option value="Semestral" <?php if($Frecuencia == 'Semestral'){echo 'selected';} ?>>Semestral</option>
                                        <option value="Anual" <?php if($Frecuencia == 'Anual'){echo 'selected';} ?>>Anual</option>
                                        <option value="Pago Único" <?php if($Frecuencia == 'Pago Único'){echo 'selected';} ?>>Pago Único</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="MontoCortoPlazo" class="col-lg-3 control-label">Monto</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" step="any" name="MontoCortoPlazo" id="MontoCortoPlazo" value="<?php echo $MontoAmortizacion ?>"  required>
                                </div>
                            </div>
                            <input type="hidden" min="0" class="form-control" name="ID" id="ID" value="<?php echo $_GET['ID'] ?>"  required>
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <a href="estado_patrimonial.php"><button type="button" class="btn btn-warning">
                        <span class="glyphicon glyphicon-arrow-left"></span> Regresar
                    </button></a>
                    <button type="submit" class="btn btn-success">
                        <span class="glyphicon glyphicon-ok"></span> Actualizar
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
