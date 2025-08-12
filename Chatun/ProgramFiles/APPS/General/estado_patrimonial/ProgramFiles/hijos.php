0<?php
include("../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../Script/comas.php");
include("../Script/cambiofecha.php");
$auxi=$_SESSION["iduser"];

function nombre_completo($nombre1, $nombre2, $nombre3, $apellido1, $apellido2, $apellido_casada) {
	if ($nombre3 != '') {
		$nombres = $nombre1.' '.$nombre2.' '.$nombre3;
	} elseif ($nombre2 != '') {
		$nombres = $nombre1.' '.$nombre2;
	} else {
		$nombres = $nombre1;
	}
	
	if ($apellido2 != '') {
		$apellidos = $apellido1.' '.$apellido2;
	} else {
	$apellidos = $apellido1;	
	}
	
	if ($apellido_casada != '') {
		$apellidos = $apellidos.' de '.$apellido_casada;
	}
	$resultado = $nombres.' '.$apellidos;
	return $resultado;
}
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
	document.form_bienes_inmuebles.cif.focus();
}

function validar_todo() {	
	if (document.getElementById("a_nombre1").value == "") {
		alert ("Debe llevar por lo menos el primer Nombre");	
		document.getElementById("a_nombre1").focus();
		return false;
	}
	if (document.getElementById("a_apellido1").value == "") {
		alert ("Debe llevar por lo menos el primer Apellido");
		document.getElementById("a_apellido1").focus();
		return false;
	}
	if (document.getElementById("a_sexo").value == 0) {
		alert ("Debe seleccionar por lo menos un tipo de Sexo");	
		document.getElementById("a_sexo").select();
		return false;
	}
	if (document.getElementById("a_dependiente").value == 0) {
		alert ("Debe seleccionar por lo menos una opción");
		document.getElementById("a_dependiente").focus();
		return false;
	}	
	if (document.getElementById("a_escolaridad").value == "") {
		alert ("Debe de especificar algún nivel de escolaridad");	
		document.getElementById("a_escolaridad").focus();
		return false;
	}
	if (document.getElementById("a_ocupacion").value == "") {
		alert ("Debe llevar por lo menos algún comentario");
		document.getElementById("a_ocupacion").focus();
		return false;
	}
	if (document.getElementById("a_fecha_nacimiento").value == "") {
		document.getElementById("a_fecha_nacimiento").focus();
		return false;
	}
	document.form_bienes_inmuebles.submit();
}

function validar_todo2() {	
	if (document.getElementById("e_nombre1").value == "") {
		alert ("Debe llevar por lo menos el primer Nombre");	
		document.getElementById("e_nombre1").focus();
		return false;
	}
	if (document.getElementById("e_apellido1").value == "") {
		alert ("Debe llevar por lo menos el primer Apellido");
		document.getElementById("e_apellido1").focus();
		return false;
	}
	if (document.getElementById("e_sexo").value == 0) {
		alert ("Debe seleccionar por lo menos un tipo de Sexo");	
		document.getElementById("e_sexo").select();
		return false;
	}
	if (document.getElementById("e_dependiente").value == 0) {
		alert ("Debe seleccionar por lo menos una opción");
		document.getElementById("e_dependiente").focus();
		return false;
	}	
	if (document.getElementById("e_escolaridad").value == "") {
		alert ("Debe de especificar algún nivel de escolaridad");	
		document.getElementById("e_escolaridad").focus();
		return false;
	}
	if (document.getElementById("e_ocupacion").value == "") {
		alert ("Debe llevar por lo menos algún comentario");
		document.getElementById("e_ocupacion").focus();
		return false;
	}
	if (document.getElementById("e_fecha_nacimiento").value == "") {
		document.getElementById("e_fecha_nacimiento").focus();
		return false;
	}
	document.form_bienes_inmuebles_editar.submit();
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
function Validar(Cadena){
	alert (Cadena);
    var Fecha= new String(Cadena)   // Crea un string   
    var RealFecha= new Date()   // Para sacar la fecha de hoy   
    // Cadena Año   
    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))   
    // Cadena Mes   
    var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))   
    // Cadena Día   
    var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")))   
  // Valido el año contra fecha actual   
    var year= RealFecha.getYear();
	// Valido el año   
    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1940 ){   
            alert('Año inválido');
			document.form_bienes_inmuebles.a_fecha_nacimiento.select();
        return false	   
    }   
    // Valido el Mes   
    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){   
        alert('Mes inválido') ;
		document.form_bienes_inmuebles.fecha_nacimiento.select();
        return false   
    }   
    // Valido el Dia   
    if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){   
        alert('Día inválido')  ;
		document.form_bienes_inmuebles.fecha_nacimiento.select();
        return false   
    }   
    if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {   
        if (Mes==2 && Dia > 28 || Dia>30) {   
            alert('Día inválido')   
		document.form_bienes_inmuebles.fecha_nacimiento.select();
            return false   
        }   
    
	}   
       
  //para que envie los datos, quitar las  2 lineas siguientes   
