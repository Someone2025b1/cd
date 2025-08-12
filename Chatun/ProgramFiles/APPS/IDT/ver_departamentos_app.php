<?php
include ("../../../Script/conex.php");
$sql = mysqli_query($db, "SELECT A.id_depto, B.gerencia, A.nombre_depto FROM ".$base_general.".departamentos AS A INNER JOIN ".$base_general.".gerencias AS B ON A.id_gerencia = B.id_gerencia ORDER BY A.id_gerencia, A.nombre_depto");
$contador = 0;
?>

<html>
<head>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Script/funciones_java.js"></script>
<script language="javascript">
function confirmar() {
	return confirm("¿Está seguro de eliminar este grupo? Esta acción ya no se puede revertir");	 
}
</script>
</head>

<body class="Pagina">
<div id="menuprincipal">

<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center" class="Negrita">
    <td width="14%"><img src="Imagenes/BBDD.png" width="64" height="64"></td>
    <th width="86%" colspan="3" class="Tamano24">DEFINIR APLICACIONES POR DEPARTAMENTOS</th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>

<table width="45%" border="1" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Cajero_Generales">
  <tr align="center" bgcolor="#FFFF99">
    <th width="1%">#</th>
    <th>Nombre Gerencia</th>
    <th>Nombre Departamento</th>
    <th width="5%">Integrantes</th>
    <th>Aplicaciones</th>
    </tr>
<?php
	while ($row = mysqli_fetch_row($sql)) {
		$no_integrantes = mysqli_fetch_row(mysqli_query($db, "SELECT COUNT(id_departamento) FROM ".$base_general.".define_integrantes_departamentos WHERE id_departamento = ".$row[0]." GROUP BY id_departamento"));
		$no_aplicaciones = mysqli_fetch_row(mysqli_query($db, "SELECT COUNT(id_departamento) FROM ".$base_general.".define_aplicaciones_departamentos WHERE id_departamento = ".$row[0]." GROUP BY id_departamento"));
?>
  <tr>
    <td><?php echo ++$contador ?></td>
    <td><?php echo $row[1] ?></td>
    <td><?php echo $row[2] ?></td>
    <td align="center"><?php echo $no_integrantes[0] ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo 'ver_integrantes_departamentos.php?centinela=0&iddepto='.$row[0].'&nombre_depto='.$row[2] ?>"><img src="Imagenes/buscar.png" alt="Ver integrantes" width="16" height="16" border="0"></a></td>
    <td align="center"><?php echo $no_aplicaciones[0] ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo 'ver_aplicaciones_departamentos.php?centinela=0&iddepto='.$row[0].'&nombre_depto='.$row[2] ?>"></a><a href="<?php echo 'ver_aplicaciones_departamentos.php?centinela=0&iddepto='.$row[0].'&nombre_depto='.$row[2] ?>"><img src="Imagenes/buscar.png" alt="Ver integrantes" width="16" height="16" border="0"></a></td>
    </tr>
<?php
	}
?>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
</table>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="principal.php"><img src="Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="principal.php">Cerrar</a></td>
</tr>
</table>
</div>
</body>
</html>