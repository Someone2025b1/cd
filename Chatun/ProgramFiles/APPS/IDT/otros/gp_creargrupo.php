<?php 
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.letras_balncas {
	color: #FFF;
	font-weight: bold;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<form id="form1" name="form1" method="get" action="gp_ingresogrupo.php">
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#00CCCC"><div align="center" class="letras_balncas">Creación de Grupos</div></td>
    </tr>
  <tr>
    <td>Nombre del Grupo</td>
    <td><label for="nombre_gru"></label>
      <input type="text" name="nombre_gru" id="nombre_gru" /></td>
    </tr>
  <tr>
    <td>Comentario</td>
    <td><label for="comentario"></label>
      <textarea name="comentario" id="comentario" cols="45" rows="2"></textarea></td>
    </tr>
  <tr>
    <td>Nivel</td>
    <td><label for="nivel"></label>
      <select name="nivel" id="nivel">
        <option selected>--SELECIONE UN NIVEL--</option>
        <option value="1">Nivel 1</option>
        <option value="2">Nivel 2</option>
        <option value="3">Nivel 3</option>
      </select></td>
    </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">
      <input type="submit" name="button" id="button" value="Crear Gupo">
      &nbsp;&nbsp;<input name="" type="reset" value="Restablecer">
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