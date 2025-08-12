<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));
$CostoTotalSuma = 0;

$Anho = $_POST["Anho"];
$Mes = $_POST["Mes"];
$NombreMes = nombre_mes($Mes);

function _data_last_month_day($Mes, $Anho) { 
	$month = $Mes;
	$year = $Anho;
	$day = date("d", mktime(0,0,0, $month+1, 0, $year));

	return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
};

/** Actual month first day **/
function _data_first_month_day($Mes, $Anho) {
	$month = $Mes;
	$year = $Anho;
	return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
}

$PrimerDiaMes = _data_first_month_day($Mes, $Anho);
$PrimerDiaMesF = date('Y-m-d', strtotime($PrimerDiaMes));

$UltimoDiaMes = _data_first_month_day($Mes, $Anho);
$UltimoDiaMesF = date('Y-m-d', strtotime($UltimoDiaMes));



$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Ingreso de Asociados del Mes de ".$NombreMes." de ".$Anho,16,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>utf8_decode('Código'), 'col2'=>'Nombre', 'col3'=>'Unidad de Medida', 'col4'=>'Cantidad', 'col5'=>'Costo Unitario', 'col6'=>'Costo Total');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/


//QUERY PARA TRAER TODO EL MOVIMIENTO DE LAS CUENTAS EN EL RANGO DE FECHAS SELECCIONADO
$QueryCuentas = "SELECT * FROM ";
$ResultCuentas = mysqli_query($db, $QueryCuentas);
while($row = mysqli_fetch_array($ResultCuentas))
{
        
}

$Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'<b>TOTAL</b>', 'col6'=>number_format($CostoTotalSuma, 4, '.', ','));


$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>