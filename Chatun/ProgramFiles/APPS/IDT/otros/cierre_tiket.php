<?php 
include("../../../../Script/conex.php");

$ticket= $HTTP_GET_VARS[ti];
//echo $ticket;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.cetnro {
	text-align: center;
	color: #FFF;
}
td {
	text-align: center;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<form action="cancelado.php" method="get">
<table align="center" width="60%" border="0">
  <tr bgcolor="#000099">
    <td colspan="2" class="cetnro">Cierre de Ticket</td>
    </tr>
  <tr>
    <td>Ticket</td>
    <td><label for="ticket"></label>
      <input name="ticket" type="text" id="ticket" value="<?php echo $ticket ?>"></td>
  </tr>
  <tr>
    <td colspan="2">Comentarios</td>
    </tr>
  <tr>
    <td colspan="2"><label for="comentario"></label>
      <textarea name="comentario" id="comentario" cols="45" rows="5"></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="cierre" id="cierre" value="Cierre de Ticket">&nbsp;
      <input type="reset" name="Restablecer" id="Restablecer" value="Restablecer"></td>
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