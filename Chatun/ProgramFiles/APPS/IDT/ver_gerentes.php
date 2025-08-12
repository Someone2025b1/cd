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
    <th width="86%" colspan="3" class="Tamano24">DEFINICI&Oacute;N DE GERENTES</th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>

<?php
	$sql = mysqli_query($db, "SELECT A.*,  C.nombre FROM ".$base_general.".gerencias AS A LEFT JOIN ".$base_general.".define_gerentes AS B ON A.id_gerencia = B.id_gerencia LEFT JOIN ".$base_bbdd.".usuarios AS C
ON B.id_user = C.id_user") or die (mysqli_error());
/*Definición de Tipos de Colaboradores:
201	Gerentes
202	Jefes de Departamentos
203	Jefes de Agencias
204	Cajeros Generales
205	Coordinadores de Negocio
*/
$contador = 0;
?>

<table width="35%" border="1" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Cajero_Generales">
  <tr align="center" bgcolor="#FFFF99">
    <td width="1%">#</td>
    <td width="48%">Gerencia</td>
    <td width="50%">Nombre Colaborador</td>
    <td width="1%">&nbsp;</td>
    </tr>
<?php
	while ($row = mysqli_fetch_row($sql)) {
?>
  <tr>
    <td><?php echo ++$contador ?></td>
    <td>&nbsp;<?php echo " ".$row[1];?></td>
    <td>&nbsp;<?php echo " ".$row[2];?></td>
    <td><a href="<?php echo "definir_colaboradores.php?centinela=0&tipo=1&id=".$row["0"]; ?>"><img src="Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a></td>
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