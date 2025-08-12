<?php
ob_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));


/*TITULOS TABLA DE ACTIVOS*/
    $Titulo = array('col1'=>utf8_decode('Código'), 'col2'=>utf8_decode('Descripción'), 'col3'=>utf8_decode('Área'), 'col4'=>utf8_decode('Clasficación'), 'col5'=>utf8_decode('Fecha Adquisición'), 'col6'=>utf8_decode('Valor Adquisición'), 'col7'=>utf8_decode('Valor Actual'));
/*FIN TITULOS TABLA DE ACTIVOS*/

/*OPCIONES TABLA DE ACTIVOS*/
    $Opciones = array('fontSize'=>8, 'maxWidth'=>'560', 'shaded'=>1, 'showBgCol'=>1);
/*FIN OPCIONES TABLA DE ACTIVOS*/

$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezStartPageNumbers(550,20,10,'','',1); 
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Activos Dados de Baja",14,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 20);

	$i = 0;
	$TotalValorAdquisicion = 0;
	$TotalValorActual = 0;
	unset($Data);
	$pdf->ezText("", 15);


	$query = "SELECT ACTIVO_FIJO.*, AREA_GASTO.AG_NOMBRE, TIPO_ACTIVO.TA_NOMBRE, TRANSACCION.TRA_FECHA_TRANS
			FROM Contabilidad.ACTIVO_FIJO, Contabilidad.AREA_GASTO, Contabilidad.TIPO_ACTIVO , Contabilidad.TRANSACCION
			WHERE ACTIVO_FIJO.AF_AREA = AREA_GASTO.AG_CODIGO
			AND ACTIVO_FIJO.TA_CODIGO = TIPO_ACTIVO.TA_CODIGO
			AND ACTIVO_FIJO.AF_TRANSACCION = TRANSACCION.TRA_CODIGO
			AND ACTIVO_FIJO.AF_ESTADO = 2";
	$result = mysqli_query($db,$query);
	while($row = mysqli_fetch_array($result))
	{
		$TotalValorAdquisicion = $TotalValorAdquisicion + $row["AF_VALOR"];
		$TotalValorActual = $TotalValorActual + $row["AF_VALOR_ACTUAL"];
	    $Data[] = array('col1'=>$row["AF_CODIGO"], 'col2'=>utf8_decode($row["AF_NOMBRE"]), 'col3'=>utf8_decode($row["AG_NOMBRE"]), 'col4'=>utf8_decode($row["TA_NOMBRE"]), 'col5'=>date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"])), 'col6'=>number_format($row["AF_VALOR"], 2, '.', ','), 'col7'=>number_format($row["AF_VALOR_ACTUAL"], 2, '.', ','));
	    $i++;
	}

	$Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'Total de Activos:   '.$i, 'col6'=>number_format($TotalValorAdquisicion, 2, '.', ','), 'col7'=>number_format($TotalValorActual, 2, '.', ','));

	$pdf->ezTable($Data, $Titulo,'', $Opciones);

	$pdf->ezText("", 30);

ob_clean();
$pdf->ezStream();
?>