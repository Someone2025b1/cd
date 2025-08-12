<?php
set_time_limit(300);
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$FechaInicio = $_POST["FechaInicio"];
$FechaFin = $_POST["FechaFin"];
$Tipo  = $_GET["Tipo"]; 
if ($Tipo==2) {
    $Filtro = "AND TRANSACCION.TRA_ESTABLECIMIENTO = 2";
}
elseif ($Tipo==3) 
{
    $Filtro = "AND TRANSACCION.TRA_ESTABLECIMIENTO = 3";
}
else
{
    $Filtro = "AND TRANSACCION.TRA_ESTABLECIMIENTO <> 2 AND TRANSACCION.TRA_ESTABLECIMIENTO <> 3";
}
$TotalGeneralCargos = 0;
$TotalGeneralAbonos = 0;

$GLOBALS["FechaI"] = $_POST["FechaInicio"];
$GLOBALS["FechaF"] = $_POST["FechaFin"];

$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));

$Periodo  = $_GET["Periodo"];

$Fecha            = 0;
$Serie            = 0;
$Factura          = 0;
$NIT              = 0;
$Proveedor        = 0;
$Documento        = 0;
$Bienes           = 0;
$Combustibles     = 0;
$Importacion      = 0;
$Galones          = 0;
$TipoCombustible  = 0;
$BienesNeto       = 0;
$ImportacionNeto  = 0;
$IDP              = 0;
$CombustiblesNeto = 0;
$IVA              = 0;
$Total            = 0;

$BienesMostrar           = 0;
$CombustiblesMostrar     = 0;
$ImportacionMostrar      = 0;
$GalonesMostrar          = 0;
$BienesNetoMostrar       = 0;
$ImportacionNetoMostrar  = 0;
$IDPMostrar              = 0;
$CombustiblesNetoMostrar = 0;
$IVAMostrar              = 0;
$TotalMostrar            = 0;

$SumaTotalBienes = 0;
$SumaTotalServicios = 0;
$SumaTotalCombustibles = 0;
$SumaTotalImportacion = 0;
$SumaTotalTotal = 0;


$TotalCargos = 0;
$TotalAbonos = 0;

