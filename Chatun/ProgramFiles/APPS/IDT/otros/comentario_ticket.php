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
.blancas {
	color: #FFF;
	font-weight: bold;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<table align="center"width="60%" border="0">
  <tr>
    <td><div align="right"><a href="cierre_tiket.php?ti=<?php echo $ticket ?>">Cierre de Ticket</a> &nbsp;&nbsp; <a href="cierre_tiket.php?ti=<?php echo $ticket ?>"><img src="../Imagenes/candado.png" alt="Cerrado de Ticket" width="48" height="48" border="0"></a></div></td>
  </tr>
</table>

<form action="ingreso_comentario_ticket.php" method="get">
<table align="center" width="60%" border="0">
  <tr bgcolor="#000099">
    <td colspan="2" class="cetnro">Comentario de Ticket</td>
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
    <td colspan="2"><input type="submit" name="ingreso" id="ingreso" value="Ingreso de Comentario">&nbsp;
      <input type="reset" name="Restablecer" id="Restablecer" value="Restablecer"></td>
    
  </tr>
  </table>



</form>
<?php
$sql = "SELECT * FROM coosajo_caidas_enlaces.secuencia_ticket WHERE `nun_ticket` =$ticket LIMIT 0, 30 "; 
$result_n = mysqli_query($db, $sql);

?>
<table align="center" width="60%" border="0">
  <tr>
    <td colspan="2" bgcolor="#0000CC" class="blancas">Historial de seguimeinto de Ticket</td>
  </tr>
  <tr class="blancas">
    <td bgcolor="#006600">Fecha de Comentario</td>
    <td bgcolor="#006600">Comentario</td>
  </tr>
   <?php while ($row=mysqli_fetch_array($result_n)) {
		
		
		
		?>
  <tr>
    <td><?php echo $row["fecha"] ?></td>
    <td><?php echo $row["comentarios"] ?></td>
  </tr>
  <?php }
  ?>
</table>
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