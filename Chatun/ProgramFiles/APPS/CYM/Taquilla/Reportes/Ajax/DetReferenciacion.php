<?php
ob_start();
session_start(); 
set_time_limit(300); 
include("../../../../../../Script/conex.php");
include("../../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../../Script/seguridad.php"); 
include("../../../../../../Script/funciones.php");  

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));
$mesObtenido = $_GET['mes'];
$fechaInicial = $_GET["fechaInicial"];
$fechaFinal = $_GET["fechaFinal"]; 
$dia = $_GET["dia"];
$anio = $_GET["anio"];
if ($fechaInicial != "" and $fechaFinal!="") 
{
 $texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
 $filtroAsociados = "DATE(A.IA_FECHA_INGRESO) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroNoA = "DATE(a.INA_FECHA_INGRESO) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroProgramas = "DATE(a.AF_FECHA) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroEvento = "DATE(a.IE_FECHA_EVENTO) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroCortesia = "DATE(a.IC_FECHA) BETWEEN  '$fechaInicial' AND '$fechaFinal'";
 $filtroHotel = "DATE(A.IH_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroTar = "DATE(A.ITF_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
 $filtroRefer = "DATE(A.AF_FECHA) BETWEEN '$fechaInicial' AND '$fechaFinal'";
}
elseif($dia!="")
{
 $texto = "Del día ".cambio_fecha($dia);
 $filtroAsociados = "DATE(A.IA_FECHA_INGRESO) = '$dia'";
 $filtroNoA = "DATE(a.INA_FECHA_INGRESO) = '$dia'";
 $filtroProgramas = "DATE(a.AF_FECHA) = '$dia'";
 $filtroEvento = "DATE(a.IE_FECHA_EVENTO) = '$dia'";
 $filtroCortesia = "DATE(a.IC_FECHA) = '$dia'";
 $filtroHotel = "DATE(A.IH_FECHA) = '$dia'";
 $filtroTar = "DATE(A.ITF_FECHA) = '$dia'";
 $filtroRefer = "DATE(A.AF_FECHA) = '$dia'";
}
elseif($anio!="")
{
 $texto = "Del año ".$anio;
 $filtroAsociados = "YEAR(DATE(A.IA_FECHA_INGRESO)) = '$anio'";
 $filtroNoA = "YEAR(DATE(a.INA_FECHA_INGRESO)) = '$anio'";
 $filtroProgramas = "YEAR(DATE(a.AF_FECHA)) = '$anio'";
 $filtroEvento = "YEAR(DATE(a.IE_FECHA_EVENTO)) = '$anio'";
 $filtroCortesia = "YEAR(DATE(a.IC_FECHA)) = '$anio'";
 $filtroHotel = "YEAR(DATE(A.IH_FECHA))= '$anio'";
 $filtroTar = "YEAR(DATE(A.ITF_FECHA))= '$anio'";
 $filtroRefer = "YEAR(DATE(A.AF_FECHA))= '$anio'";
}
//ASOCIADOS
$selectAsociados = mysqli_query($db, "SELECT A.IAT_CIF_ASOCIADO
FROM Taquilla.INGRESO_ASOCIADO AS A 
WHERE $filtroAsociados
GROUP BY A.IA_FECHA_INGRESO, A.IAT_CIF_ASOCIADO
");
$mayor =0;
$menor= 0;
$menor5=0;
while($rowTarAdultos = mysqli_fetch_array($selectAsociados))
{
	$edad = Saber_Edad_Asociado($rowTarAdultos['IAT_CIF_ASOCIADO']);

	if ($edad>=18) {
		$mayor ++; 
	}
	elseif($edad < 18)
	{
		$menor++; 
	}
	#else
    #{ 
	#	$menor5++;
    #}
	$Totas+=1;

	if(!$edad){
		$Totas+=1;
	}
}
 


$asociadosAcomp = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(IAT_NOMBRE) as total 
FROM Taquilla.INGRESO_ACOMPANIANTE AS A
WHERE $filtroAsociados  
 "));

 
//no asociados
$noAsociadosAdulto = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_ADULTO) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA AND a.INA_ADULTO>0  
 "));

$noAsociadosAdultoM = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_ADULTO_MAYOR) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA AND a.INA_ADULTO_MAYOR>0  
 "));

$noAsociadosNino = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_NINIO) AS SUMA FROM Taquilla.INGRESO_NO_ASOCIADO a
WHERE $filtroNoA AND a.INA_NINIO>0  
 "));

