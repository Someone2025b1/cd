<?php
include ("../../../Script/conex.php");
include ("../../../Script/seguridad.php");
$id_depto = $_SESSION["id_departamento"];
$i = 0;
$sql = mysqli_query($db, "SELECT A.id_aplicacion, B.nombre, B.icono, B.link FROM ".$base_general.".define_aplicaciones_departamentos AS A LEFT JOIN ".$base_bbdd.".aplicaciones AS B ON A.id_aplicacion = B.id_aplicacion WHERE A.id_departamento = $id_depto AND B.estado = 1") or die (mysqli_error());
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
</head>

<body class="Pagina">
<div id="menuprincipal">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Menu">
  <tr align="center">
    <td colspan="5">&nbsp;</td>
    </tr>
<?php
while ($grupos = mysqli_fetch_row($sql)) {
	$i++;
	$a = substr($grupos[3],0,4);
	if ($a == "http") {
		$link = $grupos[3];
	} else {
		$link = "..".$grupos[3];
	}

    if ($i == 1) {
		echo '<tr>';
	}
	if ($i <= 5) {
		echo '<td><a href="'.$link.'?idaplicacion='.$grupos[0].'"><img src="../IDT/Imagenes/Aplicaciones/'.$grupos[2].'" width="128" height="128" border="0"></br>'.strtoupper($grupos[1]).'</a></td>';
	}
	if ($i == 5) {
		echo '</tr>';
		echo '<tr>';
		echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
		echo '</tr>';
		$i = 0;	
	}
}

echo '</tr>';

?>
  <tr align="center" class="Negrita">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="../../portal_principal.php" target="_top"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="../../portal_principal.php" target="_top">Regresar</a></td>
</tr>
</table>
</div>

</body>
</html>