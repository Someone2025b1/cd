<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../libs/tcpdf/tcpdf.php");


$Usuario = $_SESSION["iduser"];
$FechaHora = date('d-m-Y H:i:s', strtotime('now'));
$User = $_SESSION["login"];

$Factura = $_GET["Codigo"];

$sql = "SELECT * FROM Bodega.FACTURA_SV AS A LEFT JOIN Bodega.RESOLUCION AS B ON A.RES_NUMERO = B.RES_NUMERO WHERE A.F_CODIGO = '".$Factura."'";
$result = mysqli_query($db, $sql);
while($row = mysqli_fetch_array($result))
{
    $Serie  = $row["F_SERIE"];
    $Numero  = $row["F_NUMERO"];
    $NIT    = $row["CLI_NIT"];
    $TipoPago    = $row["F_TIPO"];
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
    $TotalFactura  = $row["F_TOTAL"];
    $PagoEfectivo = number_format($row["F_EFECTIVO"], 2, '.', ',');
    $Cambio = number_format($row["F_CAMBIO"], 2, '.', ',');
    $NumeroOrden = $row["F_ORDEN"];
    $ResolucionNumero = $row["RES_NUMERO"];
    $Descuento = $row["F_CON_DESCUENTO"];    
    $ResolucionNumero = $row["RES_NUMERO"];
    $DTE = $row["F_DTE"];
    $CAE = $row["F_CAE"];

    $DelResolucion = $row["RES_DEL"];
    $AlResolucion = $row["RES_AL"];
    $FechaResolucion = $row["RES_FECHA_INGRESO"];
    $FechaVencimientoResolucion = date('d-m-Y', strtotime($row["RES_FECHA_VENCIMIENTO"]));
}





$sqlCliente = "SELECT * FROM Bodega.CLIENTE WHERE CLI_NIT = '".$NIT."'";
$resultCliente = mysqli_query($db, $sqlCliente);
while($rowC = mysqli_fetch_array($resultCliente))
{
    $Nombre  = utf8_decode($rowC["CLI_NOMBRE"]);
    $Direccion  = utf8_decode($rowC["CLI_DIRECCION"]);
}

$TablaProducto = <<<EOD
<table cellspacing="2" cellpadding="1" border="0">
    <tr>
    <td align="left">CA</td>
    <td align="left">PROD</td>
    <td align="right">P/U</td>
    <td align="right">DESC</td>
    <td align="right">TOT</td>
    </tr>
EOD;

$contJuego=0;

$sqlD = "SELECT FACTURA_SV_DETALLE.*, PRODUCTO.P_NOMBRE, PRODUCTO.P_JUEGOS 
                FROM Bodega.FACTURA_SV_DETALLE, Productos.PRODUCTO 
                WHERE FACTURA_SV_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
                AND FACTURA_SV_DETALLE.F_CODIGO = '".$Factura."'";
$resultD = mysqli_query($db, $sqlD);
while($rowD = mysqli_fetch_array($resultD))
{
    if($rowD["P_CODIGO"]==121){
        $locker=1;
    }

    if($rowD["P_JUEGOS"]==1){

        $contJuego+=1;
        
    }

    $Cantidad  = number_format($rowD["FD_CANTIDAD"], 0, '.', ',');
    $NombreProd  = $rowD["P_NOMBRE"];
    $PrecioUnitario  = number_format($rowD["FD_PRECIO_UNITARIO"], 2, '.', ',');
    $Descuento  = number_format($rowD["FD_DESCUENTO"], 2, '.', ',');
    $Subtotal  = number_format($rowD["FD_SUBTOTAL"], 2, '.', ',');
    $SubTotalTotal = $SubTotalTotal + $rowD["FD_SUBTOTAL"];
    $SubTotalTotalFormato = number_format($SubTotalTotal, 2, '.', ',');
    $Descuento1  += $rowD["FD_DESCUENTO"];
    $TablaProducto .= <<<EOD
    <tr>
    <td align="left" style="font-size: 30px; width: 50px;">$Cantidad</td>
    <td align="left" style="font-size: 30px; width: 230px;">$NombreProd</td>
    <td align="right" style="font-size: 30px; width: 100px;">$PrecioUnitario</td>
    <td align="right" style="font-size: 30px; width: 100px;">$Descuento</td>
    <td align="right" style="font-size: 30px; width: 120px;">$Subtotal</td>
    </tr>
EOD;
}


if($Descuento != 0)
{
    $DescuentoFormato = number_format($Descuento1, 2, '.', ',');
    $TablaProducto .= <<<EOD
    <tr>
    <td align="left" style="font-size: 35px; width: 80px;"></td>
    <td align="left" style="font-size: 35px; width: 270px;">SUBTOTAL</td>
    <td align="right" style="font-size: 35px; width: 120px;">Q.</td>
    <td align="right" style="font-size: 35px; width: 120px;">$SubTotalTotalFormato</td>
    </tr>
EOD;

$TablaProducto .= <<<EOD
    <tr>
    <td align="left" style="font-size: 35px; width: 80px;"></td>
    <td align="left" style="font-size: 35px; width: 270px;"></td>
    <td align="right" style="font-size: 35px; width: 120px;">DESC Q.</td>
    <td align="right" style="font-size: 35px; width: 120px;">$DescuentoFormato</td>
    </tr>
EOD;
}

