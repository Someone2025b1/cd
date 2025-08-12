<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");


$fecha_inicio=$_POST["FechaInicio"];
$fecha_fin=$_POST["FechaFin"];
$Hora=$_POST["Hora"];


if(isset($_POST["ConFinDe"]))
    {
        $ConFin = 1;
    }
    else
    {
        $ConFin = 0;
    }
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));



$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Reporte Ingresos",16,array('justification'=>'center'));
$pdf->ezText(date('d-m-Y',strtotime($fecha_inicio))." - al - ".date('d-m-Y',strtotime($fecha_fin)),16,array('justification'=>'center'));
$pdf->ezText(date('h:i a',strtotime($Hora))." - al Cierre",16,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);


/*TITULOS*/
$Titulo = array('col1'=>utf8_decode('Punto de Venta'), 'col2'=>'Documentos Emitidos', 'col3'=>'Sub Total Ingreso');
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>10, 'width'=>'550', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/


if($ConFin==1){
$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO = 1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;
    


$Data[] = array('col1'=>'TERRAZAS', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));


$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;
    


$Data[] = array('col1'=>'TERRAZAS #2', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));


$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_SV WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_SV WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'SOUVENIRS', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));


$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_SV_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_SV_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'SOUVENIRS #2', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_KS WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_KS WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'CAFE LOS ABUELOS', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_TQ WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_TQ WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'TAQUILLA', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));


$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_TQ_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_TQ_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'TAQUILLA #2', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_TQ_3 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_TQ_3 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'TAQUILLA #3', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_TQ_4 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_TQ_4 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'TAQUILLA #4', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_RS WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_RS WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'MIRADOR', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

#################
$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_HS WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_HS WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'HELADOS', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

###############################

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_KS_3 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_KS_3 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'KIOSKO OASIS', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

###############################

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_KS_4 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_KS_4 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'KIOSKO PASILLO', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

###############################

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_KS_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_KS_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'KIOSKO AZADOS', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

###############################

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_JG WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_JG WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'JUEGOS', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

###############################

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_EV WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_EV WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'EVENTOS', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

###############################

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_HC WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1 ";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_HC WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND F_ESTADO=1 ";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'HOTELES', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

###############################

$Data[] = array('col1'=>'<b>TOTALES</b>', 'col2'=>number_format($TotalDoc, 0, '.', ','), 'col3'=>'Q.'.number_format($Total, 2, '.', ','));


#$Meta=120000;
#$Marcador = $Total-$Meta;

#if($Marcador<0){
#$Data[] = array('col1'=>'<b>FALTA PARA LLEGAR A LA META</b>', 'col2'=>'--', 'col3'=>'Q.'.number_format($Marcador, 2, '.', ','));
#}else{
#   $Data[] = array('col1'=>'<b>MAS DE LA META</b>', 'col2'=>'--', 'col3'=>'Q.'.number_format($Marcador, 2, '.', ','));
#}


}else{
#### SIN FIN DE SEMANA #####################
##############################################
#############################################
###########################################
##########################################
############################################

    $Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;
    


$Data[] = array('col1'=>'Terrazas', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));


$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_SV WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_SV WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'Souvenirs', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_SV_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_SV_2 WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'Souvenirs #2', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_KS WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_KS WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'Cafe Los Abuelos', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.number_format($SubTotal, 2, '.', ','));

$Queryp = "SELECT COUNT(F_CODIGO) AS FACTURAS_EMITIDAS FROM Bodega.FACTURA_TQ WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Resultp = mysqli_query($db,$Queryp);
while($rowp = mysqli_fetch_array($Resultp))
{
    $FacturasEmitidas1 = $rowp["FACTURAS_EMITIDAS"];
}

$Query11p = "SELECT SUM(F_TOTAL) AS TOTAL_FACTURADO FROM Bodega.FACTURA_TQ WHERE F_FECHA_TRANS BETWEEN '$fecha_inicio' AND '$fecha_fin' AND F_HORA >='$Hora' AND DAYOFWEEK(F_FECHA_TRANS) <> 1 AND DAYOFWEEK(F_FECHA_TRANS) <> 7";
$Result11p = mysqli_query($db,$Query11p);
while($rowp = mysqli_fetch_array($Result11p))
{
    $SubTotal = $rowp["TOTAL_FACTURADO"];
}

    
$Total+=$SubTotal;
$TotalDoc+=$FacturasEmitidas1;

$Data[] = array('col1'=>'Taquilla', 'col2'=>$FacturasEmitidas1, 'col3'=>'Q.'.$SubTotal);


$Data[] = array('col1'=>'<b>TOTALES</b>', 'col2'=>number_format($TotalDoc, 0, '.', ','), 'col3'=>'Q.'.number_format($Total, 2, '.', ','));
 
}   



 
//***********************************************************
//***********************************************************
$pdf->ezTable($Data, $Titulo,'', $Opciones);

if($ConFin==1){
    $pdf->ezText("",10,array('justification'=>'right'));
    $pdf->ezText("Datos Incluyen Fin De Semana",8,array('justification'=>'right'));
}else{
    $pdf->ezText("",10,array('justification'=>'right'));
    $pdf->ezText("Datos NO Incluyen Fin De Semana",8,array('justification'=>'right'));
}
ob_clean();

$pdf->ezStream();
?>					
	