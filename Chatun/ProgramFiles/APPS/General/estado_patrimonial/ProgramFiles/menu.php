<?php
//header('Location: ../../../../../Script/Mantenimiento/index.html');
header('Content-Type:text/html;charset=utf-8');
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
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />

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
    <?php include("../../../../MenuTop.php") ?>

	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title" align="center">
				<h3><strong>Información Colaboradores</strong></h3>
			</div>
		</div>
		<div class="panel-body" style="width: 100%; height: 83%">
			<div class="row">
                <div class="col-lg-6 text-center">
                   <a href="informacion_base.php"><img src="../Imagenes/user-flat.png" alt="..." class="img-thumbnail"></a>
                </div>   
                <div class="col-lg-6 text-center">
                <a href="imprimir.php" target="_blank"><img src="../Imagenes/print-flat.png" alt="..." class="img-thumbnail"></a>
                </div>        
            </div>
            <div class="row">
                <div class="col-lg-6 text-center">
                   <a href="informacion_base.php">Información Básica</a>
                </div>   
                <div class="col-lg-6 text-center">
                <a href="imprimir.php" target="_blank">Imprimir</a>
                </div>        
            </div>
		</div>
	</div>
</body>

</html>