//  alert("Fecha correcta.")   
  return false     
}   
function Validar1(Cadena){   
    var Fecha= new String(Cadena)   // Crea un string   
    var RealFecha= new Date()   // Para sacar la fecha de hoy   
    // Cadena Año   
    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))   
    // Cadena Mes   
    var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))   
    // Cadena Día   
    var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")))   
  // Valido el año contra fecha actual   
    var year= RealFecha.getYear();
	// Valido el año   
    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1940 || parseFloat(Ano)>(year)){   
            alert('Año inválido');
			document.form_bienes_inmuebles_editar.fecha_nacimiento.select();
        return false	   
    }   
    // Valido el Mes   
    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){   
        alert('Mes inválido') ;
		document.form_bienes_inmuebles_editar.fecha_nacimiento.select();
        return false   
    }   
    // Valido el Dia   
    if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){   
        alert('Día inválido')  ;
		document.form_bienes_inmuebles_editar.fecha_nacimiento.select();
        return false   
    }   
    if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {   
        if (Mes==2 && Dia > 28 || Dia>30) {   
            alert('Día inválido')   
		document.form_bienes_inmuebles_editar.fecha_nacimiento.select();
            return false   
        }   
    
	}   
       
  //para que envie los datos, quitar las  2 lineas siguientes   
