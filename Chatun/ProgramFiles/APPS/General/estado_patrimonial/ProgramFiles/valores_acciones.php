<?php
include("../Script/seguridad.php");
include("../Script/conex.php");
include("../Script/comas.php");
$auxi=$_SESSION["iduser"];

$sql_periodo = "SELECT * FROM Estado_Patrimonial.periodo order by id desc limit 1 ";
$result_periodo = mysqli_query($db, $sql_periodo) or die("".mysqli_error());
$row_periodo=mysqli_fetch_array($result_periodo); 
echo $mes_periodo=$row_periodo[1];
echo $anio_periodo=$row_periodo[2];
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
	document.form_bienes_inmuebles.clase_titulo.focus();
}
function operar() {
	if (document.form_bienes_inmuebles.clase_titulo.value != ""){
		if (document.form_bienes_inmuebles.institucion.value != ""){
			if (form_bienes_inmuebles.monto.value > 0){
					if (document.form_bienes_inmuebles.valor_comercial.value > 0){
					form_bienes_inmuebles.submit()
						}else{
						alert("El valor comercial debe contener valores numericos")
					}
					}else{
					alert("El Monto invertido debe contener valores numericos")
			}
			}else{
			alert("Esrciba la Institucion o Empresa")
			}
	}else{
	alert("Escriba la Clase de titulo")
}
}
function operar1() {
	if (document.form_bienes_inmuebles_editar.clase_titulo.value != ""){
		if (document.form_bienes_inmuebles_editar.institucion.value != ""){
			if (form_bienes_inmuebles_editar.monto.value > 0){
					if (document.form_bienes_inmuebles_editar.valor_comercial.value > 0){
					form_bienes_inmuebles_editar.submit()
						}else{
						alert("El valor comercial debe contener valores numericos")
					}
					}else{
					alert("El Monto invertido debe contener valores numericos")
			}
			}else{
			alert("Esrciba la Institucion o Empresa")
			}
	}else{
	alert("Escriba la Clase de titulo")
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
<tr bgcolor="#CCFF99" class="LetraBlanca Tamaño10" id="dateformat2">
  <td height="25" align="left" bgcolor="#006A00">&nbsp;
	<script language="JavaScript" type="text/javascript">
	  document.write(TODAY);	
    </script>    </td>
  <td height="25" bgcolor="#006A00">&nbsp;</td>
  <td height="25" bgcolor="#006A00" align="right">&nbsp;</td>
</tr>
</table>

  <?php
	if ($_GET["accion"] == 1) {
		$clase_titulo = $_POST["clase_titulo"];
		$institucion = $_POST["institucion"];
		$monto_1 = $_POST["monto"];
		$valor_comercial_1 = $_POST["valor_comercial"];
		$monto = str_replace(",","",$monto_1);
		$valor_comercial = str_replace(",","",$valor_comercial_1);
		$insertar = "INSERT INTO Estado_Patrimonial.detalle_valor_acciones (colaborador, clase_titulo, institucion, monto, valor_comercial, mes, anio) VALUES ('$auxi', '$clase_titulo', '$institucion', '$monto', '$valor_comercial', $mes_periodo, $anio_periodo)";
		mysqli_query($db, $insertar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 4) {
		$id = $_GET["id"];
		$eliminar = "DELETE FROM Estado_Patrimonial.detalle_valor_acciones WHERE id = '$id' and mes=$mes_periodo and anio=$anio_periodo ";
		mysqli_query($db, $eliminar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 3) {
		$id = $_GET["id"];
		$clase_titulo = $_POST["clase_titulo"];
		$institucion = $_POST["institucion"];
		$monto_1 = $_POST["monto"];
		$valor_comercial_1 = $_POST["valor_comercial"];
		$monto = str_replace(",","",$monto_1);
		$valor_comercial = str_replace(",","",$valor_comercial_1);
		$actualizar = "UPDATE Estado_Patrimonial.detalle_valor_acciones SET colaborador = '$auxi', clase_titulo = '$clase_titulo', institucion = '$institucion', monto = '$monto', valor_comercial = '$valor_comercial' WHERE id = '$id' and mes=$mes_periodo and anio=$anio_periodo ";
		mysqli_query($db, $actualizar) or die (mysqli_error());
	}
	if ($_GET["accion"] != 2) {
?>
<table width="600" border="0" align="center" id="tabla_bienes_inmuebles" class="Tamaño12">
<form action="valores_acciones.php?accion=1" method="post" name="form_bienes_inmuebles" id="form_bienes_inmuebles">
  <tr>
    <td colspan="2" align="center"><b>DETALLE DE VALORES Y ACCIONES</b>
      <label for="clase_titulo"></label></td>
    </tr>
  <tr>
    <td width="222">Clase de T&iacute;tulo:</td>
    <td><label for="clase_titulo"></label>
      <input type="text" name="clase_titulo" id="clase_titulo"></td>
    </tr>
  <tr>
    <td>Instituci&oacute;n o Empresa:</td>
    <td><input type="text" name="institucion" id="institucion"></td>
  </tr>
  <tr>
    <td>Monto Invertido:</td>
    <td><input type="text" name="monto" id="monto"></td>
  </tr>
  <tr>
    <td>Valor Comercial:</td>
    <td><input type="text" name="valor_comercial" id="valor_comercial"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input type="button" name="Actualizar" id="Actualizar" value="Actualizar..." onClick="operar()">
      <input name="grabar" type="hidden" id="grabar" value="1">
      </td>
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
		$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_valor_acciones WHERE colaborador = '$auxi' and id = '$id' and mes=$mes_periodo and anio=$anio_periodo ";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($editar=mysqli_fetch_array($query_historial)) 	{ 	
?>
<table width="600" border="0" align="center" id="tabla_bienes_inmuebles" class="Tamaño12">
<form action="valores_acciones.php?accion=3&id=<?php echo $editar['id'] ?>" method="post" name="form_bienes_inmuebles_editar" id="form_bienes_inmuebles_editar">
  <tr>
    <td colspan="2" align="center"><b>DETALLE DE VALORES Y ACCIONES</b></td>
    </tr>
  <tr>
    <td width="222">Clase de T&iacute;tulo:</td>
    <td><label for="clase_titulo"></label>
      <input name="clase_titulo" type="text" id="clase_titulo" value="<?php echo $editar["clase_titulo"] ?>"></td>
    </tr>
  <tr>
    <td>Instituci&oacute;n o Empresa:</td>
    <td><input name="institucion" type="text" id="institucion" value="<?php echo $editar["institucion"] ?>"></td>
  </tr>
  <tr>
    <td>Monto Invertido:</td>
    <td><input name="monto" type="text" id="monto" value="<?php echo $editar["monto"] ?>"></td>
  </tr>
  <tr>
    <td>Valor Comercial:</td>
    <td><input name="valor_comercial" type="text" id="valor_comercial" value="<?php echo $editar["valor_comercial"] ?>"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input type="button" name="Actualizar" id="Actualizar" value="Actualizar..." onClick="operar1()">
      <input name="grabar" type="hidden" id="grabar" value="3">
      </td>
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
	}
	}
?>
<table width="500" border="1" align="center" class="Tamaño12" id="tabla_historial">
<tr> 
	<td width="42%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Clase de T&iacute;tulos</b></td>
	<td width="39%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Instituci&oacute;n o Empresa</b></td>
	<td width="12%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Monto</b></td>
	<td width="7%" bgcolor="#000000" class="LetraBlanca" align="center">&nbsp;</td>
  </tr>
  <?php
	$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_valor_acciones WHERE colaborador = '$auxi' and mes=$mes_periodo and anio=$anio_periodo ";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($historial=mysqli_fetch_array($query_historial)) 	{ 
?>
<tr> 
<td><? echo $historial ["clase_titulo"] ?></font></td>
<td><? echo $historial["institucion"] ?></font></td>
<td><? echo poner_comas($historial["valor_comercial"]) ?></font></td>
<td><a href="valores_acciones.php?accion=2&id=<?php echo $historial['id']?>"><img src="../Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a><a href="valores_acciones.php?accion=4&id=<?php echo $historial['id']?>"><img src="../Imagenes/borrar.png" alt="Borrar..." width="16" height="16" border="0"></a></td>
<?php 
	}	//end while
?>
</tr>
</table>

<table width="81" border="0" align="center">
  <tr>
    <td width="75" height="62" align="center"><a href="estado_patrimonial.php"><img src="../Imagenes/Regresar02.png" alt="Regresar..." width="85" height="60" border="0"></a></td>
  </tr>
  <tr>
    <td height="25" align="center"><a href="estado_patrimonial.php">REGRESAR</a></td>
  </tr>
</table>
<!-- end #container -->	
</div>
</body>
</html>
