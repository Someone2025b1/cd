<?php 
require ('../Script/fpdf.php');
include("../Script/seguridad.php");
include("../Script/conex.php");
//************** CONEXCION CON LA BASE DE DATOS ************** //
function edad($fecha_nac){
//Esta funcion toma una fecha de nacimiento 
//desde una base de datos mysql
//en formato aaaa/mm/dd y calcula la edad en números enteros 
$dia=date("j");
$mes=date("n");
$anno=date("Y"); //descomponer fecha de nacimiento
$dia_nac=substr($fecha_nac, 8, 2);
$mes_nac=substr($fecha_nac, 5, 2);
$anno_nac=substr($fecha_nac, 0, 4);
if($mes_nac>$mes){
$calc_edad= $anno-$anno_nac-1;
}else{
if($mes==$mes_nac AND $dia_nac>$dia){
$calc_edad= $anno-$anno_nac-1; 
}else{
$calc_edad= $anno-$anno_nac;
}
}
return $calc_edad;
}
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
$auxi=$_SESSION["cuenta"];
$sql="SELECT * FROM coosajo_base_colaboradores.empleados WHERE id=$auxi";
$result = mysqli_query($db, $sql);
$data1=mysqli_fetch_array($result) or die(mysqli_error());
$sql = "SELECT * FROM Estado_Patrimonial.detalle_estado_patrimonial WHERE id = $auxi";
$result=mysqli_query($db, $sql);
$data2=mysqli_fetch_array($result) or die(mysqli_error());
//************** DEFINICIÓN DEL PDF  ************** //
$pdf = new FPDF('p', 'mm', 'letter');
$pdf -> AliasNbPages(); 
$pdf -> SetTopMargin(10);
$pdf -> AddPage();
//****ENCABEZADO EN PLUGGINS FPDF****							
$pdf -> SetFont('Times', 'B', 14);
$pdf -> SetTextColor(255,255,255);
$pdf -> SetFillColor(0,0,0);
$pdf -> Cell (0,7, "ACTUALIZACION SOCIO ECONÓMICA",1,1,'C',1);
$pdf -> Ln(4);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (5,4,"");
$pdf -> Cell (43,4, "1.- DATOS GENERALES:",0,0,'L',1);
$pdf -> Ln(4);
$pdf -> SetTextColor(0,0,0);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (48,4, "NOMBRE:",0,0,'R',0);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (71,4, $data1["Apellido1"]." ".$data1["Apellido2"],1,0,'C',0);
$pdf -> Cell (71,4, $data1["Nombre1"]." ".$data1["Nombre2"],1,0,'C',0);
$pdf -> Ln(4);
$pdf -> SetFont('Times', 'I', 5);
$pdf -> Cell (48,2, "",0,0,'R',0);
$pdf -> Cell (71,2, "Apellidos",0,0,'C',0);
$pdf -> Cell (71,2, "Nombres",0,0,'C',0);
$pdf -> Ln(8);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (48,4, "FECHA NACIMIENTO:",0,0,'R',0);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (35,4, $data1["FechaNacimiento"],1,0,'',0);


$pdf -> Cell (13,4, "",0,0,'R',0);
$pdf -> Cell (30,4, "EDAD:",0,0,'C',0);
$pdf -> Cell (13,4, "",0,0,'R',0);
$pdf -> Cell (33,4, "SEXO",0,0,'C',0);
$pdf -> Cell (13,4, "",0,0,'R',0);
$pdf -> Cell (38,4, "ESTADO CIVIL",0,0,'C',0);
$pdf -> Ln(4);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (5,4,"");
$pdf -> Cell (45,4, $data1["FechaNacimiento"],1,0,'C',0);
$pdf -> Cell (13,4, "",0,0,'R',0);
$pdf -> Cell (30,4, edad($data1["FechaNacimiento"]),1,0,'C',0);
$pdf -> Cell (13,4, "",0,0,'R',0);
	switch($data1["Sexo"]) {
		case "M":
			$sexo = "Masculino";
			
		case "F":
			$sexo = "Femenino";
			
	}
$pdf -> Cell (33,4, $sexo,1,0,'C',0);
$pdf -> Cell (13,4, "",0,0,'R',0);
	switch($data1["EstadoCivil"]) {
		case 0:
			$estado_civil = "Soltero(a)";
			
		case 1:
			$estado_civil = "Casado(a) / Unido";
			
		case 2:
			$estado_civil = "Viudo(a)";
			
		case 3:
			$estado_civil = "Divorciado(a)";
			
	}
