<?php 
require ('../Script/fpdf.php');

include("../../../../../Script/conex.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
$auxi=$_POST["cif"];
$sql_periodo = "SELECT * FROM Estado_Patrimonial.periodo order by id desc limit 1 ";
$result_periodo = mysqli_query($db, $sql_periodo) or die("".mysqli_error());
$row_periodo=mysqli_fetch_array($result_periodo); 
$mes_periodo=$row_periodo[1];
$anio_periodo=$row_periodo[2];
//************** CONEXCION CON LA BASE DE DATOS ************** //
//************** CONEXCION CON LA BASE DE DATOS ************** //
session_start();
//$auxi=$_SESSION["cuenta"];
$sql="SELECT * FROM Estado_Patrimonial.empleados WHERE id=$auxi";
$result = mysqli_query($db, $sql);
$data1=mysqli_fetch_array($result) or die(mysqli_error());
$sql = "SELECT * FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE id = $auxi AND fecha = (SELECT MAX(fecha) FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE id = $auxi)";
$result=mysqli_query($db, $sql);
$data2=mysqli_fetch_array($result) or die(mysqli_error());
$sql = "SELECT * FROM Estado_Patrimonial.proyeccion_ingresos_egresos_detalle WHERE colaborador = $auxi AND fecha = (SELECT MAX(fecha) FROM Estado_Patrimonial.proyeccion_ingresos_egresos_detalle WHERE colaborador = $auxi) ";
$result=mysqli_query($db, $sql);
$data3=mysqli_fetch_array($result) or die(mysqli_error());
$ano_actual=date('Y');
$ano_actual=$ano_actual-1;

//Saber Total de Terrenos y Construcciones
$Consulta = mysqli_query($db, "SELECT SUM(valor_mercado) as TOTAL FROM Estado_Patrimonial.bienes_inmuebles_detalle WHERE colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
	if($row["TOTAL"] == '')
	{
		$TotalTerrenos = 0;
	}
	else
	{
    	$TotalTerrenos = $row["TOTAL"];
	}
}

//Saber Total de Vehículos
$Consulta = mysqli_query($db, "SELECT SUM(valor_vehiculo) as TOTAL FROM Estado_Patrimonial.vehiculos_detalle WHERE colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$TotalVehiculos = 0;
	}
	else
	{
    	$TotalVehiculos = $row["TOTAL"];
	}                  
}

//Saber Total de Inversiones
$Consulta = mysqli_query($db, "SELECT SUM(valor_comercial) as TOTAL FROM Estado_Patrimonial.valor_acciones_detalle WHERE colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$TotalInversiones = 0;
	}
	else
	{
    	$TotalInversiones = $row["TOTAL"];
	}                    
}

//Saber Total de Prestamos Coosajo menores a 1 año
$Consulta = mysqli_query($db, "SELECT SUM(saldo_actual) as TOTAL FROM Estado_Patrimonial.obligaciones_detalle WHERE entidad_financiera = 'Coosajo R.L.' AND colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$TotalPCM = 0;
	}
	else
	{
    	$TotalPCM = $row["TOTAL"];
	}                   
}

//Saber Total de Prestamos otros bancos menores a 1 año
$Consulta = mysqli_query($db, "SELECT SUM(saldo_actual) as TOTAL FROM Estado_Patrimonial.obligaciones_detalle WHERE entidad_financiera = 'Bancos' AND colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$TotalPBM = 0;
	}
	else
	{
    	$TotalPBM = $row["TOTAL"];
	}                   
}

//Saber Total de Saldos en Tarjeta de Crédito
$Consulta = mysqli_query($db, "SELECT SUM(saldo_actual) as TOTAL FROM Estado_Patrimonial.tarjetas_credito_detalle WHERE colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$TotalTarjetas = 0;
	}
	else
	{
    	$TotalTarjetas = $row["TOTAL"];
	}                    
}

//Saber Total de Prestamos Bancos Mayores a 1 año
$Consulta = mysqli_query($db, "SELECT SUM(saldo_actual) as TOTAL FROM Estado_Patrimonial.obligacioneslp_detalle WHERE entidad_financiera = 'Bancos' AND colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$TotalPBMA = 0;
	}
	else
	{
    	$TotalPBMA = $row["TOTAL"];
	}                   
}

//Saber Total de Prestamos Bancos Mayores a 1 año
$Consulta = mysqli_query($db, "SELECT SUM(saldo_actual) as TOTAL FROM Estado_Patrimonial.obligacioneslp_detalle WHERE entidad_financiera = 'Coosajo R.L.' AND colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$TotalPCMA = 0;
	}
	else
	{
    	$TotalPCMA = $row["TOTAL"];
	}                   
}


