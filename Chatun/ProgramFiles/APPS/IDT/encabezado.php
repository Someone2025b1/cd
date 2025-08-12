<?php
include("../../../Script/seguridad.php");
include("../../../Script/conex.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
</head>

<script language="javascript" src="../../../Script/fecha.js">
</script>
<script language="JavaScript" type="text/javascript">
function cerrar(){
	if (confirm("Esta seguro de salir de la aplicacion")){
	window.close();
	}
}
</script>

<body class="Pagina">
<div id="encabezado">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="Encabezado" class="LetraBlanca Tamano10">
  <tr>
    <td width="25%"><a href="/portal/ProgramFiles/portal_principal.php" target="_top"><img src="../../../Imagenes/Coosajo es mi Coope.png" width="250" height="50" border="0"></a></td>
    <td width="50%" align="center" class="Tamano20"><b>PORTAL COOSAJO - M&Oacute;DULO IDT</b></td>
    <td width="25%" align="right"><a href="/portal/Script/salida.php" target="_top"><img src="../../../Imagenes/Salida.png" width="143" height="50" border="0"></a></td>
  </tr>
  <tr bgcolor="#007336">
    <td align="left">
    <script language="JavaScript" type="text/javascript">
		document.write(TODAY);	
    </script>  
    </td>
    <td>&nbsp;</td>
    <td align="right">
	<?php
		echo $_SESSION["nombre_user"];
	?>
    </td>
  </tr>
</table>
</div>
</body>
</html>