//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {

    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("L","mm","A4", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,20,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', '', 7);

$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
    <td align="center" style="background-color: #C9C9C9"><b>Fecha</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Serie</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Factura</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>NIT</b></td>
    <td align="center" style="background-color: #C9C9C9; width: 150"><b>Proveedor</b></td>
    <td align="center" style="background-color: #C9C9C9; width: 25"><b>Docto</b></td>
    <td align="right" style="background-color: #C9C9C9; width: 50"><b>Bienes</b></td>
    <td align="right" style="background-color: #C9C9C9; width: 50"><b>Servicios</b></td>
    <td align="right" style="background-color: #C9C9C9; width: 50"><b>Combustibles</b></td>
    <td align="right" style="background-color: #C9C9C9; width: 50"><b>Importación</b></td>
    <td align="right" style="background-color: #C9C9C9; width: 50"><b>IVA</b></td>
    <td align="right" style="background-color: #C9C9C9; width: 50"><b>Total</b></td>
    </tr>
EOD;

$Consulta = "SELECT *
            FROM Contabilidad.TRANSACCION
            LEFT JOIN Contabilidad.PROVEEDOR ON PROVEEDOR.P_CODIGO = TRANSACCION.P_CODIGO
            LEFT JOIN Contabilidad.COMBUSTIBLE ON TRANSACCION.COM_CODIGO = COMBUSTIBLE.COM_CODIGO
            WHERE (TRANSACCION.TT_CODIGO = 2 OR TRANSACCION.TT_CODIGO = 13 OR TRANSACCION.TT_CODIGO = 19 or TRANSACCION.TT_CODIGO = 27)
            AND TRANSACCION.E_CODIGO = 2
            AND TRANSACCION.PC_CODIGO  = ".$Periodo." $Filtro
            AND TRANSACCION.TRA_CONCEPTO <> 'PÓLIZA ANULADA'  
            ORDER BY TRANSACCION.TRA_FECHA_TRANS ASC";

$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{

    $Bienes = 0;
            $Combustibles = 0;
            $Importacion = 0;
            $Galones = 0;
            $BienesNeto = 0;
            $ImportacionNeto = 0;
            $IDP = 0;
            $CombustiblesNeto = 0;
            $IVA = 0;
            $Total = 0;
    
    //SI PROVEEDOR ES PEQUEÑO CONTRIBUYENTE
    if($row["REG_CODIGO"] == 1)
    {
        //SI LA FACTURA ES DE COMBUSTIBLES
        if($row["TC_CODIGO"] == 'C')
        {
            $IVA = 0;
            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
            $Serie            = $row["TRA_SERIE"];
            $Factura          = $row["TRA_FACTURA"];
            $NIT              = $row["P_NIT"];
            $Proveedor        = $row["P_NOMBRE"];
            if ($row["TT_CODIGO"]==27) 
            {
            $Documento = "NC";
            }
            else
            {
            $Documento        = $row["TF_CODIGO"];
            }
            $Bienes           = 0.00;
            $Combustibles     = $row["TRA_TOTAL"];
            $Importacion      = 0.00;
            $Galones          = $row["TRA_CANT_GALONES"];
            $TipoCombustible  = $row["COM_CODIGO"];
            $BienesNeto       = 0.00;
            $ImportacionNeto  = 0.00;
            $IDP              = $Galones * $row["COM_IDP"];
            $CombustiblesNeto = ($row["TRA_TOTAL"]);
            $IVA              = 0;
            $Total            = $CombustiblesNeto + $IVA + $IDP;

            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
            $IDPMostrar              = number_format($IDP, 2, '.', ',');
            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
            $IVAMostrar              = number_format($IVA, 2, '.', ',');
            $TotalMostrar            = number_format($Total, 2, '.', ',');

            $tbl1 .= <<<EOD
    <tr>
    <td align="left">$Fecha</td>
    <td align="left">$Serie </td>
    <td align="left">$Factura</td>
    <td align="left">$NIT</td>
    <td align="left" style="width: 150">$Proveedor</td>
    <td align="left" style="width: 25">$Documento</td>
    <td align="right" style="width: 50">$BienesMostrar</td>
    <td align="right" style="width: 50">0.00</td>
    <td align="right" style="width: 50">$CombustiblesMostrar</td>
    <td align="right" style="width: 50">$ImportacionMostrar</td>
    <td align="right" style="width: 50">$IVAMostrar</td>
    <td align="right" style="width: 50">$TotalMostrar</td>
    </tr>
EOD;
            
            $SumaTotalBienes       = $SumaTotalBienes + $Bienes;
            $SumaTotalServicios    = $SumaTotalServicios + 0;
            $SumaTotalCombustibles = $SumaTotalCombustibles + $Combustibles;
            $SumaTotalImportacion  = $SumaTotalImportacion + $CombustiblesNeto;
            $SumaTotalTotal        = $SumaTotalTotal + $Total;

        }
        //SI LA FACTURA ES BIENES
        elseif($row["TC_CODIGO"] == 'B')
        {
            $IVA = 0;
            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
            $Serie            = $row["TRA_SERIE"];
            $Factura          = $row["TRA_FACTURA"];
            $NIT              = $row["P_NIT"];
            $Proveedor        = $row["P_NOMBRE"];
            if ($row["TT_CODIGO"]==27) 
            {
            $Documento = "NC";
            }
            else
            {
            $Documento        = $row["TF_CODIGO"];
            }
            $Bienes           = $row["TRA_TOTAL"];
            $Combustibles     = 0.00;
            $Importacion      = 0.00;
            $Galones          = 0.00;
            $TipoCombustible  = 0.00;
            $ImportacionNeto  = 0.00;
            $IDP              = 0.00;
            $CombustiblesNeto = 0.00;
            $BienesNeto1      = $row["TRA_TOTAL"];
            $IVA              = 0;
            $BienesNeto       = $row["TRA_TOTAL"]-$IVA;
            $Total            = $BienesNeto + $IVA;

            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
            $IDPMostrar              = number_format($IDP, 2, '.', ',');
            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
            $IVAMostrar              = number_format($IVA, 2, '.', ',');
            $TotalMostrar            = number_format($Total, 2, '.', ',');

            $tbl1 .= <<<EOD
    <tr>
    <td align="left">$Fecha</td>
    <td align="left">$Serie </td>
    <td align="left">$Factura</td>
    <td align="left">$NIT</td>
    <td align="left" style="width: 150">$Proveedor</td>
    <td align="left" style="width: 25">$Documento</td>
    <td align="right" style="width: 50">$BienesMostrar</td>
    <td align="right" style="width: 50">0.00</td>
    <td align="right" style="width: 50">$CombustiblesMostrar</td>
    <td align="right" style="width: 50">$ImportacionMostrar</td>
    <td align="right" style="width: 50">0.00</td>
    <td align="right" style="width: 50">$TotalMostrar</td>
    </tr>
EOD;
                        
            $SumaTotalBienes       = $SumaTotalBienes + $Bienes;
            $SumaTotalServicios    = $SumaTotalServicios + 0;
            $SumaTotalCombustibles = $SumaTotalCombustibles + $Combustibles;
            $SumaTotalImportacion  = $SumaTotalImportacion + $CombustiblesNeto;
            $SumaTotalTotal        = $SumaTotalTotal + $Total;
        }
        elseif($row["TC_CODIGO"] == 'S')
        {
            $IVA = 0;
            $Concepto         = $row["TRA_CONCEPTO"];
            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
            $Serie            = $row["TRA_SERIE"];
            $Factura          = $row["TRA_FACTURA"];
            $NIT              = $row["P_NIT"];
            $Proveedor        = $row["P_NOMBRE"];
            if ($row["TT_CODIGO"]==27) 
            {
            $Documento = "NC";
            }
            else
            {
            $Documento        = $row["TF_CODIGO"];
            }
            $Bienes           = $row["TRA_TOTAL"];
            $Combustibles     = 0.00;
            $Importacion      = 0.00;
            $Galones          = 0.00;
            $TipoCombustible  = 0.00;
            $ImportacionNeto  = 0.00;
            $IDP              = 0.00;
            $CombustiblesNeto = 0.00;
            $BienesNeto1      = $row["TRA_TOTAL"];
            $IVA              = 0;
            $BienesNeto       = $row["TRA_TOTAL"]-$IVA;
            $Total            = $BienesNeto + $IVA;

            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
            $IDPMostrar              = number_format($IDP, 2, '.', ',');
            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
            $IVAMostrar              = number_format($IVA, 2, '.', ',');
            $TotalMostrar            = number_format($Total, 2, '.', ',');

            if($Concepto != 'PÓLIZA ANULADA')
            {
                $tbl1 .= <<<EOD
    <tr>
    <td align="left">$Fecha</td>
    <td align="left">$Serie </td>
    <td align="left">$Factura</td>
    <td align="left">$NIT</td>
    <td align="left" style="width: 150">$Proveedor</td>
    <td align="left" style="width: 25">$Documento</td>
    <td align="right" style="width: 50">0.00</td>
    <td align="right" style="width: 50">$BienesMostrar</td>
    <td align="right" style="width: 50">$CombustiblesMostrar</td>
    <td align="right" style="width: 50">$ImportacionMostrar</td>
    <td align="right" style="width: 50">0.00</td>
    <td align="right" style="width: 50">$TotalMostrar</td>
    </tr>
EOD;
                        
            $SumaTotalBienes       = $SumaTotalBienes + 0;
            $SumaTotalServicios    = $SumaTotalServicios + $Bienes;
            $SumaTotalCombustibles = $SumaTotalCombustibles + $Combustibles;
            $SumaTotalImportacion  = $SumaTotalImportacion + $CombustiblesNeto;
            $SumaTotalTotal        = $SumaTotalTotal + $Total;
            }
            
        }
    }
    //SI ES PROVEEDOR CONTRIBUYENTE NORMAL
    elseif($row["REG_CODIGO"] == 2 || $row["REG_CODIGO"] == 4)
    {
        //SI LA FACTURA ES DE COMBUSTIBLES
        if($row["TC_CODIGO"] == 'C')
        {
            $IVA = 0;
            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
            $Serie            = $row["TRA_SERIE"];
            $Factura          = $row["TRA_FACTURA"];
            $NIT              = $row["P_NIT"];
            $Proveedor        = $row["P_NOMBRE"];
            if ($row["TT_CODIGO"]==27) 
            {
            $Documento = "NC";
            }
            else
            {
            $Documento        = $row["TF_CODIGO"];
            }
            $Bienes           = 0.00;
            $Combustibles     = $row["TRA_TOTAL"];
            $Importacion      = 0.00;
            $Galones          = $row["TRA_CANT_GALONES"];
            $TipoCombustible  = $row["COM_CODIGO"];
            $BienesNeto       = 0.00;
            $ImportacionNeto  = 0.00;
            $IDP              = $Galones * $row["COM_IDP"];
            $CombustiblesNeto = ($row["TRA_TOTAL"])/1.12;
            $IVA              = $CombustiblesNeto * 0.12;
            $Total            = $CombustiblesNeto + $IVA;

            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
            $IDPMostrar              = number_format($IDP, 2, '.', ',');
            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
            $IVAMostrar              = number_format($IVA, 2, '.', ',');
            $TotalMostrar            = number_format($Total, 2, '.', ',');

            $tbl1 .= <<<EOD
    <tr>
    <td align="left">$Fecha</td>
    <td align="left">$Serie </td>
    <td align="left">$Factura</td>
    <td align="left">$NIT</td>
    <td align="left" style="width: 150">$Proveedor</td>
    <td align="left" style="width: 25">$Documento</td>
    <td align="right" style="width: 50">$BienesMostrar</td>
    <td align="right" style="width: 50">0.00</td>
    <td align="right" style="width: 50">$CombustiblesNetoMostrar</td>
    <td align="right" style="width: 50">$ImportacionMostrar</td>
    <td align="right" style="width: 50">$IVAMostrar</td>
    <td align="right" style="width: 50">$TotalMostrar</td>
    </tr>
EOD;
             
            $SumaTotalBienes       = $SumaTotalBienes + $BienesNeto;
            $SumaTotalServicios    = $SumaTotalServicios + 0;
            $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
            $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
            $SumaTotalTotal        = $SumaTotalTotal + $Total;
        }
        //SI LA FACTURA ES BIENES/SERVICIOS
        elseif($row["TC_CODIGO"] == 'B')
        {
            $IVA = 0;
            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
            $Serie            = $row["TRA_SERIE"];
            $Factura          = $row["TRA_FACTURA"];
            $NIT              = $row["P_NIT"];
            $Proveedor        = $row["P_NOMBRE"];
            if ($row["TT_CODIGO"]==27) 
            {
            $Documento = "NC";
            }
            else
            {
            $Documento        = $row["TF_CODIGO"];
            }
            $Bienes           = $row["TRA_TOTAL"];
            $Combustibles     = 0.00;
            $Importacion      = 0.00;
            $Galones          = 0.00;
            $TipoCombustible  = 0.00;
            $BienesNeto       = $row["TRA_TOTAL"]/1.12;
            $ImportacionNeto  = 0.00;
            $IDP              = 0.00;
            $CombustiblesNeto = 0.00;
            $IVA              = $BienesNeto * 0.12;
            $Total            = $BienesNeto + $IVA;

            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
            $IDPMostrar              = number_format($IDP, 2, '.', ',');
            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
            $IVAMostrar              = number_format($IVA, 2, '.', ',');
            $TotalMostrar            = number_format($Total, 2, '.', ',');

            $tbl1 .= <<<EOD
    <tr>
    <td align="left">$Fecha</td>
    <td align="left">$Serie </td>
    <td align="left">$Factura</td>
    <td align="left">$NIT</td>
    <td align="left" style="width: 150">$Proveedor</td>
    <td align="left" style="width: 25">$Documento</td>
    <td align="right" style="width: 50">$BienesNetoMostrar</td>
    <td align="right" style="width: 50">0.00</td>
    <td align="right" style="width: 50">$CombustiblesMostrar</td>
    <td align="right" style="width: 50">$ImportacionMostrar</td>
    <td align="right" style="width: 50">$IVAMostrar</td>
    <td align="right" style="width: 50">$TotalMostrar</td>
    </tr>
EOD;
            
            $SumaTotalBienes       = $SumaTotalBienes + $BienesNeto;
            $SumaTotalServicios    = $SumaTotalServicios + 0;
            $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
            $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
            $SumaTotalTotal        = $SumaTotalTotal + $Total;
        }
        elseif($row["TC_CODIGO"] == 'S')
        {
            $IVA = 0;
            $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
            $Serie            = $row["TRA_SERIE"];
            $Factura          = $row["TRA_FACTURA"];
            $NIT              = $row["P_NIT"];
            $Proveedor        = $row["P_NOMBRE"];
            if ($row["TT_CODIGO"]==27) 
            {
            $Documento = "NC";
            }
            else
            {
            $Documento        = $row["TF_CODIGO"];
            }
            $Bienes           = $row["TRA_TOTAL"];
            $Combustibles     = 0.00;
            $Importacion      = 0.00;
            $Galones          = 0.00;
            $TipoCombustible  = 0.00;
            $BienesNeto       = $row["TRA_TOTAL"]/1.12;
            $ImportacionNeto  = 0.00;
            $IDP              = 0.00;
            $CombustiblesNeto = 0.00;
            $IVA              = $BienesNeto * 0.12;
            $Total            = $BienesNeto + $IVA;

            $BienesMostrar           = number_format($Bienes, 2, '.', ',');
            $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
            $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
            $GalonesMostrar          = number_format($Galones, 2, '.', ',');
            $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
            $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
            $IDPMostrar              = number_format($IDP, 2, '.', ',');
            $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
            $IVAMostrar              = number_format($IVA, 2, '.', ',');
            $TotalMostrar            = number_format($Total, 2, '.', ',');

            $tbl1 .= <<<EOD
    <tr>
    <td align="left">$Fecha</td>
    <td align="left">$Serie </td>
    <td align="left">$Factura</td>
    <td align="left">$NIT</td>
    <td align="left" style="width: 150">$Proveedor</td>
    <td align="left" style="width: 25">$Documento</td>
    <td align="right" style="width: 50">0.00</td>
    <td align="right" style="width: 50">$BienesNetoMostrar</td>
    <td align="right" style="width: 50">$CombustiblesMostrar</td>
    <td align="right" style="width: 50">$ImportacionMostrar</td>
    <td align="right" style="width: 50">$IVAMostrar</td>
    <td align="right" style="width: 50">$TotalMostrar</td>
    </tr>
EOD;
            
            $SumaTotalBienes       = $SumaTotalBienes + 0;
            $SumaTotalServicios    = $SumaTotalServicios + $BienesNeto;
            $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
            $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
            $SumaTotalTotal        = $SumaTotalTotal + $Total;
        }
        else
        {
        if($row["TT_CODIGO"] == 19)
        {
            if($row["TRA_CONCEPTO"] == 'Bien')
            {
                $IVA = 0;
                $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
                $Serie            = $row["TRA_SERIE"];
                $Factura          = $row["TRA_FACTURA"];
                $NIT              = $row["P_NIT"];
                $Proveedor        = $row["P_NOMBRE"];
                if ($row["TT_CODIGO"]==27) 
                {
                $Documento = "NC";
                }
                else
                {
                $Documento        = $row["TF_CODIGO"];
                }
                $Bienes           = $row["TRA_TOTAL"];
                $Combustibles     = 0.00;
                $Importacion      = 0.00;
                $Galones          = 0.00;
                $TipoCombustible  = 0.00;
                $BienesNeto       = $row["TRA_TOTAL"]/1.12;
                $ImportacionNeto  = 0.00;
                $IDP              = 0.00;
                $CombustiblesNeto = 0.00;
                $IVA              = $BienesNeto * 0.12;
                $Total            = $BienesNeto + $IVA;

                $BienesMostrar           = number_format($Bienes, 2, '.', ',');
                $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
                $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
                $GalonesMostrar          = number_format($Galones, 2, '.', ',');
                $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
                $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
                $IDPMostrar              = number_format($IDP, 2, '.', ',');
                $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
                $IVAMostrar              = number_format($IVA, 2, '.', ',');
                $TotalMostrar            = number_format($Total, 2, '.', ',');

             $tbl1 .= <<<EOD
            <tr>
            <td align="left">$Fecha</td>
            <td align="left">$Serie </td>
            <td align="left">$Factura</td>
            <td align="left">$NIT</td>
            <td align="left" style="width: 150">$Proveedor</td>
            <td align="left" style="width: 25">$Documento</td>
            <td align="right" style="width: 50">0.00</td>
            <td align="right" style="width: 50">$BienesNetoMostrar</td>
            <td align="right" style="width: 50">$CombustiblesMostrar</td>
            <td align="right" style="width: 50">$ImportacionMostrar</td>
            <td align="right" style="width: 50">$IVAMostrar</td>
            <td align="right" style="width: 50">$TotalMostrar</td>
            </tr>
        EOD;

                $SumaTotalBienes       = $SumaTotalBienes + $BienesNeto;
                $SumaTotalServicios    = $SumaTotalServicios + 0;
                $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
                $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
                $SumaTotalTotal        = $SumaTotalTotal + $Total;
            }
            else
            {
                $IVA = 0;
                $Fecha            = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
                $Serie            = $row["TRA_SERIE"];
                $Factura          = $row["TRA_FACTURA"];
                $NIT              = $row["P_NIT"];
                $Proveedor        = $row["P_NOMBRE"];
                if ($row["TT_CODIGO"]==27) 
                {
                $Documento = "NC";
                }
                else
                {
                $Documento        = $row["TF_CODIGO"];
                }
                $Bienes           = $row["TRA_TOTAL"];
                $Combustibles     = 0.00;
                $Importacion      = 0.00;
                $Galones          = 0.00;
                $TipoCombustible  = 0.00;
                $BienesNeto       = $row["TRA_TOTAL"]/1.12;
                $ImportacionNeto  = 0.00;
                $IDP              = 0.00;
                $CombustiblesNeto = 0.00;
                $IVA              = $BienesNeto * 0.12;
                $Total            = $BienesNeto + $IVA;

                $BienesMostrar           = number_format($Bienes, 2, '.', ',');
                $CombustiblesMostrar     = number_format($Combustibles, 2, '.', ',');
                $ImportacionMostrar      = number_format($Importacion, 2, '.', ',');
                $GalonesMostrar          = number_format($Galones, 2, '.', ',');
                $BienesNetoMostrar       = number_format($BienesNeto, 2, '.', ',');
                $ImportacionNetoMostrar  = number_format($ImportacionNeto, 2, '.', ',');
                $IDPMostrar              = number_format($IDP, 2, '.', ',');
                $CombustiblesNetoMostrar = number_format($CombustiblesNeto, 2, '.', ',');
                $IVAMostrar              = number_format($IVA, 2, '.', ',');
                $TotalMostrar            = number_format($Total, 2, '.', ',');

                $tbl1 .= <<<EOD
                    <tr>
                    <td align="left">$Fecha</td>
                    <td align="left">$Serie </td>
                    <td align="left">$Factura</td>
                    <td align="left">$NIT</td>
                    <td align="left" style="width: 150">$Proveedor</td>
                    <td align="left" style="width: 25">$Documento</td>
                    <td align="right" style="width: 50">0.00</td>
                    <td align="right" style="width: 50">$BienesNetoMostrar</td>
                    <td align="right" style="width: 50">$CombustiblesMostrar</td>
                    <td align="right" style="width: 50">$ImportacionMostrar</td>
                    <td align="right" style="width: 50">$IVAMostrar</td>
                    <td align="right" style="width: 50">$TotalMostrar</td>
                    </tr>
                EOD;

                $SumaTotalBienes       = $SumaTotalBienes + 0;
                $SumaTotalServicios    = $SumaTotalServicios + $BienesNeto;
                $SumaTotalCombustibles = $SumaTotalCombustibles + $CombustiblesNeto;
                $SumaTotalImportacion  = $SumaTotalImportacion + $ImportacionNeto;
                $SumaTotalTotal        = $SumaTotalTotal + $Total;
            }
        }
    }
     $TotalIVASuma +=$IVA;
    }
    
    
}


$TotalIVASuma  = number_format($TotalIVASuma, 2, '.', ',');
$SumaTotalBienesFormato       = number_format($SumaTotalBienes, 2, '.', ',');
$SumaTotalServiciosFormato    = number_format($SumaTotalServicios, 2, '.', ',');
$SumaTotalCombustiblesFormato = number_format($SumaTotalCombustibles, 2, '.', ',');
$SumaTotalImportacionFormato  = 0.00;
$SumaTotalTotalFormato        = number_format($SumaTotalTotal, 2, '.', ',');

$tbl1 .= <<<EOD
    <tr>
    <td align="left"></td>
    <td align="left"></td>
    <td align="left"></td>
    <td align="left"></td>
    <td align="left" style="width: 150"></td>
    <td align="left" style="width: 25">TOTAL</td>
    <td align="right" style="width: 50">$SumaTotalBienesFormato</td>
    <td align="right" style="width: 50">$SumaTotalServiciosFormato</td>
    <td align="right" style="width: 50">$SumaTotalCombustiblesFormato</td>
    <td align="right" style="width: 50">$SumaTotalImportacionFormato</td>
    <td align="right" style="width: 50">$TotalIVASuma</td>
    <td align="right" style="width: 50">$SumaTotalTotalFormato</td>
    </tr>
EOD;

$tbl1 .= <<<EOD
</table>
EOD;
$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
ob_clean();
$pdf->Output();
ob_flush();
?>