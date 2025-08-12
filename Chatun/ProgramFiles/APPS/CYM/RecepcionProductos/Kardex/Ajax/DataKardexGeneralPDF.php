<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
include("../../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../../libs/ezpdf/class.ezpdf.php");

$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$FechaInicio = $_GET["FechaInicio"];
$FechaFin = $_GET["FechaFin"]; 



$pdf = new Cezpdf('legal','landscape');
$pdf->selectFont('../../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Kardex - ".$NomBodega,16,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);

/*TITULOS*/
$Titulo = array('col1'=>utf8_decode('#'), 'col2'=>'Codigo', 'col3'=>'Codigo Transacción', 
'col4'=>'Fecha', 'col5'=>'Hora', 'col6'=>'Nombre', 'col7'=>'Descripcion', 'col8'=>'Cantidad', 'col9'=>'Existencia General Anterior',
'col10'=>'Existencia General Actual', 'col11'=>'Punto de Venta', 'col12'=>'Existencia Punto Anterior', 'col13'=>'Existencia Punto Actual',
'col14'=>'Costo Anterior', 'col15'=>'Costo Entro', 'col16'=>'Costo Ponderado');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>4, 'width'=>'10', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/


$Correlativo=1;

$NomTitulo = mysqli_query($db, "SELECT KARDEX.*, PRODUCTO.P_NOMBRE, PUNTO_VENTA.PV_NOMBRE
FROM Productos.KARDEX, Productos.PRODUCTO, CompraVenta.PUNTO_VENTA
WHERE KARDEX.P_CODIGO = PRODUCTO.P_CODIGO
AND PUNTO_VENTA.PV_CODIGO = KARDEX.K_PUNTO_VENTA
AND KARDEX.K_FECHA BETWEEN '$FechaInicio' AND '$FechaFin'
ORDER BY KARDEX.K_FECHA");
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $Cod=$row1["K_CODIGO"];
			$CodTra=$row1["TRA_CODIGO"];
            $Fecha=$row1["K_FECHA"];
            $Hora=$row1["K_HORA"];
            $Descripcion=$row1["K_DESCRPCION"];
            $ExiGAnt=$row1["K_EXISTENCIA_ANTERIOR"];
			$ExiGAct=$row1["K_EXISTENCIA_ACTUAL"];
            $ExiPAnt=$row1["K_EXISTENCIA_ANTERIOR_PUNTO"];
			$ExiPAct=$row1["K_EXISTENCIA_ACTUAL_PUNTO"];
			$CostoAn=$row1["K_COSTO_ANTERIOR"];
			$CostoEn=$row1["K_COSTO_ENTRO"];
			$CostoPo=$row1["K_COSTO_PONDERADO"];
			$Punto=$row1["PV_NOMBRE"];
			$Prod=$row1["P_NOMBRE"];
			
			if($row1["K_EXISTENCIA_ANTERIOR_PUNTO"]>$row1["K_EXISTENCIA_ACTUAL_PUNTO"]){

				$Cantidad=$row1["K_EXISTENCIA_ANTERIOR_PUNTO"]-$row1["K_EXISTENCIA_ACTUAL_PUNTO"];
			}else{
				$Cantidad=$row1["K_EXISTENCIA_ACTUAL_PUNTO"]-$row1["K_EXISTENCIA_ANTERIOR_PUNTO"];
			}

$Data[] = array('col1'=>$Correlativo, 'col2'=> $Cod, 'col3'=>$CodTra, 
'col4'=>date($Fecha), 'col5'=>date($Hora), 'col6'=>$Prod, 'col7'=>$Descripcion, 'col8'=>number_format($Cantidad, 2, ".", ""), 'col9'=>number_format($ExiGAnt, 2, ".", ""),
'col10'=>number_format($ExiGAct, 2, ".", ""), 'col11'=>$Punto, 'col12'=>number_format($ExiPAnt, 2, ".", ""), 'col13'=>number_format($ExiPAct, 2, ".", ""),
'col14'=>number_format($CostoAn, 2, ".", ""), 'col15'=>number_format($CostoEn, 2, ".", ""), 'col16'=>number_format($CostoPo, 2, ".", ""));
		$Correlativo+=1;

 
	
	}


	$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();

?>

		    

