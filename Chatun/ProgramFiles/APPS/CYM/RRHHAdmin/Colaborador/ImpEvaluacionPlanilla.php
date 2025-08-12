

<?php

ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");

$datosVentas = [16, 20, 12, 16, 16, 8, 12];
$datosVentas2 = [10, 15, 9, 8, 7, 4, 6];

$GLOBALS['Codigo'] = $_GET["Codigo"];
$TotalCargos = 0;
$TotalAbonos = 0;




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
              
             
                $this->Image('EcabezadoEvaluacion.png', 20, 10, 160, 20, '', '', '', false, 100, '', false, false, 0);
                $this->Image('TablaDePromedios.jpg', 15, 100, 120, 50, '', '', '', false, 100, '', false, false, 0);
              
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

$ConsultaG = "SELECT A.*, B.C_NOMBRES, B.C_APELLIDOS, B.C_BASE, B.C_BONO, C.A_NOMBRE, D.P_NOMBRE
            FROM RRHH.EVALUACION_DESEMPENO AS A, RRHH.COLABORADOR AS B, 
            RRHH.AREAS AS C, RRHH.PUESTO AS D
            WHERE A.C_CODIGO = B.C_CODIGO
            AND B.A_CODIGO = C.A_CODIGO
            AND B.P_CODIGO = D.P_CODIGO
            AND A.ED_CODIGO = '".$_GET["Codigo"]."'";
$ResultadoG = mysqli_query($db, $ConsultaG);
while($rowG = mysqli_fetch_array($ResultadoG))
{
    $Nombre=$rowG["C_NOMBRES"]." ".$rowG["C_APELLIDOS"];
    $AreaN=$rowG["A_NOMBRE"];
    $PuestoN=$rowG["P_NOMBRE"];
    $Usuario=$rowG["U_CODIGO"];
    $Base=number_format($rowG["C_BASE"], 2, '.', ',');
    $Bono=number_format($rowG["C_BONO"], 2, '.', ',');
    $Suma1=$rowG["C_BASE"]+$rowG["C_BONO"];
    $Suma=number_format($Suma1, 2, '.', ',');
    $FechaE=date('d/m/Y', strtotime($rowG["ED_FECHA"]));

    
}

