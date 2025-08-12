<?php
include("../Script/seguridad.php");
include("../Script/conex.php");
include("../Script/comas.php");
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
//	document.estado_patrimonial.caja.focus();
}
function calcular_subtotal_activocirculante() {
	if (document.estado_patrimonial.caja.value.length == '0') {
		document.estado_patrimonial.caja.value = '0.00';
	}
	if (document.estado_patrimonial.depositos_coosajo.value.length == '0') {
		document.estado_patrimonial.depositos_coosajo.value = '0.00';
	}
	if (document.estado_patrimonial.depositos_bancos.value.length == '0') {
		document.estado_patrimonial.depositos_bancos.value = '0.00';
	}
	if (document.estado_patrimonial.fondo_retiro.value.length == '0') {
		document.estado_patrimonial.fondo_retiro.value = '0.00';
	}
	if (document.estado_patrimonial.cuentas_cobrar.value.length == '0') {
		document.estado_patrimonial.cuentas_cobrar.value = '0.00';
	}
	var c01 = document.estado_patrimonial.caja.value;
	var c02 = document.estado_patrimonial.depositos_coosajo.value;
	var c03 = document.estado_patrimonial.depositos_bancos.value;
	var c04 = document.estado_patrimonial.fondo_retiro.value;
	var c05 = document.estado_patrimonial.cuentas_cobrar.value;
	c01 = c01.replace(/,/, "");
	c02 = c02.replace(/,/, "");
	c03 = c03.replace(/,/, "");
	c04 = c04.replace(/,/, "");
	c05 = c05.replace(/,/, "");
	document.estado_patrimonial.caja.value = c01;
	document.estado_patrimonial.depositos_coosajo.value = c02;
	document.estado_patrimonial.depositos_bancos.value = c03;
	document.estado_patrimonial.fondo_retiro.value = c04;
	document.estado_patrimonial.cuentas_cobrar.value = c05;
	document.estado_patrimonial.subtotal_activocirculante.value = parseFloat(c01)+parseFloat(c02)+parseFloat(c03)+parseFloat(c04)+parseFloat(c05);
	estado_patrimonial.submit();
}
function calcular_subtotal_activofijo() {
	if (document.estado_patrimonial.terrenos.value.length == '0') {
		document.estado_patrimonial.terrenos.value = '0.00';
	}
	if (document.estado_patrimonial.vehiculos.value.length == '0') {
		document.estado_patrimonial.vehiculos.value = '0.00';
	}
	if (document.estado_patrimonial.mobiliario.value.length == '0') {
		document.estado_patrimonial.mobiliario.value = '0.00';
	}
	if (document.estado_patrimonial.inversiones_ganado.value.length == '0') {
		document.estado_patrimonial.inversiones_ganado.value = '0.00';
	}
	if (document.estado_patrimonial.inversiones_valores.value.length == '0') {
		document.estado_patrimonial.inversiones_valores.value = '0.00';
	}
	if (document.estado_patrimonial.otros_activos.value.length == '0') {
		document.estado_patrimonial.otros_activos.value = '0.00';
	}

	var c01 = document.estado_patrimonial.terrenos.value;
	var c02 = document.estado_patrimonial.vehiculos.value;
	var c03 = document.estado_patrimonial.mobiliario.value;
	var c04 = document.estado_patrimonial.inversiones_ganado.value;
	var c05 = document.estado_patrimonial.inversiones_valores.value;
	var c06 = document.estado_patrimonial.otros_activos.value;
	c01 = c01.replace(/,/, "");
	c02 = c02.replace(/,/, "");
	c03 = c03.replace(/,/, "");
	c04 = c04.replace(/,/, "");
	c05 = c05.replace(/,/, "");
	c06 = c06.replace(/,/, "");
	document.estado_patrimonial.terrenos.value = c01;
	document.estado_patrimonial.vehiculos.value = c02;
	document.estado_patrimonial.mobiliario.value = c03;
	document.estado_patrimonial.inversiones_ganado.value = c04;
	document.estado_patrimonial.inversiones_valores.value = c05;
	document.estado_patrimonial.otros_activos.value = c06;
	document.estado_patrimonial.subtotal_activofijo.value = parseFloat(c01)+parseFloat(c02)+parseFloat(c03)+parseFloat(c04)+parseFloat(c05)+parseFloat(c06);
}
function calcular_totalactivo() {
	var c01 = document.estado_patrimonial.subtotal_activocirculante.value;
	var c02 = document.estado_patrimonial.subtotal_activofijo.value;
	document.estado_patrimonial.total_activo.value = parseFloat(c01)+parseFloat(c02);
	estado_patrimonial.submit();
}
function calcular_subtotal_pasivocirculante() {
	if (document.estado_patrimonial.prestamos_coosajo_menor.value.length == '0') {
		document.estado_patrimonial.prestamos_coosajo_menor.value = '0.00';
	}
	if (document.estado_patrimonial.prestamos_bancos_menor.value.length == '0') {
		document.estado_patrimonial.prestamos_bancos_menor.value = '0.00';
	}
	if (document.estado_patrimonial.anticipo_sueldo.value.length == '0') {
		document.estado_patrimonial.anticipo_sueldo.value = '0.00';
	}
	if (document.estado_patrimonial.otros_prestamos.value.length == '0') {
		document.estado_patrimonial.otros_prestamos.value = '0.00';
	}
	if (document.estado_patrimonial.tarjetas_credito.value.length == '0') {
		document.estado_patrimonial.tarjetas_credito.value = '0.00';
	}
	if (document.estado_patrimonial.cuentas_por_pagar.value.length == '0') {
		document.estado_patrimonial.cuentas_por_pagar.value = '0.00';
	}
	if (document.estado_patrimonial.proveedores.value.length == '0') {
		document.estado_patrimonial.proveedores.value = '0.00';
	}
	if (document.estado_patrimonial.otros_pasivocirculante.value.length == '0') {
		document.estado_patrimonial.otros_pasivocirculante.value = '0.00';
	}
	var c01 = document.estado_patrimonial.prestamos_coosajo_menor.value;
	var c02 = document.estado_patrimonial.prestamos_bancos_menor.value;
	var c03 = document.estado_patrimonial.anticipo_sueldo.value;
	var c04 = document.estado_patrimonial.otros_prestamos.value;
	var c05 = document.estado_patrimonial.tarjetas_credito.value;
	var c06 = document.estado_patrimonial.cuentas_por_pagar.value;
	var c07 = document.estado_patrimonial.proveedores.value;
	var c08 = document.estado_patrimonial.otros_pasivocirculante.value;
	c01 = c01.replace(/,/, "");
	c02 = c02.replace(/,/, "");
	c03 = c03.replace(/,/, "");
	c04 = c04.replace(/,/, "");
	c05 = c05.replace(/,/, "");
	c06 = c06.replace(/,/, "");
	c07 = c07.replace(/,/, "");
	c08 = c08.replace(/,/, "");
	document.estado_patrimonial.prestamos_coosajo_menor.value = c01;
	document.estado_patrimonial.prestamos_bancos_menor.value = c02;
	document.estado_patrimonial.anticipo_sueldo.value = c03;
	document.estado_patrimonial.otros_prestamos.value = c04;
	document.estado_patrimonial.tarjetas_credito.value = c05;
	document.estado_patrimonial.cuentas_por_pagar.value = c06;
	document.estado_patrimonial.proveedores.value = c07;
	document.estado_patrimonial.otros_pasivocirculante.value = c08;
	document.estado_patrimonial.subtotal_pasivocirculante.value = parseFloat(c01)+parseFloat(c02)+parseFloat(c03)+parseFloat(c04)+parseFloat(c05)+parseFloat(c06)+parseFloat(c07)+parseFloat(c08);
	estado_patrimonial.submit();
}
function calculo_subtotal_pasivofijo() {
	if (document.estado_patrimonial.prestamos_coosajo_mayores.value.length == '0') {
		document.estado_patrimonial.prestamos_coosajo_mayores.value = '0.00';
	}
	if (document.estado_patrimonial.prestamos_bancos_mayores.value.length == '0') {
		document.estado_patrimonial.prestamos_bancos_mayores.value = '0.00';
	}
	if (document.estado_patrimonial.otras_deudas.value.length == '0') {
		document.estado_patrimonial.otras_deudas.value = '0.00';
	}
	var c01 = document.estado_patrimonial.prestamos_coosajo_mayores.value;
	var c02 = document.estado_patrimonial.prestamos_bancos_mayores.value;
	var c03 = document.estado_patrimonial.otras_deudas.value;
	c01 = c01.replace(/,/, "");
	c02 = c02.replace(/,/, "");
	c03 = c03.replace(/,/, "");
	document.estado_patrimonial.prestamos_coosajo_mayores.value = c01;
	document.estado_patrimonial.prestamos_bancos_mayores.value = c02;
	document.estado_patrimonial.otras_deudas.value = c03;
	document.estado_patrimonial.subtotal_pasivofijo.value = parseFloat(c01)+parseFloat(c02)+parseFloat(c03);
}
function calculo_totalpasivo() {
	var c01 = document.estado_patrimonial.subtotal_pasivocirculante.value;
	var c02 = document.estado_patrimonial.subtotal_pasivofijo.value;
	document.estado_patrimonial.total_pasivo.value = parseFloat(c01)+parseFloat(c02);
}
function calculo_patrimonio() {
	var c01 = document.estado_patrimonial.total_activo.value;
	var c02 = document.estado_patrimonial.total_pasivo.value;
	document.estado_patrimonial.patrimonio.value = parseFloat(c01)-parseFloat(c02);
}
function suma_final() {
	var c01 = document.estado_patrimonial.total_pasivo.value;
	var c02 = document.estado_patrimonial.patrimonio.value;
	document.estado_patrimonial.total_pasivo_patrimonio.value = parseFloat(c01)+parseFloat(c02);
	estado_patrimonial.submit();
}
function Grabar1() {
	estado_patrimonial.submit();
}
function calculo_total_ingresos() {
	var c01 = document.estado_patrimonial.sueldos_salarios.value;
	var c02 = document.estado_patrimonial.bonificaciones.value;
	var c03 = document.estado_patrimonial.alquileres_rentas.value;
	var c04 = document.estado_patrimonial.jubilaciones_pensiones.value;
	var c05 = document.estado_patrimonial.otros_ingresos.value;
	c01 = c01.replace(/,/, "");
	c02 = c02.replace(/,/, "");
	c03 = c03.replace(/,/, "");
	c04 = c04.replace(/,/, "");
	c05 = c05.replace(/,/, "");
	document.estado_patrimonial.total_ingresos.value = parseFloat(c01)+parseFloat(c02)+parseFloat(c03)+parseFloat(c04)+parseFloat(c05);
}
function calculo_total_egresos() {
	var c11 = document.estado_patrimonial.gastos_personales.value;
	var c12 = document.estado_patrimonial.gastos_familiares.value;
	var c13 = document.estado_patrimonial.descuentos_salariales.value;
	var c14 = document.estado_patrimonial.amortizacion_creditos.value;
	var c15 = document.estado_patrimonial.pago_tarjetas_credito.value;
	var c16 = document.estado_patrimonial.otros_egresos.value;
	c11 = c11.replace(/,/, "");
	c12 = c12.replace(/,/, "");
	c13 = c13.replace(/,/, "");
	c14 = c14.replace(/,/, "");
	c15 = c15.replace(/,/, "");
	c16 = c16.replace(/,/, "");
	document.estado_patrimonial.total_egresos.value = parseFloat(c11)+parseFloat(c12)+parseFloat(c13)+parseFloat(c14)+parseFloat(c15)+parseFloat(c16);
	estado_patrimonial.submit();
}
function operar() {
	if (document.estado_patrimonial.caja.value >= 0){
			if (estado_patrimonial.depositos_coosajo.value >= 0){
					if (estado_patrimonial.depositos_bancos.value >= 0){
						if (estado_patrimonial.fondo_retiro.value >= 0){
							if (estado_patrimonial.cuentas_cobrar.value >= 0){
							estado_patrimonial.submit()
							}else{
							alert("Las Cuentas y Doc. por cobrar deben ser mayor o igual a cero")
			}
						}else{
						alert("El fondo de retiro debe ser mayor o igual a cero")
			}
						}else{
			alert("Los depositos en Bancos deben ser mayor o igual a cero")
			}
						}else{
			alert("Los depositos en coosajo deben ser mayor o igual a cero")
			}
	}else{
	alert("El monto en caja debe ser mayor o igual a cero")
}
}
</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Estado patrimonial de Colaboradores</title>
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
.Tamaño13 {
	font-size: 13px;
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
	$sql2="SELECT * FROM Estado_Patrimonial.detalle_estado_patrimonial WHERE id=$auxi";
	$result2=mysqli_query($db, $sql2);
	$row2=mysqli_fetch_array($result2);
  ?>
   </td>
</tr>
</table>

<form action="grabar_estado_patrimonial.php" method="post" name="estado_patrimonial" id="estado_patrimonial">
<table width="600" border="0" align="center" id="Tabla_general" class="Tamaño12">
  <tr>
    <td colspan="3" align="center" bgcolor="#000066" class="LetraBlanca"><b>ACTIVO CIRCULANTE</b></td>
  </tr>
  <tr>
    <td width="354">Caja (efectivo):</td>
    <td width="170"><label for="caja"></label>
      <input name="caja" type="text" id="caja" value="<?php echo $row2["caja"] ?>"></td>
    <td width="62">&nbsp;</td>
  </tr>
  <tr>
    <td>Dep&oacute;sitos en Coosajo:</td>
    <td><label for="depositos_coosajo">
      <input name="depositos_coosajo" type="text" id="depositos_coosajo" value="<?php echo $row2["depositos_coosajo"] ?>">
    </label></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Dep&oacute;sitos en Bancos:</td>
    <td><label for="depositos_bancos"></label>
      <input name="depositos_bancos" type="text" id="depositos_bancos" value="<?php echo $row2["depositos_bancos"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Fondo de Retiro:</td>
    <td><label for="fondo_retiro"></label>
      <input name="fondo_retiro" type="text" id="fondo_retiro" value="<?php echo $row2["fondo_retiro"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Cuentas y Documentos x cobrar:</td>
    <td><label for="cuentas_cobrar"></label>
      <input name="cuentas_cobrar" type="text" id="cuentas_cobrar" onChange="grabar1()" value="<?php echo $row2["cuentas_cobrar"] ?>" ></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>SUB-TOTAL:</b></td>
    <td><label for="subtotal_activocirculante"></label>
      <input name="subtotal_activocirculante" type="text" id="subtotal_activocirculante" style="background-color:#FF9" onBlur="calcular_subtotal_activocirculante()" value="<?php echo $row2["subtotal_activocirculante"] ?>" readonly="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" bgcolor="#000066" class="LetraBlanca"><b>ACTIVO FIJO</b></td>
    </tr>
  <tr>
    <td>Terrenos y construcciones:</td>
    <?php
		$sumatoria_terrenos = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_bienes_inmuebles WHERE colaborador=$auxi";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_terrenos = $sumatoria_terrenos + $sumatoria["valor_mercado"];
		}							
	?>
    <td><input name="terrenos" type="text" id="terrenos" value="<?php echo $sumatoria_terrenos ?>" readonly="readonly"></td>
    <td><a href="bienes_inmuebles.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td>Veh&iacute;culos:</td>
    <?php
		$sumatoria_vehiculos = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_vehiculos WHERE colaborador=$auxi ";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_vehiculos = $sumatoria_vehiculos + $sumatoria["valor_vehiculo"];
		}
	?>
    <td><input name="vehiculos" type="text" id="vehiculos" value="<?php echo $sumatoria_vehiculos ?>" readonly="readonly"></td>
    <td><a href="vehiculos.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td>Inversiones en valores y acciones:</td>
	<?php
		$sumatoria_valores = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_valor_acciones WHERE colaborador=$auxi";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_valores = $sumatoria_valores + $sumatoria["valor_comercial"];
		}
	?>
    <td><input name="inversiones_valores" type="text" id="inversiones_valores" value="<?php echo $sumatoria_valores ?>" readonly="readonly"></td>
    <td><a href="valores_acciones.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td>Mobiliario y Equipo:</td>
    <td><input name="mobiliario" type="text" id="mobiliario" value="<?php echo $row2["mobiliario"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Inversiones (ganado, cultivos, etc):</td>
    <td><input name="inversiones_ganado" type="text" id="inversiones_ganado" onBlur="Grabar1()" value="<?php echo $row2["inversiones_ganado"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Otros Activos:</td>
    <td><input name="otros_activos" type="text" id="otros_activos" value="<?php echo $row2["otros_activos"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>SUB-TOTAL:</b></td>
    <td><input name="subtotal_activofijo" type="text" id="subtotal_activofijo" style="background-color:#FF9" onBlur="calcular_subtotal_activofijo()" value="<?php echo $row2["subtotal_activofijo"] ?>" readonly="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>TOTAL DEL ACTIVO:</b></td>
    <td><input name="total_activo" type="text" id="total_activo" style="background-color:#CF3" onBlur="calcular_totalactivo()" value="<?php echo $row2["total_activo"] ?>" readonly="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" bgcolor="#000066" class="LetraBlanca"><b>PASIVO CIRCULANTE (Corto Plazo)</b></td>
    </tr>
  <tr>
    <td>Pr&eacute;stamos en Coosajo R.L. (menor a 1 a&ntilde;o):</td>
    <?php
    	$sumatoria_valores = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_obligaciones_corto_plazo WHERE colaborador=$auxi AND acreedor = 'Coosajo R.L.'";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_valores = $sumatoria_valores + $sumatoria["saldo_actual"];
		}
	?>
    <td><input name="prestamos_coosajo_menor" type="text" id="prestamos_coosajo_menor" onBlur="Grabar1()" value="<?php echo $sumatoria_valores ?>" readonly="readonly"></td>
    <td><a href="obligaciones_cortoplazo.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td>Pr&eacute;stamos en otros Bancos (menor a 1 a&ntilde;o):</td>
    <?php
    	$sumatoria_valores = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_obligaciones_corto_plazo WHERE colaborador=$auxi AND acreedor != 'Coosajo R.L.'";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_valores = $sumatoria_valores + $sumatoria["saldo_actual"];
		}
	?>
    <td><input name="prestamos_bancos_menor" type="text" id="prestamos_bancos_menor" value="<?php echo $sumatoria_valores ?>" readonly="readonly"></td>
    <td><a href="obligaciones_cortoplazo.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
	<?php
    	$sumatoria_valores = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_tarjetas_credito WHERE colaborador=$auxi";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_valores = $sumatoria_valores + $sumatoria["saldo_actual"];
		}
	?>
    <td>Tarjetas de cr&eacute;dito (saldos):</td>
    <td><input name="tarjetas_credito" type="text" id="tarjetas_credito" value="<?php echo $sumatoria_valores ?>" readonly="readonly"></td>
    <td><a href="tarjetas_credito.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td>Anticipo de Sueldo:</td>
    <td><input name="anticipo_sueldo" type="text" id="anticipo_sueldo" value="<?php echo $row2["anticipo_sueldo"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Otros pr&eacute;stamos:</td>
    <td><input name="otros_prestamos" type="text" id="otros_prestamos" value="<?php echo $row2["otros_prestamos"] ?>" onBlur="Grabar1()"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Cuentas y documentos por pagar:</td>
    <td><input name="cuentas_por_pagar" type="text" id="cuentas_por_pagar" value="<?php echo $row2["cuentas_por_pagar"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Proveedores:</td>
    <td><input name="proveedores" type="text" id="proveedores" value="<?php echo $row2["proveedores"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Otros:</td>
    <td><input name="otros_pasivocirculante" type="text" id="otros_pasivocirculante" value="<?php echo $row2["otros_pasivocirculante"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>SUB-TOTAL:</b></td>
    <td><input name="subtotal_pasivocirculante" type="text" id="subtotal_pasivocirculante" style="background-color:#FF9" onBlur="calcular_subtotal_pasivocirculante()" value="<?php echo $row2["subtotal_pasivocirculante"] ?>" readonly="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" bgcolor="#000066" class="LetraBlanca"><b>PASIVO FIJO</b></td>
    </tr>
  <tr>
	<?php
    	$sumatoria_valores = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_obligaciones_largo_plazo WHERE colaborador=$auxi AND acreedor = 'Coosajo R.L.'";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_valores = $sumatoria_valores + $sumatoria["saldo_actual"];
		}
	?>
    <td>Pr&eacute;stamos en Coosajo (mayores a 1 a&ntilde;o):</td>
    <td><input name="prestamos_coosajo_mayores" type="text" id="prestamos_coosajo_mayores" onBlur="Grabar1()" value="<?php echo $sumatoria_valores ?>" readonly="readonly"></td>
    <td><a href="obligaciones_largoplazo.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td>Pr&eacute;stamos en Otros Banco (mayores a 1 a&ntilde;o):</td>
	<?php
    	$sumatoria_valores = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_obligaciones_largo_plazo WHERE colaborador=$auxi AND acreedor != 'Coosajo R.L.'";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_valores = $sumatoria_valores + $sumatoria["saldo_actual"];
		}
	?>
    <td><input name="prestamos_bancos_mayores" type="text" id="prestamos_bancos_mayores" value="<?php echo $sumatoria_valores ?>" readonly="readonly"></td>
    <td><a href="obligaciones_largoplazo.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
  </tr>
  <tr>
    <td>Otras deudas:</td>
    <td><input name="otras_deudas" type="text" id="otras_deudas" value="<?php echo $row2["otras_deudas"] ?>"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>SUB-TOTAL:</b></td>
    <td><input name="subtotal_pasivofijo" type="text" id="subtotal_pasivofijo" style="background-color:#FF9" onBlur="calculo_subtotal_pasivofijo()" value="<?php echo $row2["subtotal_pasivofijo"] ?>" readonly="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>TOTAL DEL PASIVO:</b></td>
    <td><input name="total_pasivo" type="text" id="total_pasivo" style="background-color:#CF3" onBlur="calculo_totalpasivo()" value="<?php echo $row2["total_pasivo"] ?>" readonly="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>PATRIMONIO (ACTIVO - PASIVO):</b></td>
    <td><input name="patrimonio" type="text" id="patrimonio" style="background-color:#CF3" onBlur="calculo_patrimonio()" value="<?php echo $row2["patrimonio"] ?>" readonly="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><b>TOTAL PASIVO + PATRIMONIO:</b></td>
    <td><input name="total_pasivo_patrimonio" type="text" id="total_pasivo_patrimonio" style="background-color: #C63" onBlur="suma_final()" value="<?php echo $row2["total_pasivo_patrimonio"] ?>" readonly="readonly"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    </tr>
  <tr>
  </tr>