//Total Activo Circulante
$TotalActivoCirculante = $data2["caja"] + $data2["depositos_coosajo"] + $data2["depositos_bancos"] + $data2["fondo_retiro"] + $data2["cuentas_cobrar"];

//Total Activo Fijo
$TotalActivoFijo = $TotalTerrenos + $TotalVehiculos + $TotalInversiones + $data2["mobiliario"] + $data2["inversiones_ganado"] + $data2["otros_activos"]; 

//Total Activo
$TotalActivo = $TotalActivoCirculante + $TotalActivoFijo;

//Total de Pasivo Circulante
$TotalPasivoCirculante = $TotalPCM + $TotalPBM + $data2["anticipo_sueldo"] + $data2["otros_prestamos"] + $TotalTarjetas + $data2["cuentas_por_pagar"] + $data2["proveedores"] + $data2["otros_pasivocirculante"];

//Total de Pasivo Fijo
$TotalPasivoFijo = $TotalPBMA + $TotalPCMA + $data2["otras_deudas"];

//Total de Pasivo
$TotalPasivo = $TotalPasivoCirculante + $TotalPasivoFijo;

//Total Patrimonio
$Patrimonio = $TotalActivo - $TotalPasivo;

//Total Patrimonio Pasivo
$PatrimonioPasivo = $Patrimonio + $TotalPasivo;



//Total de Otros Ingresos
$Consulta = mysqli_query($db, "SELECT SUM(monto) as TOTAL FROM Estado_Patrimonial.otros_ingresos_detalle WHERE colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$TotalOtrosIngresos = 0;
	}
	else
	{
    	$TotalOtrosIngresos = $row["TOTAL"];
	}                    
}

//Total de Otros Egresos
$Consulta = mysqli_query($db, "SELECT SUM(monto) as TOTAL FROM Estado_Patrimonial.otros_egresos_detalle WHERE colaborador =  ".$auxi);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$TotalOtrosEgresos = 0;
	}
	else
	{
    	$TotalOtrosEgresos = $row["TOTAL"];
	}                    
}


//Total de Ingresos en Proyeccion de ingresos egresos
$TotalIngresosP = $data3["sueldos_salarios"] + $data3["bonificaciones"] + $data3["alquileres_rentas"] + $data3["jubilaciones_pensiones"] + $TotalOtrosIngresos;

//Total de Egresos en Proyeccion de Ingresos egresos
$TotalEgresosP = ($data3["gastos_personales"]) + ($data3["gastos_familiares"]) + ($data3["descuentos_salariales"]) + ($data3["amortizacion_creditos"]) + ($data3["pago_tarjetas_credito"]) + ($TotalOtrosEgresos);

