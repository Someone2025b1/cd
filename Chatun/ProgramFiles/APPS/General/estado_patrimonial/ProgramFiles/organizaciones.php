<?php
include("../Script/seguridad.php");
include("../Script/conex.php");
include("../Script/comas.php");
include("../Script/cambiofecha.php");
$auxi=$_SESSION["iduser"];
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
function empezar() {
	document.form_bienes_inmuebles.nombre_organizacion.focus();
}
function operar() {
	camposTexto = document.getElementById("form_bienes_inmuebles").elements; 
    for (x=0; x < camposTexto.length; x++) {
	  if (camposTexto[x].value == "" ){
      	alert("El campo " + camposTexto[x].id + " tiene un valor incorrecto");
      return false;
      }		
    }
	  document.form_bienes_inmuebles.submit();
}
function operar1() {
	camposTexto = document.getElementById("form_bienes_inmuebles_editar").elements; 
    for (x=0; x < camposTexto.length; x++) {
	  if (camposTexto[x].value == "" ){
      	alert("El campo " + camposTexto[x].id + " tiene un valor incorrecto");
      return false;
      }		
    }
	  document.form_bienes_inmuebles_editar.submit();
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
<![endif]-->
<script src="../Script/jquery-1.4.2.js" type="text/javascript"> </script>
<script src="../Script/jquery.maskedinput-1.2.2.js" type="text/javascript"> </script>
<script type="text/javascript">
	jQuery(function($){
		$("#fecha_ingreso").mask("99-99-9999");
	});
</script>
</head>
<body class="thrColAbs" onLoad="empezar()">
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
	//  document.write(TODAY);	
    </script>    </td>
  <td height="25" bgcolor="#006A00">&nbsp;</td>
  <td height="25" bgcolor="#006A00" align="right">
  
   </td>
</tr>
</table>

  <?php
	if ($_GET["accion"] == 1) {
		$tipo_organizacion = $_POST["tipo_organizacion"];
		$nombre_organizacion = $_POST["nombre_organizacion"];
		$fecha_ingreso = cambio_fecha_usa($_POST["fecha_ingreso"]);
		$cargo = $_POST["cargo"];
		$insertar = "INSERT INTO Estado_Patrimonial.detalle_organizaciones_civiles (colaborador, tipo_organizacion, nombre_organizacion, fecha_ingreso, cargo) VALUES ('$auxi', '$tipo_organizacion', '$nombre_organizacion', '$fecha_ingreso', '$cargo')";
	mysqli_query($db, $insertar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 4) {
		$id = $_GET["id"];
		$eliminar = "DELETE FROM Estado_Patrimonial.detalle_organizaciones_civiles WHERE id = '$id'";
		mysqli_query($db, $eliminar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 3) {
		$id = $_GET["id"];
		$tipo_organizacion = $_POST["tipo_organizacion"];
		$nombre_organizacion = $_POST["nombre_organizacion"];
		$fecha_ingreso = cambio_fecha_usa($_POST["fecha_ingreso"]);
		$cargo = $_POST["cargo"];
		$actualizar = "UPDATE Estado_Patrimonial.detalle_organizaciones_civiles SET colaborador = '$auxi', tipo_organizacion = '$tipo_organizacion', nombre_organizacion = '$nombre_organizacion', fecha_ingreso = '$fecha_ingreso', cargo = '$cargo' WHERE id = '$id'";
		mysqli_query($db, $actualizar) or die (mysqli_error());
	}
	if ($_GET["accion"] != 2) {
?>
<table width="600" border="0" align="center" id="tabla_bienes_inmuebles" class="Tama�o12">
<form action="organizaciones.php?accion=1" method="post" name="form_bienes_inmuebles" id="form_bienes_inmuebles">
  <tr>
    <td colspan="2" align="center"><b>DETALLE DE PARTICIPACION EN ORGANIZACIONES CIVILES</b>
      <label for="nombre"></label></td>
    </tr>
  <tr>
    <td width="222">Tipo de Organizaci&oacute;n:</td>
    <td><label for="nombre">
      <select name="tipo_organizacion" id="tipo_organizacion">
        <option>== ESCOGER OPCION ==</option>
        <option value="Consejos Comunitarios de Desarrollo (COCODE)">Consejos Comunitarios de Desarrollo (COCODE)</option>
        <option value="Consejos Municipales de Desarrollo (COMUDE)">Consejos Municipales de Desarrollo (COMUDE)</option>
        <option value="Consejos Departamentales de Desarrollo (CODEDE)">Consejos Departamentales de Desarrollo (CODEDE)</option>
        <option value="Cooperativas">Cooperativas</option>
        <option value="Asociones No Lucrativas">Asociones No Lucrativas</option>
        <option value="Organizaciones No Gubernamentales (ONG)">Organizaciones No Gubernamentales (ONG)</option>
        <option value="Comit&eacute;s">Comit&eacute;s</option>
        <option value="Patronato">Patronato</option>
        <option value="Congregaci&oacute;n">Congregaci&oacute;n</option>
        <option value="Mesa">Mesa</option>
        <option value="Instancia">Instancia</option>
        <option value="Junta">Junta</option>
        <option value="Grupo">Grupo</option>
        <option value="Fundaciones">Fundaciones</option>
        <option value="Comunidades y Pueblos Ind&iacute;genas">Comunidades y Pueblos Ind&iacute;genas</option>
        <option value="Sindicatos">Sindicatos</option>
      </select>
    </label></td>
    </tr>
  <tr>
    <td>Nombre de la Organizaci&oacute;n:</td>
    <td><input name="nombre_organizacion" type="text" id="nombre_organizacion" size="50"></td>
  </tr>
  <tr>
    <td align="left">Cargo:</td>
    <td align="left"><input name="cargo" type="text" id="cargo" size="35"></td>
    </tr>
  <tr>
    <td align="left">Fecha Ingreso: (dd-mm-aaaa)</td>
    <td align="left"><input type="text" name="fecha_ingreso" id="fecha_ingreso"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" name="Actualizar2" id="Actualizar2" value="Actualizar..." onClick="operar()">
      <input name="grabar2" type="hidden" id="grabar2" value="1"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</form>
</table>
<?php
	} else {
		$id = $_GET["id"];
		$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_organizaciones_civiles WHERE colaborador = '$auxi' and id = '$id'";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($editar=mysqli_fetch_array($query_historial)) 	{ 	
?>
<table width="600" border="0" align="center" id="tabla_bienes_inmuebles" class="Tama�o12">
<form action="organizaciones.php?accion=3&id=<?php echo $editar['id'] ?>" method="post" name="form_bienes_inmuebles_editar" id="form_bienes_inmuebles_editar">
  <tr>
    <td colspan="2" align="center"><b>DETALLE DE DATOS FAMILIARES (N&uacute;cleo Familiar)</b></td>
    </tr>
  <tr>
    <td width="222">Tipo de Organizaci&oacute;n:</td>
    <td><label for="nombre_organizacion">
      <select name="tipo_organizacion" id="tipo_organizacion">
        <option value="<?php echo $editar['tipo_organizacion'] ?>"><?php echo $editar['tipo_organizacion'] ?></option>
        <option>== ESCOGER OPCION ==</option>
        <option value="Consejos Comunitarios de Desarrollo (COCODE)">Consejos Comunitarios de Desarrollo (COCODE)</option>
        <option value="Consejos Municipales de Desarrollo (COMUDE)">Consejos Municipales de Desarrollo (COMUDE)</option>
        <option value="Consejos Departamentales de Desarrollo (CODEDE)">Consejos Departamentales de Desarrollo (CODEDE)</option>
        <option value="Cooperativas">Cooperativas</option>
        <option value="Asociones No Lucrativas">Asociones No Lucrativas</option>
        <option value="Organizaciones No Gubernamentales (ONG)">Organizaciones No Gubernamentales (ONG)</option>
        <option value="Comit&eacute;s">Comit&eacute;s</option>
        <option value="Patronato">Patronato</option>
        <option value="Congregaci&oacute;n">Congregaci&oacute;n</option>
        <option value="Mesa">Mesa</option>
        <option value="Instancia">Instancia</option>
        <option value="Junta">Junta</option>
        <option value="Grupo">Grupo</option>
        <option value="Fundaciones">Fundaciones</option>
        <option value="Comunidades y Pueblos Ind&iacute;genas">Comunidades y Pueblos Ind&iacute;genas</option>
        <option value="Sindicatos">Sindicatos</option>
      </select>
    </label></td>
    </tr>
  <tr>
    <td>Nombre de la Organizaci&oacute;n:</td>
    <td><input name="nombre_organizacion" type="text" id="nombre_organizacion" value="<?php echo $editar["nombre_organizacion"] ?>" size="50"></td>
    </tr>
  <tr>
    <td align="left">Cargo:</td>
    <td align="left"><input name="cargo" type="text" id="cargo" value="<?php echo $editar["cargo"] ?>" size="35"></td>
  </tr>
  <tr>
    <td>Fecha Ingreso: (aaaa-mm-dd)</td>
    <td><input name="fecha_ingreso" type="text" id="fecha_ingreso" value="<?php echo cambio_fecha_usa($editar["fecha_ingreso"]) ?>"></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="button" name="Actualizar" id="Actualizar" value="Actualizar..." onClick="operar1()">
      <input name="grabar" type="hidden" id="grabar" value="3"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
</form>
</table>
<?php
	}
	}
?>
<table width="500" border="1" align="center" class="Tama�o12" id="tabla_historial">
<tr> 
	<td width="71%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Organizacion</b></td>
	<td width="21%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Fecha Ingreso</b></td>
	<td width="8%" bgcolor="#000000" class="LetraBlanca" align="center">&nbsp;</td>
  </tr>
  <?php
	$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_organizaciones_civiles WHERE colaborador = '$auxi'";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($historial=mysqli_fetch_array($query_historial)) 	{ 
?>
<tr> 
<td><? echo $historial ["tipo_organizacion"] ?></font></td>
<td><? echo cambio_fecha_gua($historial["fecha_ingreso"]) ?></font></td>
<td><a href="organizaciones.php?accion=2&id=<?php echo $historial['id']?>"><img src="../Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a><a href="organizaciones.php?accion=4&id=<?php echo $historial['id']?>"><img src="../Imagenes/borrar.png" alt="Borrar..." width="16" height="16" border="0"></a></td>
<?php 
	}	//end while
?>
</tr>
</table>

<table width="81" border="0" align="center">
  <tr>
    <td width="75" height="62" align="center"><a href="informacion_base.php"><img src="../Imagenes/Regresar02.png" alt="Regresar..." width="85" height="60" border="0"></a></td>
  </tr>
  <tr>
    <td height="25" align="center"><a href="informacion_base.php">REGRESAR</a></td>
  </tr>
</table>
<!-- end #container -->	
</div>
</body>
</html>
