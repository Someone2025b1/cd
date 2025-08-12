<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
$_GET["centinela"] = $_GET["centinela"];

if ($_GET["centinela"] == '4') { //Cuando cambia la información
	$id_user = $_GET["cif"];
	$departamento = $_POST["departamento"];
	$texto = '';
	$sql = mysqli_query($db, "INSERT INTO info_base.define_integrantes_departamentos VALUES('$departamento', '$id_user') ON DUPLICATE KEY UPDATE id_departamento = '$departamento'") or die(mysqli_error()." / Ya debe de existir agregado el acceso a este departamento...");
	$_GET["centinela"] = 3;
}

if ($_GET["centinela"] == '5') { //Cuando cambia la información
	$id_user = $_GET["cif"];
	$depto = $_GET["depto"];
	$texto = '';
	$sql = mysqli_query($db, "DELETE FROM info_base.define_integrantes_departamentos WHERE id_user = '$id_user' AND id_departamento = '$depto'") or die (mysqli_error());
	$_GET["centinela"] = 3;
}
?>
<html>
<head>
<meta charset="iso-8859-1" http-equiv="Content-Type" content="text/html"/>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
</head>

<script language="javascript">
function cargar() {
	document.Buscar.cif.focus();
}
function confirmar() {
	return confirm("¿Está seguro de eliminar el acceso a este departamento?");	 
}
</script>

<body class="Pagina" onLoad="cargar()">
<div id="menuprincipal">
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano24">
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td width="12%"><img src="Imagenes/Permisos.png" width="64" height="64"></td>
    <th width="88%" align="center">CONFIGURACI&Oacute;N DE PERMISOS DEL PORTAL</th>
    </tr>
  <tr>
    <td colspan="2"><hr>
    </td>
    </tr>
</table>

<?php
if ($_GET["centinela"] != '2' AND $_GET["centinela"] != '3') { //Visible cuando entra y cuando busca
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>" method="post" name="Buscar" id="Buscar">
<table width="25%" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="buscador">
  <tr>
    <td width="75%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    </tr>
  <tr>
    <td>CIF o Nombre:
      <input type="text" name="cif" id="cif"></td>
    <td>
      <input type="submit" name="Buscar" id="Buscar" value="Buscar...">
    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '1') {  //Visible cuando busca
	$buscador = $_POST["cif"];
	$buscador1 = "%".$buscador."%";
	$sql = "SELECT * FROM info_bbdd.usuarios WHERE id_user = '$buscador' OR nombre LIKE '$buscador1' ORDER BY id_user LIMIT 20";  
	$result = mysqli_query($db, $sql);
?>
<table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr bgcolor="#FFFF99" align="center">
    <td width="25%">CIF</td>
    <td width="75%">Nombre y Apellido</td>
    </tr>
<?php
	while ($row1 = mysqli_fetch_row($result)) {
?>
  <tr>
    <td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=2&cif='.$row1[0] ?>"><?php echo $row1[0]; ?></a></td>
    <td><?php echo $row1[1]; ?></td>
  </tr>
<?php 
	}
?>
  <tr>
    <td colspan="2" align="center" class="Tamano10">&nbsp;</td>
  </tr>
</table>

<?php
}
if ($_GET["centinela"] == '2' OR $_GET["centinela"] == '3') { ///Visible cuando selecciona Usuario
	$id_user = $_GET["cif"];
	$sql = mysqli_query($db, "SELECT * FROM ".$base_bbdd.".usuarios WHERE id_user = '$id_user'");
	$row = mysqli_fetch_array($sql);
  $Nombr = $row['nombre'];
?>

<table width="35%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="MenuCaja">
  <tr >
    <td width="40%" >Nombres y Apellidos</td>
    <td colspan="2"><input name="nombres" type="text" disabled id="nombres" value="<?php echo $Nombr; ?>" size="40"></td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>

<?php
 
$sql = mysqli_query($db, "SELECT A.id_departamento, B.nombre_depto FROM info_base.define_integrantes_departamentos AS A LEFT JOIN info_bbdd.departamentos AS B ON A.id_departamento = B.id_depto WHERE id_user = '$id_user'");
if (mysqli_num_rows($sql) > 0) {
?>
  <tr align="center">
    <th colspan="3">Acceso a los Departamentos:</th>
  </tr>
  <tr align="center">
    <td colspan="3"><hr /></td>
  </tr>
<?php 
while ($data = mysqli_fetch_row($sql)) {
?>
  <tr align="center">
    <td colspan="2"><?php echo $data[1] ?></td>
    <td width="10%"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=5&cif='.$id_user."&depto=".$data[0]?>"><img src="Imagenes/borrar.png" width="16" height="16" border="0" onClick="return confirmar()"></a></td>
  </tr>
<?php
}
?>
  <tr align="center">
    <td colspan="3"><hr /></td>
  </tr>
<?php
}
?>
  <tr align="center">
    <td colspan="3"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=3&cif='.$id_user ?>"><img src="Imagenes/agregar.png" alt="Agregar permiso..." width="32" height="32" border="0"></a></td>
  </tr>
  <tr align="center">
    <td colspan="3" class="Tamano10"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=3&cif='.$id_user?>">Agregar acceso a departamento</a></td>
  </tr>
  <tr align="center">
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

<?php
}
if ($_GET["centinela"] == '3') {
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=4&cif='.$id_user ?>" method="post" name="cambio_perfil" id="cambio_perfil">
<table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="MenuCaja">
  <tr >
    <td colspan="2"><hr /></td>
    </tr>
  <tr >
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" width="50%">Departamento:</td>
    <td width="50%"><?php $sql = mysqli_query($db, "SELECT * FROM info_base.departamentos ORDER BY nombre_depto ASC"); ?>
    <select name="departamento" id="departamento">
      <option value="0">:: Seleccionar Depto ::</option>
    	<?php while ($select_depto = mysqli_fetch_row($sql)) {
		?>
        <option value="<?php echo $select_depto[0]?>"><?php echo $select_depto[2]?></option>
		<?php
        }
		?>
    </select></td>
    </tr>
  <tr >
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr >
    <td colspan="2" align="center"><input type="submit" name="Guardar" id="Guardar" value="Guardar"></td>
    </tr>
  <tr >
    <td>&nbsp;</td>
    <td><?php echo '<script language="javascript"> document.getElementById("departamento").focus(); </script>'; ?></td>
  </tr>
</table>
</form>
<?php 
}
?>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
<?php
if ($_GET["centinela"] == 0) {
?>
  <td align="center"><a href="principal.php"><img src="Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"></br>Cerrar</a></td>
<?php
} else {
?>
<td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></br>Regresar</a></td>
<?php
}
?>
</tr>
</div>

</body>
</html>