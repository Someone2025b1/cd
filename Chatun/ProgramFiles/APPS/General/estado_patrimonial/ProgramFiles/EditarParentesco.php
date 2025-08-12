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
    </script>

</head>

<body style="background-color: #FFFFFF" onload="LevantarModal()">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title" align="center">
				<h3><strong>Editar Parentesco</strong></h3>
			</div>
		</div>
		<div class="panel-body">
			<div class="container">
                <?php
                    $sql = "SELECT * FROM Estado_Patrimonial.detalle_parentescos WHERE id = '".$_GET["CodigoPariente"]."'";
                    $Resultados = mysqli_query($db, $sql);
                    while($row = mysqli_fetch_array($Resultados))
                    {
                        $TipoPersona         = $row["tipo_persona"];
                        $Parentesco          = $row["parentesco"];
                        $Dependiente         = $row["dependiente"];
                        $Ocupacion           = $row["ocupacion"];
                        $CIF                 = $row["cif"];
                        $Vive                = $row["vive"];
                        $DireccionHijo       = $row["direccion_hijo"];
                        $NombreNoAsociado    = $row["nombre_no_asociado"];
                        $FechaNacimientoHijo = $row["fecha_nacimiento_hijo"];
                    }
                ?>

                        <form class="form-horizontal" role="form" id="ParentescosFORM" action="ActualizarParentescoEditar.php" method="POST">
                            <div class="form-group">
                                <label for="TipoPersonaParentesco" class="col-lg-3 control-label">¿Su familiar es asociado?</label>
                                <div class="col-lg-9">
                                    <select name="TipoPersona" id="TipoPersonaParentesco" class="form-control" onChange="HabilitarTipoPersona(this)">
                                        <option value="" disabled selected>Elige una opción</option>
                                        <option value="1" <?php if($TipoPersona==1){echo 'selected';} ?>>Sí</option>
                                        <option value="2" <?php if($TipoPersona==2){echo 'selected';} ?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div id="DIVTipoPersonaAsociado" <?php if($TipoPersona==1){echo 'style="display: block"';}else{echo 'style="display: none"';} ?>>
                                <div class="form-group">
                                    <label for="CIF" class="col-lg-3 control-label">CIF</label>
                                    <div class="col-lg-9" align="left" >
                                        <input type="tel" size="10" class="form-control" name="CIF" id="CIF" value="<?php echo $CIF ?>" onchange="BusquedaCIF(this.value)" title="Ayuda" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Si no conoce el CIF de la persona, puede realizar su búsqueda por medio del nombre, en el campo de abajo." >
                                        <span class="help-block text-left">Búsqueda por CIF</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Nombre" class="col-lg-3 control-label">Nombre</label>
                                    <div class="col-lg-9" align="left" >
                                        <input type="tel" size="75" class="form-control" value="<?php echo saber_nombre_asociado($CIF) ?>" name="Nombre" id="Nombre" title="Ayuda" data-toggle="popover" data-trigger="hover" data-placement="left" data-content="Su búsqueda puede ser por nombres o apellidos, respetando el orden de los mismos (apellidos,nombres). " >
                                        <div id="suggestions"></div>
                                        <span class="help-block text-left">Búsqueda por nombre</span>
                                    </div>
                                </div>
                            </div>
                            <div id="DIVTipoPersonaNoAsociado" <?php if($TipoPersona==2){echo 'style="display: block"';}else{echo 'style="display: none"';} ?>>
                                <div class="form-group">
                                    <label for="NombreNoAsociado" class="col-lg-3 control-label">Nombre</label>
                                    <div class="col-lg-9" align="left" >
                                        <input type="tel" size="75" class="form-control" value="<?php echo $NombreNoAsociado ?>" name="NombreNoAsociado" id="NombreNoAsociado" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="a_parentesco" class="col-lg-3 control-label">Parentesco</label>
                                <div class="col-lg-9">
                                    <select name="parentesco" id="a_parentesco" class="form-control" onChange="HabilitarHijos(this.value)">
                                        <option value="" disabled selected>Elige una opción</option>
                                        <option value="1"<?php if($Parentesco=='Hijo / Hija'){echo 'selected';} ?>>Hijo / Hija</option>
                                        <option value="2"<?php if($Parentesco=='Padre / Madre'){echo 'selected';} ?>>Padre / Madre</option>
                                        <option value="3"<?php if($Parentesco=='Hermano / Hermana'){echo 'selected';} ?>>Hermano / Hermana</option>
                                        <option value="4"<?php if($Parentesco=='Nieto / Nieta'){echo 'selected';} ?>>Nieto / Nieta</option>
                                        <option value="5"<?php if($Parentesco=='Abuelo / Abuela'){echo 'selected';} ?>>Abuelo / Abuela</option>
                                        <option value="6"<?php if($Parentesco=='Suegro / Suegra'){echo 'selected';} ?>>Suegro / Suegra</option>
                                        <option value="7"<?php if($Parentesco=='Yerno / Nuera'){echo 'selected';} ?>>Yerno / Nuera</option>
                                        <option value="8"<?php if($Parentesco=='Cuñado / Cuñada'){echo 'selected';} ?>>Cuñado / Cuñada</option>
                                        <option value="9"<?php if($Parentesco=='Cónyuge'){echo 'selected';} ?>>Cónyuge</option>
                                    <option value="10" <?php if($Parentesco=='Tio/Tia'){echo 'selected';} ?>>Tio/Tia</option>
                                        <option value="11"  <?php if($Parentesco=='Sobrino/Sobrina'){echo 'selected';} ?>>Sobrino/Sobrina</option>
                                        <option value="12"  <?php if($Parentesco=='Biznieto/Biznieta'){echo 'selected';} ?>>Biznieto/Biznieta</option>
                                        <option value="13"  <?php if($Parentesco=='Bisabuela/Bisabuelo'){echo 'selected';} ?>>Bisabuela/Bisabuelo</option>
                                        <option value="14"  <?php if($Parentesco=='Primo / Prima'){echo 'selected';} ?>>Primo / Prima</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="FechaNacimientoHijo" <?php if($Parentesco=='Hijo / Hija'){echo 'style="display: block"';}else{echo 'style="display: none"';} ?>>
                                <label for="FechaNacimiento" class="col-lg-3 control-label">Fecha Nacimiento</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="date" class="form-control" name="FechaNacimiento" id="FechaNacimiento" value="<?php echo $FechaNacimientoHijo ?>">
                                </div>
                            </div>
                            <div class="form-group" id="ViveConUsted" <?php if($Parentesco=='Hijo / Hija'){echo 'style="display: block"';}else{echo 'style="display: none"';} ?>>
                                <label for="Vive" class="col-lg-3 control-label">Vive con usted?</label>
                                <div class="col-lg-9" align="left" >
                                    <select name="Vive" id="Vive" class="form-control" onChange="HabilitarDireccionHijo(this.value)">
                                        <option value="" disabled selected>Elige una opción</option>
                                        <option value="1" <?php if($Vive==1){echo 'selected';} ?>>Si</option>
                                        <option value="2" <?php if($Vive==2){echo 'selected';} ?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="DireccionHijo" <?php if($Vive==2){echo 'style="display: block"';}else{echo 'style="display: none"';} ?>>
                                <label for="DireccionHijo" class="col-lg-3 control-label">Dirección</label>
                                <div class="col-lg-9" align="left" >
                                    <textarea name="DireccionHijo" id="DireccionHijo" cols="75" rows="5" class="form-control" ><?php echo $DireccionHijo ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="dependiente" class="col-lg-3 control-label">Depende de usted?</label>
                                <div class="col-lg-9" align="left" >
                                    <select name="dependiente" id="dependiente" class="form-control">
                                        <option value="" disabled selected>Elige una opción</option>
                                        <option value="1" <?php if($Dependiente==1){echo 'selected';} ?>>Si</option>
                                        <option value="2" <?php if($Dependiente==2){echo 'selected';} ?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="OcupacionParentesco" class="col-lg-3 control-label">Ocupación</label>
                                <div class="col-lg-9" align="left" >
                                    <input type="text" size="75" class="form-control" value="<?php echo $Ocupacion ?>" name="OcupacionParentesco" id="OcupacionParentesco">
                                </div>
                            </div>
                            <div id="resultado"></div>
                            <input type="hidden" size="75" class="form-control" value="<?php echo $_GET['CodigoPariente'] ?>" name="IDParentescoEditar" id="IDParentescoEditar">
                        
                    </div>
                </div>
                <div class="panel-footer text-center">
                    <a href="informacion_base.php"><button type="button" class="btn btn-warning">
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
