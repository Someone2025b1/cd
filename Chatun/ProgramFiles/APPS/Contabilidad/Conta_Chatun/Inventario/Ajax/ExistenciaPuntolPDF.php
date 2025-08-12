<?php
include("../../../../../../Script/funciones.php");
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../../libs/ezpdf/class.ezpdf.php");

$Bodega=$_GET["Bodega"];
$FechaFin=$_GET["Fecha"];

$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));



$query = "SELECT * FROM CompraVenta.PUNTO_VENTA WHERE PV_CODIGO=".$Bodega;
		  $result = mysqli_query($db, $query);
		  while($row = mysqli_fetch_array($result))
		  {
			$NomBodega=$row["PV_NOMBRE"];
		  }

$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Existencia de Productos - ".$NomBodega." - AL ".date('d-m-Y',strtotime($FechaFin)),16,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);

/*TITULOS*/
$Titulo = array('col1'=>utf8_decode('Código'), 'col2'=>'Nombre', 'col3'=>'Unidad de Medida', 'col4'=>'Cantidad', 'col5'=>'Costo Unitario', 'col6'=>'Costo Total');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/

if($Bodega==1){

    $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_TERRAZAS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
    
    }
    elseif($Bodega==2){
    
    $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_SOUVENIRS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
    }
    elseif($Bodega==3){
            $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_HELADOS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
            }
    elseif($Bodega==4){
        $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_CAFE=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
    }
    
    elseif($Bodega==5){
        $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_LLEVA_EXISTENCIA=1");
    }
    elseif($Bodega==6){

        $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_KIOSCO=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
        
        }

        if($Bodega==8){

        $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_PIZZERIA=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");

        }

    


    while($row1 = mysqli_fetch_array($NomTitulo))
    {
        $Producto = $row1["P_CODIGO"];
        $Nombre=$row1["P_NOMBRE"];
        $Venta=$row1["P_PRECIO_VENTA"];
        $Souivenirs=$row1["P_EXISTENCIA_SOUVENIRS"];

        $EXIS = mysqli_query($db, "SELECT * FROM Productos.KARDEX
        WHERE KARDEX.K_FECHA <= '$FechaFin'
        AND KARDEX.P_CODIGO = ".$Producto."
        AND (KARDEX.K_COSTO_PONDERADO > 0
        OR KARDEX.K_COSTO_PONDERADO <> '')
        ORDER BY KARDEX.K_FECHA DESC, KARDEX.K_HORA DESC
        LIMIT 1");
        while($rowEX = mysqli_fetch_array($EXIS))
                {
                    $Ponderado=$rowEX["K_COSTO_PONDERADO"];
                }

                if(!$Ponderado | $Ponderado==0){

                    $EXIS = mysqli_query($db, "SELECT * FROM Productos.KARDEX
                WHERE KARDEX.K_FECHA >= '$FechaFin'
                AND KARDEX.P_CODIGO = ".$Producto."
                AND (KARDEX.K_COSTO_ANTERIOR > 0
                OR KARDEX.K_COSTO_ANTERIOR <> '')
                ORDER BY KARDEX.K_FECHA, KARDEX.K_HORA 
                LIMIT 1");
                while($rowEX = mysqli_fetch_array($EXIS))
                        {
                            $Ponderado=$rowEX["K_COSTO_ANTERIOR"];
                        }
                    }

            if(!$Ponderado | $Ponderado==0){

                    $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
                }
        

        $UM=$row1["UM_CODIGO"];

        $unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
        while($rowmedida = mysqli_fetch_array($unidadmedida))
        {
            $unidadDeMedidad=$rowmedida["UM_NOMBRE"];
            
        }

        $EXIS = mysqli_query($db, "SELECT * FROM Productos.KARDEX
        WHERE KARDEX.K_FECHA <= '$FechaFin'
        AND KARDEX.K_PUNTO_VENTA =".$Bodega."
        AND KARDEX.P_CODIGO = ".$Producto."
        ORDER BY KARDEX.K_FECHA DESC, KARDEX.K_HORA DESC
        LIMIT 1");
        while($rowEX = mysqli_fetch_array($EXIS))
                {
                    $Existencias = $rowEX["K_EXISTENCIA_ACTUAL_PUNTO"];
        
                    $subtot=$Ponderado*$Existencias;
                    $Total+=$subtot;
    
                    $HAY=1;
    
                }
    
        if($HAY==0){
    
                $Existencias =0.0;
                    $subtot=$Ponderado*$Existencias;
                    $Total+=$subtot;
                }

                
                if($Existencias!=0){


            $Data[] = array('col1'=>$Producto, 'col2'=>$Nombre, 'col3'=>$unidadDeMedidad, 'col4'=>number_format($Existencias, 2, '.', ','), 'col5'=>number_format($Ponderado, 2, '.', ','), 'col6'=>number_format($subtot, 2, '.', ','));
                }
            $HAY=0;
            $Ponderado=0;
        }
$Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'<b>TOTAL</b>', 'col6'=>number_format($Total, 4, '.', ','));
 
//***********************************************************
//***********************************************************
$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>					
	