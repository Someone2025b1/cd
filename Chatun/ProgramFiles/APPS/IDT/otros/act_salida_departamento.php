<?php 
$id= $HTTP_GET_VARS[id];
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.letras_blancas {
	color: #FFF;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<?php $sql = "SELECT * FROM coosajo_inventario_idt.inventario_departamento where id='$id'";
	$result_n = mysqli_query($db, $sql); 
	$row=mysqli_fetch_array($result_n);
?>
<form action="act_actualizar_salida_equipo.php" method="get">
<table width="35%" border="0" align="center">
  <tr>
    <td colspan="2" bgcolor="#000099"><div align="center" class="letras_blancas">Salida de equipo del Departamento IDT</div></td>
    </tr>
  <tr>
    <td bgcolor="#009900">&nbsp;</td>
    <td bgcolor="#009900">&nbsp;</td>
  </tr>
  <tr>
    <td>Inventario</td>
    <td><label for="inventa"></label>
      <input name="inventa" type="text" id="inventa" value="<?php echo $row["inventario"] ?>" readonly></td>
  </tr>
  <tr>
    <td>Tipo</td>
    <td><label for="tipo"></label>
      <input name="tipo" type="text" id="tipo" value="<?php echo $row["tipo"] ?>" readonly></td>
  </tr>
  <tr>
    <td>Descripcion Salida</td>
    <td><label for="descri"></label>
      <textarea name="descri" id="descri" cols="45" rows="2"></textarea></td>
  </tr>
  <tr>
    <td><input name="id" type="hidden" id="id" value="<?php echo $row["id"]  ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" id="button" value="Sacar Equipo"></td>
  </tr>
</table>
</form>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="javascript:history.back()"><img src="../Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="javascript:history.back()">Regresar</a></td>
</tr>
</table>
</div>

</body>
</html>