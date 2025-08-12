<?php 
include("../../../../Script/conex.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.formato {
	color: #FFF;
}
table {
	text-align: center;
	font-size: 12px;
}
</style>
</head>

<body>
<table width="70%">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT DISTINCT *  FROM colaboradores c, id_agencias a WHERE a.id=c.agencia AND c.agencia=a.id ";
	  $result_n = mysqli_query($db, $sql);
	  ?>
<table align="center" border="0" width="100%">
  <tr bgcolor="#000099">
    <td colspan="7" class="formato">Colaboradores</td>
  </tr>
  <tr bgcolor="#00CC66">
    <td class="formato">Nombre</td>
    <td class="formato">Agencia</td>
    <td class="formato">Puesto</td>
    <td class="formato">No. Telefono</td>
    <td class="formato">No. Celular</td>
    <td class="formato">Dirección</td>
  </tr>
  <?php 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
	?>
  <tr>
    <td><?php echo $row["nombre_colaborador"]?></td>
    <td><?php echo $row["agencia"]?></td>
    <td><?php echo $row["puesto"]?></td>
    <td><?php echo $row["nun_telefono"]?></td>
    <td><?php echo $row["nun_celular"]?></td>
    <td><?php echo $row["direccion"]?></td>
  </tr>
  <?php
	 	} ?>
</table>
</body>
</html>