<?php
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuar = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Codigo = $_GET["Codigo"];
$Total=0;
$CON=0;

$TABLAT .= <<<EOD
            <table border="0">  
            EOD; 

$sql = "SELECT A.*, B.CC_NIT, C.CLI_NOMBRE, C.CLI_DIRECCION, D.TRA_CONCEPTO
FROM Contabilidad.CUENTAS_POR_COBRAR_KARDEX AS A,
Contabilidad.CUENTAS_POR_COBRAR AS B,
Bodega.CLIENTE AS C,
Contabilidad.TRANSACCION AS D
WHERE A.CC_CODIGO = B.CC_CODIGO
AND B.CC_NIT = C.CLI_NIT
AND B.F_CODIGO = D.TRA_CODIGO
AND A.T_CODIGO = '".$Codigo."'";
$result = mysqli_query($db,$sql);
while($row = mysqli_fetch_array($result))
{
    $Nit  = $row["CC_NIT"];
    $Nombre  = $row["CLI_NOMBRE"];
    $Direccion  = $row["CLI_DIRECCION"];
    $Monto    = number_format($row["KC_MONTO"], 2, ".", "");
    $Fecha    = date($row["KC_FECHA"]);
    $Usuario  = $row["KC_USER"];
    $Observaciones  = $row["TRA_CONCEPTO"];
    $Estado  = $row["KC_ESTADO"];

    if($Estado==1){
        $AC="Abono";
    }else{
        $AC="Cancelada";
    }

    $Info = explode("Según", $Observaciones);

    


    $TABLAT .= <<<EOD
            
                <tr style="font-size: 22X">
                    <td colspan="8" align="left">$Info[1] </td>
                    <td colspan="3" align="right">$AC </td>
                    <td colspan="2" align="center">$Monto </td>
                </tr>   
            EOD; 

            if($CON==0){
                $Total=$Monto;

            }else{
                $Total=$Total+$Monto;
            }
            $CON+=1;
}
$TABLAT .= <<<EOD
                
            </table>
            EOD; 



$sqlRet = mysqli_query($db,"SELECT A.nombre 
FROM info_bbdd.usuarios AS A     
WHERE A.id_user = ".$Usuario); 
$rowret=mysqli_fetch_array($sqlRet);

$NombreRet=$rowret["nombre"];


if($TipoPago == 1)
    {
        $Pago = 'EFECTIVO';
    }
    elseif($TipoPago == 2)
    {
        $Pago = 'TARJETA CREDITO';
    }
    elseif($TipoPago == 3)
    {
        $Pago = 'CREDITO';
    }
    elseif($TipoPago == 4)
    {
        $Pago = 'DEPOSITO';
    }
    $Icono  = $_SERVER['DOCUMENT_ROOT']."/img/logoev.png"; 


//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {

}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","pt", array(600, 3000), 'UTF-8', FALSE);
// Add a page
$pdf->AddPage();
$pdf->SetMargins(5,0,10, true);
$pdf->SetFont('helvetica', '', 35);

$Transac .= <<<EOD
            <table border="0">  
                
                <tr style="font-size: 34px">
                    <td colspan="8" align="center"><img src="$Icono" width="250" ></td>
                </tr>   
            </table>
            EOD; 
$pdf->writeHTML($Transac,0,0,0,0,'J'); 

$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 25);
$tbl1 = "Parque Chatun";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', 'B', 35);
$tbl1 = "RECIBO DE PAGO CREDITO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "Número: ".$Codigo;
$pdf->writeHTML($tbl1,6,6,6,6,'R');
$tbl1 = "N.I.T.:     $Nit";
$pdf->writeHTML($tbl1,1,0,0,6,'L');
$tbl1 = "NOMBRE:     $Nombre";
$pdf->writeHTML($tbl1,1,0,0,6,'L');
$tbl1 = "DIRECCION:   $Direccion";
$pdf->writeHTML($tbl1,1,0,0,6,'L');
$tbl1 = "FECHA: $Fecha";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->writeHTML($TABLAT,0,0,0,0,'J'); 
$pdf->SetFont('helvetica', '', 40);
$tbl1 = "MONTO: Q."."$Total";
$pdf->writeHTML($tbl1,0,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);

$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');




$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();

?>