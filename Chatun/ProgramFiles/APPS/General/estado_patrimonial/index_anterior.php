<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Gestión de Colaboradores - Departamento IDT - Coosajo R.L.</title>
<script language="JavaScript" type="text/JavaScript">
function toForm() {
	document.form1.user.focus();
}
</script>
<style type="text/css">
<!--
body {
	background-image: url(Imagenes/Fondo_rojo.jpg);
	background-repeat: repeat-x;
}
.LetraBlanca {
	color: #FFF;
}
-->
</style></head>
<body onload="toForm()">
<table width="428" height="256" border="0" align="center" background="Imagenes/inicio_sesion.gif">
<form id="form1" name="form1" method="post" action="Script/control.php">
        <tr>
          <td height="57" colspan="2">&nbsp;</td>
          <td colspan="2" align="right" class="LetraBlanca"><b>COLABORADORES 1.0</b></td>
        </tr>
        <tr>
          <td height="28" colspan="4" align="center">           
			<?php 
			if ($_GET["errorusuario"]=="si"){?>
			<span class="style1" style="color:#FFFFFF"><b>Datos incorrectos</b></span> 
            <span class="style1">
            <?php } else{?>
            <font face="Verdana, Arial, Helvetica, sans-serif" size="3" color="#FFFFFF"><b>Ingreso 
          al sistema</b></font>            
            <?php }?>
          </span></td>
        </tr>
      <tr>
          <td width="26" height="28">&nbsp;</td>
          <td width="107" class="LetraBlanca"><span class="style1">Usuario:</span></td>
          <td width="249"><label>
            <input name="user" type="text" id="user" size="23" maxlength="25" />
        </label>          </td>
          <td width="28">&nbsp;</td>
    </tr>
        <tr>
          <td height="28">&nbsp;</td>
          <td height="28" class="LetraBlanca"><span class="style4"><span class="style5"><span class="style7"><span class="style1">Password:</span></span></span></span></td>
          <td><label>
            <input name="clave" type="password" id="clave" size="25" maxlength="25" />
          </label></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td><label>
            <input type="submit" name="Ingresar" id="Ingresar" value="Ingresar" />
<div align="right"></div>
          </label></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="24" colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="36" colspan="2"><a href="ProgramFiles/buscador.php"><img src="Imagenes/logo_pequeno.png" width="120" height="31" border="0" /></a></td>
          <td></td><td></td>
        </tr>
</form>
      </table>
</body>
</html>