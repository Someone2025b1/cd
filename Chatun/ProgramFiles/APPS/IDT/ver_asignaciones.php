<?php
include ("../../../Script/conex.php");
include ("../../../Script/seguridad.php");
/*Definición de Tipos de Colaboradores:
1	Gerentes
2	Jefes de Departamentos
3	Jefes de Agencias
4	Cajeros Generales
5	Coordinadores de Negocios
*/
switch ($_GET["tipo"]) {
	case 1:	$encabezado  = "GERENTES";
			$columna1 = "Gerencia";
			$sql = mysqli_query($db, "SELECT A.*,  C.nombre FROM info_base.gerencias AS A LEFT JOIN info_base.define_gerentes AS B ON A.id_gerencia = B.id_gerencia LEFT JOIN ".$base_bbdd.".usuarios AS C
ON B.id_user = C.id_user") or die (mysqli_error());
			break;
	case 2:	$encabezado  = "JEFES DE DEPARTAMENTOS";
			$columna1 = "Gerencia";
			$columna2 = "Departamento";
			$sql = mysqli_query($db, "SELECT A.id_depto, B.gerencia, A.nombre_depto, D.nombre FROM info_base.departamentos AS A LEFT JOIN info_base.gerencias AS B ON A.id_gerencia = B.id_gerencia LEFT JOIN info_base.define_jefe_departamento AS C ON A.id_depto = C.id_departamento LEFT JOIN ".$base_bbdd.".usuarios AS D ON C.id_user = D.id_user  WHERE B.id_gerencia > 0 ORDER BY B.id_gerencia") or die (mysqli_error());
			break;
	case 3:	$encabezado  = "JEFES DE AGENCIA";
			$columna1 = "Agencia";
			$sql = mysqli_query($db, "SELECT A.id_agencia, A.agencia, C.nombre FROM info_base.agencias AS A LEFT JOIN info_base.define_jefe_agencia AS B ON A.id_agencia = B.id_agencia LEFT JOIN ".$base_bbdd.".usuarios AS C ON B.id_user = C.id_user") or die (mysqli_error());
			break;
	case 4:	$encabezado  = "CAJEROS GENERALES";
			$columna1 = "Agencia";
			$sql = mysqli_query($db, "SELECT A.id_agencia, A.agencia, C.nombre FROM info_base.agencias AS A LEFT JOIN info_base.define_cajeros_generales AS B ON A.id_agencia = B.id_agencia LEFT JOIN ".$base_bbdd.".usuarios AS C ON B.id_user = C.id_user") or die (mysqli_error());
			break;
	case 5:	$encabezado  = "COORDINADORES DE NEGOCIOS";
			$columna1 = "Agencia";
			$sql = mysqli_query($db, "SELECT A.id_agencia, A.agencia, C.nombre FROM info_base.agencias AS A LEFT JOIN info_base.define_coordinadores_negocios AS B ON A.id_agencia = B.id_agencia LEFT JOIN ".$base_bbdd.".usuarios AS C ON B.id_user = C.id_user") or die (mysqli_error());
			break;
}
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
    <th width="86%" colspan="3" class="Tamano24">DEFINICI&Oacute;N DE <?php echo $encabezado ?></th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>

<?php
if ($_GET["tipo"] != 2) {
$contador = 0;
?>
<table width="35%" border="1" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Cajero_Generales">
  <tr align="center" bgcolor="#FFFF99">
    <td width="1%">#</td>
    <td width="48%"><?php echo $columna1 ?>xxx</td>
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
    <td><a href="<?php echo "definir_colaboradores.php?centinela=0&id=".$row["0"].'&tipo='.$_GET["tipo"].'&encabezado='.$row[1]; ?>"><img src="Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a></td>
  </tr>
<?php
	}
?>
</table>

<?php
} else {
$contador = 0;
?>

<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Cajero_Generales">
  <tr align="center" bgcolor="#FFFF99">
    <td width="1%">#</td>
    <td width="30%"><?php echo $columna1 ?></td>
    <td width="30%"><?php echo $columna2 ?></td>
    <td width="38%">Nombre Colaborador</td>
    <td width="1%">&nbsp;</td>

    </tr>
<?php
	while ($row = mysqli_fetch_row($sql)) {
?>
  <tr>
    <td><?php echo ++$contador ?></td>
    <td>&nbsp;<?php echo " ".$row[1];?></td>
    <td>&nbsp;<?php echo " ".$row[2];?></td>
    <td>&nbsp;<?php echo " ".$row[3];?></td>
    <td><a href="<?php echo "definir_colaboradores.php?centinela=0&id=".$row["0"].'&tipo='.$_GET["tipo"].'&encabezado='.$row[2]; ?>"><img src="Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a></td>
  </tr>
<?php
	}
?>
</table>

<?php
}
?>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
<?php
if ($_GET["centinela"] == 0) {
	if ($_GET["tipo"] != 2) {
		$link = "definir_agencias.php?centinela=0";
	} else {
		$link = "definir_departamentos.php?centinela=0";	
	}
?>
  <td align="center"><a href="<?php echo $link ?>"><img src="Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"></br>Cerrar</a></td>
<?php
} else {
?>
<td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></br>Regresar</a></td>
<?php
}
?>
</tr>
</div>

</body>
</html>