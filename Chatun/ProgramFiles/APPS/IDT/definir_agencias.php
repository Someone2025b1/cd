<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
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
  <link type="text/css" rel="stylesheet" href="../../../css/style.css">
  <link type="text/css" rel="stylesheet" href="../../../css/theme-4/bootstrap.css" />
  <link type="text/css" rel="stylesheet" href="../../../css/theme-4/materialadmin.css" />
  <link type="text/css" rel="stylesheet" href="../../../css/theme-4/font-awesome.min.css" />
  <link type="text/css" rel="stylesheet" href="../../../css/theme-4/material-design-iconic-font.min.css" />
  <!-- END STYLESHEETS -->
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

  <?php include("../../MenuTop.php") ?>

  <!-- BEGIN BASE-->
  <div id="base">

    <!-- BEGIN CONTENT-->
    <div id="content" style="margin-left: -125px">
      <div class="content-fluid text-right">
        <br>
        <button type="button" class="btn ink-reaction btn-primary">
          <i class="fa fa-chevron-left"> <a href="principal.php">Regresar</a></i>
        </button>
        <br>
        <br>
      </div>
      
      <div id="menuprincipal">
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano24">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center">
    <td width="14%"><img src="Imagenes/Agencias_peque.png" width="64" height="64"></td>
    <th width="86%" colspan="3">DEFINIR AGENCIAS</th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>
