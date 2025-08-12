<?php
ob_start();
include ("../../../Script/conex.php");
$idgrupo = $_GET["idgrupo"];
$sql = mysqli_query($db, "SELECT * FROM ".$base_general.".define_grupos WHERE id_grupo = '$idgrupo'");
$row = mysqli_fetch_row($sql);
$contador = 0;
?>

<html>
<head>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Script/funciones_java.js"></script>
</head>

<body class="Pagina">
<div id="menuprincipal">

<?php
$sql = mysqli_query($db, "SELECT A.id_aplicacion, B.nombre, C.nivel, B.estado, C.id_nivel FROM info_base.define_aplicaciones_grupos AS A JOIN ".$base_bbdd.".aplicaciones AS B ON A.id_aplicacion = B.id_aplicacion JOIN ".$base_bbdd.".define_nivel AS C ON A.id_nivel = C.id_nivel WHERE A.id_grupo = $idgrupo ORDER BY B.nombre ASC") or die (mysqli_error());
?>
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center" class="Negrita">
    <td width="14%"><img src="Imagenes/Cajero General.png" width="64" height="64" alt="Definir Cajero General"></td>
    <th width="86%" colspan="3" class="Tamano24">GRUPO <?php echo strtoupper($row[1])?></th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>

<table width="35%" border="1" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Cajero_Generales">
  <tr align="center" bgcolor="#FFFF99">
    <th width="5%">#</th>
    <th width="60%">Aplicaci&oacute;n</th>
    <th width="25%">Nivel</th>
    <th width="5%">Estado</th>
    <th width="5%">&nbsp;</th>
    </tr>
<?php
	while ($row = mysqli_fetch_row($sql)) {
?>
  <tr>
    <td><?php echo ++$contador ?></td>
    <td>&nbsp;<?php echo $row[1] ?></td>
    <td align="center"><?php echo $row[2] ?></td>
    <td align="center"><?php if($row[3] == 1) { echo "Activo"; } else { echo "Inactivo"; } ?></td>
    <td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=3&idaplicacion='.$row[0].'&idgrupo='.$idgrupo ?>" onClick="return confirmar('esta aplicacion')"><img src="Imagenes/borrar.png" alt="" width="16" height="16" border="0"></a></td>
  </tr>
<?php
	}
?>
</table>

<table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1&idgrupo='.$idgrupo ?>"><img src="Imagenes/agregar.png" alt="Agregar nueva agencia" width="32" height="32" border="0"></a></td>
    </tr>
  <tr>
    <td align="center" class="Tamano10"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1&idgrupo='.$idgrupo ?>">Agregar Aplicaci&oacute;n</a></td>
    </tr>
  <tr>
    <td align="center" class="Tamano10">&nbsp;</td>
  </tr>
</table>

<?php
if ($_GET["centinela"] != '0') {
	$idgrupo = $_GET["idgrupo"];
	$sql = mysqli_query($db, "SELECT * FROM ".$base_bbdd.".aplicaciones ORDER BY nombre") or die (mysqli_error());
	$sql_1 = mysqli_query($db, "SELECT * FROM ".$base_bbdd.".define_nivel") or die (mysqli_error());
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=2&idgrupo='.$idgrupo?>" method="post" name="Buscar" id="Buscar">
<table width="25%" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="buscador">
  <tr align="center">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Aplicaci&oacute;n:</td>
    <td><select name="aplicacion" id="aplicacion">
      <?php while ($apps = mysqli_fetch_row($sql)) {  ?>
      <option value="<?php echo $apps[0] ?>"><?php echo $apps[1] ?></option>
      <?php } ?>
    </select></td>
    </tr>
  <tr>
    <td>Nivel:</td>
    <td><select name="nivel" id="nivel">
      <?php while ($nivel = mysqli_fetch_row($sql_1)) {  ?>
      <option value="<?php echo $nivel[0] ?>"><?php echo $nivel[1] ?></option>
      <?php } ?>
    </select></td>
    </tr>
  <tr align="center">
    <td colspan="2"><input type="submit" name="Grabar" id="Grabar" value="Grabar">
      <?php echo '<script language="javascript"> hacer_focus("aplicacion") </script>' ?></td>
    </tr>
</table>
</form>

<?php
}
if ($_GET["centinela"] == '2') { 
	$idgrupo = $_GET["idgrupo"];
	$idaplicacion = $_POST["aplicacion"];
	$idnivel = $_POST["nivel"];
	
	$sql = mysqli_query($db, "INSERT INTO ".$base_general.".define_aplicaciones_grupos VALUES ($idgrupo, $idaplicacion, $idnivel)") or die ("Ya existe esta aplicación en este grupo, si desea modificar, eliminelo primero y luego vuelvalo a ingresar...".mysqli_error());
	
	//Complementos en otras tablas
	$sql = mysqli_query($db, "SELECT * FROM ".$base_general.".define_integrantes_grupos WHERE id_grupo = $idgrupo");
	$hay_datos = mysqli_querynum_rows($sql);
	if ($hay_datos != 0) {
		while ($si_datos = mysqli_fetch_row($sql)) {
			mysqli_queryquery ("INSERT INTO ".$base_bbdd.".define_permisos VALUES (NULL, $idgrupo, $si_datos[1], $idaplicacion, $idnivel) ON DUPLICATE KEY UPDATE id_nivel = $idnivel") or die (mysqli_error());
		}
	}	
		
	header('Location: '.$_SERVER['PHP_SELF'].'?centinela=0&idgrupo='.$idgrupo);
}
if ($_GET["centinela"] == '3') { 
	$idgrupo = $_GET["idgrupo"];
	$idaplicacion = $_GET["idaplicacion"];
	
	mysqli_query($db, "DELETE FROM ".$base_general.".define_aplicaciones_grupos WHERE id_grupo = $idgrupo AND id_aplicacion = $idaplicacion") or die (mysqli_error());
	
	//Complementos en otras tablas
	mysqli_query($db, "DELETE FROM ".$base_bbdd.".define_permisos WHERE id_grupo = $idgrupo AND id_aplicacion = $idaplicacion") or die (mysqli_error());
	
	header('Location: '.$_SERVER['PHP_SELF'].'?centinela=0&idgrupo='.$idgrupo);
}
?>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="ver_grupos.php?centinela=0"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="ver_grupos.php?centinela=0">Regresar</a></td>
</tr>
</table>
</div>

</body>
</html>
<?php
ob_flush;
?>