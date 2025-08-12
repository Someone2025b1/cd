<?php 
require ('../Script/fpdf.php');
include("../Script/seguridad.php");
include("../Script/conex.php");
$auxi=$_SESSION["iduser"];
$sql_periodo = "SELECT * FROM Estado_Patrimonial.periodo order by id desc limit 1 ";
$result_periodo = mysqli_query($db, $sql_periodo) or die("".mysqli_error());
$row_periodo=mysqli_fetch_array($result_periodo); 
$mes_periodo=$row_periodo[1];
$anio_periodo=$row_periodo[2];
//************** CONEXCION CON LA BASE DE DATOS ************** //
function poner_comas($cantidad) {
	$desglose=explode(".",$cantidad);
	$n=$desglose[0];
	if ($desglose[1] == "") {
		$d="00";
	} else {
		$d=$desglose[1];
	}
	if (strlen($n) < 4) {
		$resultado=$n;
	} else {
		switch (strlen($n)) {
			case 4 :
				$tmp_1=substr($n,0,1);
				$tmp_2=substr($n,1,3);
				$resultado=$tmp_1.",".$tmp_2;
				
			case 5:
				$tmp_1=substr($n,0,2);
				$tmp_2=substr($n,2,3);
				$resultado=$tmp_1.",".$tmp_2;
				
			case 6:
				$tmp_1=substr($n,0,3);
				$tmp_2=substr($n,3,3);
				$resultado=$tmp_1.",".$tmp_2;
				
			case 7:
				$tmp_1=substr($n,0,1);
				$tmp_2=substr($n,1,3);
				$tmp_3=substr($n,4,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				
			case 8:
				$tmp_1=substr($n,0,2);
				$tmp_2=substr($n,2,3);
				$tmp_3=substr($n,5,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				
			case 9:
				$tmp_1=substr($n,0,3);
				$tmp_2=substr($n,3,3);
				$tmp_3=substr($n,6,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				
		} // end switch
	} // end if-else
	$resultado=$resultado.".".$d;		
	return $resultado;
}
//************** CONEXCION CON LA BASE DE DATOS ************** //
session_start();
//$auxi=$_SESSION["cuenta"];
$sql="SELECT * FROM Estado_Patrimonial.empleados WHERE id=$auxi";
$result = mysqli_query($db, $sql);
$data1=mysqli_fetch_array($result) or die(mysqli_error());
$sql = "SELECT * FROM Estado_Patrimonial.detalle_estado_patrimonial WHERE id = $auxi and mes=$mes_periodo and anio=$anio_periodo ";
$result=mysqli_query($db, $sql);
$data2=mysqli_fetch_array($result) or die(mysqli_error());
$sql = "SELECT * FROM Estado_Patrimonial.detalle_proyeccion_ingresos_egresos WHERE colaborador = $auxi and mes=$mes_periodo and anio=$anio_periodo ";
$result=mysqli_query($db, $sql);
$data3=mysqli_fetch_array($result) or die(mysqli_error());
$ano_actual=date('Y');
$ano_actual=$ano_actual-1;
//************** DEFINICIÓN DEL PDF  ************** //
$pdf = new FPDF('p', 'mm', 'letter');
$pdf -> AliasNbPages(); 
$pdf -> SetTopMargin(10);
$pdf -> AddPage();
//****ENCABEZADO EN PLUGGINS FPDF****							
$pdf -> SetFont('Times', 'B', 14);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (0,7, "ESTADO PATRIMONIAL AL 31 DE DICIEMBRE  $ano_actual ",1,1,'C',1);
$pdf -> Ln(4);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (20,4,"");
$pdf -> Cell (30,4, "ACTIVO",0,0,'L',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> Cell (20,4,"");
$pdf -> Cell (43,4, "CIRCULANTE",0,0,'L',0);
$pdf -> Ln(4);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Caja (Efectivo):");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'LT',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["caja"]),'RT',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Depósitos en Coosajo:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["depositos_coosajo"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Depósitos en Bancos:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["depositos_bancos"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Fondo de Retiro:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["fondo_retiro"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Cuentas y documentos x cobrar:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["cuentas_cobrar"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'B', 10);
$pdf -> Cell (15,4,"Sub-Total");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($data2["subtotal_activocirculante"]),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> SetTextColor(0,0,0);
$pdf -> Cell (20,4,"");
$pdf -> Cell (43,4, "FIJO",0,0,'L',0);
$pdf -> Ln(4);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Terrenos y construcciones:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'LT',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["terrenos"]),'RT',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Vehículos:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["vehiculos"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Mobiliario y Equipo:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["mobiliario"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Inversiones (ganado, cultivos, etc):");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["inversiones_ganado"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Inversiones en valores y acciones:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["inversiones_valores"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Otros Activos:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["otros_activos"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'B', 10);
$pdf -> Cell (15,4,"Sub-Total");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($data2["subtotal_activofijo"]),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (15,4,"TOTAL DEL ACTIVO");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($data2["total_activo"]),'RBT',0,'R',1);
$pdf -> Ln(15);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (20,4,"");
$pdf -> SetFillColor(0,0,0);
$pdf -> SetTextColor(255,255,255);
$pdf -> Cell (30,4, "PASIVO",0,0,'L',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> Cell (20,4,"");
$pdf -> Cell (43,4, "CIRCULANTE (Corto Plazo)",0,0,'L',0);
$pdf -> Ln(4);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Préstamos en Coosajo, R.L.(menores a 1 año):");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'LT',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["prestamos_coosajo_menor"]),'RT',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Préstamos en otros Bancos (menores a 1 año):");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["prestamos_bancos_menor"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Anticipo de Sueldo:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["anticipo_sueldo"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Otros préstamos:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["otros_prestamos"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Tarjetas de Crédito (saldos):");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["tarjetas_credito"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Cuentas y documentos por pagar:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["cuentas_por_pagar"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Proveedores:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["proveedores"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Otros:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["otros_pasivocirculante"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'B', 10);
$pdf -> Cell (15,4,"Sub-Total");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($data2["subtotal_pasivocirculante"]),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> SetTextColor(0,0,0);
$pdf -> Cell (20,4,"");
$pdf -> Cell (43,4, "FIJO",0,0,'L',0);
$pdf -> Ln(4);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Préstamos en Coosajo, R.L. (mayores a 1 año):");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'LT',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["prestamos_coosajo_mayores"]),'RT',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Préstamos en Bancos (mayores a 1 año):");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["prestamos_bancos_mayores"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Otras deudas:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["otras_deudas"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'B', 10);
$pdf -> Cell (15,4,"Sub-Total");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($data2["subtotal_pasivofijo"]),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (15,4,"TOTAL DEL PASIVO");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($data2["total_pasivo"]),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (15,4,"PATRIMONIO (ACTIVO - PASIVO)");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($data2["patrimonio"]),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (15,4,"TOTAL PASIVO + PATRIMONIO");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($data2["total_pasivo_patrimonio"]),'RBT',0,'R',1);
$pdf -> Ln(15);
$pdf -> Cell (10,0,"");
	$dia=date("j");
	$mes=date("n");
	$anno=date("Y");
	switch ($mes) {
		case 1:
			$mes = "Enero";
			
		case 2:
			$mes = "Febrero";
			
		case 3:
			$mes = "Marzo";
			
		case 4:
			$mes = "Abril";
			
		case 5:
			$mes = "Mayo";
			
		case 6:		
			$mes = "Junio";
			
		case 7:
			$mes = "Julio";
			
		case 8:		
			$mes = "Agosto";
			
		case 9:
			$mes = "Septiembre";
			
		case 10:		
			$mes = "Octubre";
			
		case 11:
			$mes = "Noviembre";
			
		case 12:		
			$mes = "Diciembre";
			
	}
$pdf -> Cell (50,0,"Fecha de Entrega: ".$dia." de ".$mes." del ".$anno.".");
$pdf -> Ln(10);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (10,0, "");
$pdf -> Cell (50,4, "Declaro bajo juramento que la información proporcionada en este Estado Patrimonial y sus Anexos contienen la",0,0,'L',0);
$pdf -> Ln(4);
$pdf -> Cell (10,0, "");
$pdf -> Cell (50,4, "información real de mi patrimonio. Declaro además que conozco la pena correspondiente al delito de perjurio.",0,0,'L',0);
$pdf -> Ln(25);
$pdf -> SetFont('Times', 'BI', 10);
$pdf -> Cell (0,0, "_________________________________________________",0,0,'C',0);
$pdf -> Ln(4);
	if ($data1["ApellidoCasada"] == NULL) {
		$pdf -> Cell (0,0, $data1["Nombre1"]." ".$data1["Nombre2"]." ".$data1["Apellido1"]." ".$data1["Apellido2"],0,0,'C',0);
	}else {
		$pdf -> Cell (0,0, $data1["Nombre1"]." ".$data1["Nombre2"]." ".$data1["Apellido1"]." ".$data1["Apellido2"]." de ".$data1["ApellidoCasada"],0,0,'C',0);
	}
// ****** SEGUNDA HOJA *****
$pdf -> AddPage();
$pdf -> SetFont('Times', 'B', 14);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (0,7, "DETALLE DEL ESTADO PATRIMONIAL AL 31 DE DICIEMBRE DE $ano_actual",1,1,'C',1);
$pdf -> Ln(4);
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (10,4,"");
$pdf -> Cell (70,4, "   DETALLE DE BIENES INMUEBLES",1,0,'L',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (10,4,"");
$pdf -> Cell (55,4, "LOCALIZACION",1,0,'C',1);
$pdf -> Cell (15,4, "FINCA",1,0,'C',1);
$pdf -> Cell (15,4, "FOLIO",1,0,'C',1);
$pdf -> Cell (15,4, "LIBRO",1,0,'C',1);
$pdf -> Cell (35,4, "DEPARTAMENTO",1,0,'C',1);
$pdf -> Cell (38,4, "VALOR DE MERCADO",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.detalle_bienes_inmuebles WHERE colaborador = $auxi and mes=$mes_periodo and anio=$anio_periodo ";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (55,4, $tabla["localizacion"],1,0,'C');
$pdf -> Cell (15,4, $tabla["finca"],1,0,'C');
$pdf -> Cell (15,4, $tabla["folio"],1,0,'C');
$pdf -> Cell (15,4, $tabla["libro"],1,0,'C');
$pdf -> Cell (35,4, $tabla["departamento"],1,0,'C');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (33,4, poner_comas($tabla["valor_mercado"]),'RTB',0,'R');
$pdf -> Ln(4);
}
$pdf -> Ln(5);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (10,4,"");
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (60,4, "   DETALLE DE VEHÍCULOS",1,0,'L',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (10,4,"");
$pdf -> Cell (43,4, "MARCA",1,0,'C',1);
$pdf -> Cell (17,4, "MODELO",1,0,'C',1);
$pdf -> Cell (30,4, "COLOR",1,0,'C',1);
$pdf -> Cell (26,4, "VALOR",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.detalle_vehiculos WHERE colaborador = $auxi and mes=$mes_periodo and anio=$anio_periodo ";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (43,4, $tabla["marca"],1,0,'C');
$pdf -> Cell (17,4, $tabla["modelo"],1,0,'C');
$pdf -> Cell (30,4, $tabla["color"],1,0,'C');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (21,4, poner_comas($tabla["valor_vehiculo"]),'RTB',0,'R');
$pdf -> Ln(4);
}
$pdf -> Ln(5);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (10,4,"");
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (80,4, "   INVERSIONES EN VALORES Y ACCIONES",1,0,'L',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (10,4,"");
$pdf -> Cell (53,4, "CLASE DE TITULO",1,0,'C',1);
$pdf -> Cell (50,4, "INSTITUCION O EMPRESA",1,0,'C',1);
$pdf -> Cell (35,4, "MONTO INVERTIDO",1,0,'C',1);
$pdf -> Cell (35,4, "VALOR COMERCIAL",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.detalle_valor_acciones WHERE colaborador = $auxi and mes=$mes_periodo and anio=$anio_periodo ";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (53,4, $tabla["clase_titulo"],1,0,'C');
$pdf -> Cell (50,4, $tabla["institucion"],1,0,'C');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (30,4, poner_comas($tabla["monto"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (30,4, poner_comas($tabla["valor_comercial"]),'RTB',0,'R');
$pdf -> Ln(4);
}
$pdf -> Ln(5);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (10,4,"");
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (55,4, "   TARJETAS DE CREDITO",1,0,'L',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (10,4,"");
$pdf -> Cell (55,4, "ACREEDOR",1,0,'C',1);
$pdf -> Cell (35,4, "VENCIMIENTO",1,0,'C',1);
$pdf -> Cell (40,4, "MONTO ORIGINAL",1,0,'C',1);
$pdf -> Cell (43,4, "SALDO ACTUAL",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.detalle_tarjetas_credito WHERE colaborador = $auxi and mes=$mes_periodo and anio=$anio_periodo ";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (55,4, $tabla["acreedor"],1,0,'C');
$pdf -> Cell (35,4, $tabla["vencimiento"],1,0,'C');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (35,4, poner_comas($tabla["monto_original"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (38,4, poner_comas($tabla["saldo_actual"]),'RTB',0,'R');
$pdf -> Ln(4);
}
$pdf -> Ln(5);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (10,4,"");
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (67,4, "   PASIVO CONTINGENTE",1,0,'L',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (10,4,"");
$pdf -> Cell (68,4, "FIADOR, CODEUDOR O AVALISTA DE",1,0,'C',1);
$pdf -> Cell (48,4, "INSTITUCION",1,0,'C',1);
$pdf -> Cell (25,4, "MONTO",1,0,'C',1);
$pdf -> Cell (32,4, "VENCIMIENTO",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.detalle_pasivo_contingente WHERE colaborador = $auxi and mes=$mes_periodo and anio=$anio_periodo ";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (68,4, $tabla["fiador_de"],1,0,'C');
$pdf -> Cell (48,4, $tabla["institucion"],1,0,'C');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (20,4, poner_comas($tabla["monto"]),'RTB',0,'R');
$pdf -> Cell (32,4, $tabla["vencimiento"],1,0,'C');
$pdf -> Ln(4);
}
$pdf -> Ln(5);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (10,4,"");
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (87,4, "   OBLIGACIONES A CORTO PLAZO (HASTA 1 AÑO)",1,0,'L',1);
$pdf -> Cell (52,4,"");
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (43,4,"DATOS AMORTIZACION",1,0,'C',1);
$pdf -> Ln(4);
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (10,4,"");
$pdf -> Cell (30,4, "ACREEDOR",1,0,'C',1);
$pdf -> Cell (32,4, "GARANTIA",1,0,'C',1);
$pdf -> Cell (25,4, "VENCIMIENTO",1,0,'C',1);
$pdf -> Cell (25,4, "MONTO ORIG",1,0,'C',1);
$pdf -> Cell (27,4, "SALDO ACTUAL",1,0,'C',1);
$pdf -> Cell (23,4, "FRECUENCIA",1,0,'C',1);
$pdf -> Cell (20,4, "MONTO",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.detalle_obligaciones_corto_plazo WHERE colaborador = $auxi and mes=$mes_periodo and anio=$anio_periodo ";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (30,4, $tabla["acreedor"],1,0,'C');
$pdf -> Cell (32,4, $tabla["garantia"],1,0,'C');
$pdf -> Cell (25,4, $tabla["vencimiento"],1,0,'C');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (20,4, poner_comas($tabla["monto_original"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (22,4, poner_comas($tabla["saldo_actual"]),'RTB',0,'R');
$pdf -> Cell (23,4, $tabla["frecuencia"],1,0,'C');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (15,4, poner_comas($tabla["monto_amortizacion"]),'RTB',0,'R');
$pdf -> Ln(4);
}
$pdf -> Ln(5);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (10,4,"");
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (87,4, "   OBLIGACIONES A LARGO PLAZO (MAS DE 1 AÑO)",1,0,'L',1);
$pdf -> Cell (52,4,"");
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (43,4,"DATOS AMORTIZACION",1,0,'C',1);
$pdf -> Ln(4);
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (10,4,"");
$pdf -> Cell (43,4, "ACREEDOR",1,0,'C',1);
$pdf -> Cell (19,4, "GARANTIA",1,0,'C',1);
$pdf -> Cell (25,4, "VENCIMIENTO",1,0,'C',1);
$pdf -> Cell (25,4, "MONTO ORIG",1,0,'C',1);
$pdf -> Cell (27,4, "SALDO ACTUAL",1,0,'C',1);
$pdf -> Cell (23,4, "FRECUENCIA",1,0,'C',1);
$pdf -> Cell (20,4, "MONTO",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.detalle_obligaciones_largo_plazo WHERE colaborador = $auxi and mes=$mes_periodo and anio=$anio_periodo ";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (43,4, $tabla["acreedor"],1,0,'C');
$pdf -> Cell (19,4, $tabla["garantia"],1,0,'C');
$pdf -> Cell (25,4, $tabla["vencimiento"],1,0,'C');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (20,4, poner_comas($tabla["monto_original"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (22,4, poner_comas($tabla["saldo_actual"]),'RTB',0,'R');
$pdf -> Cell (23,4, $tabla["frecuencia"],1,0,'C');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (15,4, poner_comas($tabla["monto_amortizacion"]),'RTB',0,'R');
$pdf -> Ln(4);
}
$pdf -> Ln(8);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (10,4,"");
$pdf -> Cell (51,4," ");
$pdf -> Cell (70,4, "PROYECCION DE INGRESOS Y EGRESOS",0,0,'C',1);
$pdf -> Ln(8);
$pdf -> Cell(46,4);
$pdf -> Cell(44,4,"INGRESOS", 1,0,'C',1);
$pdf -> Cell(58,4);
$pdf -> Cell(44,4,"EGRESOS", 1,0,'C',1);
$pdf -> Ln(4);
$pdf -> Cell(46,4);
$pdf -> Cell(22,4,"Mensuales", 1,0,'C',1);
$pdf -> Cell(22,4,"Anuales", 1,0,'C',1);
$pdf -> Cell(58,4);
$pdf -> Cell(22,4,"Mensuales", 1,0,'C',1);
$pdf -> Cell(22,4,"Anuales", 1,0,'C',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (41,4, "Sueldos y Salarios:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["sueldos_salarios"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["sueldos_salarios"]*12),'RTB',0,'R');
$pdf -> Cell (15,4, "");
$pdf -> Cell (38,4, "Gastos Personales:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["gastos_personales"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["gastos_personales"]*12),'RTB',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (41,4, "Bonificaciones:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["bonificaciones"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["bonificaciones"]*12),'RTB',0,'R');
$pdf -> Cell (15,4, "");
$pdf -> Cell (38,4, "Gastos Familiares:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["gastos_familiares"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["gastos_familiares"]*12),'RTB',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (41,4, "Alquileres y/o rentas:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["alquileres_rentas"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["alquileres_rentas"]*12),'RTB',0,'R');
$pdf -> Cell (15,4, "");
$pdf -> Cell (38,4, "Descuentos salariales:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["descuentos_salariales"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["descuentos_salariales"]*12),'RTB',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (41,4, "Jubilaciones y/o pensiones:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["jubilaciones_pensiones"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["jubilaciones_pensiones"]*12),'RTB',0,'R');
$pdf -> Cell (15,4, "");
$pdf -> Cell (38,4, "Amortización de créditos:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["amortizacion_creditos"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["amortizacion_creditos"]*12),'RTB',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (41,4, "Bono 14 y Aguinaldo:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, "0.00",'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["bono14_aguinaldo"]),'RTB',0,'R');
$pdf -> Cell (15,4, "");
$pdf -> Cell (38,4, "Pago Tarjetas de Crédito:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["pago_tarjetas_credito"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["pago_tarjetas_credito"]*12),'RTB',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (41,4, "Otros Ingresos:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["otros_ingresos"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["otros_ingresos"]*12),'RTB',0,'R');
$pdf -> Cell (15,4, "");
$pdf -> Cell (38,4, "Otros egresos:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["otros_egresos"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["otros_egresos"]*12),'RTB',0,'R');
$pdf -> Ln(4);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (41,4, "Total de Ingresos:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB',0,'L',1);
$pdf -> Cell (17,4, poner_comas($data3["total_ingresos"]),'RTB',0,'R',1);
$pdf -> Cell (5,4, "Q.",'LTB',0,'L',1);
$pdf -> Cell (17,4, poner_comas(($data3["total_ingresos"]*12)+$data3["bono14_aguinaldo"]),'RTB',0,'R',1);
$pdf -> Cell (15,4, "");
$pdf -> Cell (38,4, "Total de egresos:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB',0,'L',1);
$pdf -> Cell (17,4, poner_comas($data3["total_egresos"]),'RTB',0,'R',1);
$pdf -> Cell (5,4, "Q.",'LTB',0,'L',1);
$pdf -> Cell (17,4, poner_comas($data3["total_egresos"]*12),'RTB',0,'R',1);
$pdf -> Ln(10);
$pdf -> SetY(250);
$pdf -> SetFont('Times', 'BI', 10);
$pdf -> Cell (0,0, "_________________________________________________",0,0,'C',0);
$pdf -> Ln(4);
	if ($data1["ApellidoCasada"] == NULL) {
		$pdf -> Cell (0,0, $data1["Nombre1"]." ".$data1["Nombre2"]." ".$data1["Apellido1"]." ".$data1["Apellido2"],0,0,'C',0);
	}else {
		$pdf -> Cell (0,0, $data1["Nombre1"]." ".$data1["Nombre2"]." ".$data1["Apellido1"]." ".$data1["Apellido2"]." de ".$data1["ApellidoCasada"],0,0,'C',0);
	}
// **** CREACION DEL PDF ****
$pdf -> Output();
?>