<?php
if ($_GET["centinela"] == '0' OR $_GET["centinela"] == '1') {
?>
<table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr bgcolor="#FFFF99" align="center">
    <th width="25%">#</th>
    <th width="50%">Agencia</th>
    <th width="25%">Accion</th>
    </tr>
<?php
  $result = mysqli_query($db, "SELECT * FROM ".$base_general.".agencias ORDER BY id_agencia ASC");
  while ($row = mysqli_fetch_array($result)) {
?>
  <tr>
    <td align="center"><?php echo $row["id_agencia"] ?></td>
    <td><?php echo $row["agencia"] ?></td>
    <td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=3&agencia='.$row["id_agencia"] ?>"><img src="Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a>&nbsp;&nbsp;<a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=5&agencia='.$row["id_agencia"] ?>" onClick="return confirmar('esta agencia')"><img src="Imagenes/borrar.png" width="16" height="16" border="0" ></a></td>
  </tr>
<?php 
  }
?>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>"><img src="Imagenes/agregar.png" alt="Agregar nueva agencia" width="32" height="32" border="0"></a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="Tamano10"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>">Agregar nueva agencia</a></td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="Tamano10">&nbsp;</td>
  </tr>
</table>
<?php
}
if ($_GET["centinela"] == '1') {
?>
<form name="agregar_agencia" method="post" action="<?php echo $_SERVER['PHP_SELF'].'?centinela=2' ?>">
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <th colspan="2">Agregar Agencia</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="40%">N&uacute;mero Agencia:</td>
    <td width="60%">
      <label for="no_agencia"></label>
      <input name="no_agencia" type="text" id="no_agencia" size="8"></td>
  </tr>
  <tr>
    <td width="40%">Nombre Agencia:</td>
    <td width="60%">
      <label for="no_agencia"></label>
      <input name="nombre_agencia" type="text" id="nombre_agencia"></td>
  </tr>
  <tr>
    <td>Direcci&oacute;n:</td>
    <td><input name="direccion" type="text" id="direccion"></td>
    </tr>
  <tr>
    <td>Departamento:</td>
    <td><input name="departamento" type="text" id="departamento"></td>
    </tr>
  <tr>
    <td>Municipio:</td>
    <td><input name="municipio" type="text" id="municipio"></td>
    </tr>
  <tr>
    <td>Tel&eacute;fonos:</td>
    <td><input name="telefonos" type="text" id="telefonos"></td>
    </tr>
  <tr>
    <td>Fax:</td>
    <td><input name="fax" type="text" id="fax"></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar2" id="Grabar2" value="Grabar..."><?php echo '<script> hacer_focus("no_agencia") </script>' ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '2') {
  $no_agencia = $_POST["no_agencia"];
  $nombre_agencia = $_POST["nombre_agencia"]; 
  $direccion = $_POST["direccion"];
  $departamento = $_POST["departamento"];
  $municipio = $_POST["municipio"];
  $telefonos = $_POST["telefonos"];
  $fax = $_POST["fax"];
  $datos_nuevos = $no_agencia." * ".$nombre_agencia." * ".$direccion." * ".$departamento." * ".$municipio." * ".$telefonos." * ".$fax;
  $comentario = "Se creó nueva agencia con número: ".$no_agencia." y con nombre: ".$nombre_agencia;
  mysqli_query($db, "INSERT INTO ".$base_general.".agencias VALUES ('$no_agencia', '$nombre_agencia', '$municipio', '$departamento', '$direccion', '$telefonos', '$fax')") or die("Error al grabar este registro... Ya existe esta agencia, favor de revisar... ".mysqli_error());
?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
  <tr>
    <td>Datos grabados con &eacute;xito...</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>">Regresar...</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
}
if ($_GET["centinela"] == '3') {
  $agencia = $_GET["agencia"];
  $result = mysqli_query($db, "SELECT * FROM ".$base_general.".agencias WHERE id_agencia = '$agencia'");
  $row = mysqli_fetch_array($result);
?>
<form name="modificar_agencia" method="post" action="<?php echo $_SERVER['PHP_SELF'].'?centinela=4&agencia='.$agencia ?>">
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <th colspan="2">Modificar Agencia</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="40%">N&uacute;mero Agencia:</td>
    <td width="60%">
      <label for="no_agencia"></label>
      <input name="no_agencia" type="text" id="no_agencia" value="<?php echo $row['id_agencia'] ?>" size="8"></td>
  </tr>
  <tr>
    <td width="40%">Nombre Agencia:</td>
    <td width="60%">
      <label for="no_agencia"></label>
      <input name="nombre_agencia" type="text" id="nombre_agencia" value="<?php echo $row['agencia'] ?>"></td>
  </tr>
  <tr>
    <td>Direcci&oacute;n:</td>
    <td><input name="direccion" type="text" id="direccion" value="<?php echo $row['direccion'] ?>"></td>
    </tr>
  <tr>
    <td>Departamento:</td>
    <td><input name="departamento" type="text" id="departamento" value="<?php echo $row['departamento'] ?>"></td>
    </tr>
  <tr>
    <td>Municipio:</td>
    <td><input name="municipio" type="text" id="municipio" value="<?php echo $row['municipio'] ?>"></td>
    </tr>
  <tr>
    <td>Tel&eacute;fonos:</td>
    <td><input name="telefonos" type="text" id="telefonos" value="<?php echo $row['telefonos'] ?>"></td>
    </tr>
  <tr>
    <td>Fax:</td>
    <td><input name="fax" type="text" id="fax" value="<?php echo $row['fax'] ?>"></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar" id="Grabar" value="Grabar...">
      <?php echo '<script> hacer_focus("no_agencia") </script>' ?>
      <input name="datos anteriores" type="hidden" id="datos anteriores" value="<?php echo $row["id_agencia"]." * ".$row["agencia"]." * ".$row["direccion"]." * ".$row["departamento"]." * ".$row["municipio"]." * ".$row["telefonos"]." * ".$row["fax"]; ?>">
      <input name="datos_agencia" type="hidden" id="datos_agencia" value="<?php echo $row["id_agencia"]."  ".$row["agencia"]; ?>"></td>
    </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '4') {
  $agencia = $_GET["agencia"];
  $no_agencia = $_POST["no_agencia"];
  $nombre_agencia = $_POST["nombre_agencia"]; 
  $direccion = $_POST["direccion"];
  $departamento = $_POST["departamento"];
  $municipio = $_POST["municipio"];
  $telefonos = $_POST["telefonos"];
  $fax = $_POST["fax"];
  $datos_anteriores = $_POST["datos_anteriores"];
  $datos_nuevos = $no_agencia." * ".$nombre_agencia." * ".$direccion." * ".$departamento." * ".$municipio." * ".$telefonos." * ".$fax;
  $comentario = "Se hicieron modificaciones a la Agencia: ".$_POST["datos_agencia"];
  mysqli_query($db, "UPDATE ".$base_general.".agencias SET id_agencia = '$no_agencia', agencia = '$nombre_agencia' WHERE id_agencia = '$agencia'") or die("Error al grabar este registro... #".mysqli_error());
?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
  <tr>
    <td>Datos modificados con &eacute;xito...</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>">Regresar...</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
}
if ($_GET["centinela"] == '5') {
  $agencia = $_GET["agencia"];
  $sql = mysqli_query($db, "SELECT * FROM ".$base_general.".agencias WHERE id_agencia = $agencia") or die (mysqli_error());
  $tmp = mysqli_fetch_row($sql);
  $datos_anteriores = $tmp[0]." * ".$tmp[1]." * ".$tmp[2]." * ".$tmp[3]." * ".$tmp[4]." * ".$tmp[5]." * ".$tmp[6];
  $comentario = "Se eliminó información de la Agencia: ".$tmp[0]." ".$tmp[1];
  mysqli_query($db, "DELETE FROM ".$base_general.".agencias WHERE id_agencia = '$agencia'") or die("Error al eliminar registro... #".mysqli_error());
  mysqli_query($db, "DELETE FROM ".$base_general.".define_cajeros_generales WHERE id_agencia = $agencia") or die(mysqli_error());
  mysqli_query($db, "DELETE FROM ".$base_general.".define_coordinadores_negocios WHERE id_agencia = $agencia") or die(mysqli_error());
  mysqli_query($db, "DELETE FROM ".$base_general.".define_jefe_agencia WHERE id_agencia = $agencia") or die(mysqli_error());
?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
  <tr>
    <td>Datos eliminado con &eacute;xito...</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>">Regresar...</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
}
?>
</div>

<?php 
if ($_GET["centinela"] == 0) {
}
?>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
<?php
if ($_GET["centinela"] == 0) {
?>
<?php
} else {
?>
<td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></br>Regresar</a></td>
<?php
}
?>
</tr>
</div>


    </div>
  </div><!--end #base-->
  <!-- END BASE -->

  <!-- BEGIN JAVASCRIPT -->
  <script src="../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
  <script src="../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
  <script src="../../../js/libs/bootstrap/bootstrap.min.js"></script>
  <script src="../../../js/libs/spin.js/spin.min.js"></script>
  <script src="../../../js/libs/autosize/jquery.autosize.min.js"></script>
  <script src="../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
  <script src="../../../js/core/source/App.js"></script>
  <script src="../../../js/core/source/AppNavigation.js"></script>
  <script src="../../../js/core/source/AppOffcanvas.js"></script>
  <script src="../../../js/core/source/AppCard.js"></script>
  <script src="../../../js/core/source/AppForm.js"></script>
  <script src="../../../js/core/source/AppNavSearch.js"></script>
  <script src="../../../js/core/source/AppVendor.js"></script>
  <script src="../../../js/core/demo/Demo.js"></script>
  <!-- END JAVASCRIPT -->

</body>
</html>