$TotalFactura = number_format($TotalFactura, 2, '.', ',');

$TablaProducto .= <<<EOD
    <tr>
    <td align="left"></td>
    <td align="left"></td>
    <td align="right">TOTAL Q.</td>
    <td align="right">$TotalFactura</td>
    </tr>
EOD;
$TablaProducto .= <<<EOD
</table>
EOD;

//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {

}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","pt", array(600, 3000), 'UTF-8', FALSE);
// Add a page
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "ASOCIACIÓN PARA EL CRECIMIENTO EDUCATIVO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "REG. COOPERATIVO Y APOYO TURÍSTICO DE ESQUIPULAS";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "-ACERCATE-";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "KILOMETRO 226.5 CARRETERA DE ASFALTADA HACIA";
$pdf->writeHTML($tbl1,1,0,0,0,'C'); 
$tbl1 = "FRONTERA DE HONDURAS";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "PARQUE CHATUN";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "ESQUIPULAS, CHIQUIMULA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "N.I.T. 9206609-7";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 25);
$tbl1 = "DOCUMENTO TRIBUTARIO ELECTRONICO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', 'B', 35);
$tbl1 = "FACTURA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "SERIE: ".$Serie;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "NUMERO: ".$CAE;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "AUTORIZACIÓN: ";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = $DTE;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "$FechaHora";
$pdf->writeHTML($tbl1,1,0,0,0,'R');
$tbl1 = "$User";
$pdf->writeHTML($tbl1,1,0,0,0,'R');
$tbl1 = "Computadora No. 1";
$pdf->writeHTML($tbl1,1,0,0,0,'R');
$tbl1 = "Transacción $Factura";
$pdf->writeHTML($tbl1,1,0,0,0,'R');
$tbl1 = "N.I.T.:     $NIT";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$tbl1 = "NOMBRE:     $Nombre";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
$tbl1 = "----------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 28);
$pdf->writeHTML($TablaProducto,0,0,0,0,'J'); 
$tbl1 = "TIPO PAGO:   $Pago";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
if($rowD["FD_SUBTOTAL"] == 1)
    {
        $tbl1 = "PAGO Q.:         ".$PagoEfectivo;
        $pdf->writeHTML($tbl1,1,0,0,0,'L');
    }
    elseif($rowD["FD_SUBTOTAL"] == 2)
    {
        $tbl1 = "PAGO $.:         ".$PagoEfectivo;
        $pdf->writeHTML($tbl1,1,0,0,0,'L');
    }
    elseif($rowD["FD_SUBTOTAL"] == 3)
    {
        $tbl1 = "PAGO $.:         ".$PagoEfectivo;
        $pdf->writeHTML($tbl1,1,0,0,0,'L');
    }
$tbl1 = "CAMBIO Q.:      $Cambio";
$pdf->writeHTML($tbl1,1,0,0,0,'L');
if($Descuento != 0)
{
    $tbl1 = "Descuento: ".$DescuentoFormato;
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
}
if($TipoPago == 3)
{
    $tbl1 = "";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $tbl1 = "";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $tbl1 = "(f)______________________________";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $tbl1 = "Firma de Aceptación de Crédito";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
}
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "CERTIFICADOR: INFILE, S.A.";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "NIT CERTIFICADOR: 12521337";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "SUJETO A PAGOS TRIMESTRALES";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
if($locker==1){
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $tbl1 = "***************************************";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $pdf->SetFont('helvetica', '', 35);
    $tbl1 = "NOTA";
    $pdf->SetFont('helvetica', '', 35);
    $tbl1 = "EL EXTRAVIO DE LLAVE TIENE UN COSTO DE Q100.00";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $pdf->SetFont('helvetica', '', 35);
    $tbl1 = "GRACIAS POR SU COMPRENSIÓN"; 
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
    $tbl1 = "***************************************";
    $pdf->writeHTML($tbl1,1,0,0,0,'C');
}
$tbl1 = "ESPERAMOS QUE VUELVA PRONTO";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$tbl1 = "GRACIAS POR PREFERIRNOS";
$pdf->writeHTML($tbl1,1,0,0,0,'C');




