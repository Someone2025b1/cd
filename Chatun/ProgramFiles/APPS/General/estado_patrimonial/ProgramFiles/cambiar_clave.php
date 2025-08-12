<?php
include("../Script/seguridad.php");
include("../Script/conex.php");
?>
<script language="JavaScript" type="text/javascript">
//--------------- LOCALIZEABLE GLOBALS ---------------
var d=new Date();
var monthname=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octuber","Noviembre","Diciembre");
//Ensure correct for language. English is "January 1, 2004"
var TODAY =  d.getDate() + " de " + monthname[d.getMonth()] + " del " + d.getFullYear();
//---------------   END LOCALIZEABLE   ---------------
function cerrar(){
if (confirm("Esta seguro de salir de la aplicacion")){
window.close();
}
}
</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingreso de Informaci&oacute;n de Colaboradores</title>
<style type="text/css"> 
<!-- 
body  {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #666666;
	margin: 0; /* es recomendable ajustar a cero el margen y el relleno del elemento body para lograr la compatibilidad con la configuración predeterminada de los diversos navegadores */
	padding: 0;
	text-align: center; /* esto centra el contenedor en los navegadores IE 5*. El texto se ajusta posteriormente con el valor predeterminado de alineación a la izquierda en el selector #container */
	color: #000000;
}
.thrColAbs #container {
	position: relative; /* la adición de position: relative le permite colocar las dos barras laterales en relación con este contenedor */
	width: 820px;  /* el uso de 20px menos que un ancho completo de 800px da cabida a los bordes del navegador y evita la aparición de una barra de desplazamiento horizontal */
	background: #FFFFFF;
	margin: 0 auto; /* los márgenes automáticos (conjuntamente con un ancho) centran la página */
	border: 1px solid #000000;
	text-align: left; /* esto anula text-align: center en el elemento body. */
} 

/* Sugerencias para barras laterales con posición absoluta:
1. Los elementos con posición absoluta (AP) deben recibir un valor superior y lateral, ya sea derecho o izquierdo. (De manera predeterminada, si no se asigna ningún valor superior, el elemento AP comenzará directamente después del último elemento del orden de origen de la página. Esto significa que, si las barras laterales son el primer elemento del #container en el orden de origen del documento, aparecerán en la parte superior del #container aunque no se les asigne un valor superior. No obstante, si posteriormente se trasladan en el orden de origen por cualquier motivo, necesitarán un valor superior para que aparezcan donde usted desea.
2. Los elementos con posición absoluta (AP) se extraen del flujo del documento. Esto significa que los elementos situados alrededor de ellos no saben que existen y no los tienen en cuenta al ocupar su espacio en la página. En consecuencia, sólo deberá utilizar un div AP como columna lateral si está seguro de que el div #mainContent del centro siempre será el que incluya la mayor parte del contenido. Si alguna de las barras laterales incluyera más contenido, la barra lateral superaría la parte inferior del div padre y no parecería que la barra lateral estuviera contenida.
3. Si se cumplen los requisitos anteriores, las barras laterales con posición absoluta pueden ser una forma sencilla de controlar el orden de origen del documento.
*/
.thrColAbs #sidebar1 {
	position: absolute;
	top: 0;
	left: 0;
	width: 150px; /* el ancho real de este div, en navegadores que cumplen los estándares, o el modo de estándares de Internet Explorer, incluirá el relleno y el borde además del ancho */
	background: #EBEBEB; /* el color de fondo se mostrará a lo largo de todo el contenido de la columna, pero no más allá */
	padding: 15px 10px 15px 20px; /* el relleno mantiene el contenido del div alejado de los bordes */
}
.thrColAbs #sidebar2 {
	position: absolute;
	top: 10px;
	right: 311px;
	width: 160px; /* el ancho real de este div, en navegadores que cumplen los estándares, o el modo de estándares de Internet Explorer, incluirá el relleno y el borde además del ancho */
	background: #EBEBEB; /* el color de fondo se mostrará a lo largo de todo el contenido de la columna, pero no más allá */
	padding: 15px 10px 15px 20px; /* el relleno mantiene el contenido del div alejado de los bordes */
}
.thrColAbs #mainContent { 
	margin: 0 200px; /* los márgenes derecho e izquierdo de este elemento div crean las dos columnas externas de los lados de la página. Con independencia de la cantidad de contenido que incluyan los divs de las barras laterales, permanecerá el espacio de la columna. */
	padding: 0 10px; /* recuerde que el relleno es el espacio situado dentro del cuadro div y que el margen es el espacio situado fuera del cuadro div */
}
.fltrt { /* esta clase puede utilizarse para que un elemento flote en la parte derecha de la página. El elemento flotante debe preceder al elemento junto al que debe aparecer en la página. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* esta clase puede utilizarse para que un elemento flote en la parte izquierda de la página. */
	float: left;
	margin-right: 8px;
}
.LetraBlanca {
	color: #FFF;
}
.Tamaño28 {
	font-size: 20px;
}
.Tamaño14 {
	font-size: 14px;
}
.Tamaño10 {
	font-size: 10px;
}
.Tamaño12 {
	font-size: 12px;
}