//HOTELES
$selectHotel = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(A.IH_ADULTOS) AS ADULTOS, SUM(A.IH_ADULTO_MAYOR) AS ADULTOSM, SUM(A.IH_NINOS) AS MENORES, SUM(A.IH_MENORES_5) AS MENORES5 FROM Taquilla.INGRESO_HOTEL A 
WHERE $filtroHotel
"));


 //tarjetas insert
$selectTarj = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(A.ITF_ADULTOS) AS ADULTOS, SUM(A.ITF_NINOS) AS NINOS, SUM(A.ITF_MENORES_5) AS MENORES5
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE $filtroTar
"));

$ContarTar = mysqli_fetch_array(mysqli_query($db, "SELECT count(*) as Cont
FROM Taquilla.INGRESO_TARJETAS_FAMILIARES A 
WHERE $filtroTar
"));
 
//MENORES 5 AÑOS INSERT 

$selectUpdMenor = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.INA_NINIO_MENOR_5) AS MENORES5 FROM Taquilla.INGRESO_NO_ASOCIADO a 
WHERE $filtroNoA AND a.INA_NINIO_MENOR_5>0  "));

  
//EJERCICIOS

$selectEjercicios = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.AF_PARTICIPANTES) AS SUMA FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.PROGRAMAS_ACTIVOS b ON a.PA_ID = b.PA_ID
WHERE $filtroProgramas AND a.PA_ID IN (6,8)"));
  
//FORMACION

$selectFormacion = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.AF_PARTICIPANTES) AS SUMA FROM Taquilla.ASOCIADOS_FORMACION a 
INNER JOIN Taquilla.CLASIFICADOR_EVENTO c ON c.CE_ID = a.CE_ID
WHERE $filtroProgramas #AND a.CE_ID = 1 SE comento para que todos los asociados salgan donde pertenecen
 ")); 
//EVENTOS INSERT
 
$selectEventos1 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.IE_CANTIDAD_PERSONAS)  AS SUMA
FROM Taquilla.INGRESO_EVENTO a  
INNER JOIN Taquilla.CLASIFICADOR_EVENTO C ON C.CE_ID = a.CE_ID 
WHERE $filtroEvento"));
 
#$selectEventos2 = mysqli_fetch_array(mysqli_query($db,"SELECT  SUM(A.AF_PARTICIPANTES) AS SUMA
#FROM Taquilla.ASOCIADOS_FORMACION A 
#INNER JOIN Taquilla.PROGRAMAS_ACTIVOS P ON P.PA_ID = A.PA_ID 
#INNER JOIN Taquilla.CLASIFICADOR_EVENTO C ON C.CE_ID = A.CE_ID 
#WHERE $filtroRefer AND A.CE_ID NOT IN (1)"));
$SumaEventos = $selectEventos1["SUMA"];#+$selectEventos2["SUMA"]; se comento para que no sume de mas

 
//CORTESIAS INSERT

$selectCortesia = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.IC_CANTIDAD_PERSONAS) AS SUMA FROM Taquilla.INGRESO_CORTESIA a
WHERE $filtroCortesia"));

$totalAsociado = $$totalAsociado = $mayor+$asociadosAcomp["total"]+$menor+$selectEjercicios["SUMA"]+$selectFormacion["SUMA"];
$totalNoAsociado = $noAsociadosAdulto["SUMA"]+$noAsociadosAdultoM["SUMA"]+$noAsociadosNino["SUMA"]+$selectHotel["ADULTOS"]+$selectHotel["ADULTOSM"]+$selectHotel["MENORES"]+$selectTarj["ADULTOS"]+$selectTarj["NINOS"]+$ContarTar["Cont"];
            
$totalIV = $selectTarj["MENORES5"]+$selectHotel["MENORES5"]+$selectUpdMenor["MENORES5"]+$SumaEventos+$selectCortesia["SUMA"]+$menor5;
$totalM = $totalNoAsociado+$totalIV+$totalAsociado;
$ninos= $selectTarj["MENORES5"]+$selectHotel["MENORES5"]+$selectUpdMenor["MENORES5"]+$menor5;

$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$FechaHorahoy=cambio_fecha($FechaHora);

$sqlRet = mysqli_query($db,"SELECT A.nombre 
FROM info_bbdd.usuarios AS A     
WHERE A.id_user = ".$Username); 
$rowret=mysqli_fetch_array($sqlRet);

$NombreGenero=$rowret["nombre"];

GLOBAL $fecha;
$fecha = date("d-m-Y");
GLOBAL $correlativo;
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo 
    }

    public function Footer() {
    }
}


