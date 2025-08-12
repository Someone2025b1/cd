<?php
include ("../../../Script/conex.php");
$iddepto = $_GET["iddepto"];
$nombre_depto = $_GET["nombre_depto"];
$contador = 0;
if ($_GET["centinela"] == 3) {
	$cif = $_GET["cif"];
	mysqli_query($db, "INSERT INTO ".$base_general.".define_integrantes_departamentos VALUES ($iddepto, $cif)") or die ("Ya existe este usuario dentro de este departamento... Verifique por favor... #Error:".mysqli_error());
}
if ($_GET["centinela"] == 4) {
	$cif = $_GET["cif"];
	mysqli_query($db, "DELETE FROM ".$base_general.".define_integrantes_departamentos WHERE id_user = $cif AND id_departamento = $iddepto") or die ("No existe la persona en este depto, verifique porfavor... #Error:".mysqli_error());
}
?>

<html>
<head>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Script/funciones_java.js"></script>
<script language="javascript">
function confirmar() {
	return confirm("¿Está seguro de eliminar este integrante de este departamento? Esta acción ya no se puede revertir");	 
}
</script>
</head>

<body class="Pagina">
<div id="menuprincipal">

<?php
$sql = mysqli_query($db, "SELECT A.id_departamento, B.id_user, B.nombre FROM ".$base_general.".define_integrantes_departamentos AS A JOIN ".$base_bbdd.".usuarios AS B ON A.id_user = B.id_user WHERE A.id_departamento = $iddepto ORDER BY B.nombre") or die (mysqli_error());
?>
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center" class="Negrita">
    <td width="14%"><img src="Imagenes/Cajero General.png" width="64" height="64" alt="Definir Cajero General"></td>
    <th width="86%" colspan="3" class="Tamano24">DEPARTAMENTO <?php echo strtoupper($nombre_depto)?></th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>

<table width="35%" border="1" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Cajero_Generales">
  <tr align="center" bgcolor="#FFFF99">
    <th width="3%">#</th>
    <th width="95%">Colaborador</th>
    <th width="2%">&nbsp;</th>
    </tr>
<?php
	while ($row = mysqli_fetch_row($sql)) {
?>
  <tr>
    <td><?php echo ++$contador ?></td>
    <td>&nbsp;<?php echo $row[2] ?></td>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=4&iddepto='.$row[0].'&cif='.$row[1].'&nombre_depto='.$nombre_depto ?>" onClick="return confirmar()"><img src="Imagenes/borrar.png" width="16" height="16" border="0"></a></td>
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
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1&iddepto='.$iddepto.'&nombre_depto='.$_GET["nombre_depto"] ?>"><img src="Imagenes/agregar.png" alt="Agregar nueva agencia" width="32" height="32" border="0"></a></td>
    </tr>
  <tr>
    <td align="center" class="Tamano10"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1&idgrupo='.$idgrupo ?>">Agregar colaborador</a></td>
    </tr>
  <tr>
    <td align="center" class="Tamano10">&nbsp;</td>
  </tr>
</table>

<?php
if ($_GET["centinela"] != '0') {
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=2&iddepto='.$iddepto.'&nombre_depto='.$nombre_depto ?>" method="post" name="Buscar" id="Buscar">
<table width="25%" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="buscador">
  <tr align="center">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>CIF o Nombre:</td>
    <td><input type="text" name="cif" id="cif"></td>
    <td><input type="submit" name="Buscar2" id="Buscar2" value="Buscar..."></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo '<script language="javascript"> hacer_focus("cif") </script>' ?></td>
  </tr>
</table>
</form>

<?php
}
if ($_GET["centinela"] == '2') { 
	$buscador = $_POST["cif"];
	$buscador1 = "%".$buscador."%";
	$sql = mysqli_query($db, "SELECT * FROM info_bbdd.usuarios WHERE id_user = '$buscador' OR nombre LIKE '$buscador1' ORDER BY nombre LIMIT 10");
?>
<table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr bgcolor="#FFFF99" align="center">
    <td width="25%">CIF</td>
    <td width="75%">Nombre y Apellido</td>
    </tr>
<?php
	while ($row1 = mysqli_fetch_row($sql)) {
?>
  <tr>
    <td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=3&iddepto='.$iddepto.'&cif='.$row1[0].'&nombre_depto='.$nombre_depto ?>"><?php echo $row1[0]; ?></a></td>
    <td><?php echo $row1[1]; ?></td>
  </tr>
<?php 
	}
?>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
	}
?>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="ver_departamentos_app.php?centinela=0"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="ver_departamentos_app.php?centinela=0">Regresar</a></td>
</tr>
</table>
</div>

</body>
</html>