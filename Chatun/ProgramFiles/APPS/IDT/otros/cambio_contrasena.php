<?php 
include("../../../../Script/conex.php");
$id_agencia= $HTTP_GET_VARS[ag];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.blanco {
	text-align: center;
	color: #FFF;
}
#centro {
	text-align: center;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<?php 

echo $id_agencia;
$sql= "SELECT * FROM coosajo_caidas_enlaces.id_agencias WHERE id=$id_agencia";
$result_n= mysqli_query($db, $sql);
$row=mysqli_fetch_array($result_n);

?>
<form action="actualizar_password.php" method="get">
<table align="center" width="60%" border="0">
  <tr bgcolor="#000099" class="blanco">
    <td colspan="2">Cambio de Contraseña</td>
    </tr>
  <tr>
    <td>Agencia</td>
    <td><label for="agencia"></label>
      <input name="agencia" type="text" id="agencia" value="<?php echo $row["agencia"] ?>" />
      <input name="nu_agencia" type="hidden" id="nu_agencia" value="<?php echo $id_agencia ?>"></td>
  </tr>
  <tr>
    <td>Contraseña Nueva</td>
    <td><label for="clave"></label>
      <input type="text" name="clave" id="clave" /></td>
  </tr>
  <tr>
    <td colspan="2" id="centro"><div align="center">
      <input type="submit" name="enviar" id="enviar" value="Enviar" />
      &nbsp;
      <input type="reset" name="Restablecer" id="Restablecer" value="Restablecer" />
    </div></td>
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