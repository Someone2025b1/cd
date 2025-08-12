<?php
include ("../../../Script/conex.php");
?>

<html>
<head>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
</head>

<body class="Pagina">
<div id="menuprincipal">
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center" class="Negrita">
    <td width="14%"><img src="Imagenes/Cajero General.png" width="64" height="64" alt="Definir Cajero General"></td>
    <th width="86%" colspan="3" class="Tamano24"> CAJEROS GENERALES</th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>

<?php
	$sql = mysqli_query($db, "SELECT T_Agencias.id_agencia, T_Agencias.agencia, T_Cajeros.id_user, T_Usuarios.nombre FROM ".$base_general.".agencias AS T_Agencias LEFT JOIN ".$base_general.".cajeros_generales AS T_Cajeros ON T_Agencias.id_agencia = T_Cajeros.id_agencia LEFT JOIN ".$base_bbdd.".usuarios AS T_Usuarios ON T_Usuarios.id_user = T_Cajeros.id_user") or die (mysqli_error());
?>

<table width="35%" border="1" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Cajero_Generales">
  <tr align="center" bgcolor="#FFFF99">
    <td width="1%">#</td>
    <td width="48%">Agencia</td>
    <td width="50%">Cajero General</td>
    <td width="1%">&nbsp;</td>
    </tr>
<?php
	while ($row = mysqli_fetch_array($sql)) {
?>
  <tr>
    <td><?php echo $row["id_agencia"]; ?></td>
    <td>&nbsp;Ag.<?php echo " ".$row["agencia"];?></td>
    <td>&nbsp;<?php echo " ".$row["nombre"];?></td>
    <td><a href="definir_cajero_general.php?centinela=0&agencia=<?php echo $row["id_agencia"]; ?>"><img src="Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a></td>
  </tr>
<?php
	}
?>
</table>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="configuracion.php"><img src="Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="configuracion.php">Cerrar</a></td>
</tr>
</table>
</div>

</body>
</html>