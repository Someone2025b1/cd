<?php
ob_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));
$Colaborador = $_GET['Usuario'];
$i = 0;

/*TITULOS TABLA DE ACTIVOS*/
    $Titulo = array('col1'=>utf8_decode('Código'), 'col2'=>utf8_decode('Descripción'), 'col3'=>utf8_decode('Área'), 'col4'=>utf8_decode('Clasficación'), 'col5'=>utf8_decode('Fecha Adquisición'));
/*FIN TITULOS TABLA DE ACTIVOS*/

/*OPCIONES TABLA DE ACTIVOS*/
    $Opciones = array('fontSize'=>8, 'maxWidth'=>'560', 'shaded'=>1, 'showBgCol'=>1);
/*FIN OPCIONES TABLA DE ACTIVOS*/

$pdf = new Cezpdf('letter','portrait');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezStartPageNumbers(550,20,10,'','',1); 
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Responsabilidad de Activos",14,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);
$pdf->ezText("Responsable: ".$_GET["Usuario"]."     ".utf8_Decode(saber_nombre_colaborador($_GET["Usuario"]),10,array('justification'=>'left')));
$pdf->ezText("", 25);

$query = "SELECT ACTIVO_FIJO.*, AREA_GASTO.AG_NOMBRE, TIPO_ACTIVO.TA_NOMBRE, TRANSACCION.TRA_FECHA_TRANS
FROM Contabilidad.ACTIVO_FIJO, Contabilidad.AREA_GASTO, Contabilidad.TIPO_ACTIVO , Contabilidad.TRANSACCION
WHERE ACTIVO_FIJO.AF_AREA = AREA_GASTO.AG_CODIGO
AND ACTIVO_FIJO.TA_CODIGO = TIPO_ACTIVO.TA_CODIGO
AND ACTIVO_FIJO.AF_TRANSACCION = TRANSACCION.TRA_CODIGO
AND ACTIVO_FIJO.AF_ESTADO = 1
AND ACTIVO_FIJO.AF_RESPONSABLE = ".$_GET["Usuario"];
$result = mysqli_query($db,$query);
while($row = mysqli_fetch_array($result))
{
    $Data[] = array('col1'=>$row["AF_CODIGO"], 'col2'=>utf8_decode($row["AF_NOMBRE"]), 'col3'=>utf8_decode($row["AG_NOMBRE"]), 'col4'=>utf8_decode($row["TA_NOMBRE"]), 'col5'=>date('d-m-Y', strtotime($row["TRA_FECHA_TRANS"])));
    $i++;
}
$pdf->ezTable($Data, $Titulo,'', $Opciones);
$pdf->ezText("", 50);
$pdf->ezText(utf8_decode("NÚMERO DE ACTIVOS:      ".$i."          FECHA DE REVISIÓN FÍSICA:_____________________________"),10,array('justification'=>'left'));
$pdf->ezText("", 20);
$pdf->ezText(utf8_decode("NOTA IMPORTANTE: LOS BIENES A SU CARGO ESTÁN BAJO SU COMPLETA RESPONSABILIDAD, LOS CUALES DEBE DE ENTREGARSE POR CUALQUIER CAMBIO DE CARGO O PRESENTARLOS OBLIGATORIAMENTE DURANTE LOS INVENTARIOS REALIZADOS. EN CASO DE TRASLADO DE BIENES, DEJA DE LABORAR O POSEER EN MAL ESTADO, DEBE NOTIFICARLO POR ESCRITO AL DEPARTAMENTO DE CONTABILIDAD, POR MEDIO DEL ENCARGADO DEL CONTROL DE ACTIVOS FIJOS, PARA LOS CONTROLES RESPECTIVOS."),10,array('justification'=>'full'));
$pdf->ezText("", 50);
$pdf->ezText(utf8_decode("___________________________________                     ___________________________________________________"),10,array('justification'=>'center'));  
$pdf->ezText(utf8_decode(saber_nombre_colaborador($Colaborador)."                                        FIRMA ENCARGADO DE CONTROL DE ACTIVOS FIJOS"),10,array('justification'=>'center'));
$pdf->ezText("", 50);
$pdf->ezText(utf8_decode("OBSERVACIONES"),10,array('justification'=>'left'));
$pdf->ezText("", 10);
$pdf->ezText(utf8_decode("_________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________"),10,array('justification'=>'full'));
ob_clean();
$pdf->ezStream();
?>