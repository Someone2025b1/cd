<?php
include("../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../Script/comas.php");
$auxi=$_GET[cif];
$periodo=$_GET[periodo];

$sql_periodo = "SELECT * FROM Estado_Patrimonial.periodo WHERE id=$periodo ";
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
	document.form_bienes_inmuebles.tipo_inmueble.focus();
}
function operar() {
	if (document.form_bienes_inmuebles.tipo_inmueble.value == "0") {
		alert("Deje ingresar un tipo de Inmueble...");
		return false;
	}
	if (document.form_bienes_inmuebles.localizacion.value != ""){
			if (form_bienes_inmuebles.valor_mercado.value > 0){
					if (document.form_bienes_inmuebles.departamento.value != ""){
					form_bienes_inmuebles.submit()
						}else{
						alert("Escriba el departamento")
					}
					}else{
					alert("El valor de Mercado debe contener valor numerico")
			}
			
	}else{
	alert("Escriba la localizacion del inmueble")
}
}
function operar1() {
	if (document.form_bienes_inmuebles_editar.tipo_inmueble.value == "0") {
		alert("Deje ingresar un tipo de Inmueble...");
		return false;
	}
	if (document.form_bienes_inmuebles_editar.localizacion.value != ""){
		if (document.form_bienes_inmuebles_editar.finca.value > 0 && form_bienes_inmuebles_editar.folio.value > 0 && form_bienes_inmuebles_editar.libro.value > 0){
			if (form_bienes_inmuebles_editar.valor_mercado.value > 0){
					if (document.form_bienes_inmuebles_editar.departamento.value != ""){
					form_bienes_inmuebles_editar.submit()
						}else{
						alert("Escriba el departamento")
					}
					}else{
					alert("El valor de Mercado debe contener valor numerico")
			}
			}else{
			alert("verifique que en Finca, Folio y Libro ercribio valores numericos")
			}
	}else{
	alert("Escriba la localizacion del inmueble")
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
	  document.write(TODAY);	
    </script>    </td>
  <td height="25" bgcolor="#006A00">&nbsp;</td>
  <td height="25" bgcolor="#006A00" align="right">&nbsp;</td>
</tr>
</table>

  <?php
	if ($_GET["accion"] == 1) {
		$auxi=$_SESSION["iduser"];
		$tipo_inmueble = $_POST["tipo_inmueble"];
		$localizacion = $_POST["localizacion"];
		$finca = $_POST["finca"];
		$folio = $_POST["folio"];
		$libro = $_POST["libro"];
		$departamento = $_POST["departamento"];
		$valor_mercado_ingresado = $_POST["valor_mercado"];
		$valor_mercado = str_replace(",","",$valor_mercado_ingresado);
		$insertar = "INSERT INTO Estado_Patrimonial.detalle_bienes_inmuebles (id_tipo_inmueble, colaborador, localizacion, finca, folio, libro, departamento, valor_mercado) VALUES ('$tipo_inmueble', '$auxi', '$localizacion', '$finca', '$folio', '$libro', '$departamento', '$valor_mercado')";
	mysqli_query($db, $insertar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 4) {
		$id = $_GET["id"];
		$eliminar = "DELETE FROM Estado_Patrimonial.detalle_bienes_inmuebles WHERE id = '$id'";
		mysqli_query($db, $eliminar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 3) {
		$id = $_GET["id"];
		$tipo_inmueble = $_POST["tipo_inmueble"];
		$localizacion = $_POST["localizacion"];
		$finca = $_POST["finca"];
		$folio = $_POST["folio"];
		$libro = $_POST["libro"];
		$departamento = $_POST["departamento"];
		$valor_mercado_ingresado = $_POST["valor_mercado"];
		$valor_mercado = str_replace(",","",$valor_mercado_ingresado);
		$actualizar = "UPDATE Estado_Patrimonial.detalle_bienes_inmuebles SET id_tipo_inmueble = '$tipo_inmueble', colaborador = '$auxi', localizacion = '$localizacion', finca = '$finca', libro = '$libro', departamento = '$departamento', valor_mercado = '$valor_mercado' WHERE id = '$id'";
		mysqli_query($db, $actualizar) or die (mysqli_error());
	}
	if ($_GET["accion"] != 2) {
?>
  <?php
	} else {
		$id = $_GET["id"];
		$auxi=$_SESSION["iduser"];
		$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_bienes_inmuebles WHERE colaborador = '$auxi' and id = '$id'";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($editar=mysqli_fetch_array($query_historial)) 	{ 	
?>
<table width="600" border="0" align="center" id="tabla_bienes_inmuebles" class="Tama�o12">
</table>
<?php
	}
	}
?>
<table width="500" border="1" align="center" class="Tama�o12" id="tabla_historial">
<tr> 
	<td width="42%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Localizacion</b></td>
	<td width="39%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Departamento</b></td>
	<td width="12%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Precio</b></td>
	<td width="7%" bgcolor="#000000" class="LetraBlanca" align="center">&nbsp;</td>
  </tr>
  <?php
  $auxi=$_SESSION["iduser"];
	$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_bienes_inmuebles WHERE colaborador = '$auxi'";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($historial=mysqli_fetch_array($query_historial)) 	{ 
?>
<tr> 
<td><? echo $historial ["localizacion"] ?></font></td>
<td><? echo $historial["departamento"] ?></font></td>
<td><? echo poner_comas($historial["valor_mercado"]) ?></font></td>
<td>&nbsp;</td>
<?php 
	}	//end while
?>
</tr>
</table>

<table width="81" border="0" align="center">
  <tr>
    <td width="75" height="62" align="center"><a href="estado_patrimonial_vista.php?cif=<?php echo $auxi ?>&periodo=<?php echo $periodo ?>&centinela=1"><img src="../Imagenes/Regresar02.png" alt="Regresar..." width="85" height="60" border="0"></a></td>
  </tr>
  <tr>
    <td height="25" align="center"><a href="estado_patrimonial_vista.php?cif=<?php echo $auxi ?>&periodo=<?php echo $periodo ?>&centinela=1">REGRESAR</a></td>
  </tr>
</table>
<!-- end #container -->	
</div>
</body>
</html>
