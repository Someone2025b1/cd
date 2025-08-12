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
	document.form_bienes_inmuebles.marca.focus();
}
function operar() {
	if (document.form_bienes_inmuebles.marca.value != ""){
		if (document.form_bienes_inmuebles.modelo.value != ""&& form_bienes_inmuebles.modelo.value > 0){
			if (form_bienes_inmuebles.color.value != ""){
					if (form_bienes_inmuebles.valor_vehiculo.value > 0){
					form_bienes_inmuebles.submit()
						}else{
						alert("El valor del Vehiculo debe contener valor numerico")
					}
					}else{
					alert("El color del Vehiculo no puede estar vacio")
			}
			}else{
			alert("Escriba la Modelo del Vehiculo o no es numero")
			}
	}else{
	alert("Escriba la Marca del Vehiculo")
}
}
function operar1() {
if (document.form_bienes_inmuebles_editar.marca.value != ""){
		if (document.form_bienes_inmuebles_editar.modelo.value != ""&& form_bienes_inmuebles_editar.modelo.value > 0){
			if (form_bienes_inmuebles_editar.valor_vehiculo.value > 0){
				  if (form_bienes_inmuebles_editar.color.value != ""){
					form_bienes_inmuebles_editar.submit()
					}else{
					alert("El color del vehiculo esta vacio")
			}
					}else{
					alert("El valor del Vehiculo debe contener valor numerico")
			}
			}else{
			alert("Escriba la Modelo del Vehiculo o no es numero")
			}
	}else{
	alert("Escriba la Marca del Vehiculo")
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
</style>
<script src="../Script/jquery-1.4.2.js" type="text/javascript"> </script>
<script src="../Script/jquery.maskedinput-1.2.2.js" type="text/javascript"> </script>
<script type="text/javascript">
	jQuery(function($){
		$("#modelo").mask("9999");
	});
</script>

<!--[if IE 5]>
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
		$marca = $_POST["marca"];
		$modelo = $_POST["modelo"];
		$color = $_POST["color"];
		$valor_vehiculo_ingresado = $_POST["valor_vehiculo"];
		$valor_vehiculo = str_replace(",","",$valor_vehiculo_ingresado);
		$insertar = "INSERT INTO Estado_Patrimonial.detalle_vehiculos (colaborador, marca, modelo, color, valor_vehiculo, mes, anio) VALUES ('$auxi', '$marca', '$modelo', '$color', '$valor_vehiculo', $mes_periodo, $anio_periodo)";
	mysqli_query($db, $insertar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 4) {
		$id = $_GET["id"];

		$eliminar = "DELETE FROM Estado_Patrimonial.detalle_vehiculos WHERE id = '$id' and mes=$mes_periodo and anio=$anio_periodo ";
		mysqli_query($db, $eliminar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 3) {
		$id = $_GET["id"];
		$marca = $_POST["marca"];
		$modelo = $_POST["modelo"];
		$color = $_POST["color"];
		$valor_vehiculo_ingresado = $_POST["valor_vehiculo"];
		$valor_vehiculo = str_replace(",","",$valor_vehiculo_ingresado);
		$actualizar = "UPDATE Estado_Patrimonial.detalle_vehiculos SET colaborador = '$auxi', marca = '$marca', modelo = '$modelo', color = '$color', valor_vehiculo = '$valor_vehiculo' WHERE id = '$id' and mes=$mes_periodo and anio=$anio_periodo ";
		mysqli_query($db, $actualizar) or die (mysqli_error());
	}
	if ($_GET["accion"] != 2) {
?>
<table width="600" border="0" align="center" id="tabla_bienes_inmuebles" class="Tamaño12">
<form action="vehiculos.php?accion=1" method="post" name="form_bienes_inmuebles" id="form_bienes_inmuebles">
  <tr>
    <td colspan="2" align="center"><b>DETALLE DE VEH&Iacute;CULOS</b>
      <label for="marca"></label></td>
    </tr>
  <tr>
    <td width="222">Marca:</td>
    <td><label for="marca"></label>
      <input type="text" name="marca" id="marca"></td>
    </tr>
  <tr>
    <td>Modelo: (anio Ej. 2001)</td>
    <td><input type="text" name="modelo" id="modelo"></td>
  </tr>
  <tr>
    <td>Color:</td>
    <td><input type="text" name="color" id="color"></td>
  </tr>
  <tr>
    <td>Valor:</td>
    <td><input type="text" name="valor_vehiculo" id="valor_vehiculo"></td>
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
		$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_vehiculos WHERE colaborador = '$auxi' and id = '$id' and mes=$mes_periodo and anio=$anio_periodo ";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($editar=mysqli_fetch_array($query_historial)) 	{ 	
?>
<table width="600" border="0" align="center" id="tabla_bienes_inmuebles" class="Tamaño12">
<form action="vehiculos.php?accion=3&id=<?php echo $editar['id'] ?>" method="post" name="form_bienes_inmuebles_editar" id="form_bienes_inmuebles_editar">
  <tr>
    <td colspan="2" align="center"><b>DETALLE DE VEH&Iacute;CULOS</b></td>
    </tr>
  <tr>
    <td width="222">Marca:</td>
    <td><label for="marca"></label>
      <input name="marca" type="text" id="marca" value="<?php echo $editar["marca"] ?>"></td>
    </tr>
  <tr>
    <td>Modelo:(anio Ej. 2001)</td>
    <td><input name="modelo" type="text" id="modelo" value="<?php echo $editar["modelo"] ?>"></td>
  </tr>
  <tr>
    <td>Color:</td>
    <td><input name="color" type="text" id="color" value="<?php echo $editar["color"] ?>"></td>
  </tr>
  <tr>
    <td>Valor:</td>
    <td><input name="valor_vehiculo" type="text" id="valor_vehiculo" value="<?php echo $editar["valor_vehiculo"] ?>"></td>
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
	<td width="42%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Marca</b></td>
	<td width="39%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Modelo</b></td>
	<td width="12%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Precio</b></td>
	<td width="7%" bgcolor="#000000" class="LetraBlanca" align="center">&nbsp;</td>
  </tr>
  <?php
	$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_vehiculos WHERE colaborador = '$auxi' and mes=$mes_periodo and anio=$anio_periodo ";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($historial=mysqli_fetch_array($query_historial)) 	{ 
?>
<tr> 
<td><? echo $historial ["marca"] ?></font></td>
<td><? echo $historial["modelo"] ?></font></td>
<td><? echo poner_comas($historial["valor_vehiculo"]) ?></font></td>
<td><a href="vehiculos.php?accion=2&id=<?php echo $historial['id']?>"><img src="../Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a><a href="vehiculos.php?accion=4&id=<?php echo $historial['id']?>"><img src="../Imagenes/borrar.png" alt="Borrar..." width="16" height="16" border="0"></a></td>
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