//************** DEFINICIÓN DEL PDF  ************** //
$pdf = new FPDF('p', 'mm', 'letter');
$pdf -> AliasNbPages(); 
$pdf -> SetTopMargin(10);
$pdf -> AddPage();
//****ENCABEZADO EN PLUGGINS FPDF****							
$pdf -> SetFont('Times', 'B', 14);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (0,7, "ESTADO PATRIMONIAL, ".fecha_ive(date('Y-m-d')),1,1,'C',1);
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
$pdf -> Cell (15,4,utf8_decode("Depósitos en Coosajo:"));
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["depositos_coosajo"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,utf8_decode("Depósitos en Bancos:"));
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
$pdf -> Cell (15,4,"Cuentas y documentos por cobrar:");
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
$pdf -> Cell (25,4, poner_comas($TotalActivoCirculante),'RBT',0,'R',1);
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
$pdf -> Cell (25,4, poner_comas($TotalTerrenos),'RT',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,utf8_decode("Vehículos:"));
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($TotalVehiculos),'R',0,'R');
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
$pdf -> Cell (25,4, poner_comas($TotalInversiones),'R',0,'R');
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
$pdf -> Cell (25,4, poner_comas($TotalActivoFijo),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (15,4,"TOTAL DEL ACTIVO");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($TotalActivo),'RBT',0,'R',1);
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
$pdf -> Cell (15,4,utf8_decode("Préstamos en Coosajo, R.L.(menores a 1 año):"));
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'LT',0,'L');
$pdf -> Cell (25,4, poner_comas($TotalPCM),'RT',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,utf8_decode("Préstamos en otros Bancos (menores a 1 año):"));
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($TotalPBM),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,"Anticipo de Sueldo:");
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["anticipo_sueldo"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,utf8_decode("Otros préstamos:"));
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["otros_prestamos"]),'R',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,utf8_decode("Tarjetas de Crédito (saldos):"));
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'L',0,'L');
$pdf -> Cell (25,4, poner_comas($TotalTarjetas),'R',0,'R');
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
$pdf -> Cell (25,4, poner_comas($TotalPasivoCirculante),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> SetTextColor(0,0,0);
$pdf -> Cell (20,4,"");
$pdf -> Cell (43,4, "FIJO",0,0,'L',0);
$pdf -> Ln(4);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,utf8_decode("Préstamos en Coosajo, R.L. (mayores a 1 año):"));
$pdf -> Cell (70,4,"");
$pdf -> Cell (5,4, "Q.",'LT',0,'L');
$pdf -> Cell (25,4, poner_comas($data2["prestamos_coosajo_mayores"]),'RT',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (30,4,"");
$pdf -> Cell (15,4,utf8_decode("Préstamos en Bancos (mayores a 1 año):"));
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
$pdf -> Cell (25,4, poner_comas($TotalPasivoFijo),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (15,4,"TOTAL DEL PASIVO");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($TotalPasivo),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (15,4,"PATRIMONIO (ACTIVO - PASIVO)");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($Patrimonio),'RBT',0,'R',1);
$pdf -> Ln(8);
$pdf -> Cell (30,4,"");
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (15,4,"TOTAL PASIVO + PATRIMONIO");
$pdf -> Cell (70,4,"");
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (5,4, "Q.",'LBT',0,'L',1);
$pdf -> Cell (25,4, poner_comas($PatrimonioPasivo),'RBT',0,'R',1);
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
$pdf -> Cell (50,4, utf8_decode("Declaro bajo juramento que la información proporcionada en este Estado Patrimonial y sus Anexos contienen la"),0,0,'L',0);
$pdf -> Ln(4);
$pdf -> Cell (10,0, "");
$pdf -> Cell (50,4, utf8_decode("información real de mi patrimonio. Y conozco de la implicaciones legales por la falsedad que en ella se observe,"),0,0,'L',0);
$pdf -> Ln(4);
$pdf -> Cell (10,0, "");
$pdf -> Cell (50,4, utf8_decode("en consecuencia del delito de PERJURIO Articulo 459 del Decreto 17-73 Código Penal."),0,0,'L',0);
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
$pdf -> Cell (0,7, "DETALLE DEL ESTADO PATRIMONIAL, ".fecha_ive(date('Y-m-d')),1,1,'C',1);
$pdf -> Ln(4);
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (10,4,"");
$pdf -> Cell (70,4, "   DETALLE DE BIENES INMUEBLES",1,0,'L',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (10,4,"");
$pdf -> Cell (55,4, utf8_decode("LOCALIZACIÓN"),1,0,'C',1);
$pdf -> Cell (15,4, "FINCA",1,0,'C',1);
$pdf -> Cell (15,4, "FOLIO",1,0,'C',1);
$pdf -> Cell (15,4, "LIBRO",1,0,'C',1);
$pdf -> Cell (35,4, "DEPARTAMENTO",1,0,'C',1);
$pdf -> Cell (38,4, "VALOR DE MERCADO",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.bienes_inmuebles_detalle WHERE colaborador = $auxi";
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
$pdf -> Cell (60,4, utf8_decode("   DETALLE DE VEHÍCULOS"),1,0,'L',1);
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
	$sql = "SELECT * FROM Estado_Patrimonial.vehiculos_detalle WHERE colaborador = $auxi";
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
$pdf -> Cell (53,4, utf8_decode("CLASE DE TÍTULO"),1,0,'C',1);
$pdf -> Cell (50,4, utf8_decode("INSTITUCIÓN O EMPRESA"),1,0,'C',1);
$pdf -> Cell (35,4, "MONTO INVERTIDO",1,0,'C',1);
$pdf -> Cell (35,4, "VALOR COMERCIAL",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.valor_acciones_detalle WHERE colaborador = $auxi";
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
$pdf -> Cell (55,4, utf8_decode("   TARJETAS DE CRÉDITO"),1,0,'L',1);
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
	$sql = "SELECT * FROM Estado_Patrimonial.tarjetas_credito_detalle WHERE colaborador = $auxi";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (55,4, $tabla["acreedor"],1,0,'C');
$pdf -> Cell (35,4, date('d-m-Y', strtotime($tabla["vencimiento"])),1,0,'C');
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
$pdf -> Cell (48,4, utf8_decode("INSTITUCIÓN"),1,0,'C',1);
$pdf -> Cell (25,4, "MONTO",1,0,'C',1);
$pdf -> Cell (32,4, "VENCIMIENTO",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.detalle_pasivo_contingente WHERE colaborador = $auxi";
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
$pdf -> Cell (87,4, utf8_decode("   OBLIGACIONES A CORTO PLAZO (HASTA 1 AÑO)"),1,0,'L',1);
$pdf -> Cell (52,4,"");
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (43,4,utf8_decode("DATOS AMORTIZACIÓN"),1,0,'C',1);
$pdf -> Ln(4);
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (10,4,"");
$pdf -> Cell (30,4, "ACREEDOR",1,0,'C',1);
$pdf -> Cell (32,4, utf8_decode("GARANTÍA"),1,0,'C',1);
$pdf -> Cell (25,4, "VENCIMIENTO",1,0,'C',1);
$pdf -> Cell (25,4, "MONTO ORIGINAL",1,0,'C',1);
$pdf -> Cell (27,4, "SALDO ACTUAL",1,0,'C',1);
$pdf -> Cell (23,4, "FRECUENCIA",1,0,'C',1);
$pdf -> Cell (20,4, "MONTO",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.obligaciones_detalle WHERE colaborador = $auxi";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (30,4, $tabla["acreedor"],1,0,'C');
$pdf -> Cell (32,4, $tabla["garantia"],1,0,'C');
$pdf -> Cell (25,4, date('d-m-Y', strtotime($tabla["vencimiento"])),1,0,'C');
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
$pdf -> Cell (87,4, utf8_decode("   OBLIGACIONES A LARGO PLAZO (MAS DE 1 AÑO)"),1,0,'L',1);
$pdf -> Cell (52,4,"");
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFillColor(233,233,233);
$pdf -> Cell (43,4,utf8_decode("DATOS AMORTIZACIÓN"),1,0,'C',1);
$pdf -> Ln(4);
$pdf -> SetFont('Times', 'IB', 9);
$pdf -> Cell (10,4,"");
$pdf -> Cell (43,4, "ACREEDOR",1,0,'C',1);
$pdf -> Cell (19,4, utf8_decode("GARANTÍA"),1,0,'C',1);
$pdf -> Cell (25,4, "VENCIMIENTO",1,0,'C',1);
$pdf -> Cell (25,4, "MONTO ORIGINAL",1,0,'C',1);
$pdf -> Cell (27,4, "SALDO ACTUAL",1,0,'C',1);
$pdf -> Cell (23,4, "FRECUENCIA",1,0,'C',1);
$pdf -> Cell (20,4, "MONTO",1,0,'C',1);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', '', 8);
$pdf -> Ln(4);
	$sql = "SELECT * FROM Estado_Patrimonial.obligacioneslp_detalle WHERE colaborador = $auxi";
	$result=mysqli_query($db, $sql);
	while ($tabla=mysqli_fetch_array($result)) 	{ 
$pdf -> Cell (10,4,"");
$pdf -> Cell (43,4, $tabla["acreedor"],1,0,'C');
$pdf -> Cell (19,4, $tabla["garantia"],1,0,'C');
$pdf -> Cell (25,4, date('d-m-Y', strtotime($tabla["vencimiento"])),1,0,'C');
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
$pdf -> Cell (70,4, utf8_decode("PROYECCIÓN DE INGRESOS Y EGRESOS"),0,0,'C',1);
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
$pdf -> Cell (38,4, utf8_decode("Amortización de créditos:"),0,0,'L',0);
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
$pdf -> Cell (38,4, utf8_decode("Pago Tarjetas de Crédito:"),0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["pago_tarjetas_credito"]),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($data3["pago_tarjetas_credito"]*12),'RTB',0,'R');
$pdf -> Ln(4);
$pdf -> Cell (41,4, "Otros Ingresos:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($TotalOtrosIngresos),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($TotalOtrosIngresos*12),'RTB',0,'R');
$pdf -> Cell (15,4, "");
$pdf -> Cell (38,4, "Otros egresos:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($TotalOtrosEgresos),'RTB',0,'R');
$pdf -> Cell (5,4, "Q.",'LTB');
$pdf -> Cell (17,4, poner_comas($TotalOtrosEgresos*12),'RTB',0,'R');
$pdf -> Ln(4);
$pdf -> SetFillColor(233,233,233);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (41,4, "Total de Ingresos:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB',0,'L',1);
$pdf -> Cell (17,4, poner_comas($TotalIngresosP),'RTB',0,'R',1);
$pdf -> Cell (5,4, "Q.",'LTB',0,'L',1);
$pdf -> Cell (17,4, poner_comas(($TotalIngresosP*12)+$data3["bono14_aguinaldo"]),'RTB',0,'R',1);
$pdf -> Cell (15,4, "");
$pdf -> Cell (38,4, "Total de egresos:",0,0,'L',0);
$pdf -> Cell (5,4, "");
$pdf -> Cell (5,4, "Q.",'LTB',0,'L',1);
$pdf -> Cell (17,4, poner_comas($TotalEgresosP),'RTB',0,'R',1);
$pdf -> Cell (5,4, "Q.",'LTB',0,'L',1);
$pdf -> Cell (17,4, poner_comas($TotalEgresosP*12),'RTB',0,'R',1);
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
// 


$pdf -> Output();
?>