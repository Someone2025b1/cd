<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Bodega=$_GET["Punto"];
$Fecha=$_GET["Fecha"];
$Codigo=$_GET["Codigo"];
$Tipo1=$_GET["Tipo"];

if($Tipo1==1){
    $Tipo="NOTA DE CARGO";
}else{
    $Tipo="NOTA DE ABONO";
}

$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));



$query = "SELECT * FROM CompraVenta.PUNTO_VENTA WHERE PV_CODIGO=".$Bodega;
		  $result = mysqli_query($db, $query);
		  while($row = mysqli_fetch_array($result))
		  {
			$NomBodega=$row["PV_NOMBRE"];
		  }

$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText($Tipo." - ".$NomBodega." - Con Fecha ".date('d-m-Y',strtotime($Fecha)),16,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);

/*TITULOS*/
$Titulo = array('col1'=>utf8_decode('Código'), 'col2'=>'Nombre', 'col3'=>'Unidad de Medida', 'col4'=>'Cantidad', 'col5'=>'Costo Unitario', 'col6'=>'Costo Total');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/


    

    $NomTitulo = mysqli_query($db, "SELECT NOTAS_CARGO_ABONO_DETALLE.*, PRODUCTO.P_NOMBRE, PRODUCTO.UM_CODIGO
    FROM Productos.NOTAS_CARGO_ABONO_DETALLE, Productos.PRODUCTO
    WHERE NOTAS_CARGO_ABONO_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
    AND NOTAS_CARGO_ABONO_DETALLE.NCA_CODIGO='$Codigo'");
    while($row1 = mysqli_fetch_array($NomTitulo))
    {
        $Producto = $row1["P_CODIGO"];
        $Nombre=$row1["P_NOMBRE"];
        $Cantidad=$row1["NCAD_CANTIDAD"];
        $Costo=$row1["NCAD_COSTO"];
        $Subtotal=$row1["NCAD_SUBTOTAL"];
        $Total+=$Subtotal;

        

        $UM=$row1["UM_CODIGO"];

        $unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
        while($rowmedida = mysqli_fetch_array($unidadmedida))
        {
            $unidadDeMedidad=$rowmedida["UM_NOMBRE"];
            
        }
    



            $Data[] = array('col1'=>$Producto, 'col2'=>$Nombre, 'col3'=>$unidadDeMedidad, 'col4'=>number_format($Cantidad, 2, '.', ','), 'col5'=>number_format($Costo, 2, '.', ','), 'col6'=>number_format($Subtotal, 2, '.', ','));
                
            
        }
$Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'<b>TOTAL</b>', 'col6'=>number_format($Total, 4, '.', ','));
 
//***********************************************************
//***********************************************************
$pdf->ezTable($Data, $Titulo,'', $Opciones);
$pdf->ezText(utf8_decode(""),40,array('justification'=>'center'));
$pdf->ezText(utf8_decode("_____________________"),12,array('justification'=>'center'));
$pdf->ezText(utf8_decode("DIRECTOR DEL ÁREA"),12,array('justification'=>'center'));
ob_clean();
$pdf->ezStream();
?>					
	