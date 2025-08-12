<?php
include("../Script/seguridad.php");
include("../Script/conex.php");

include("../../../../../Script/funciones.php");
include("../calendario/calendario.php");
$auxi=$_SESSION["iduser"];
?>
<head>
<script language="JavaScript" type="text/javascript" src="../calendario/javascripts.js">
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingreso de Informaci&oacute;n de Colaboradores</title>

<script language="JavaScript" type="text/javascript">
function cerrar(){
	if (confirm("Esta seguro de salir de la aplicacion")){
		window.close();
	}
}
function empezar() {
	document.form_bienes_inmuebles.cif.focus();
}
function validar_todo() {	
	if (document.getElementById("cif").value == "") {
		alert ("Debe ingresar el CIF");	
		document.getElementById("cif").focus();
		return false;
	}
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
	if (document.getElementById("a_parentesco").value == 0) {
		alert ("Debe seleccionar por lo menos una opción en parentesco");	
		document.getElementById("a_parentesco").focus();
		return false;
	}
	if (document.getElementById("a_dependiente").value == 0) {
		alert ("Debe seleccionar por lo menos una opción");
		document.getElementById("a_dependiente").focus();
		return false;
	}	
	if (document.getElementById("a_ocupacion").value == "") {
		alert ("Debe llevar por lo menos algún comentario");
		document.getElementById("a_ocupacion").focus();
		return false;
	}
	document.form_bienes_inmuebles.submit();
}

function validar_todo2() {	
	if (document.getElementById("e_cif").value == "") {
		alert ("Debe ingresar el CIF");	
		document.getElementById("e_cif").focus();
		return false;
	}
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
	if (document.getElementById("e_parentesco").value == 0) {
		alert ("Debe seleccionar por lo menos una opción en parentesco");	
		document.getElementById("e_parentesco").focus();
		return false;
	}
	if (document.getElementById("e_dependiente").value == 0) {
		alert ("Debe seleccionar por lo menos una opción");
		document.getElementById("e_dependiente").focus();
		return false;
	}	
	if (document.getElementById("e_ocupacion").value == "") {
		alert ("Debe llevar por lo menos algún comentario");
		document.getElementById("e_ocupacion").focus();
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
</script>

<script src="../../../../../Script/jQuery/jQuery.buscador.js"></script>
<script src="../../../../../Script/jQuery/jQuery.buscador.tmpl.js"></script>
<script>
$(function(){
	$('#buscador').live('keyup', function(){
        var data = 'query=' + $(this).val();
		$.post('ajax_buscador.php', data, function(resp){
    	    $('#tabla_buscador').empty();
        	$('#tmpl_buscador').tmpl(resp).appendTo('#tabla_buscador');
		}, 'json');
	});
});
</script>

<script id="tmpl_buscador" type="text/x-jquery-tmpl">
<tr>
{{if cif}}
	<td>${cif}</td>
    <td>${nombre}</td>
{{else}}
	<td colspan="2">No existen resultados</td>
{{/if}}
</tr>
</script> 

<script language="Javascript">
function isNumberKey(evt)
	{
    	var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        	return false;
        return true;
      }
</script>

<script>	  
function cambio() {
	
if (document.form_bienes_inmuebles.vive.value==1) {
	document.form_bienes_inmuebles.dir.style.display = 'none';
	document.getElementById('a').style.display='none';  
}

if (document.form_bienes_inmuebles.vive.value==2) {
	document.form_bienes_inmuebles.dir.style.display = 'block';
	document.getElementById('a').style.display='block';  
}
}
	  
</script>
       
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
}
.Centrar {
	text-align:center;	
}
.thrColAbs #flotante_izquierdo {
	position: absolute;
	top: 0px;
	height: 80px;
	left: 0px;
	width: 60px;
	padding: 5px 5px 5px 5px;
}

--> 
</style>
</head>

