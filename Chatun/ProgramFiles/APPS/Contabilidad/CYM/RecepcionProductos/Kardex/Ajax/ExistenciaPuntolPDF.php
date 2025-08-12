<?php
include("../../../../../../Script/funciones.php");
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../../libs/ezpdf/class.ezpdf.php");

$Bodega=$_GET["Bodega"];

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
$pdf->ezText("Existencia de Productos - ".$NomBodega,16,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);

/*TITULOS*/
$Titulo = array('col1'=>utf8_decode('Código'), 'col2'=>'Nombre', 'col3'=>'Unidad de Medida', 'col4'=>'Cantidad', 'col5'=>'Costo Unitario', 'col6'=>'Costo Total');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/



if($Bodega==1){
    $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_EXISTENCIA_TERRAZAS<>0 AND PRODUCTO.P_TERRAZAS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
    while($row1 = mysqli_fetch_array($NomTitulo))
            {
                $Cod = $row1["P_CODIGO"];
                $Nombre=$row1["P_NOMBRE"];
                $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
                $Venta=$row1["P_PRECIO_VENTA"];
                $Terrazas=$row1["P_EXISTENCIA_TERRAZAS"];
    
                $subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_TERRAZAS"];
                $Total+=$subtot;
    
                $UM=$row1["UM_CODIGO"];
    
                $unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
                while($rowmedida = mysqli_fetch_array($unidadmedida))
                {
                    $unidadDeMedidad=$rowmedida["UM_NOMBRE"];
                    
                }

    


            $Data[] = array('col1'=>$Cod, 'col2'=>$Nombre, 'col3'=>$unidadDeMedidad, 'col4'=>$Terrazas, 'col5'=>$Ponderado, 'col6'=>$subtot);

    
}
}
elseif($Bodega==2){
    $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_EXISTENCIA_SOUVENIRS<>0 AND PRODUCTO.P_SOUVENIRS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
    while($row1 = mysqli_fetch_array($NomTitulo))
            {
                $Cod = $row1["P_CODIGO"];
                $Nombre=$row1["P_NOMBRE"];
                $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
                $Venta=$row1["P_PRECIO_VENTA"];
                $Souivenirs=$row1["P_EXISTENCIA_SOUVENIRS"];
    
                $subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_SOUVENIRS"];
                $Total+=$subtot;
    
                $UM=$row1["UM_CODIGO"];
    
                $unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
                while($rowmedida = mysqli_fetch_array($unidadmedida))
                {
                    $unidadDeMedidad=$rowmedida["UM_NOMBRE"];
                    
                }

    

    
                $Data[] = array('col1'=>$Cod, 'col2'=>$Nombre, 'col3'=>$unidadDeMedidad, 'col4'=>$Souivenirs, 'col5'=>$Ponderado, 'col6'=>$subtot);

    
}
}
elseif($Bodega==3){
    $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_EXISTENCIA_HELADOS<>0 AND PRODUCTO.P_HELADOS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
		while($row1 = mysqli_fetch_array($NomTitulo))
            {
                $Cod = $row1["P_CODIGO"];
                $Nombre=$row1["P_NOMBRE"];
                $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
                $Venta=$row1["P_PRECIO_VENTA"];
                $Souivenirs=$row1["P_EXISTENCIA_HELADOS"];
    
                $subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_HELADOS"];
                $Total+=$subtot;
    
                $UM=$row1["UM_CODIGO"];
    
                $unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
                while($rowmedida = mysqli_fetch_array($unidadmedida))
                {
                    $unidadDeMedidad=$rowmedida["UM_NOMBRE"];
                    
                }

    

    
                $Data[] = array('col1'=>$Cod, 'col2'=>$Nombre, 'col3'=>$unidadDeMedidad, 'col4'=>$Souivenirs, 'col5'=>$Ponderado, 'col6'=>$subtot);

    
}
}

elseif($Bodega==4){
    $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_EXISTENCIA_CAFE<>0 AND PRODUCTO.P_CAFE=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
	while($row1 = mysqli_fetch_array($NomTitulo))
            {
                $Cod = $row1["P_CODIGO"];
                $Nombre=$row1["P_NOMBRE"];
                $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
                $Venta=$row1["P_PRECIO_VENTA"];
                $Souivenirs=$row1["P_EXISTENCIA_CAFE"];
    
                $subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_CAFE"];
                $Total+=$subtot;
    
                $UM=$row1["UM_CODIGO"];
    
                $unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
                while($rowmedida = mysqli_fetch_array($unidadmedida))
                {
                    $unidadDeMedidad=$rowmedida["UM_NOMBRE"];
                    
                }

    

    
                $Data[] = array('col1'=>$Cod, 'col2'=>$Nombre, 'col3'=>$unidadDeMedidad, 'col4'=>$Souivenirs, 'col5'=>$Ponderado, 'col6'=>$subtot);


    
}
}

elseif($Bodega==5){
    $NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_EXISTENCIA_BODEGA<>0 PRODUCTO.P_LLEVA_EXISTENCIA=1");
	while($row1 = mysqli_fetch_array($NomTitulo))
            {
                $Cod = $row1["P_CODIGO"];
                $Nombre=$row1["P_NOMBRE"];
                $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
                $Venta=$row1["P_PRECIO_VENTA"];
                $Souivenirs=$row1["P_EXISTENCIA_BODEGA"];
    
                $subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_BODEGA"];
                $Total+=$subtot;
    
                $UM=$row1["UM_CODIGO"];
    
                $unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
                while($rowmedida = mysqli_fetch_array($unidadmedida))
                {
                    $unidadDeMedidad=$rowmedida["UM_NOMBRE"];
                    
                }

    

    
                $Data[] = array('col1'=>$Cod, 'col2'=>$Nombre, 'col3'=>$unidadDeMedidad, 'col4'=>$Souivenirs, 'col5'=>$Ponderado, 'col6'=>$subtot);


    
}
}
$Data[] = array('col1'=>'', 'col2'=>'', 'col3'=>'', 'col4'=>'', 'col5'=>'<b>TOTAL</b>', 'col6'=>number_format($Total, 4, '.', ','));
 
//***********************************************************
//***********************************************************
$pdf->ezTable($Data, $Titulo,'', $Opciones);
ob_clean();
$pdf->ezStream();
?>					
	