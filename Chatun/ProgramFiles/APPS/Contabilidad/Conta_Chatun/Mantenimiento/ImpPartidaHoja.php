<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$TotalCargos = 0;
$TotalAbonos = 0;
$Partida = $_POST["Partida"];

$QueryTransaccion = "SELECT TRA_CODIGO FROM Contabilidad.TRANSACCION WHERE TRA_NO_HOJA = '$Partida' ";
$ResultTransaccion = mysqli_query($db, $QueryTransaccion);
$FilaTransaccion = mysqli_fetch_array($ResultTransaccion);

$Codigo = $FilaTransaccion["TRA_CODIGO"];

$Consulta = "SELECT * FROM Contabilidad.TRANSACCION WHERE TRA_CODIGO = '".$Codigo."'";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
    $GLOBALS['Comprobante'] = $row["TRA_COMPROBANTE"];
    $Fecha                  = date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"]));
    $Hora                   = $row["TRA_HORA"];
    $Concepto               = $row["TRA_CONCEPTO"];
    $FechaHoy               = date('d-m-Y', strtotime($row["TRA_FECHA_HOY"]));
    $Usuario                = $row["TRA_USUARIO"];
    $Nit                    =$row["P_NIT"];
    $ProveedorCodigo        =$row["P_CODIGO"];
    $ProveedorNombre        =$row["P_NOMBRE"];
    $Serie                  =$row["TRA_SERIE"];
    $Factura                =$row["TRA_FACTURA"];
    $TipoCompra             =$row["TC_CODIGO"];
    $Combustible            = $row["COM_CODIGO"];
    $DestinoCombustible     =$row["TRA_DESTINO_COM"];
    $CantidadGalones        =$row["TRA_CANT_GALONES"];
    $PrecioGalones          =$row["TRA_PRECIO_GALONES"];
    $TotalFactura           =$row["TRA_TOTAL"];
    $FormaPago              =$row["FP_CODIGO"];
    $Usuario                =$row["TRA_USUARIO"];
    $NoPoliza               =$row["TRA_CORRELATIVO"];
    $Tipo                   = $row["TT_CODIGO"];
    $Corr                   = $row["TRA_NO_HOJA"];
    if($Tipo == 10 || $Tipo == 13)
    {
        $Contabilizo            =$row["TRA_CONTABILIZO"];
        $NombreContabilizo      = saber_nombre_colaborador($row["TRA_CONTABILIZO"]);
        $Puesto                 = saber_puesto($row["TRA_CONTABILIZO"]);
        $PuestoColaborador      = saber_puesto_nombre($Puesto);    
    }
    else
    {
        $Contabilizo            =$row["TRA_CONTABILIZO"];
        $NombreContabilizo      = saber_nombre_colaborador($row["TRA_CONTABILIZO"]);
        $Puesto                 = saber_puesto($row["TRA_CONTABILIZO"]);
        $PuestoColaborador      = saber_puesto_nombre($Puesto);  
    }
}   

//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {

            global $Corr;
            global $Concepto;
        
              // get the current page break margin
              $bMargin = $this->getBreakMargin();
              // get current auto-page-break mode
              $auto_page_break = $this->AutoPageBreak;
              // disable auto-page-break
              $this->SetAutoPageBreak(false, 0);
              // set bacground image
              
              if($Concepto=="PÓLIZA ANULADA"){
                $this->Image('EncabezadoDocAnulada.png', 0, 0, 215, 80, '', '', '', false, 300, '', false, false, 0);
              }else{

                $this->Image('EncabezadoDoc2.png', 0, 0, 215, 32, '', '', '', false, 300, '', false, false, 0);

              }
              
              // restore auto-page-break status
              $this->SetAutoPageBreak($auto_page_break, $bMargin);
              // set the starting point for the page content
              $this->setPageMark();
          
              //$this->Image('LibroDiario.jpg',0,0,500,600);
              //$this->SetFont('Helvetica','B',10);
              //$this->SetFont('Helvetica', '', 8);
              //$this->Image('tabla.png',180,4,25);
              //$this->Cell(10,5, "",0,1,'R');
              //$this->Cell(185,0,'FOLIO NO.',0,0,'R');
              $this->SetTextColor(255,0,0);
              $this->SetFont('Helvetica', '', 18);
              $this->Cell(10,5, "",0,1,'R');
              $this->SetFont('Helvetica', '', 22);
              $this->Cell(10,5, "",0,1,'R');
              $this->SetFont('Helvetica', '', 14);
              $this->Cell(190,0, "No.$Corr",0,1,'R');
              //$this->SetTextColor(0,0,0);
              //$this->SetFont('Helvetica','B',12);
              //$this->Cell(0,0,'LIBRO DIARIO',0,0,'C');
              
              //$this->SetFont('Helvetica', '', 8);
              //$this->Cell(10,5, "",0,1,'R');
        
              //$this->SetFont('Helvetica','B',12);
              //$this->Cell(0,0,'ACERCATE',0,0,'C');
        
              //$this->SetFont('Helvetica', '', 8);
              //$this->Cell(150,5, "",0,1,'R');
        
             // $this->SetFont('Helvetica','B',8);
              //$this->Cell(0,0,'Asociación Para el Crecimiento Educativo Reg. Cooperativo y Apoyo Turistico de Esquipulas -ACERCATE-',0,0,'C');
        
              //$this->SetFont('Helvetica', '', 8);
              //$this->Cell(150,2, "",0,1,'R');
        
              //$this->SetFont('Helvetica','B',8);
              //$this->Cell(0,0,'NIT:9206609-7',0,0,'C');
                
              $Corr=$Corr+1;
              
            }
}
//***********************************************************
//***********************************************************