<body class="thrColAbs " onLoad="empezar()">
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
		$cif = $_POST["cif"];
		$nombre1 = $_POST["nombre1"];
		$nombre2 = $_POST["nombre2"];
		$nombre3 = $_POST["nombre3"];
		$apellido1 = $_POST["apellido1"];
		$apellido2 = $_POST["apellido2"];
		$apellido_casada = $_POST["apellido_casada"];
		$parentesco = $_POST["parentesco"];
		$dependiente = $_POST["dependiente"];
		$ocupacion = $_POST["ocupacion"];
		$fecha_nacimiento = cambio_fecha($_POST["fecha2"]);
		$vive = $_POST["vive"];
		$dir = $_POST["dir"];

		switch ($parentesco) {
			case 1:
				$parentesco = "Hijo / Hija";
				$grado_consaguinidad = "Primer Grado Consaguinidad";
				
			case 2:
				$parentesco = "Padre / Madre";
				$grado_consaguinidad = "Primer Grado Consaguinidad";
				
			case 3:
				$parentesco = "Hermano / Hermana";
				$grado_consaguinidad = "Segundo Grado Consaguinidad";
				
			case 4:
				$parentesco = "Nieto / Nieta";
				$grado_consaguinidad = "Segundo Grado Consaguinidad";
				
			case 5:
				$parentesco = "Abuelo / Abuela";
				$grado_consaguinidad = "Segundo Grado Consaguinidad";
				
			case 6:
				$parentesco = "Suegro / Suegra";
				$grado_consaguinidad = "Primer Grado Afinidad";
				
			case 7:
				$parentesco = "Yerno / Nuera";
				$grado_consaguinidad = "Primer Grado Afinidad";
				
			case 8:
				$parentesco = "Cuñado / Cuñada";
				$grado_consaguinidad = "Segundo Grado Afinidad";
				
			case 9:
				$parentesco = "Cónyuge";
				$grado_consaguinidad = "Primer Grado Afinidad";
				$nombre_conyuge = nombre_completo_minuscula($nombre1, $nombre2, $nombre3, $apellido1, $apellido2, $apellido_casada);
				mysqli_query($db, "UPDATE Estado_Patrimonial.empleados SET Nombre_conyuge = '$nombre_conyuge' WHERE id = '$auxi' ") or die (mysqli_error());	
							
		}
		
		$insertar = "INSERT INTO Estado_Patrimonial.detalle_parentescos VALUES (NULL, '$auxi', '$nombre1', '$nombre2', '$nombre3', '$apellido1', '$apellido2', '$apellido_casada', '$parentesco', '$dependiente', '$ocupacion', '$grado_consaguinidad', '$cif', CURRENT_TIMESTAMP, '$fecha_nacimiento', '$vive', '$dir')";
	mysqli_query($db, $insertar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 4) {
		$id = $_GET["id"];
		$eliminar = "DELETE FROM Estado_Patrimonial.detalle_parentescos WHERE id = '$id'";
		mysqli_query($db, "UPDATE Estado_Patrimonial.empleados SET Nombre_conyuge = '' WHERE id = '$auxi' ") or die (mysqli_error());	
		mysqli_query($db, $eliminar) or die (mysqli_error());
	}
	if ($_GET["accion"] == 3) {
		$id = $_GET["id"];
		$cif = $_POST["cif"];
		$nombre1 = $_POST["nombre1"];
		$nombre2 = $_POST["nombre2"];
		$nombre3 = $_POST["nombre3"];
		$apellido1 = $_POST["apellido1"];
		$apellido2 = $_POST["apellido2"];
		$apellido_casada = $_POST["apellido_casada"];
		$parentesco = $_POST["parentesco"];
		$dependiente = $_POST["dependiente"];
		$ocupacion = $_POST["ocupacion"];
		$fecha_naci = cambio_fecha($_POST["fecha3"]);
		$vive2 = $_POST["vive2"];

		switch ($parentesco) {
			case 1:
				$parentesco = "Hijo / Hija";
				$grado_consaguinidad = "Primer Grado Consaguinidad";
				
			case 2:
				$parentesco = "Padre / Madre";
				$grado_consaguinidad = "Primer Grado Consaguinidad";
				
			case 3:
				$parentesco = "Hermano / Hermana";
				$grado_consaguinidad = "Segundo Grado Consaguinidad";
				
			case 4:
				$parentesco = "Nieto / Nieta";
				$grado_consaguinidad = "Segundo Grado Consaguinidad";
				
			case 5:
				$parentesco = "Abuelo / Abuela";
				$grado_consaguinidad = "Segundo Grado Consaguinidad";
							
			case 6:
				$parentesco = "Suegro / Suegra";
				$grado_consaguinidad = "Primer Grado Afinidad";
				
			case 7:
				$parentesco = "Yerno / Nuera";
				$grado_consaguinidad = "Primer Grado Afinidad";
				
			case 8:
				$parentesco = "Cuñado / Cuñada";
				$grado_consaguinidad = "Segundo Grado Afinidad";
				
			case 9:
				$parentesco = "Cónyuge";
				$grado_consaguinidad = "Primer Grado Afinidad";
				echo $nombre_conyuge2 = nombre_completo_minuscula($nombre1, $nombre2, $nombre3, $apellido1, $apellido2, $apellido_casada);
				mysqli_query($db, "UPDATE Estado_Patrimonial.empleados SET Nombre_conyuge = '$nombre_conyuge2' WHERE id = '$auxi' ") or die (mysqli_error());	
						
		}
		$actualizar = "UPDATE Estado_Patrimonial.detalle_parentescos SET colaborador = '$auxi', primer_nombre = '$nombre1', segundo_nombre = '$nombre2', tercer_nombre = '$nombre3', primer_apellido = '$apellido1', segundo_apellido = '$apellido2', apellido_casada = '$apellido_casada', parentesco = '$parentesco', dependiente = '$dependiente', ocupacion = '$ocupacion', grado_consaguinidad = '$grado_consaguinidad', cif = '$cif', fecha_nacimiento_hijo = '$fecha_naci', vive = '$vive2', direccion_hijo = '$dir2', actualizo = CURRENT_TIMESTAMP WHERE id = '$id'";
		mysqli_query($db, $actualizar) or die (mysqli_error());
	}
	if ($_GET["accion"] != 2) {
?>
<table width="800" border="0" align="center" id="tabla_bienes_inmuebles" class="Tamaño12">
<form action="parentescos.php?accion=1" method="post" name="form_bienes_inmuebles" id="form_bienes_inmuebles">
  <tr>
    <td colspan="4" align="center"><b>DETALLE DE DATOS FAMILIARES (N&uacute;cleo Familiar)</b>
      <label for="nombre"></label></td>
  </tr>
  <tr>
    <td>CIF:</td>
    <td colspan="3" class="Tamaño8" align="left"><input name="cif" type="text" id="cif" size="12" onKeyPress="return isNumberKey(event)">
    * Si no conoce el CIF, puede utilizar el buscador de la izquierda. De lo contrario ingresar 0.</td>
  </tr>
  <tr align="center">
    <td align="left">Nombres:</td>
    <td><label for="nombre1"></label>
      <input type="text" name="nombre1" id="a_nombre1">
      *</td>
    <td><input type="text" name="nombre2" id="a_nombre2"></td>
    <td><input type="text" name="nombre3" id="a_nombre3"></td>
  </tr>
  <tr class="Tama&ntilde;o8 Centrar">
    <td>&nbsp;</td>
    <td>Primer Nombre</td>
    <td>Segundo Nombre</td>
    <td>Tercer Nombre</td>
  </tr>
  <tr align="center">
    <td align="left">Apellidos:</td>
    <td><label for="nombre2"></label>
      <input type="text" name="apellido1" id="a_apellido1">
      *</td>
    <td><input type="text" name="apellido2" id="a_apellido2"></td>
    <td><input type="text" name="apellido_casada" id="a_apellido_casada"></td>
  </tr>
  <tr class="Tama&ntilde;o8 Centrar">
    <td>&nbsp;</td>
    <td>Primer Apellido</td>
    <td>Segundo Apellido</td>
    <td>Apellido de Casada</td>
  </tr>
  <tr>
    <td width="222">Parentesco:</td>
    <td colspan="3">
      <select name="parentesco" id="a_parentesco">
        <option value=0>== ESCOGER OPCION ==</option>
        <option value=1>Hijo / Hija</option>
        <option value=2>Padre / Madre</option>
        <option value=3>Hermano / Hermana</option>
        <option value=4>Nieto / Nieta</option>
        <option value=5>Abuelo / Abuela</option>
        <option value=6>Suegro / Suegra</option>
        <option value=7>Yerno / Nuera</option>
        <option value=8>Cu&ntilde;ado / Cu&ntilde;ada</option>
        <option value=9>C&oacute;nyuge</option>
        </select></td>
  </tr>
  <tr>
    <td>Fecha Nacimiento: (Hijos)</td>
    <td colspan="3">
    <?php   $date= date("d/m/Y");  ?>
      <?php escribe_formulario_fecha_vacio("fecha2","form_bienes_inmuebles")?>
      <script>form_bienes_inmuebles.fecha2.value='<?php echo $date ?>';form_bienes_inmuebles.fecha2.id='fecha2'</script>
    </td>
  </tr>
  <tr>
    <td>Vive con Usted: (Hijos)</td>
    <td colspan="3"><select name="vive" id="vive" onChange="cambio()">
      <option value=0>= Escoger Opci&oacute;n =</option>
      <option value="1">Si</option>
      <option value="2">No</option>
    </select></td>
  </tr>
  <tr>
    <td id="a">Direccion: (Hijo)</td>
    <td colspan="3"><input type="text" name="dir" id="dir"></td>
  </tr>
  <tr>
    <td>Depende de Usted:</td>
    <td colspan="3"><select name="dependiente" id="a_dependiente">
      <option value=0>= Escoger Opci&oacute;n =</option>
      <option value="Si">Si</option>
      <option value="No">No</option>
      </select></td>  
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
		$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_parentescos WHERE colaborador = '$auxi' and id = '$id'";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($editar=mysqli_fetch_array($query_historial)) 	{ 	
?>
<table width="800" border="0" align="center" id="tabla_bienes_inmuebles" class="Tamaño12">
<form action="parentescos.php?accion=3&id=<?php echo $editar['id'] ?>" method="post" name="form_bienes_inmuebles_editar" id="form_bienes_inmuebles_editar">
  <tr>
    <td colspan="4" align="center"><b>DETALLE DE DATOS FAMILIARES (N&uacute;cleo Familiar)</b></td>
    </tr>
  <tr>
    <td width="222">Cif:</td>
    <td colspan="3" class="Tamaño8"><input name="cif" type="text" id="e_cif" value="<?php echo $editar["cif"] ?>" size="12" onKeyPress="return isNumberKey(event)">* Si no conoce el CIF, puede utilizar el buscador de la izquierda. De lo contrario ingresar 0.</td>
  </tr>
  <tr align="center">
    <td align="left">Nombres:</td>
    <td><label for="nombre1"></label>
      <input name="nombre1" type="text" id="e_nombre1" value="<?php echo $editar["primer_nombre"] ?>"></td>
    <td><input name="nombre2" type="text" id="e_nombre2" value="<?php echo $editar["segundo_nombre"] ?>"></td>
    <td><input name="nombre3" type="text" id="e_nombre3" value="<?php echo $editar["tercer_nombre"] ?>"></td>
  </tr>
  <tr class="Tama&ntilde;o8 Centrar">
    <td>&nbsp;</td>
    <td>Primer Nombre</td>
    <td>Segundo Nombre</td>
    <td>Tercer Nombre</td>
  </tr>
  <tr align="center">
    <td align="left">Apellidos:</td>
    <td><label for="nombre2"></label>
      <input name="apellido1" type="text" id="e_apellido1" value="<?php echo $editar["primer_apellido"] ?>"></td>
    <td><input name="apellido2" type="text" id="e_apellido2" value="<?php echo $editar["segundo_apellido"] ?>"></td>
    <td><input name="apellido_casada" type="text" id="e_apellido_casada" value="<?php echo $editar["apellido_casada"] ?>"></td>
  </tr>
  <tr class="Tama&ntilde;o8 Centrar">
    <td>&nbsp;</td>
    <td>Primer Apellido</td>
    <td>Segundo Apellido</td>
    <td>Apellido de Casada</td>
  </tr>
  <tr>
    <td>Parentesco:</td>
    <?php
		switch ($editar['parentesco']) {
		    case 1:
				$parentesco = "Hijo / Hija";
				$grado_consaguinidad = "Primer Grado Consaguinidad";
				
			case 2:
				$parentesco = "Padre / Madre";
				$grado_consaguinidad = "Primer Grado Consaguinidad";
				
			case 3:
				$parentesco = "Hermano / Hermana";
				$grado_consaguinidad = "Segundo Grado Consaguinidad";
				
			case 4:
				$parentesco = "Nieto / Nieta";
				$grado_consaguinidad = "Segundo Grado Consaguinidad";
				
			case 5:
				$parentesco = "Abuelo / Abuela";
				$grado_consaguinidad = "Segundo Grado Consaguinidad";
				
			
			case 6:
				$parentesco = "Suegro / Suegra";
				$grado_consaguinidad = "Primer Grado Afinidad";
				
			case 7:
				$parentesco = "Yerno / Nuera";
				$grado_consaguinidad = "Primer Grado Afinidad";
				
			case 8:
				$parentesco = "Cuñado / Cuñada";
				$grado_consaguinidad = "Segundo Grado Afinidad";
				
			case 9:
				$parentesco = "Cónyuge";
				$grado_consaguinidad = "Primer Grado Afinidad";
						
		}		
	?>
    <td colspan="3"><select name="parentesco" id="e_parentesco">
      
      <option value=0>== ESCOGER OPCION ==</option>
      <option value=1 <?php if ($editar['parentesco'] == 'Hijo / Hija') { echo 'selected' ; } ?>>Hijo / Hija</option>
      <option value=2 <?php if ($editar['parentesco'] == 'Padre / Madre') { echo 'selected' ; } ?>>Padre / Madre</option>
      <option value=3 <?php if ($editar['parentesco'] == 'Hermano / Hermana') { echo 'selected' ; } ?>>Hermano / Hermana</option>
      <option value=4 <?php if ($editar['parentesco'] == 'Nieto / Nieta') { echo 'selected' ; } ?>>Nieto / Nieta</option>
      <option value=5 <?php if ($editar['parentesco'] == 'Abuelo / Abuela') { echo 'selected' ; } ?>>Abuelo / Abuela</option>
      <option value=6 <?php if ($editar['parentesco'] == 'Suegro / Suegra') { echo 'selected' ; } ?>>Suegro / Suegra</option>
      <option value=7 <?php if ($editar['parentesco'] == 'Yerno / Nuera') { echo 'selected' ; } ?>>Yerno / Nuera</option>
      <option value=8 <?php if ($editar['parentesco'] == 'Cuñado / Cuñada') { echo 'selected' ; } ?>>Cu&ntilde;ado / Cu&ntilde;ada</option>
      <option value=9 <?php if ($editar['parentesco'] == 'Cónyuge') { echo 'selected' ; } ?>>C&oacute;nyuge</option>    
      </select></td>
  </tr>
  <tr>
    <td>Fecha Nacimiento: (Hijos)</td>
    <td colspan="3">
    <?php   $date= date("d/m/Y"); 
	function cambiar_fecha1($f) {
	$desglose=split("-",$f);
	$resultado=$desglose[2]."/".$desglose[1]."/".$desglose[0];
	return $resultado;
}
	
	
	 ?>
      <?php escribe_formulario_fecha_vacio("fecha3","form_bienes_inmuebles_editar")?>
      <script>form_bienes_inmuebles_editar.fecha3.value='<?php echo $fecha_nac_camb = cambiar_fecha1($editar["fecha_nacimiento_hijo"] );?>';form_bienes_inmuebles_editar.fecha3.id='fecha3'</script>
    </td>
  </tr>
  <tr>
    <td>Vive con Usted: (Hijos)</td>
    <td colspan="3"><select name="vive2" tabindex="8" size="1">
      <option value="0">= Escoger opci&oacute;n =</option>
      <option value="1" <?php if ($editar["vive"] == 1) { echo 'selected'; } ?>>Si</option>
      <option value="2" <?php if ($editar["vive"] == 2) { echo 'selected'; } ?>>No</option>
    </select></td>
  </tr>
  <tr>
    <td>Direccion: (Hijo)</td>
    <td colspan="3"><input type="text" name="dir2" id="dir2" value="<?php echo $editar["direccion_hijo"] ?>"></td>
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
	<td width="18%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Cif</b></td>
	<td width="48%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Nombre</b></td>
	<td width="26%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Parentesco</b></td>
  
	<td width="18%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Depende de Usted?</b></td>
	<td width="18%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Fecha Nacimiento</b></td>
	<td width="18%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Vive con Usted</b></td>
	<td width="18%" bgcolor="#000000" class="LetraBlanca" align="center"><b>Direccion</b></td>
	<td width="8%" bgcolor="#000000" class="LetraBlanca" align="center">&nbsp;</td>
  </tr>
  <?php
	$sql_historial="SELECT * FROM Estado_Patrimonial.detalle_parentescos WHERE colaborador = '$auxi'";
	$query_historial = mysqli_query($db, $sql_historial);
	while ($historial=mysqli_fetch_array($query_historial)) 	{ 
?>
<tr> 
<td align="center"><? echo $historial["cif"] ?></td>
<td><?php echo nombre_completo_minuscula($historial["primer_nombre"], $historial["segundo_nombre"], $historial["tercer_nombre"], $historial["primer_apellido"], $historial["segundo_apellido"], $historial["apellido_casada"]) ?></font></td>
<td><? echo $historial["parentesco"] ?></font></td>
<td align="center"><? echo $historial["dependiente"] ?></font></td>
<td align="center"><? echo cambio_fecha($historial["fecha_nacimiento_hijo"]) ?></td>
<td align="center"><?  $vive = $historial["vive"];
if($vive == 1){
echo "Si";
}
if($vive == 2){
echo "No"; 
} 
 ?></td>
<td><? echo $historial["direccion_hijo"] ?></td>
<td><a href="parentescos.php?accion=2&id=<?php echo $historial['id']?>"><img src="../Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a><a href="parentescos.php?accion=4&id=<?php echo $historial['id']?>"><img src="../Imagenes/borrar.png" alt="Borrar..." width="16" height="16" border="0"></a></td>
<?php 
	}	//end while
?>
</tr>
</table>

<table width="200" border="0" align="center">
  <tr>
    <td width="75" height="62" align="center"><a href="informacion_base.php"><img src="../Imagenes/Regresar02.png" alt="Regresar..." width="85" height="60" border="0"><br />REGRESAR</a></td>
    <td width="75" align="center"><a href="<?php echo $_SERVER['PHP_SELF']?>"><img src="../Imagenes/add.png" width="64" height="64" border=0><br />NUEVO</a></td>
  </tr>
</table>
<!-- end #container -->	
</div>

<div id="flotante_izquierdo">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" id="flotante" class="Tamaño8" align="center" bgcolor="#FFFFFF">
<tr>
  <td align="center">Nombres o Apellidos:</td>
  <td align="center"><input name="buscador" type="text" id="buscador" value="" size="15" /></td>
</tr>
<tr align="center" bgcolor="#003300">
	<td class="LetraBlanca">CIF</td>
	<td class="LetraBlanca">Nombres</td>
</tr>
   <tbody id="tabla_buscador">
        <tr>
          <td colspan="2">Favor de escribir sin tildes</td>
          </tr>
   </tbody>
    </table>
</div>

</body>
</html>