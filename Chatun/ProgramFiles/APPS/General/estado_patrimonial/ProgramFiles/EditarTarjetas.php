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

</head>

<body style="background-color: #FFFFFF" onload="LevantarModal()">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title" align="center">
				<h3><strong>Editar Tarjetas de Crédito</strong></h3>
			</div>
		</div>
		<div class="panel-body">
			<div class="container">
                <?php
                    $sql = "SELECT * 
                            FROM  `Estado_Patrimonial`.`tarjetas_credito_detalle` 
                            WHERE  `id` ='".$_GET["ID"]."'";
                    $Resultados = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_array($Resultados))
                    {
                        $Acreedor         = $row["acreedor"];
                        $Vencimiento = $row["vencimiento"];
                        $MontoOriginal        = $row["monto_original"];
                        $SaldoActual        = $row["saldo_actual"];
                    }
                ?>

                        <form class="form-horizontal" role="form" id="ParentescosFORM" action="ActualizarTarjetasEditar.php" method="POST">
                            <div class="form-group">
                                <label for="Localizacion" class="col-lg-3 control-label">Acreedor</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="Acreedor" id="Acreedor" value="<?php echo $Acreedor ?>"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Finca" class="col-lg-3 control-label">Vencimiento</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="date" class="form-control" name="Vencimiento" id="Vencimiento" value="<?php echo $Vencimiento ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Folio" class="col-lg-3 control-label">Monto Original</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" class="form-control" name="MontoOriginal" id="MontoOriginal" value="<?php echo $MontoOriginal ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Libro" class="col-lg-3 control-label">Saldo Actual</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" class="form-control" name="SaldoActual" id="SaldoActual" value="<?php echo $SaldoActual ?>" >
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
