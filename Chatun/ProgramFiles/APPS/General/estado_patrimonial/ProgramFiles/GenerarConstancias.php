<?php
ob_start();
session_start();
include("../../../../../Script/conex_pdf.php");
include("../../../../../Script/conex_sql_server.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/Numero_Letras_edad.php");
include("../../../../../Script/Numero_a_Letras.php");
include("../../../../../Script/tcpdf/tcpdf.php");
//ini_set("mssql.charset", "UTF-8");
//

$FechaAnalisis = $_POST["FechaAnalisis"];

$i = 1;

$FechaInicio = date('Y-m-d', strtotime($_POST["FIA"]));
$FechaFin    = date('Y-m-d', strtotime($_POST["FFA"]));

$GLOBALS['NombreAsociado'] = '';
$GLOBALS['CIFAsociado'] = '';



//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo_example.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,10,15);
$pdf->SetAutoPageBreak(TRUE, 43);
$pdf->setPrintHeader(FALSE);
$pdf->setPrintFooter(FALSE);
$pdf->SetFont('Helvetica', '', 10);
// Add a page
$Consulta = "SELECT id FROM info_bbdd.usuarios_general WHERE estado=1 ORDER BY id";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
    $TotalRiesgo = 0;
    $ID = $row["id"];

    $Consulta1 = "SELECT fecha FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE (fecha BETWEEN '".$FechaInicio."' AND '".$FechaFin."') AND (id = ".$ID.") ORDER BY fecha ASC LIMIT 1";
    $Resultado1 = mysqli_query($db, $Consulta1);
    while($row1 = mysqli_fetch_array($Resultado1))
    {
        $FechaI = $row1["fecha"];
    }  

    $Consulta2 = "SELECT fecha FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE (fecha BETWEEN '".$FechaInicio."' AND '".$FechaFin."') AND (id = ".$ID.") ORDER BY fecha DESC LIMIT 1";
    $Resultado2 = mysqli_query($db, $Consulta2);
    while($row2 = mysqli_fetch_array($Resultado2))
    {
        $FechaF = $row2["fecha"];
    }    

    $Consulta3 = "SELECT total_activo, total_pasivo, patrimonio FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE (fecha = '".$FechaI."') AND (id = ".$ID.") ORDER BY fecha ASC LIMIT 1";
    $Resultado3 = mysqli_query($db, $Consulta3);
    while($row3 = mysqli_fetch_array($Resultado3))
    {
        $RActivo1 = $row3["total_activo"];
        $RPasivo1 = $row3["total_pasivo"];
        $RPatrimonio1 = $row3["patrimonio"];

    }

    $Consulta4 = "SELECT total_activo, total_pasivo, patrimonio FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE (fecha = '".$FechaF."') AND (id = ".$ID.") ORDER BY fecha DESC LIMIT 1";
    $Resultado4 = mysqli_query($db, $Consulta4);
    while($row4 = mysqli_fetch_array($Resultado4))
    {
        $RActivo2 = $row4["total_activo"];
        $RPasivo2 = $row4["total_pasivo"];
        $RPatrimonio2 = $row4["patrimonio"];

    }

    //Saber la fecha de ingreso del colaborador
    $ConsultaFechaIngreso  = "SELECT fecha_ingreso FROM info_colaboradores.datos_laborales WHERE cif = '".$ID."'";
    $ResultadoFechaIngreso = mysqli_query($db, $ConsultaFechaIngreso);
    while($Fila = mysqli_fetch_array($ResultadoFechaIngreso))
    {
        $FechaIngreso = $Fila["fecha_ingreso"];
    }

    //Si la fecha de ingreso es mayor que la fecha de inicio de los cálculos que despliege mensaje de no aplica
    if($FechaIngreso > $FechaInicio)
    {

        $GLOBALS['CIFAsociado'] = $row["id"];
        
        $GLOBALS['NombreAsociado'] = utf8_encode(saber_nombre_asociado($GLOBALS['CIFAsociado']));

        if(($i % 2) == 0)
        {
            $pdf->AddPage('P', 'A4');
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Text(80, 15, 'ANALISIS DE ESTADO PATRIMONIAL', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(88, 20, 'EMPLEADOS Y DIRECTIVOS', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->Image('../../../../img/logocoope.jpg', 15, 15, 40, 10, 'JPG', '', 'LEFT', true, 150, '', false, false, 0, false, false, false);
            $pdf->Text(15, 30, 'Nombre Empleado:  '.$GLOBALS['NombreAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 35, 'CIF:                            '.$GLOBALS['CIFAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 40, 'Período Analizado:  Del '.date('d-m-Y', strtotime($FechaInicio)).' al '.date('d-m-Y', strtotime($FechaFin)), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 45, 'Fecha de Análisis:   '.date('d-m-Y', strtotime($_POST["FechaAnalisis"])), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 50, '', false, false, true, 0, 1, '', false, '', 0, false, 'T', 'M', false);
            $pdf->SetFont('Helvetica', '', 10);
            $txt = "<br><br><b>NO APLICA, DEBIDO A QUE LA FECHA DE ANÁLISIS ES MENOR QUE LA FECHA DE INGRESO DEL COLABORADOR A LA COOPERATIVA</b>";
            $pdf->writeHTML($txt, true, false, false, false, 'J');
            $txt = "<br><br><br><br>_________________________________________________________________________________________";
            $pdf->writeHTML($txt, true, false, false, false, 'J');
        }
        else
        {
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Text(80, 140, 'ANALISIS DE ESTADO PATRIMONIAL', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(88, 145, 'EMPLEADOS Y DIRECTIVOS', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->Image('../../../../img/logocoope.jpg', 15, 140, 40, 10, 'JPG', '', 'LEFT', true, 150, '', false, false, 0, false, false, false);
            $pdf->Text(15, 160, 'Nombre Empleado:  '.$GLOBALS['NombreAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 165, 'CIF:                            '.$GLOBALS['CIFAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 170, 'Período Analizado:  Del '.date('d-m-Y', strtotime($FechaInicio)).' al '.date('d-m-Y', strtotime($FechaFin)), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 175, 'Fecha de Análisis:   '.date('d-m-Y', strtotime($_POST["FechaAnalisis"])), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 180, '', false, false, true, 0, 1, '', false, '', 0, false, 'T', 'M', false);
            $pdf->SetFont('Helvetica', '', 10);
            $txt = "<b>NO APLICA, DEBIDO A QUE LA FECHA DE ANÁLISIS ES MENOR QUE LA FECHA DE INGRESO DEL COLABORADOR A LA COOPERATIVA</b>";
            $pdf->writeHTML($txt, true, false, false, false, 'J');
        }
    }
    else
    {
        //Saber la cantidad de estados patrimoniales que ha registrado el colaborador
        $SqlRegistros  = "SELECT COUNT(id) AS CANTIDAD_RESGISTROS FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE id = '".$ID."' AND fecha BETWEEN '".$FechaI."' AND '".$FechaF."'";
        $ResultadoRegistros = mysqli_query($db, $SqlRegistros);
        while($FilaRegistros = mysqli_fetch_array($ResultadoRegistros))
        {
            $EstadosPatrimoniales = $FilaRegistros["CANTIDAD_RESGISTROS"];
        }

        //Si la cantidad de estados patrimoniales es mayor a 1 que realice todos los cálculos
        if($EstadosPatrimoniales > 1)
        {
            $IncreDecrePatrimonio = $RPatrimonio2 - $RPatrimonio1;

            if($IncreDecrePatrimonio >=500000)
            {  
                $NotaIncreDecrePatri=10; 
            }
            else
            { 
                if($IncreDecrePatrimonio >=80000)
                {
                    $NotaIncreDecrePatri=((500000 - 80000)*(10-2)) / (( 500000 - 80000) + 2);
                }
                else
                {  
                    $NotaIncreDecrePatri=1; 
                }
            }

            if($RActivo1 != 0)
            {
                $ResultadoActivo = $RActivo2/$RActivo1;
            }

            if($ResultadoActivo > 2)
            { 
                $NotaCrecimientos2=10; 
            }
            else
            {
                if($ResultadoActivo >=1.333)
                { 
                    $NotaCrecimientos2= (($ResultadoActivo -1)*10); 
                }
                else
                {  
                    $NotaCrecimientos2=1;
                }
            }

            $TotalRiesgo = $NotaCrecimientos2 * $NotaIncreDecrePatri;

            if($TotalRiesgo >= 51)
            {
                $NombreRiesgo = 'ALTO';
            }
            elseif($TotalRiesgo >= 31 && $TotalRiesgo <= 50)
            {
                $NombreRiesgo = 'MEDIO';
            }
            elseif($TotalRiesgo >= 0 && $TotalRiesgo <= 30)
            {
                $NombreRiesgo = 'BAJO';
            }

            $GLOBALS['CIFAsociado'] = $row["id"];
            
            $GLOBALS['NombreAsociado'] = utf8_encode(saber_nombre_asociado($GLOBALS['CIFAsociado']));

            if(($i % 2) == 0)
            {
                $pdf->AddPage('P', 'A4');
                $pdf->SetFont('Helvetica', 'B', 12);
                $pdf->Text(80, 15, 'ANALISIS DE ESTADO PATRIMONIAL', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(88, 20, 'EMPLEADOS Y DIRECTIVOS', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->SetFont('Helvetica', 'B', 10);
                $pdf->Image('../../../../img/logocoope.jpg', 15, 15, 40, 10, 'JPG', '', 'LEFT', true, 150, '', false, false, 0, false, false, false);
                $pdf->Text(15, 30, 'Nombre Empleado:  '.$GLOBALS['NombreAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 35, 'CIF:                            '.$GLOBALS['CIFAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 40, 'Período Analizado:  Del '.date('d-m-Y', strtotime($FechaInicio)).' al '.date('d-m-Y', strtotime($FechaFin)), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 45, 'Fecha de Análisis:   '.date('d-m-Y', strtotime($_POST["FechaAnalisis"])), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 50, '', false, false, true, 0, 1, '', false, '', 0, false, 'T', 'M', false);
                $pdf->SetFont('Helvetica', '', 10);
                $txt = "<br><br>En cumplimineto a lo dispuesto en la legislación vigente para la prenveción del lavado de dinero u otros activos y la represión y el financiamiento del terrorismo; ademas de las políticas internas de la Cooperativa como el Manual de Cumplimiento, se procedió con el análisis de los estados patrimoniales presentados por su persona, los cuales son parte de su expediente de empleado. Los cuales a realizarse ciertas ponderación de riesgo en relación al crecimiento PATRIMONIAL y de ACTIVOS en los periodos correspodientes; arroja LA SIGUIENTE INFORMACION: ";
                $pdf->writeHTML($txt, true, false, false, false, 'J');
                $pdf->SetFont('Helvetica', 'B', 10);
                $pdf->Text(15, 90, 'NIVEL DE RIESGO TOTAL:  '.$TotalRiesgo, false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 95, 'RIESGO:                                 '.$NombreRiesgo, false, false, true, 0, 1, '', false, '', 0, false, 'T', 'M', false);
                $pdf->SetFont('Helvetica', '', 10);
                $txt = "<br><br>BASE LEGAL; 1) Congreso de la República de Guatemala, Decreto 67-2001 Ley contra el lavado de dinero u otros activos; Artículo 19 Programas inciso a) Procedimientos que aseguren un alto nivel de integridad del personal y de conocimiento de los antecedentes personales, laborales y patrimoniales de los empleados.";
                $pdf->writeHTML($txt, true, false, false, false, 'J');
                $txt = "<br><br><br><br>_________________________________________________________________________________________";
                $pdf->writeHTML($txt, true, false, false, false, 'J');
            }
            else
            {
                $pdf->SetFont('Helvetica', 'B', 12);
                $pdf->Text(80, 140, 'ANALISIS DE ESTADO PATRIMONIAL', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(88, 145, 'EMPLEADOS Y DIRECTIVOS', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->SetFont('Helvetica', 'B', 10);
                $pdf->Image('../../../../img/logocoope.jpg', 15, 140, 40, 10, 'JPG', '', 'LEFT', true, 150, '', false, false, 0, false, false, false);
                $pdf->Text(15, 160, 'Nombre Empleado:  '.$GLOBALS['NombreAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 165, 'CIF:                            '.$GLOBALS['CIFAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 170, 'Período Analizado:  Del '.date('d-m-Y', strtotime($FechaInicio)).' al '.date('d-m-Y', strtotime($FechaFin)), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 175, 'Fecha de Análisis:   '.date('d-m-Y', strtotime($_POST["FechaAnalisis"])), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 180, '', false, false, true, 0, 1, '', false, '', 0, false, 'T', 'M', false);
                $pdf->SetFont('Helvetica', '', 10);
                $txt = "<br><br>En cumplimineto a lo dispuesto en la legislación vigente para la prenveción del lavado de dinero u otros activos y la represión y el financiamiento del terrorismo; ademas de las políticas internas de la Cooperativa como el Manual de Cumplimiento, se procedió con el análisis de los estados patrimoniales presentados por su persona, los cuales son parte de su expediente de empleado. Los cuales a realizarse ciertas ponderación de riesgo en relación al crecimiento PATRIMONIAL y de ACTIVOS en los periodos correspodientes; arroja LA SIGUIENTE INFORMACION: ";
                $pdf->writeHTML($txt, true, false, false, false, 'J');
                $pdf->SetFont('Helvetica', 'B', 10);
                $pdf->Text(15, 225, 'NIVEL DE RIESGO TOTAL:  '.$TotalRiesgo, false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
                $pdf->Text(15, 230, 'RIESGO:                                 '.$NombreRiesgo, false, false, true, 0, 1, '', false, '', 0, false, 'T', 'M', false);
                $pdf->SetFont('Helvetica', '', 10);
                $txt = "<br><br>BASE LEGAL; 1) Congreso de la República de Guatemala, Decreto 67-2001 Ley contra el lavado de dinero u otros activos; Artículo 19 Programas inciso a) Procedimientos que aseguren un alto nivel de integridad del personal y de conocimiento de los antecedentes personales, laborales y patrimoniales de los empleados.";
                $pdf->writeHTML($txt, true, false, false, false, 'J');
            }
            
        }
        else
        {
            $GLOBALS['CIFAsociado'] = $row["id"];
        
        $GLOBALS['NombreAsociado'] = utf8_encode(saber_nombre_asociado($GLOBALS['CIFAsociado']));

        if(($i % 2) == 0)
        {
            $pdf->AddPage('P', 'A4');
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Text(80, 15, 'ANALISIS DE ESTADO PATRIMONIAL', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(88, 20, 'EMPLEADOS Y DIRECTIVOS', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->Image('../../../../img/logocoope.jpg', 15, 15, 40, 10, 'JPG', '', 'LEFT', true, 150, '', false, false, 0, false, false, false);
            $pdf->Text(15, 30, 'Nombre Empleado:  '.$GLOBALS['NombreAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 35, 'CIF:                            '.$GLOBALS['CIFAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 40, 'Período Analizado:  Del '.date('d-m-Y', strtotime($FechaInicio)).' al '.date('d-m-Y', strtotime($FechaFin)), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 45, 'Fecha de Análisis:   '.date('d-m-Y', strtotime($_POST["FechaAnalisis"])), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 50, '', false, false, true, 0, 1, '', false, '', 0, false, 'T', 'M', false);
            $pdf->SetFont('Helvetica', '', 10);
            $txt = "<br><br><b>NO APLICA, DEBIDO A QUE SOLAMENTE TIENE UN REGISTRO DE SUS ESTADOS PATRIMONIALES EN EL PERIODO ANALIZADO</b>";
            $pdf->writeHTML($txt, true, false, false, false, 'J');
            $txt = "<br><br><br><br>_________________________________________________________________________________________";
            $pdf->writeHTML($txt, true, false, false, false, 'J');
        }
        else
        {
            $pdf->SetFont('Helvetica', 'B', 12);
            $pdf->Text(80, 140, 'ANALISIS DE ESTADO PATRIMONIAL', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(88, 145, 'EMPLEADOS Y DIRECTIVOS', false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->SetFont('Helvetica', 'B', 10);
            $pdf->Image('../../../../img/logocoope.jpg', 15, 140, 40, 10, 'JPG', '', 'LEFT', true, 150, '', false, false, 0, false, false, false);
            $pdf->Text(15, 160, 'Nombre Empleado:  '.$GLOBALS['NombreAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 165, 'CIF:                            '.$GLOBALS['CIFAsociado'], false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 170, 'Período Analizado:  Del '.date('d-m-Y', strtotime($FechaInicio)).' al '.date('d-m-Y', strtotime($FechaFin)), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 175, 'Fecha de Análisis:   '.date('d-m-Y', strtotime($_POST["FechaAnalisis"])), false, false, true, 0, 0, '', false, '', 0, false, 'T', 'M', false);
            $pdf->Text(15, 180, '', false, false, true, 0, 1, '', false, '', 0, false, 'T', 'M', false);
            $pdf->SetFont('Helvetica', '', 10);
            $txt = "<br><br><b>NO APLICA, DEBIDO A QUE SOLAMENTE TIENE UN REGISTRO DE SUS ESTADOS PATRIMONIALES EN EL PERIODO ANALIZADO</b>";
            $pdf->writeHTML($txt, true, false, false, false, 'J');
        }
        }

        
    }


    $i++;
}
// Imprime todo el cuerpo del Contrato
ob_clean();
$pdf->Output();
ob_flush();
?>