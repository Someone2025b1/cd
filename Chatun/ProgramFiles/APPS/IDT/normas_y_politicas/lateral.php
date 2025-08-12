<?php
include ("../../../../Script/conex.php");
?>
<head>
<meta charset="iso-8859-1" http-equiv="Content-Type" content="text/html"/>
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
</head>


<style type="text/css">
body {
	position:relative;
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #FFFFFF;
	margin: 0 auto;
	padding: 0;
}
</style>
<body class="Pagina">
<div id="menuprincipal">

<table width="80" border="0" cellpadding="0" cellspacing="0" id="menu_formasenblanco" class="Tamano10 Texto_Centrado" align="center">
<?php 
$tmp = mysqli_query($db, "SELECT * FROM normatividad.repositorio WHERE id_departamento = ".$_SESSION["id_departamento"]." AND tipo_documento != '7' ORDER BY nombre_documento ASC");
	if (mysqli_querynum_rows($tmp) > 0) { 
?>
  <tr >
    <th>MANUALES Y POL&Iacute;TICAS</th>
    </tr>
  <tr >
    <td>&nbsp;</td>
    </tr>	
<?php
	while ($archivos = mysqli_fetch_array($tmp)) {
?>
  <tr >
    <td><a href="<?php echo '../../Nac/normativas/repositorio/'.$archivos['nombre_archivo'] ?>" target="MenuPrincipal"><?php echo $archivos['nombre_documento'] ?></a></td>
    </tr>
  <tr >
    <td>&nbsp;</td>
  </tr>
<?php
	}
?>
  <tr >
    <td>&nbsp;</td>
    </tr>
<?php
	}
	$tmp1 = mysqli_query($db, "SELECT * FROM normatividad.repositorio WHERE id_departamento = ".$_SESSION["id_departamento"]." AND tipo_documento = '7' ORDER BY nombre_documento ASC");
	if (mysqli_querynum_rows($tmp1) > 0) {
?>
  <tr >
    <th>AUDIO MANUALES</th>
    </tr>
  <tr >
    <td>&nbsp;</td>
    </tr>	
<?php
	while ($archivos1 = mysqli_fetch_array($tmp1)) {
?>
  <tr >
    <td><a href="<?php echo '../../Nac/normativas/tutoriales/reproducir_tutorial.php?url='.$archivos1['nombre_archivo'].'&archivo='.$archivos1['nombre_documento'] ?>" target="MenuPrincipal"><?php echo $archivos1['nombre_documento'] ?></a></td>
    </tr>
  <tr >
    <td>&nbsp;</td>
  </tr>
<?php
	}
	}
?>
  <tr >
    <td>&nbsp;</td>
  </tr>	
  <tr >
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
  </tr>	
  <tr >
    <td>&nbsp;</td>
  </tr>	
  <tr >
    <td>&nbsp;</td>
    </tr>	
  <tr >
    <td><a href="blanco.php" target="MenuPrincipal"><img src="Imagenes/cerrar.png" alt="Cerrar documento" width="64" height="64" border="0"><br />Cerrar documento</a></td>
  </tr>
  <tr >
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td><a href="<?php echo '../principal.php?id_depto='.$_SESSION["id_departamento"] ?>" target="_top"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"><br />Regresar</a></td>
  </tr>
</table>
</div>
</body>
</html>