<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
?>
<html>
<head>
<meta charset="iso-8859-1" http-equiv="Content-Type" content="text/html"/>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
</head>

<script language="javascript">
function empezar() {
	document.cambio_contrasenia.actual.focus();
}

function verificar() {
	if (document.cambio_contrasenia.nueva.value != document.cambio_contrasenia.confirmar.value) {
	alert("la nueva contraseña no coincide... Vuelva a intentar");
	document.cambio_contrasenia.nueva.select();	
	} else {
		document.cambio_contrasenia.submit();	
	}
}
</script>

<body class="Pagina" onLoad="empezar()">
<div id="menuprincipal">
<form action="cambiar_contrasenia.php?centinela=1" method="post" name="cambio_contrasenia" id="cambio_contrasenia">
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano24">
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td width="20%"><img src="Imagenes/Cambiar contrasena.png" width="64" height="64" alt="Definir Cajero General"></td>
    <th width="80%" align="center">CAMBIAR CONTRASE&Ntilde;A</th>
    </tr>
  <tr>
    <td colspan="2"><hr>
    </td>
    </tr>
</table>

<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="MenuCaja">
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
<?php
	if ($_GET["centinela"] == '0') {
?>

  <tr >
    <td align="right" width="50">Contrase&ntilde;a actual:</td>
    <td>
      <input type="password" name="actual" id="actual">
    </td>
  </tr>
  <tr >
    <td align="right">Nueva contrase&ntilde;a:</td>
    <td><input type="password" name="nueva" id="nueva"></td>
  </tr>
  <tr >
    <td align="right">Confirmar contrase&ntilde;a:</td>
    <td><input type="password" name="confirmar" id="confirmar"></td>
  </tr>
  <tr >
    <td >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td align="center" colspan="2"><input type="button" name="Grabar" id="Grabar" value="Grabar..." onClick="verificar()"></td>
    </tr>
<?php 
	} //End if centinela
?>
<?php
	if ($_GET["centinela"] == '1') {
		$nuevo_password = $_POST["nueva"];
		$id_user = $_SESSION["iduser"];
		$texto = '';
		if (md5($_POST["actual"]) != $_SESSION["password"]) {
			$texto = "Error en la contraseña Actual, favor de intentar nuevamente...";
		} else {
		$sql = "UPDATE ".$bbdd_general.".usuarios SET password = md5('$nuevo_password') WHERE id_user = $id_user";
		$result = mysqli_query($db, $sql) or die(mysqli_error());
		$texto = "Contrase&ntilde;a cambiada con éxito... T&oacute;melo en cuenta al pr&oacute;ximo inicio de sesión...";		
		}
?>
  <tr >
    <td colspan="2"><?php echo $texto;?></td>
  </tr>
  <tr >
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr >
    <td colspan="2" align="center"><a href="cambiar_contrasenia.php?centinela=0">Regresar...</a></td>
  </tr>
<?php
	}
?>
  <tr >
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
</form>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="configuracion.php"><img src="Imagenes/cerrar.png" alt="Cerrar..." width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="configuracion.php">Cerrar</a></td>
</tr>
</table>
</div>

</div>
</body>
</html>