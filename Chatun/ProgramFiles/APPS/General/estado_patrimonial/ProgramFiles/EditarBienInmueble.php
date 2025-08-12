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
				<h3><strong>Editar Bien Inmueble</strong></h3>
			</div>
		</div>
		<div class="panel-body">
			<div class="container">
                <?php
                    $sql = "SELECT * 
                            FROM  `Estado_Patrimonial`.`bienes_inmuebles_detalle` 
                            WHERE  `id` ='".$_GET["ID"]."'";
                    $Resultados = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_array($Resultados))
                    {
                        $Tipo         = $row["id_tipo_inmueble"];
                        $Localizacion = $row["localizacion"];
                        $Finca        = $row["finca"];
                        $Folio        = $row["folio"];
                        $Libro        = $row["libro"];
                        $Departamento = $row["departamento"];
                        $ValorMercado = $row["valor_mercado"];
                    }
                ?>

                        <form class="form-horizontal" role="form" id="ParentescosFORM" action="ActualizarBienInmuebleEditar.php" method="POST">
                            <div class="form-group">
                                <label for="TipoInmueble" class="col-lg-3 control-label">Tipo de Inmueble</label>
                                <div class="col-lg-9">
                                    <select name="TipoInmueble" id="TipoInmueble" class="form-control">
                                        <option value="" disabled selected>Elige una opción</option>
                                        <option value="1" <?php if($Tipo==1){echo 'selected';} ?>>Casa</option>
                                        <option value="2" <?php if($Tipo==3){echo 'selected';} ?>>Finca</option>
                                        <option value="2" <?php if($Tipo==4){echo 'selected';} ?>>Locales Comerciales</option>
                                        <option value="2" <?php if($Tipo==5){echo 'selected';} ?>>Otros</option>
                                        <option value="2" <?php if($Tipo==2){echo 'selected';} ?>>Terreno</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Localizacion" class="col-lg-3 control-label">Localización</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="Localizacion" id="Localizacion" value="<?php echo $Localizacion ?>"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Finca" class="col-lg-3 control-label">Finca</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" class="form-control" name="Finca" id="Finca" value="<?php echo $Finca ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Folio" class="col-lg-3 control-label">Folio</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" class="form-control" name="Folio" id="Folio" value="<?php echo $Folio ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Libro" class="col-lg-3 control-label">Libro</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" class="form-control" name="Libro" id="Libro" value="<?php echo $Libro ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Departamento" class="col-lg-3 control-label">Departamento</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="50" class="form-control" name="Departamento" id="Departamento" value="<?php echo $Departamento?>"  required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ValorMercado" class="col-lg-3 control-label">Valor de Mercado</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="number" min="0" class="form-control" name="ValorMercado" id="ValorMercado" value="<?php echo $ValorMercado ?>"  required>
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