$Contador = count($StringExplotado);

$StringExplotado = explode(" ", $EspecificarIngreso);

$NuevoStringIngreso = '';

for($x = 1; $x < $Contador; $x++)
{
    if(5 % $x == 0)
    {
        $NuevoStringIngreso = $NuevoStringIngreso."\n";
    }
    else
    {
        $NuevoStringIngreso = $StringExplotado[$x].' '.$NuevoStringIngreso;
    }
}

$pdf = new MYPDF("P","mm","letter", TRUE, 'UTF-8', FALSE);

$pdf->AddPage();
$pdf->SetLineWidth(.3); 
$pdf->SetDrawColor(0, 0, 0); 
$pdf->SetFont('helvetica',10);
$pdf->SetFillColor(255,255,255);   
$tbl1 .= <<<EOD
<table cellspacing="0" cellpadding="1" border="0">   
          <tr>
          <td style="width:150"><img src="logo.png"  width="100" height="100"></td>
          <td style="width:300px" align="center">INGRESOS AL PARQUE <br>
          $texto</td>
         
          </tr>
          <tr>
          <td style="width:auto">Fecha y hora género: $FechaHora</td>
          </tr>
          <tr>
          <td style="width:auto">Por: $NombreGenero</td>
          </tr>
            </table> 
EOD;
$pdf->writeHTML($tbl1, true, false, false, false, '');  
 $pdf->SetFont('helvetica',12);
$tbl .= <<<EOD
 <table cellspacing="0" cellpadding="1" border="1">  
               <tbody> 
              <tr>
                <td>TITULAR TARJETA MI COOPE</td>
                <td align="center">$mayor</td>
              </tr>
              <tr>
                <td>ACOMPAÑANTES TARJETA MI COOPE</td>
                <td align="center">$asociadosAcomp[total]</td>
              </tr>
              <tr>
                <td>NIÑOS TARJETA MI COOPE</td>
                <td align="center">$menor</td>
              </tr>
               <tr>
                <td>EJERCICIOS</td>
                <td align="center">$selectEjercicios[SUMA]</td>
              </tr>
              <tr>
                <td>FORMACION</td>
                <td align="center">$selectFormacion[SUMA]</td>
              </tr>
              <tr bgcolor="#ddd">
                <td>TOTAL ASOCIADOS</td>
                <td align="center">$totalAsociado</td>
              </tr>
              <tr>
                <td>ADULTO NO ASOCIADO</td>
                <td align="center">$noAsociadosAdulto[SUMA]</td>
              </tr>
              <tr>
                <td>ADULTO MAYOR NO ASOCIADO</td>
                <td align="center">$noAsociadosAdultoM[SUMA]</td>
              </tr>
              <tr>
                <td>NIÑO NO ASOCIADO</td>
                <td align="center">$noAsociadosNino[SUMA]</td>
              </tr>
              <tr>
                <td>HOTEL ADULTO</td>
                <td align="center">$selectHotel[ADULTOS]</td>
              </tr>
              <tr>
                <td>HOTEL ADULTO MAYOR</td>
                <td align="center">$selectHotel[ADULTOSM]</td>
              </tr>
              <tr>
                <td>HOTEL NIÑOS</td>
                <td align="center">$selectHotel[MENORES]</td>
              </tr>
              <tr>
                <td>TARJETAS FAMILIARES</td>
                <td align="center">$ContarTar[Cont]</td>
              </tr>
              <tr>
                <td>ACOMPAÑANTES TARJETAS FAMILIARES</td>
                <td align="center">$TotalTar</td>
              </tr>
              <tr bgcolor="#ddd">
                <td>TOTAL NO ASOCIADOS</td>
                <td align="center">$totalNoAsociado</td>
              </tr>
              <tr>
                <td>NIÑOS MENORES 5 AÑOS</td>
                <td align="center">$ninos</td>
              </tr> 
              <tr>
                <td>EVENTOS</td>
                <td align="center">$SumaEventos</td>
              </tr>
              <tr>
                <td>CORTESÍAS</td>
                <td align="center">$selectCortesia[SUMA]</td>
              </tr>
              <tr bgcolor="#ddd">
                <td>TOTAL INGRESOS VARIOS</td>
                <td align="center">$totalIV</td>
              </tr>
              <tr bgcolor="#62CE46">
                <td>TOTAL</td>
                <td align="center">$totalM</td>
              </tr> 

                </tbody>
   </table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->Ln(10);
ob_clean();
$pdf->Output();
$pdf->ezStream(); 
?>
 