//  alert("Fecha correcta.")   
  return false     
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
.Tamaño8 {
	font-size: 8px;
	text-align:center;
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
		$("#fecha_nacimiento").mask("99-99-9999");
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
<tr bgcolor="#CCFF99" class="LetraBlanca Tamaño10" id="dateformat2">
  <td height="25" align="left" bgcolor="#006A00">&nbsp;
	<script language="JavaScript" type="text/javascript">
	 // document.write(TODAY);	
    </script>    </td>
  <td height="25" bgcolor="#006A00">&nbsp;</td>
  <td height="25" bgcolor="#006A00" align="right">&nbsp;</td>
</tr>
</table>

  <?php
	if ($_GET["accion"] == 1) {
		$cif_hijo = $_POST["cif"];
		$nombre1 = $_POST["nombre1"];
		$nombre2 = $_POST["nombre2"];
		$nombre3 = $_POST["nombre3"];
		$apellido1 = $_POST["apellido1"];
		$apellido2 = $_POST["apellido2"];
		$apellido_casada = $_POST["apellido_casada"];		
		$sexo = $_POST["sexo"];
		$fecha_nacimiento = cambio_fecha_usa($_POST["fecha_nacimiento"]);
		$dependiente = $_POST["dependiente"];
		$escolaridad = $_POST["escolaridad"];
		$ocupacion = $_POST["ocupacion"];
		$grado_consaguinidad = "Primer Grado Consaguinidad";
		$insertar = "INSERT INTO Estado_Patrimonial.detalle_hijos  VALUES (NULL, '$auxi', '$nombre1', '$nombre2', '$nombre3', '$apellido1', '$apellido2', '$apellido_casada', '$sexo', '$fecha_nacimiento', '$dependiente', '$escolaridad', '$ocupacion', '$grado_consaguinidad', '$cif_hijo')";
	mysqli_query($db, $insertar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 4) {
		$id = $_GET["id"];
		$eliminar = "DELETE FROM Estado_Patrimonial.detalle_hijos WHERE id = '$id'";
		mysqli_query($db, $eliminar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 3) {
		$id = $_GET["id"];
		$cif_hijo = $_POST["cif"];
		$nombre1 = $_POST["nombre1"];
		$nombre2 = $_POST["nombre2"];
		$nombre3 = $_POST["nombre3"];
		$apellido1 = $_POST["apellido1"];
		$apellido2 = $_POST["apellido2"];
		$apellido_casada = $_POST["apellido_casada"];
		$sexo = $_POST["sexo"];
		$fecha_nacimiento = cambio_fecha_usa($_POST["fecha_nacimiento"]);
		$dependiente = $_POST["dependiente"];
		$escolaridad = $_POST["escolaridad"];
		$ocupacion = $_POST["ocupacion"];
$grado_consaguinidad = "Primer Grado Consaguinidad";
		$actualizar = "UPDATE Estado_Patrimonial.detalle_hijos SET colaborador = '$auxi', primer_nombre = '$nombre1', segundo_nombre = '$nombre2', tercer_nombre = '$nombre3', primer_apellido = '$apellido1', segundo_apellido = '$apellido2', apellido_casada = '$apellido_casada', sexo = '$sexo', fecha_nacimiento = '$fecha_nacimiento', dependiente = '$dependiente', escolaridad = '$escolaridad', ocupacion = '$ocupacion', grado_consaguinidad = '$grado_consaguinidad', cif = '$cif_hijo' WHERE id = '$id'";
		mysqli_query($db, $actualizar) or die (mysqli_error());
	}
	if ($_GET["accion"] != 2) {
?>
<table width="800" border="0" align="center" id="tabla_bienes_inmuebles" class="Tamaño12">
<form action="hijos.php?accion=1" method="post" name="form_bienes_inmuebles" id="form_bienes_inmuebles">
  <tr>
    <td colspan="4" align="center"><b>DETALLE DE DATOS DE HIJOS</b>
      <label for="nombre1"></label></td>
    </tr>
  <tr>
    <td>Cif:</td>
    <td colspan="3"><input name="cif" type="text" id="a_cif" size="12"></td>
    </tr>
  <tr align="center">
    <td width="400" align="left">Nombres:</td>
    <td width="200"><label for="nombre1"></label>
      <input type="text" name="nombre1" id="a_nombre1"></td>
    <td width="200"><input type="text" name="nombre2" id="a_nombre2"></td>
    <td width="200"><input type="text" name="nombre3" id="a_nombre3"></td>
    </tr>
  <tr class="Tamaño8">
    <td>&nbsp;</td>
    <td>Primer Nombre</td>
    <td>Segundo Nombre</td>
    <td>Tercer Nombre</td>
  </tr>
  <tr align="center">
    <td align="left">Apellidos:</td>
    <td><label for="nombre2"></label>
      <input type="text" name="apellido1" id="a_apellido1"></td>
    <td><input type="text" name="apellido2" id="a_apellido2"></td>
    <td><input type="text" name="apellido_casada" id="a_apellido_casada"></td>
  </tr>
  <tr class="Tama&ntilde;o8">
    <td>&nbsp;</td>
    <td>Primer Apellido</td>
    <td>Segundo Apellido</td>
    <td>Apellido de Casada</td>
  </tr>
  <tr>
    <td>Sexo:</td>
    <td colspan="3">
      <select name="sexo" id="a_sexo">
        <option value=0>== ESCOGER OPCION ==</option>
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>
        </select></td>
  </tr>
  <tr>
    <td>Fecha Nacimiento: (dd-mm-aaaa)</td>
    <td colspan="3"><input type="text" name="fecha_nacimiento" id="a_fecha_nacimiento" onBlur="Validar(fecha_nacimiento.value)"></td>
  </tr>
  <tr>     <td>Depende de Usted:</td>
    <td colspan="3"><select name="dependiente" id="a_dependiente">
      <option value=0>= Escoger Opci&oacute;n =</option>
        <option value="Si">Si</option>
        <option value="No">No</option>
    </select></td>
  </tr>
  <tr>
    <td>Escolaridad:</td>
    <td colspan="3">
      <input type="text" name="escolaridad" id="a_escolaridad">
    </td>
  </tr>
  <tr>
    <td>Ocupaci&oacute;n:</td>
    <td colspan="3"><input type="text" name="ocupacion" id="a_ocupacion"></td>
  </tr>
  <tr>
    <td colspan="4" align="center">
      <input type="button" name="Actualizar" id="Actualizar" value="Grabar..." onClick="validar_todo()">
      <input name="grabar" type="hidden" id="grabar" value="1">
    </td>
    </tr>
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
</form>
</table>
<?php
	} else {
		$id = $_GET["id"];
		$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_hijos WHERE colaborador = '$auxi' and id = '$id'";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($editar=mysqli_fetch_array($query_historial)) 	{ 	
?>
<table width="800" border="0" align="center" id="tabla_bienes_inmuebles" class="Tamaño12">
<form action="hijos.php?accion=3&id=<?php echo $editar['id'] ?>" method="post" name="form_bienes_inmuebles_editar" id="form_bienes_inmuebles_editar">
  <tr>
    <td colspan="4" align="center"><b>DETALLE DE DATOS DE HIJOS2</b></td>
    </tr>
  <tr>
    <td>Cif:</td>
    <td colspan="3"><input name="cif" type="text" id="nombre9" value="<?php echo $editar["cif"] ?>" size="12"></td>
  </tr>
  <tr align="center">
    <td align="left">Nombres:</td>
    <td><label for="nombre1"></label>
      <input name="nombre1" type="text" id="e_nombre1" value="<?php echo $editar["primer_nombre"] ?>"></td>
    <td><input name="nombre2" type="text" id="e_nombre2" value="<?php echo $editar["segundo_nombre"] ?>"></td>
    <td><input name="nombre3" type="text" id="e_nombre3" value="<?php echo $editar["tercer_nombre"] ?>"></td>
  </tr>
  <tr class="Tama&ntilde;o8">
    <td>&nbsp;</td>
    <td>Primer Nombre</td>
    <td>Segundo Nombre</td>
    <td>Tercer Nombre</td>
  </tr>
  <tr align="center">
    <td align="left">Apellidos:</td>
    <td><label for="nombre3"></label>
      <input name="apellido1" type="text" id="e_apellido1" value="<?php echo $editar["primer_apellido"] ?>"></td>
    <td><input name="apellido2" type="text" id="e_apellido2" value="<?php echo $editar["segundo_apellido"] ?>"></td>
    <td><input name="apellido_casada" type="text" id="e_apellido_casada" value="<?php echo $editar["apellido_casada"] ?>"></td>
  </tr>
  <tr class="Tama&ntilde;o8">
    <td>&nbsp;</td>
    <td>Primer Apellido</td>
    <td>Segundo Apellido</td>
    <td>Apellido de Casada</td>
  </tr>
  <tr>
    <td width="400">Nombre:</td>
    <td width="200"><label for="nombre"></label></td>
    <td width="200">&nbsp;</td>
    <td width="200">&nbsp;</td> 
  </tr>
  <tr>
    <td>Sexo:</td>
    <td colspan="3"><select name="sexo" id="e_sexo">
 <option value="<?php echo $editar['sexo']?>"><?php echo $editar['sexo'] ?></option>
        <option value=0>== ESCOGER OPCION ==</option>
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>
    </select></td>
    </tr>
  <tr>
    <td>Fecha Nacimiento: (dd-mm-aaaa)</td>
    <td colspan="3"><input name="fecha_nacimiento" type="text" id="e_fecha_nacimiento" value="<?php echo cambio_fecha_gua($editar["fecha_nacimiento"]) ?>" onBlur="Validar1(fecha_nacimiento.value)"></td>
    </tr>
  <tr>
    <td>Depende de Usted:</td>
    <td colspan="3"><select name="dependiente" id="e_dependiente">
	  <option value="<?php echo $editar["dependiente"] ?>"><?php echo $editar["dependiente"] ?></option>
      <option value=0>= Escoger Opci&oacute;n =</option>
      <option value="Si">Si</option>
      <option value="No">No</option>
    </select></td>
    </tr>
  <tr>
    <td>Escolaridad:</td>
    <td colspan="3">      <input name="escolaridad" type="text" id="e_escolaridad" value="<?php echo $editar["escolaridad"] ?>">
    </td>
    </tr>
  <tr>
    <td>Ocupaci&oacute;n:</td>
    <td colspan="3"><input name="ocupacion" type="text" id="e_ocupacion" value="<?php echo $editar["ocupacion"] ?>"></td>
  </tr>
  <tr>
    <td colspan="4" align="center">
      <input type="button" name="Actualizar" id="Actualizar" value="Actualizar..." onClick="validar_todo2()">
      <input name="grabar" type="hidden" id="grabar" value="3">
    </td>
    </tr>
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center">&nbsp;</td>
  </tr>
</form>
</table>
<?php
	}
}
?>
<table width="500" border="1" align="center" class="Tamaño12" id="tabla_historial">
<tr>
  <td width="13%" bgcolor="#000000" class="LetraBlanca" align="center"><b>CIF</b></td> 
	<td width="48%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Nombre</b></td>
	<td width="17%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Sexo</b></td>
	<td width="14%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Depende de Usted?</b></td>
	<td width="8%" bgcolor="#000000" class="LetraBlanca" align="center">&nbsp;</td>
  </tr>
  <?php
	$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_hijos WHERE colaborador = '$auxi'";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($historial=mysqli_fetch_array($query_historial)) 	{ 
?>
<tr>
  <td><?php echo $historial["cif"] ?></td> 
<td><?php echo nombre_completo($historial["primer_nombre"], $historial["segundo_nombre"], $historial["tercer_nombre"], $historial["primer_apellido"], $historial["segundo_apellido"], $historial["apellido_casada"]) ?></font></td>
<td><?php echo $historial["sexo"] ?></font></td>
<td align="center"><? echo $historial["dependiente"] ?></font></td>
<td><a href="hijos.php?accion=2&id=<?php echo $historial['id']?>"><img src="../Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a><a href="hijos.php?accion=4&id=<?php echo $historial['id']?>"><img src="../Imagenes/borrar.png" alt="Borrar..." width="16" height="16" border="0"></a></td>
<?php 
	}	//end while
?>
</tr>
</table>

<table width="200" border="0" align="center">
  <tr>
    <td width="75" height="62" align="center"><a href="informacion_base.php"><img src="../Imagenes/Regresar02.png" alt="Regresar..." width="85" height="60" border="0"><br />REGRESAR</a></td>
    <td width="75" align="center"><a href="<?php echo $_SERVER['PHP_SELF']?>"><img src="../Imagenes/add.png" width="64" height="64"><br />NUEVO</a></td>
  </tr>
</table>
<!-- end #container -->	
</div>
</body>
</html>
