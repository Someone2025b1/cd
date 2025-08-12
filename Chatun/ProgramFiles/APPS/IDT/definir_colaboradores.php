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
	$tipo_definir = $_GET["tipo"];
	$id_definir = $_GET["id"];
	$encabezado = $_GET["encabezado"];
	switch ($tipo_definir) {
		case 1:	$encabezado1 = " RESPONSABLE DE ".strtoupper($encabezado);
				break;
		case 2:	$encabezado1 = " RESPONSABLE DE ".strtoupper($encabezado);
				break;	
		case 3:	$encabezado1 = " RESPONSABLE DE LA AGENCIA ".strtoupper($encabezado);
				break;
		case 4:	$encabezado1 = " CAJERO GENERAL DE LA AGENCIA ".strtoupper($encabezado);
				break;
		case 5:	$encabezado1 = " COORDINADOR DE NEGOCIOS DE LA AGENCIA ".strtoupper($encabezado);
				break;
				
	}
	$sql_agencia = "SELECT * FROM ".$base_general.".agencias WHERE id_agencia = '$id_agencia'";
	$result_ag = mysqli_query($db, $sql_agencia);
	$row0 = mysqli_fetch_array($result_ag);
?>
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center">
    <td width="14%"><img src="Imagenes/Cajero General.png" width="64" height="64" alt="Definir Cajero General"></td>
    <th width="86%" colspan="3" class="Tamano24">DEFINIR <?php echo $encabezado1 ?></th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>

<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=1&tipo='.$tipo_definir.'&id='.$id_definir.'&encabezado='.$encabezado ?>" method="post" name="Buscar" id="Buscar">
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
	$sql = mysqli_query($db, "SELECT * FROM info_colaboradores.vista_colaboradores WHERE cif = '$buscador' OR Nombres LIKE '$buscador1' LIMIT 10") or die (mysqli_error());

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
    <td align="center" onClick="alert('Datos grabados...');
"><a href="<?php echo 'grabar_definir_colaboradores.php?tipo='.$tipo_definir.'&id='.$id_definir.'&cif='.$row1[0] ?>"><?php echo $row1[0]; ?></a></td>
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
  <td align="center"><a href="<?php echo 'ver_asignaciones.php?centinela=0&tipo='.$tipo_definir ?>"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="<?php echo 'ver_asignaciones.php?centinela=0&tipo='.$tipo_definir ?>">Regresar</a></td>
</tr>
</table>
</div>

</body>
</html>