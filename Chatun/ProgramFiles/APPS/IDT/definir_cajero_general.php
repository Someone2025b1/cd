<?php
include ("../../../Script/conex.php");
include ("../../../Script/seguridad.php");
?>

<html>
<head>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
</head>
<script language="javascript">
function cargar() {
	document.Buscar.cif.focus();
}
</script>

<body class="Pagina" onLoad="cargar()">
<div id="menuprincipal">
<?php 
	$id_agencia = $_GET["agencia"];
	$sql_agencia = "SELECT * FROM ".$base_general.".agencias where id_agencia = '$id_agencia'";
	$result_ag = mysqli_query($db, $sql_agencia);
	$row0 = mysqli_fetch_array($result_ag);
?>
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center">
    <td width="14%"><img src="Imagenes/Cajero General.png" width="64" height="64" alt="Definir Cajero General"></td>
    <th width="86%" colspan="3" class="Tamano24">DEFINIR CAJERO PARA AG. <?php echo $row0["agencia"] ;?></th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>

<form action="definir_cajero_general.php?centinela=1&agencia=<?php echo  $id_agencia ?>" method="post" name="Buscar" id="Buscar">
<table width="25%" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="buscador">
  <tr>
    <td width="75%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    </tr>
  <tr>
    <td>CIF o Nombre:
      <input type="text" name="cif" id="cif"></td>
    <td><label for="cif">
      <input type="submit" name="Buscar" id="Buscar" value="Buscar...">
    </label></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

<?php
	if ($_GET["centinela"] == '1') { 
	$buscador = $_POST["cif"];
	$buscador1 = "%".$buscador."%";
	$sql = "SELECT * FROM ".$base_bbdd.".usuarios WHERE id_user = '$buscador' OR nombre LIKE '$buscador1' LIMIT 10";
	$result = mysqli_query($db, $sql);
?>
<table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr bgcolor="#FFFF99" align="center">
    <td width="25%">CIF</td>
    <td width="75%">Nombre y Apellido</td>
    </tr>
<?php
	while ($row1 = mysqli_fetch_array($result)) {
?>
  <tr>
    <td align="center" onClick="alert('Datos grabados...');
"><a href="grabar_cajero_general.php?cif=<?php echo $row1["id_user"] ?>&agencia=<?php echo $id_agencia ?>"><?php echo $row1["id_user"]; ?></a></td>
    <td><?php echo $row1["nombre"] ?></td>
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
  <td align="center"><a href="ver_cajeros_generales.php"><img src="Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="ver_cajeros_generales.php">Cerrar</a></td>
</tr>
</table>
</div>

</body>
</html>