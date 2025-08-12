<?php 
include("../../../../Script/conex.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.branco {
	color: #FFF;
	text-align: center;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<table align="center" width="80%" border="1">
<?php
$sql = "SELECT * FROM coosajo_caidas_enlaces.id_agencias WHERE compania='telered' ORDER BY id_agencias.id ASC " ;
		$result_n = mysqli_query($db, $sql);

?>
  <tr bgcolor="#000099" class="branco">
    <td>Agencias</td>
    <td>Direccion Ip</td>
    <td>Paswword</td>
    <td>Modificar</td>
  </tr>
  <tr style="text-align: center">
  <?php while ($row=mysqli_fetch_array($result_n)) {
		
		?>
    <td><div align="center"><?php echo $row["agencia"] ?></div></td>
    <td><div align="center"><?php echo $row["direccion_ip"] ?></div></td>
    <td><div align="center"><?php echo $row["contrasena"] ?></div></td>
    <td><div align="center"><a href="cambio_contrasena.php?ag=<?php echo $row["id"] ?>"><img src="../Imagenes/edit.png" alt="Modificar" width="16" height="16" border="0"></a></div></td>
  </tr>
  <?php } ?>
</table>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="../configuracion.php"><img src="../Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"><br>Cerrar</a></td>
</tr>
</table>
</div>
</div>
</body>
</html>