$sqlRet = mysqli_query($db,"SELECT A.nombre 
    FROM info_bbdd.usuarios AS A     
    WHERE A.id_user = ".$Usuario); 
    $rowret=mysqli_fetch_array($sqlRet);

    $NombreRealizo=$rowret["nombre"];


//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,25,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 2);

$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(0,0, "Nombre del Colaborador:               ".$Nombre,0,1,'L');
$pdf->Cell(0,0, "Cargo o Puesto que ocupa:            ".$PuestoN,0,1,'L');
$pdf->Cell(0,0, "Área:                                                  ".$AreaN,0,1,'L');
$pdf->Cell(0,0, "Fecha de Evaluación:                      ".$FechaE,0,1,'L');
$pdf->SetFont('Helvetica', '', 2);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->SetFont('Helvetica', 'B', 15);
$pdf->Cell(0,0, "Tabla de Resultados",0,1,'C');
$pdf->SetFont('Helvetica', '', 10);
$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
    <td colspan="2" align="center" style="background-color: #C9C9C9"><b>Área</b></td>
    <td align="center" style="background-color: #C9C9C9"><b>Promedio</b></td>
    </tr>
EOD;


$i=0;
$Consulta = "SELECT * 
            FROM RRHH.EVALUACION_DES_RESUMEN
            WHERE ED_CODIGO = '".$_GET["Codigo"]."'";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
    $Promedio=number_format($row["EVDR_PROMEDIO"], 2, '.', ',');
    $PunteoO=number_format($row["EVDR_PUNTEO"], 2, '.', ',');
    $PunteoE=number_format($row["EVDR_PUNTEO_POS"], 2, '.', ',');
    $Area=$row["AR_CODIGO"];

    $sqlRet = mysqli_query($db,"SELECT A.AR_NOMBRE 
		FROM RRHH.AREA_EVALUAR AS A     
		WHERE A.AR_CODIGO = ".$Area); 
		$rowret=mysqli_fetch_array($sqlRet);

		$NomArea=$rowret["AR_NOMBRE"];

$tbl1 .= <<<EOD
<tr>
<td colspan="2" align="left" style="font-size: 8px">$NomArea</td>
<td align="right" style="font-size: 8px">$Promedio%</td>
</tr>
EOD;
$PromedioF = $PromedioF + $Promedio;
$TotalOb = $TotalOb + $PunteoO;
$TotalEs = $TotalEs + $PunteoE;
$i++;
}
$PromedioFi = $PromedioF/$i;
$PromedioFi = number_format($PromedioFi, 2, '.', ',');
$TotalEs = number_format($TotalEs, 2, '.', ',');
$TotalOb = number_format($TotalOb, 2, '.', ',');

$tbl1 .= <<<EOD
<tr>
<td colspan="2" align="center" style="font-size: 8px"><b>PROMEDIO FINAL</b></td>
<td align="center" style="font-size: 8px"><b>$PromedioFi%</b></td>
<td align="left" style="font-size: 8px"><b></b></td>
</tr>
</table>
EOD;

$pdf->Cell(150,7, "",0,1,'R');


$pdf->writeHTML($tbl1,0,0,0,0,'J'); 

$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1" border="0">
    <tr>
        <td align="center">______________________________________</td>
        <td align="center">______________________________________</td>
    </tr>
    <tr>
        <td align="center">$NombreRealizo</td>
        <td align="center">$Nombre</td>
    </tr>
    <tr>
        <td align="center" style="font-size: 8px">JEFE INMEDIATO</td>
        <td align="center" style="font-size: 8px">COLABORADOR EVALUADO</td>
    </tr>
    <tr>
        <td align="center"></td>
        <td align="center"></td>
    </tr>

    <table cellspacing="0" cellpadding="1" border="0">
    <tr>
        <td align="center">______________________________________</td>
        <td align="center">______________________________________</td>
    </tr>
    <tr>
        <td align="center">Julio César Salguero Ramos</td>
        <td align="center">Yessica Lisely Guzmán González</td>
    </tr>
    <tr>
        <td align="center" style="font-size: 8px">DIRECTOR EJECUTIVO</td>
        <td align="center" style="font-size: 8px">Coordinadora de Gestión del Talento Humano</td>
    </tr>
 
EOD;
if($PromedioFi<=39){

    $P1 = <<<EOD
<p style="font-size: 8px">Atentamente y por este medio hago constar que luego de haber observado y evaluado durante el período de prueba a el colaborador o colaboradora: "$Nombre", en el cargo de: "$PuestoN", quien obtuvo un  DESEMPEÑO "Excelente" en el desarrollo de sus funciones de acuerdo a los criterios de evaluación presentados en este documento, por lo que informo a ustedes la decisión de: </p>
<br>
<p style="font-size: 10px; color: red">Definitivamente NO CONSIDERAR la incorporación de la ó el colaborador ya que NO SUPERÓ EL DESEMPEÑO ESPERADO y no serán contatados sus servicios</p>
 <br>
 <br>
EOD;

}elseif($PromedioFi > 39 && $PromedioFi <=59){

    $P1 = <<<EOD
<p style="font-size: 8px">Atentamente y por este medio hago constar que luego de haber observado y evaluado durante el período de prueba a el colaborador o colaboradora: "$Nombre", en el cargo de: "$PuestoN", quien obtuvo un  DESEMPEÑO "Excelente" en el desarrollo de sus funciones de acuerdo a los criterios de evaluación presentados en este documento, por lo que informo a ustedes la decisión de: </p>
<br>
<p style="font-size: 10px; color: red">(NO considerar la incorporación  de la o el colaborador dentro de la planilla correspondiente, PRORROGANDO  el período de prueba, hasta que se practique la próxima evaluación  de desempeño en la fecha recomendada).</p>
 <br>
 <br>
EOD;

}elseif($PromedioFi>=60){

    $P1 = <<<EOD
<p style="font-size: 8px">Atentamente y por este medio hago constar que luego de haber observado y evaluado durante el período de prueba a el colaborador o colaboradora: "$Nombre", en el cargo de: "$PuestoN", quien obtuvo un  DESEMPEÑO "Excelente" en el desarrollo de sus funciones de acuerdo a los criterios de evaluación presentados en este documento, por lo que informo a ustedes la decisión de: </p>
<br>
<p style="font-size: 10px">Considerar la incorporación  de la o el colaborador dentro de la planilla correspondiente con el salario:  Base Q.$Base + Bono de Ley  Q.$Bono  TOTAL Q.$Suma  de acuerdo a la política salarial vigente, asimismo asignarle los beneficios que por ley se le otorgan así como los que la empresa considere de acuerdo a su normativa y política interna; </p>
 <br>
 <br>
EOD;
}


$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');


$pdf->writeHTML($P1,0,0,0,0,'J'); 
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');


$pdf->writeHTML($tbl1,0,0,0,0,'J'); 



ob_clean();
$pdf->Output();
ob_flush();
?>
