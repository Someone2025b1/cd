<?php
include("../Script/seguridad.php");
include("conex.php");
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
	margin: 0; /* es recomendable ajustar a cero el margen y el relleno del elemento body para lograr la compatibilidad con la configuraci�n predeterminada de los diversos navegadores */
	padding: 0;
	text-align: center; /* esto centra el contenedor en los navegadores IE 5*. El texto se ajusta posteriormente con el valor predeterminado de alineaci�n a la izquierda en el selector #container */
	color: #000000;
}
.thrColAbs #container {
	position: relative; /* la adici�n de position: relative le permite colocar las dos barras laterales en relaci�n con este contenedor */
	width: 820px;  /* el uso de 20px menos que un ancho completo de 800px da cabida a los bordes del navegador y evita la aparici�n de una barra de desplazamiento horizontal */
	background: #FFFFFF;
	margin: 0 auto; /* los m�rgenes autom�ticos (conjuntamente con un ancho) centran la p�gina */
	border: 1px solid #000000;
	text-align: left; /* esto anula text-align: center en el elemento body. */
} 

/* Sugerencias para barras laterales con posici�n absoluta:
1. Los elementos con posici�n absoluta (AP) deben recibir un valor superior y lateral, ya sea derecho o izquierdo. (De manera predeterminada, si no se asigna ning�n valor superior, el elemento AP comenzar� directamente despu�s del �ltimo elemento del orden de origen de la p�gina. Esto significa que, si las barras laterales son el primer elemento del #container en el orden de origen del documento, aparecer�n en la parte superior del #container aunque no se les asigne un valor superior. No obstante, si posteriormente se trasladan en el orden de origen por cualquier motivo, necesitar�n un valor superior para que aparezcan donde usted desea.
2. Los elementos con posici�n absoluta (AP) se extraen del flujo del documento. Esto significa que los elementos situados alrededor de ellos no saben que existen y no los tienen en cuenta al ocupar su espacio en la p�gina. En consecuencia, s�lo deber� utilizar un div AP como columna lateral si est� seguro de que el div #mainContent del centro siempre ser� el que incluya la mayor parte del contenido. Si alguna de las barras laterales incluyera m�s contenido, la barra lateral superar�a la parte inferior del div padre y no parecer�a que la barra lateral estuviera contenida.
3. Si se cumplen los requisitos anteriores, las barras laterales con posici�n absoluta pueden ser una forma sencilla de controlar el orden de origen del documento.
*/
.thrColAbs #sidebar1 {
	position: absolute;
	top: 0;
	left: 0;
	width: 150px; /* el ancho real de este div, en navegadores que cumplen los est�ndares, o el modo de est�ndares de Internet Explorer, incluir� el relleno y el borde adem�s del ancho */
	background: #EBEBEB; /* el color de fondo se mostrar� a lo largo de todo el contenido de la columna, pero no m�s all� */
	padding: 15px 10px 15px 20px; /* el relleno mantiene el contenido del div alejado de los bordes */
}
.thrColAbs #sidebar2 {
	position: absolute;
	top: 10px;
	right: 311px;
	width: 160px; /* el ancho real de este div, en navegadores que cumplen los est�ndares, o el modo de est�ndares de Internet Explorer, incluir� el relleno y el borde adem�s del ancho */
	background: #EBEBEB; /* el color de fondo se mostrar� a lo largo de todo el contenido de la columna, pero no m�s all� */
	padding: 15px 10px 15px 20px; /* el relleno mantiene el contenido del div alejado de los bordes */
}
.thrColAbs #mainContent { 
	margin: 0 200px; /* los m�rgenes derecho e izquierdo de este elemento div crean las dos columnas externas de los lados de la p�gina. Con independencia de la cantidad de contenido que incluyan los divs de las barras laterales, permanecer� el espacio de la columna. */
	padding: 0 10px; /* recuerde que el relleno es el espacio situado dentro del cuadro div y que el margen es el espacio situado fuera del cuadro div */
}
.fltrt { /* esta clase puede utilizarse para que un elemento flote en la parte derecha de la p�gina. El elemento flotante debe preceder al elemento junto al que debe aparecer en la p�gina. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* esta clase puede utilizarse para que un elemento flote en la parte izquierda de la p�gina. */
	float: left;
	margin-right: 8px;
}
.LetraBlanca {
	color: #FFF;
}
.Tama�o28 {
	font-size: 20px;
}
.Tama�o14 {
	font-size: 14px;
}
.Tama�o10 {
	font-size: 10px;
}
.Tama�o12 {
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
  <td width="218" bgcolor="#000066" ><div align="left"></div></td>
  <td align="center" valign="middle" bgcolor="#000066" id="logo"><p class="Estilo6"><span class="Tama&ntilde;o28 LetraBlanca"><b>INFORMACI&Oacute;N COLABORADORES</b></span></p></td>
  <td width="217" bgcolor="#000066" ><div align="right"></div></td>
  </tr>
<tr>
  <td colspan="3" bgcolor="#003366"></td>
</tr>
<tr bgcolor="#CCFF99" class="LetraBlanca Tama�o10" id="dateformat2">
  <td height="25" align="left" bgcolor="#006A00">&nbsp;
	<script language="JavaScript" type="text/javascript">
	 // document.write(TODAY);	
    </script>    </td>
  <td height="25" bgcolor="#006A00">&nbsp;</td>
  <td height="25" bgcolor="#006A00" align="right">
  <?php
	session_start();
//	$auxi=$_SESSION["cuenta"];
	$auxi=$_SESSION["iduser"];
	$sql1="SELECT * FROM coosajo_base_bbdd.usuarios WHERE id_user=$auxi";
	$result1=mysqli_query($db, $sql1);
	$row1=mysqli_fetch_array($result1);
//	echo $row1["nombre"];
  ?>
   </td>
</tr>
</table>

<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr>
    <td width="32%" align="center" valign="middle"><a href="informacion_base.php"><img src="../Imagenes/user.png" alt="Informaci&oacute;n General" width="128" height="128" border="0"></a></td>
    <td width="35%" align="center" valign="middle"><a href="imprimir.php"><img src="../Imagenes/Imprimir.png" alt="Imprimir..." width="128" height="128" border="0"></a></td>
    <td width="33%" align="center" valign="middle">&nbsp;</td>
    </tr>
  <tr>
    <td align="center" valign="middle"><a href="informacion_base.php">INFORMACI&Oacute;N BASICA</a></td>
    <td align="center" valign="middle"><a href="imprimir.php">IMPRIMIR</a></td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
<!-- end #container -->	
</div>
</body>
</html>