//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,30,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 20);
$pdf->Cell(0,0, "PÓLIZA NO. ".$NoPoliza,0,1,'C');
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(0,0, "Operó: $Usuario",0,1,'R');
$pdf->Cell(0,0, "$FechaHoy - $Hora",0,1,'R');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(0,0, "Fecha de Póliza: ".$Fecha,0,1,'L');
$pdf->MultiCell(0, 0, 'Concepto: '.$Concepto, 0, 'L', 0, 1, '', '', true);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', 'B', 15);
$pdf->Cell(0,0, "Partida",0,1,'C');
$pdf->SetFont('Helvetica', '', 10);
$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
    <td align="center" style="background-color: #C9C9C9"><b>Código</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Cuenta</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Cargos</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Abonos</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Razón</b></td>
    </tr>
EOD;

$Consulta = "SELECT TRANSACCION_DETALLE.*, NOMENCLATURA.N_NOMBRE 
			FROM Contabilidad.TRANSACCION_DETALLE, Contabilidad.NOMENCLATURA
			WHERE TRANSACCION_DETALLE.N_CODIGO = NOMENCLATURA.N_CODIGO 
			AND TRA_CODIGO = '".$Codigo."'";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
$Codigo = $row["N_CODIGO"];
$Nombre = $row["N_NOMBRE"];
$Cargos = $row["TRAD_CARGO_CONTA"];
$Abonos = $row["TRAD_ABONO_CONTA"];
$Razon = $row["TRAD_RAZON"];
$tbl1 .= <<<EOD
<tr>
<td align="left" style="font-size: 8px">$Codigo</td>
<td align="left" style="font-size: 8px">$Nombre</td>
<td align="right" style="font-size: 8px">$Cargos</td>
<td align="right" style="font-size: 8px">$Abonos</td>
<td align="left" style="font-size: 8px">$Razon</td>
</tr>
EOD;
$TotalCargos = $TotalCargos + $Cargos;
$TotalAbonos = $TotalAbonos + $Abonos;
}

$TotalCargos = number_format($TotalCargos, 2, '.', ',');
$TotalAbonos = number_format($TotalAbonos, 2, '.', ',');

$tbl1 .= <<<EOD
<tr>
<td align="left" style="font-size: 8px"><b></b></td>
<td align="left" style="font-size: 8px"><b>Total</b></td>
<td align="right" style="font-size: 8px"><b>$TotalCargos</b></td>
<td align="right" style="font-size: 8px"><b>$TotalAbonos</b></td>
<td align="left" style="font-size: 8px"><b></b></td>
</tr>
</table>
EOD;


$pdf->writeHTML($tbl1,0,0,0,0,'J'); 

if($Tipo == 10 || $Tipo == 13)
{

    $pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
        <td align="center">______________________________________</td>
        <td align="center">______________________________________</td>
    </tr>
    <tr>
        <td align="center">Contabilizó: $Contabilizo</td>
        <td align="center">Revisó</td>
    </tr>
    <tr>
        <td align="center">$NombreContabilizo</td>
        <td align="center"></td>
    </tr>
    <tr>
        <td align="center">$PuestoColaborador</td>
        <td align="center"></td>
    </tr>
EOD;

$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
}
else
{
    $pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
        <td align="center">______________________________________</td>
        <td align="center">______________________________________</td>
    </tr>
    <tr>
        <td align="center">Contabilizó: $Usuario</td>
        <td align="center">Revisó</td>
    </tr>
    <tr>
        <td align="center">$NombreContabilizo</td>
        <td align="center"></td>
    </tr>
    <tr>
        <td align="center">$PuestoColaborador</td>
        <td align="center"></td>
    </tr>
EOD;

$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
}


ob_clean();
$pdf->Output();
ob_flush();
?>