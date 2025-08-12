<?php
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
<script language="javascript">
function confirmar() {
	return confirm("¿Está seguro de eliminar este integrante de este grupo? Esta acción ya no se puede revertir");	 
}
</script>
</head>

<body class="Pagina">
<div id="menuprincipal">

<?php
$sql = mysqli_query($db, "SELECT A.id_grupo, B.id_user, B.nombre FROM info_base.define_integrantes_grupos AS A JOIN info_bbdd.usuarios AS B ON A.id_user = B.id_user WHERE A.id_grupo = $idgrupo ORDER BY B.nombre") or die (mysqli_error());
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
    <td><a href="<?php echo 'grabar_integrantes_grupos.php?tipo=2&idgrupo='.$row[0].'&cif='.$row[1]?>" onClick="return confirmar()"><img src="Imagenes/borrar.png" width="16" height="16" border="0"></a></td>
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
    <td align="center" class="Tamano10"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1&idgrupo='.$idgrupo ?>">Agregar colaborador</a></td>
    </tr>
  <tr>
    <td align="center" class="Tamano10">&nbsp;</td>
  </tr>
</table>

<?php
if ($_GET["centinela"] != '0') {
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=2&idgrupo='.$idgrupo?>" method="post" name="Buscar" id="Buscar">
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
	while ($row1 = mysqli_fetch_array($sql)) {
?>
  <tr>
    <td align="center"><a href="<?php echo 'grabar_integrantes_grupos.php?tipo=1&idgrupo='.$idgrupo.'&cif='.$row1["id_user"] ?>"><?php echo $row1["id_user"]; ?></a></td>
    <td><?php echo utf8_decode($row1["nombre"]); ?></td>
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
  <td align="center"><a href="ver_grupos.php?centinela=0"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="ver_grupos.php?centinela=0">Regresar</a></td>
</tr>
</table>
</div>

</body>
</html>