--> 
</style><!--[if IE 5]>
<style type="text/css"> 
/* coloque las reparaciones del modelo de cuadro para IE 5* en este comentario condicional */
.thrColAbs #sidebar1 { width: 180px; }
.thrColAbs #sidebar2 { width: 190px; }
</style>
<![endif]--></head>
<body class="thrColAbs">
<div id="container">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="218" bgcolor="#000066" ><div align="left"><img src="../Imagenes/logo.png" width="215" height="56"></div></td>
  <td align="center" valign="middle" bgcolor="#000066" id="logo"><p class="Estilo6"><span class="Tama&ntilde;o28 LetraBlanca"><b>INFORMACI&Oacute;N COLABORADORES</b></span></p></td>
  <td width="217" bgcolor="#000066" ><div align="right"><a href="salir.php"><img src="../Imagenes/Salida.png" width="203" height="71" border="0" /></a></div></td>
  </tr>
<tr>
  <td colspan="3" bgcolor="#003366"></td>
</tr>
<tr bgcolor="#CCFF99" class="LetraBlanca Tamaño10" id="dateformat2">
  <td height="25" align="left" bgcolor="#006A00">&nbsp;
	<script language="JavaScript" type="text/javascript">
	  document.write(TODAY);	
    </script>    </td>
  <td height="25" bgcolor="#006A00">&nbsp;</td>
  <td height="25" bgcolor="#006A00" align="right">
  <?php
	session_start();
	$auxi=$_SESSION["cuenta"];
	$sql1="SELECT * FROM coosajo_base_bbdd.usuarios WHERE id_user=$auxi";
	$result1=mysqli_query($db, $sql1);
	$row1=mysqli_fetch_array($result1);
	echo $row1["nombre"];
  ?>
   </td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:14px">
  <tr>
    <td width="100%" align="left"><hr /></td>
  </tr>
</table>
<?php
	if ($_POST["centinela"] != 1) {
?>
<form action="cambiar_clave.php" method="post" name="cambiar_clave" id="cambiar_clave">
  <table width="347" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th colspan="2" bgcolor="#019732" class="Estilo1" scope="col">CAMBIO DE CLAVE</th>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <hr>
    </div></td>
    </tr>
  <tr>
    <td width="160" align="center" valign="middle"><div align="center">Nueva Clave:</div></td>
    <td width="187" align="center" valign="middle">      <label>
      <div align="center">
        <input type="password" name="clave" id="clave" />
      </div>
      </label></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><div align="center">Confirmar Clave:
    </div></td>
    <td align="center" valign="middle"><label>
      <div align="center">
        <input type="password" name="confirmar" id="confirmar" />
        </div>
    </label></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input name="Cambiar" type="submit" id="Cambiar" value="Cambiar" />
      <input name="centinela" type="hidden" id="centinela" value="1" />
    </div></td>
  </tr>
</table>
</form>

<?php 
	} else {
		$clave=$_POST["clave"];
		$confir=$_POST["confirmar"];
		$usuario =  $_SESSION["cuenta"];
		if ($clave == $confir) {
			$sql_clave="UPDATE coosajo_base_bbdd.usuarios SET clave='$clave' WHERE id_user='$usuario'";
			$result_clave=mysqli_query($db, $sql_clave) or die (mysqli_error());; 
?>
<div align="center"> <p align="center">
    <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366"><i>
    <strong> <br>
    Su clave ha sido cambiada con &eacute;xito.... </strong><br>
    <br> <strong>
    La pr&oacute;xima vez que desee ingresar al sistema, debe hacerlo con la 
    nueva clave </strong></i></font></p></div>
<?php
		} else {
?>
		    Su clave NO HA SIDO CAMBIADA, por no ser igual... 
			porfavor intente nuevamente... 
<?
	}
	}
?>
<hr />
<table width="81" border="0" align="center">
  <tr>
    <td width="75" height="62" align="center"><a href="menu.php"><img src="../Imagenes/Regresar02.png" alt="Regresar..." width="85" height="60" border="0"></a></td>
  </tr>
  <tr>
    <td height="25" align="center"><a href="menu.php">REGRESAR</a></td>
  </tr>
</table>
<!-- end .container --></div>
</body>
</html>