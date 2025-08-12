<?php
session_start();
include("../../../../../Script/conex_pdf.php");
include("../../../../../Script/funciones.php");
require("../../../../../Script/fpdf.php");


$colaborador =$_SESSION["iduser"]; //usario que graba


$id_rti=$_GET['id_rti'];
//***********************************************************
//***********************************************************
class PDF extends FPDF
{
// Pie de página
function Footer()
{
	$this->SetTextColor(0,0,0);
	$this->SetRightMargin(15);
    // Posición: a 1,5 cm del final
    $this->SetY(-8);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
	$texto_ver=utf8_decode("Cooperativa de Ahorro y Crédito Integral San José Obrero, R.L. PBX 7873-0808");
    $this->Cell(50,0, $texto_ver."");
    //$this->Cell(76,0,date("Y"),0,0,"C");
   // $this->Cell(50,0,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
}
}
//***********************************************************
//Descargar datos ingresados en formulario

$id_re_aso=$_GET['id_re_aso'];
//***********************************************************
//***********************************************************
$dia=array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
$mes=array("","enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
$numdia=date('w');//muestra el día de la semana
$nummes=date('n');
$diames=date('j');//muestra el día del mes
$anho=date('Y');
$ahora= " $dia[$numdia] $diames de $mes[$nummes] del $anho";
$codigo=date('dmy');
$fecha_hoy=date('Y-m_d');
$hoy=date('Y-m-d');
$ii = 1;

//$ahora=fecha_con_mes($fecha_rti);
//seleccionar LOS DATOS



//***********************************************************
$pdf =new PDF('P','mm','Letter');
$pdf->SetDisplayMode('fullwidth');
$pdf->AliasNbPages();
$pdf->SetMargins(12, 10, 12);
$pdf->AddPage();
$pdf->SetLineWidth(.7); 
$pdf->SetDrawColor(0, 0, 0); 


//TEXTO ENCABEZADO

//CONTENIDO DEL DOCUMENTO


$pdf->SetFont('Arial','B','10');

$pdf->SetFont('Arial','','10');
//CONTENIDO DEL DOCUMENTO
$pdf->SetLineWidth(.1); 

$pdf->Cell(20,3);
$pdf->Cell(0,3, utf8_decode($ahora),0,0,"R");
$pdf->Ln(10);
//sacar la fecha del rando
$pdf->SetFont('Arial','B','14');
$sqla = "SELECT * FROM Estado_Patrimonial.reporte_empleados_riesgo where fecha='$hoy' limit 1   ";
$result_na = mysqli_query($db, $sqla) or die("11".mysqli_error());
$rowa=mysqli_fetch_array($result_na);
$pdf->Cell(0,3, utf8_decode("Periodo Evaluado del  ").date('d-m-Y', strtotime($rowa[6])). utf8_decode("  al  ").date('d-m-Y', strtotime($rowa[7])) ,0,0,"C");
$pdf->Ln(15);
$pdf->SetFont('Arial','','8');
$pdf->MultiCell(185,5,utf8_decode("La cooperativa en cumplimiento a sus atribuciones para el conocimiento del empleado y directivos, ha realizado la verificación de variaciones significativas en lo relacionado al INCREMENTO/DECREMENTO de la situación patrimonial de cada uno de los empleados y directivos, así como también los incrementos en los ACTIVOS y PASIVOS respectivamente. Por lo que presumimos que los empleados o directivos abajo descritos contiene valuación de riesgo significativas en relación a los factores de riesgo de PATRIMONIO, ACTIVOS y PASIVOS; lo que genera una ALERTA por cada uno de ellos y por consiguiente el solicitarle a cada uno pueda presentar la pruebas de descargo para desvanecer dicha ALERTA."),0,"J");

$pdf->Ln(10);
$pdf->SetFont('Arial','B','8');
$pdf->Cell(15,3,  "",0,0,"C");
$pdf->Cell(8,3, "No.",1,0,"C");
$pdf->Cell(15,3, "Cif",1,0,"C");
$pdf->Cell(65,3, "Nombre Colaborador",1,0,"C");
$pdf->Cell(65,3, "Puesto de Trabajo",1,0,"C");
$pdf->Cell(10,3, "Riesgo",1,0,"C");
$pdf->SetFont('Arial','','7');

$sql = "SELECT * FROM Estado_Patrimonial.reporte_empleados_riesgo where fecha='$hoy'   ";
$result_n = mysqli_query($db, $sql) or die("11".mysqli_error());
if($result_n > 0){ while ($row=mysqli_fetch_array($result_n)) { 
$ii++;
$pdf->Ln(3);
$pdf->Cell(15,3,  "",0,0,"C");
$pdf->Cell(8,3,  $ii,1,0,"C");
$pdf->Cell(15,3, $row[1],1,0,"R");
$pdf->Cell(65,3, $row[2],1,0,"L");
$pdf->Cell(65,3, $row[3],1,0,"L");
$pdf->Cell(10,3, $row[4],1,0,"R");
}} //end the cycle
$pdf->SetFont('Arial','B','8');
$pdf->Ln(10);
$pdf->Cell(0,3, utf8_decode("Base Legal:"),0,0,"L");
$pdf->SetFont('Arial','','7');
$pdf->Ln(5);
$pdf->Cell(10,3, utf8_decode("1 "),0,0,"C");
$pdf->MultiCell(150,5,utf8_decode("Congreso de la República de Guatemala, Decreto 67-2001 Ley contra el lavado de dinero u otros activos; Artículo 19 Programas inciso a) Procedimientos que aseguren un alto nivel de integridad del personal y de conocimiento de los antecedentes personales, laborales y patrimoniales de los empleados."),0,"J");
$pdf->Ln(5);
$pdf->Cell(10,3, utf8_decode("2 "),0,0,"C");
$pdf->MultiCell(150,5,utf8_decode("Presidencia de la República de Guatemala, Acuerdo Gubernativo 118-2002 Reglamento de la Ley central el lavado de dinero u otros activos; Articulo 23 Cumplimiento de los programas, normas y procedimientos. Los funcionarios y empleados de las personas obligadas deberán dar cumplimiento a los programas, normas y procedimientos implementados por éstas, en lo que les corresponda."),0,"J");
$pdf->Ln(5);
$pdf->Cell(10,3, utf8_decode("3 "),0,0,"C");
$pdf->MultiCell(150,5,utf8_decode("Manual de Cumplimiento para el Sistema de Prevención de LD y FT, Articulo 22, Política Conoce a tu Empleado y Proveedor es la herramienta fundamental de control que permite asegurar un alto nivel de integridad de los miembros del Consejo de Administración, Comisión de Vigilancia, colaboradores y proveedores de la cooperativa que inicia desde el proceso de selección y debe continuar durante la permanencia de la relación con la cooperativa."),0,"J");
$pdf->Ln(5);
$pdf->Cell(10,3, utf8_decode("3 "),0,0,"C");
$pdf->MultiCell(150,5,utf8_decode("Declaración de buena fe de empleados de COOSAJO R.L.; en apoyo a lo declarado en la cláusula de Obligación de suministrar información y la Ampliación de Estado Patrimonial Si adquiere otros bienes cuyo precio sea mayor de Q.50,000.00 o contrajera acreencias o deudas mayores de Q.50,000.00, tienen la obligación de informarlo a través de la actualización de su correspondiente estado patrimonial"),0,"J");

$pdf->Ln(20);
$pdf->SetFont('Arial','','10');
$pdf->Cell(0,3, utf8_decode('______________________________________'),0,0,"C");
$pdf->Ln(5);
$pdf->Cell(0,3, "Francisco de Jesús Vides Castañeda",0,1,"C");
$pdf->Cell(0,3, "Oficial de Cumplimiento",0,1,"C");
$pdf->Ln(5);
ob_clean();
$pdf->Output();
?>