if ($contJuego>0){

$sqlD = "SELECT FACTURA_SV_DETALLE.*, PRODUCTO.P_NOMBRE, PRODUCTO.P_COMBO, PRODUCTO.P_ICONO
        FROM Bodega.FACTURA_SV_DETALLE, Productos.PRODUCTO 
        WHERE FACTURA_SV_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
        AND FACTURA_SV_DETALLE.F_CODIGO = '".$Factura."' AND PRODUCTO.P_JUEGOS=1";
$resultD = mysqli_query($db, $sqlD);

while($rowD = mysqli_fetch_array($resultD))
{
    $NombreProdu=$rowD["P_NOMBRE"];

    $Cantida=$rowD["FD_CANTIDAD"];
    for ($i=0; $i < $Cantida; $i++) { 
        $Transac  = $rowD["FD_CORRELATIVO"]."-".$i; 
        $Icono  = "../../Juegos/Icono/".$rowD["P_ICONO"]; 

        $codigopr=$rowD["P_CODIGO"];

        if($rowD["P_COMBO"]==1){

            $que = "SELECT COMBO_DETALLE.CD_CANTIDAD, PRODUCTO.P_NOMBRE FROM Productos.COMBO_DETALLE, Productos.PRODUCTO 
            WHERE PRODUCTO.P_CODIGO=COMBO_DETALLE.C_CODIGO AND C_CODIGO=".$codigopr;
            
                $resulte = mysqli_query($db, $que);
                while($rowe = mysqli_fetch_array($resulte))
                {
                    $Canti=$rowe["CD_CANTIDAD"];
                  

                    $NombreProdu=$rowe["P_NOMBRE"];
                    
                    for ($j=0; $j < $Canti; $j++) { 

                        $Transac  = ($j+1)."-".$Canti;

                        $pdf->AddPage();
                        $pdf->SetMargins(5,0,10, true);
                        $pdf->SetFont('Helvetica', '', 20);  
                        $pdf->Cell(0,0, "",0,1,'R'); 
                        $Transac .= <<<EOD
                        <table border="0">  
                            <tr style="font-size: 30px">
                                <td align="left"><b>Generó:</b>  $Usuario <br><b>Fecha: </b> $FechaHora </td>
                                <td align="right"><img src="logo.png" width="100" height="90"></td>
                            </tr> 
                            <tr style="font-size: 30px">
                                <td align="left"><b>PS:</b> Souvenirs </td> 
                            </tr>   
                            <tr style="font-size: 34px">
                                <td colspan="8" align="center"><br><b>CÓDIGO:</b> <br>$DTE</td>
                            </tr>
                            <tr style="font-size: 34px">
                                <td colspan="8" align="center"> $NombreProdu </td>
                            </tr>   
                            <tr style="font-size: 34px">
                                <td colspan="8" align="center"><img src="$Icono" width="200" height="200"></td>
                            </tr>   
                        </table>
                        EOD; 
                        $pdf->writeHTML($Transac,0,0,0,0,'J'); 
                         

                                                                    }
                        }
     
        }else{
            $Transac  = ($i+1)."-".$Cantida;
            $pdf->AddPage();
        $pdf->SetMargins(5,0,10, true);
        $pdf->SetFont('Helvetica', '', 20);  
        $pdf->Cell(0,0, "",0,1,'R'); 
        $Transac .= <<<EOD
        <table border="0">  
            <tr style="font-size: 30px">
                <td align="left"><b>Generó:</b>  $Usuario <br><b>Fecha: </b> $FechaHora </td>
                <td align="right"><img src="logo.png" width="100" height="90"></td>
            </tr> 
            <tr style="font-size: 30px">
                <td align="left"><b>PS:</b> Souvenirs </td> 
            </tr>   
            <tr style="font-size: 34px">
                <td colspan="8" align="center"><br><b>CÓDIGO:</b> <br>$DTE</td>
            </tr>
            <tr style="font-size: 34px">
                <td colspan="8" align="center"> $NombreProdu </td>
            </tr>   
            <tr style="font-size: 34px">
                <td colspan="8" align="center"><img src="$Icono" width="200" height="200"></td>
            </tr>   
        </table>
        EOD; 
        $pdf->writeHTML($Transac,0,0,0,0,'J'); 
        } 
    
 }

    }

}


  # PARA TIKETS

$Logo  = "../../Logo20.png"; 


$Boletos = "SELECT BOLETOS.*
        FROM Bodega.BOLETOS
        WHERE BOLETOS.B_FACTURA = '".$Factura."'";
$Boletos1 = mysqli_query($db, $Boletos);

while($ResBol = mysqli_fetch_array($Boletos1))
{
    $Numero=$ResBol["B_NUMERO"];
    $Punto=$ResBol["B_PUNTO"];

    $Transac1= <<<EOD
    <table border="0">     
        <tr style="font-size: 34px">
            <td colspan="8" align="center"><img src="$Logo" width="165" height="150"></td>
        </tr>   
    </table>
    EOD; 

$pdf->AddPage();
$pdf->SetMargins(5,0,10, true);
$pdf->SetFont('helvetica', '', 15);
$tbl1 = "";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetMargins(5,0,10, true);
$pdf->SetFont('helvetica', '', 15);
$pdf->writeHTML($Transac1,0,0,0,0,'J'); 

$tbl1 = "***************************************";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 55);
$tbl1 = "RIFA";
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 75);
$tbl1 = "Cupón #".$Numero;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);
$tbl1 = "P.V. ".$Punto;
$pdf->writeHTML($tbl1,1,0,0,0,'C');
$pdf->SetFont('helvetica', '', 35);



$tbl1 = "------------------------------------------";
$pdf->writeHTML($tbl1,1,0,0,0,'C');

}

// force print dialog
$js = 'print(true);';
// set javascript
$pdf->IncludeJS($js);
//header('refresh:7; url=Vta.php');
ob_clean();
$pdf->Output();


?>