$pdf -> Cell (38,4, $estado_civil,1,0,'C',0);
$pdf -> Ln(10);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (5,4,"");
$pdf -> Cell (43,4, "NOMBRE CÓNYUGUE:",0,0,'R',0);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (84,4, $data1["Nombre_conyugue"],1,0,'C',0);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (5,4,"");
$pdf -> Cell (43,4, "NÚMERO DE HIJOS:",0,0,'R',0);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (10,4, $data1["NumeroHijos"],1,0,'C',0);
$pdf -> Ln(10);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (5,4,"");
$pdf -> Cell (43,4, "DIRECCION",0,0,'R',0);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (84,4, $data1["Direccion"],1,0,'C',0);
$pdf -> SetFont('Times', 'IB', 10);
$pdf -> Cell (5,4,"");
$pdf -> Cell (43,4, " NÚMERO DE HIJOS:",0,0,'R',0);
$pdf -> SetFont('Times', '', 10);
$pdf -> Cell (10,4, $data1["NumeroHijos"],1,0,'C',0);
$pdf -> Ln(10);







$pdf -> SetFont('Times', '', 10);
//$pdf -> Cell (70,4, $data1["Apellido1"]." ".$data1["Apellido2"],1,0,'C',0);
//$pdf -> Cell (70,4, $data1["Nombre1"]." ".$data1["Nombre2"],1,0,'C',0);
$pdf -> Ln(4);





$pdf -> Ln(10);
//************************************************* //
$pdf -> SetFont('Times', '', 8);
while ($data=mysqli_fetch_array($result)) {
	$punto_decimal_quetzales = substr($data["importe_q"], -2,2);
	$longitud_cantidad_quetzales = strlen($data["importe_q"]);
	$restante_quetzales = substr($data["importe_q"], 0, ($longitud_cantidad_quetzales-2));
	$cantidad_quetzales = $restante_quetzales.".".$punto_decimal_quetzales;		
	$cant_quet = poner_comas($cantidad_quetzales);
	$punto_decimal_dolar = substr($data["importe_d"], -2,2);
	$longitud_cantidad_dolar = strlen($data["importe_d"]);
	$restante_dolar = substr($data["importe_d"], 0, ($longitud_cantidad_dolar-2));
	$cantidad_dolar = $restante_dolar.".".$punto_decimal_dolar;		
	$cant_dolar = poner_comas($cantidad_dolar);
	$pdf -> Cell (3);
	$pdf -> Cell (5,0, $cuenta_linea_ent,0,0,'C');
	$pdf -> Cell (5);
	$pdf -> Cell (20,0, $data["numero_remesa"],0,0,'L');
	$pdf -> Cell (7);
	$pdf -> Cell (60,0, $data["nombre_beneficiario"],0,0,'L');
	$pdf -> Cell (10);
	$pdf -> Cell (16,0, $cant_dolar,0,0,'R');
	$pdf -> Cell (7);
	$pdf -> Cell (17,0, $cant_quet,0,0,'R');
	$pdf -> Cell (9);
	$pdf -> Cell (9,0, $data["status"],0,0,'C');
	$pdf -> Cell (5);
	$pdf -> Cell (14,0, $data["receptor_pagador"],0,0,'C');
	$pdf -> Ln(4);
	$sumatoria_dolar = $sumatoria_dolar + $data["importe_d"];
	$sumatoria_quetzales = $sumatoria_quetzales + $data["importe_q"];
	$cuenta_linea_ent = $cuenta_linea_ent + 1;
}
$punto_decimal_d = substr($sumatoria_dolar, -2,2);
$longitud_cantidad_d = strlen($sumatoria_dolar);
$restante_d = substr($sumatoria_dolar, 0, ($longitud_cantidad_d-2));
$cantidad_d = $restante_d.".".$punto_decimal_d;		
$sumatoria_dolar_final = poner_comas($cantidad_d);
$punto_decimal_q = substr($sumatoria_quetzales, -2,2);
$longitud_cantidad_q = strlen($sumatoria_quetzales);
$restante_q = substr($sumatoria_quetzales, 0, ($longitud_cantidad_q-2));
$cantidad_q = $restante_q.".".$punto_decimal_q;		
$sumatoria_quetzales_final = poner_comas($cantidad_q);
$pdf -> Ln(5);
$pdf -> Cell (40);
$pdf -> SetFont('Times', 'B', 10);
$pdf -> Cell (50,0, "TOTAL:",0,0,'C');
$pdf -> Cell (20);
$pdf -> Cell (16,0, "$. ".$sumatoria_dolar_final, 0,0,'C');
$pdf -> Cell (5);
$pdf -> Cell (17,0, "Q. ".$sumatoria_quetzales_final, 0,0,'C');
//****
$pdf -> Output();
?>