</table>
  
<table width="600" border="0" align="center" id="Tabla_proyeccion" class="Tamaño12" >
<tr>
    <td colspan="4" align="center" bgcolor="#000066" class="LetraBlanca"><b>PROYECCION DE INGRESOS Y EGRESOS</b></td>
    </tr>
  <tr>
    <td width="133" align="left"><b><i>INGRESOS</i></b></td>
    <td width="148" align="center"><i>Mensuales</i></td>
    <td width="152" align="left"><b><i>EGRESOS</i></b></td>
    <td width="149" align="center"><i>Mensuales</i></td>
    </tr>
  <tr>
<?php
//select de proyeccion de ingresos y egresos
	$sql3="SELECT * FROM Estado_Patrimonial.detalle_proyeccion_ingresos_egresos WHERE colaborador=$auxi";
	$result3=mysqli_query($db, $sql3);
	$row3=mysqli_fetch_array($result3);
?>


    <td align="left">Sueldos y Salarios:</td>
    <td align="left"><label for="sueldos_salarios"></label>
      <input name="sueldos_salarios" type="text" id="sueldos_salarios" value="<?php echo $row3["sueldos_salarios"] ?>" size="15"></td>
    <td align="left">Gastos Personales:</td>
    <td align="left"><input name="gastos_personales" type="text" id="gastos_personales" value="<?php echo $row3["gastos_personales"] ?>" size="15"></td>
    </tr>
  <tr>
    <td align="left">Bonificaciones:</td>
    <td align="left"><label for="sueldos_salarios"></label>
      <input name="bonificaciones" type="text" id="bonificaciones" value="<?php echo $row3["bonificaciones"] ?>" size="15"></td>
    <td align="left">Gastos Familiares:</td>
    <td align="left"><input name="gastos_familiares" type="text" id="gastos_familiares" value="<?php echo $row3["gastos_familiares"] ?>" size="15"></td>
    </tr>
  <tr>
    <td align="left">Alquileres y/o rentas:</td>
    <td align="left"><label for="sueldos_salarios">
      <input name="alquileres_rentas" type="text" id="alquileres_rentas" value="<?php echo $row3["alquileres_rentas"] ?>" size="15">
    </label></td>
    <td align="left">Descuentos salariales:</td>
    <td align="left"><input name="descuentos_salariales" type="text" id="descuentos_salariales" value="<?php echo $row3["descuentos_salariales"] ?>" size="15"></td>
    </tr>
  <tr>
    <td align="left">Jubilaciones y/o pensiones:</td>
    <td align="left"><label for="sueldos_salarios"></label>
      <input name="jubilaciones_pensiones" type="text" id="jubilaciones_pensiones" value="<?php echo $row3["jubilaciones_pensiones"] ?>" size="15"></td>
    <td align="left">Amortizaci&oacute;n de cr&eacute;ditos:</td>
    <td align="left"><input name="amortizacion_creditos" type="text" id="amortizacion_creditos" value="<?php echo $row3["amortizacion_creditos"] ?>" size="15"></td>
    </tr>
  <tr>
    <td align="left">Bono 14 y Aguinaldo (valor anual):</td>
    <td align="left"><label for="sueldos_salarios"></label>
      <input name="bono14_aguinaldo" type="text" id="bono14_aguinaldo" value="<?php echo $row3["bono14_aguinaldo"] ?>" size="15"></td>
    <td align="left">Pago Tarjetas de Cr&eacute;dito:</td>
    <td align="left"><input name="pago_tarjetas_credito" type="text" id="pago_tarjetas_credito" value="<?php echo $row3["pago_tarjetas_credito"] ?>" size="15" onBlur="Grabar1()"></td>
    </tr>
  <tr>
	<?php
    	$sumatoria_valores = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_otros_ingresos WHERE colaborador=$auxi";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_valores = $sumatoria_valores + $sumatoria["monto"];
		}
	?>
    <td align="left">Otros ingresos (especificar):</td>
    <td align="left"><label for="sueldos_salarios"></label>
      <input name="otros_ingresos" type="text" id="otros_ingresos" value="<?php echo $sumatoria_valores ?>" size="15" readonly="readonly">
      <a href="otros_ingresos.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
	<?php
    	$sumatoria_valores = 0.00;
		$sql_contar="SELECT * FROM Estado_Patrimonial.detalle_otros_egresos WHERE colaborador=$auxi";
		$contar=mysqli_query($db, $sql_contar);
		while ($sumatoria=mysqli_fetch_array($contar)) 	{ 
			$sumatoria_valores = $sumatoria_valores + $sumatoria["monto"];
		}
	?>
    <td align="left">Otros egresos:</td>
    <td align="left"><input name="otros_egresos" type="text" id="otros_egresos" value="<?php echo $sumatoria_valores ?>" size="15" readonly="readonly">
      <a href="otros_egresos.php"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0"></a></td>
    </tr>
  <tr>
    <td align="left"><b><i>Total de ingresos:</i></b></td>
    <td align="left"><label for="sueldos_salarios"></label>
      <input name="total_ingresos" type="text" id="total_ingresos" style="background-color:#CF3" value="<?php echo $row3["total_ingresos"] ?>" size="15" readonly="readonly" onBlur="calculo_total_ingresos()"></td>
    <td align="left"><b><i>Total de egresos:</i></b></td>
    <td align="left"><input name="total_egresos" type="text" id="total_egresos" style="background-color:#CF3" value="<?php echo $row3["total_egresos"] ?>" size="15" readonly="readonly" onBlur="calculo_total_egresos()"></td>
    </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="button" name="Grabar" id="Grabar" value="Grabar..." onClick="operar()"></td>
    </tr>
</table>
</form>


<table width="81" border="0" align="center">
  <tr>
    <td height="62" align="center"><a href="menu.php"><img src="../Imagenes/Regresar02.png" alt="Regresar..." width="85" height="60" border="0"></a></td>
    </tr>
  <tr>
    <td height="25" align="center"><a href="menu.php">REGRESAR</a></td>
    </tr>
</table>
  <!-- end #container -->	
</div>
</body>
</html>
