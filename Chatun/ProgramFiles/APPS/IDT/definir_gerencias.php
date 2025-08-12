<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$sql = mysqli_query($db, "SELECT A.id_aplicacion, B.nombre, B.icono, B.link FROM ".$base_general.".define_aplicaciones_departamentos AS A LEFT JOIN ".$base_bbdd.".aplicaciones AS B ON A.id_aplicacion = B.id_aplicacion WHERE A.id_departamento = $id_depto AND B.estado = 1") or die (mysqli_error());
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
      <table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano24">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center">
    <td width="14%"><img src="Imagenes/Gerencias_peque.png" width="58" height="64"></td>
    <th width="86%" colspan="3">DEFINIR GERENCIAS</th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>
<?php
if ($_GET["centinela"] == '0' OR $_GET["centinela"] == '1') {
?>
<table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr bgcolor="#FFFF99" align="center">
    <th width="75%">Gerencia</th>
    <th width="25%">Accion</th>
    </tr>
<?php
  $result = mysqli_query($db, "SELECT * FROM ".$base_general.".gerencias");
  while ($row = mysqli_fetch_array($result)) {
?>
  <tr>
    <td align="center"><?php echo $row["gerencia"] ?></td>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=3&gerencia='.$row["id_gerencia"] ?>"><img src="Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a>&nbsp;&nbsp;<a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=5&gerencia='.$row["id_gerencia"] ?>" onClick="return confirmar('esta gerencia')"><img src="Imagenes/borrar.png" width="16" height="16" border="0" ></a></td>
    </tr>
<?php 
  }
?>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>"><img src="Imagenes/agregar.png" alt="Agregar nueva agencia" width="32" height="32" border="0"></a></td>
    </tr>
  <tr>
    <td colspan="2" align="center" class="Tamano10"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>">Agregar nueva gerencia</a></td>
    </tr>
  <tr>
    <td colspan="2" align="center" class="Tamano10">&nbsp;</td>
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
    <th colspan="2">Agregar Gerencia</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="40%">Nombre Gerencia:</td>
    <td width="60%">
      <label for="no_agencia"></label>
      <input name="nombre_gerencia" type="text" id="nombre_gerencia"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar" id="Grabar" value="Grabar..."><?php echo '<script> hacer_focus("nombre_gerencia")' ?></td>
    </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '2') {
  $nombre_gerencia = $_POST["nombre_gerencia"];
  $comentario = "Creación de nueva gerencia con nombre: ".$nombre_gerencia;
  mysqli_query($db, "INSERT INTO ".$base_general.".gerencias VALUES (NULL, '$nombre_gerencia')") or die("Error al crear este registro... #".mysqli_error());
  mysqli_query($db, "INSERT INTO ".$base_general.".log_cambios_base VALUES (NULL, 0, '$nombre_tabla', 1, '$iduser', CURRENT_TIMESTAMP, 'Creación de nueva Gerencia', '$comentario', NULL, '$nombre_gerencia', '$ip')") or die (mysqli_error());
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
</table>
<?php
}
if ($_GET["centinela"] == '3') {
  $gerencia = $_GET["gerencia"];
  $result = mysqli_query($db, "SELECT * FROM ".$base_general.".gerencias WHERE id_gerencia = '$gerencia'");
  $row = mysqli_fetch_array($result);
?>
<form name="modificar_agencia" method="post" action="<?php echo $_SERVER['PHP_SELF'].'?centinela=4&gerencia='.$gerencia ?>">
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <th colspan="2">Modificar Gerencia</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="40%">Nombre Gerencia:</td>
    <td width="60%">
      <label for="no_agencia"></label>
      <input name="nombre_gerencia" type="text" id="nombre_gerencia" value="<?php echo $row['gerencia'] ?>"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar" id="Grabar" value="Grabar...">
      <?php echo '<script> hacer_focus("nombre_gerencia")' ?></td>
    </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '4') {
  $gerencia = $_GET["gerencia"];
  $nombre_gerencia = $_POST["nombre_gerencia"];
  $tmp = mysqli_fetch_row(mysqli_query($db, "SELECT * FROM ".$base_general.".gerencias WHERE id_gerencia =  $gerencia"));
  $datos_anteriores = $tmp[0]." * ".$tmp[1];
  $datos_nuevos = $tmp[0]." * ".$nombre_gerencia; 
  $comentario = "Se modifico la Gerencia con Nombre: ".$tmp[1];
  mysqli_query($db, "UPDATE ".$base_general.".gerencias SET gerencia = '$nombre_gerencia' WHERE id_gerencia = '$gerencia'") or die("Error al modificar este registro... #".mysqli_error());
  mysqli_query($db, "INSERT INTO ".$base_general.".log_cambios_base VALUES (NULL, 0, '$nombre_tabla', 2, '$iduser', CURRENT_TIMESTAMP, 'Modificación de Gerencia', '$comentario', '$datos_anteriores', '$datos_nuevos', '$ip')") or die (mysqli_error());
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
</table>
<?php
}
if ($_GET["centinela"] == '5') {
  $gerencia = $_GET["gerencia"];
  $tmp = mysqli_fetch_row(mysqli_query($db, "SELECT * FROM ".$base_general.".gerencias WHERE id_gerencia =  $gerencia"));
  $datos_anteriores = $tmp[0]." * ".$tmp[1];
  $comentario = "Se eliminó la Gerencia con Nombre: ".$tmp[1];
  mysqli_query($db, "DELETE FROM ".$base_general.".gerencias WHERE id_gerencia = '$gerencia'") or die("Error al eliminar este registro... #".mysqli_error());
  mysqli_query($db, "DELETE FROM ".$base_general.".define_gerentes WHERE id_gerencia = $gerencia") or die(mysqli_error());
  mysqli_query($db, "DELETE FROM ".$base_general.".departamentos WHERE id_gerencia = $gerencia") or die(mysqli_error());
  mysqli_query($db, "DELETE FROM ".$base_general.".jefaturas WHERE id_gerencia = $gerencia") or die(mysqli_error());
  mysqli_query($db, "INSERT INTO ".$base_general.".log_cambios_base VALUES (NULL, 0, '$nombre_tabla', 3, '$iduser', CURRENT_TIMESTAMP, 'Eliminación de Gerencia', '$comentario', '$datos_anteriores', NULL, '$ip')") or die (mysqli_error());
?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
  <tr>
    <td>Datos eliminados con &eacute;xito...</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>">Regresar...</a></td>
  </tr>
</table>
<?php
}
?>
</div>

 
<div id="flotante_izquierdo">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="ver_asignaciones.php?centinela=0&tipo=1"><img src="Imagenes/gerentes.png" alt="Regresar" width="64" height="64" border="0"></br>DEFINIR GERENTES</a></td>
</tr>
</table>
</div>
 

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante_derecho" class="Tamano12" align="center">
<tr>
<?php
if ($_GET["centinela"] == 0) {
?>
<?php
} else {
?>
<td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"><br />Regresar</a></td>
<?php
}
?>
</tr>
</div>
    </div>
    <!-- END CONTENT -->

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
