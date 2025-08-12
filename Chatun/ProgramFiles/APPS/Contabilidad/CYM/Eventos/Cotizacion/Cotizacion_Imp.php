<?php
ob_start();
session_start();
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../libs/tcpdf/tcpdf.php");
include("../../../../../libs/PHPMailer/PHPMailerAutoload.php");
include("../../../../../libs/PHPMailer/class.phpmailer.php");
include("../../../../../libs/PHPMailer/class.smtp.php");
$id_user = $_SESSION["iduser"];

$GLOBALS['Codigo'] = $_GET["Codigo"];
$TotalCargos = 0;
$TotalAbonos = 0;

$Mes = date('m');

$Anho = date('Y');


$Consulta = "SELECT A.*, B.R_NOMBRE, B.R_CAPACIDAD, C.TE_NOMBRE, D.TM_NOMBRE
FROM Bodega.COTIZACION AS A 
LEFT JOIN Bodega.RANCHO AS B ON A.C_RANCHO = B.R_CODIGO
INNER JOIN Bodega.TIPO_EVENTO AS C ON A.TE_CODIGO = C.TE_CODIGO
LEFT JOIN Bodega.TIPO_MONTAJE AS D ON A.C_TIPO_MONTAJE = D.TM_CODIGO
WHERE A.C_CODIGO = ".$_GET[Codigo];
$Resultado = mysqli_query($db, $Consulta);
$row = mysqli_fetch_array($Resultado);

$NombreCliente = $row[CE_NOMBRE];
$CUI = $row[CE_CUI];
$NIT = $row[CE_NIT];
$Direccion = $row[CE_DIRECCION];
$Telefonos = $row[CE_TELEFONO].' - '.$row[CE_CELULAR];
$Email = $row[CE_EMAIL];
$HoraInicio = date('H:i', strtotime($row[C_HORA_INICIO_EVENTO]));
$HoraFinal = date('H:i', strtotime($row[C_HORA_FIN_EVENTO]));
$CodigoUnico = $row[C_REFERENCIA];
$FechaCotizacion = date('d-m-Y', strtotime($row[C_FECHA_EVENTO]));
$NombreRancho = strtoupper($row[R_NOMBRE]);
$NombreMontaje = strtoupper($row[TM_NOMBRE]);
$FechaXplode = explode("-", $FechaCotizacion);
$ReferenciaCotizacion = $row[C_REFERENCIA];


$TextoRancho = 'Evento en <strong>'.$row[R_NOMBRE].'</strong> con capacidad para '.$row[R_CAPACIDAD].' personas; con mobiliario dispuesto con montaje <strong>'.$row[TM_NOMBRE].'</strong>';


if($FechaXplode[1] == 1)
{
    $NombreMesCotizacion = 'Enero';
}
elseif($FechaXplode[1] == 2)
{
    $NombreMesCotizacion = 'Febrero';
}
elseif($FechaXplode[1] == 3)
{
    $NombreMesCotizacion = 'Marzo';
}
elseif($FechaXplode[1] == 4)
{
    $NombreMesCotizacion = 'Abril';
}
elseif($FechaXplode[1] == 5)
{
    $NombreMesCotizacion = 'Mayo';
}
elseif($FechaXplode[1] == 6)
{
    $NombreMesCotizacion = 'Junio';
}
elseif($FechaXplode[1] == 7)
{
    $NombreMesCotizacion = 'Julio';
}
elseif($FechaXplode[1] == 8)
{
    $NombreMesCotizacion = 'Agosto';
}
elseif($FechaXplode[1] == 9)
{
    $NombreMesCotizacion = 'Septiembre';
}
elseif($FechaXplode[1] == 10)
{
    $NombreMesCotizacion = 'Octubre';
}
elseif($FechaXplode[1] == 11)
{
    $NombreMesCotizacion = 'Noviembre';
}
elseif($FechaXplode[1] == 12)
{
    $NombreMesCotizacion = 'Diciembre';
}

$FechaCotizacion = $FechaXplode[0].' de '.$NombreMesCotizacion.' del '.$FechaXplode[2];


if($Mes == 1)
{
    $NombreMes = 'Enero';
}
elseif($Mes == 2)
{
    $NombreMes = 'Febrero';
}
elseif($Mes == 3)
{
    $NombreMes = 'Marzo';
}
elseif($Mes == 4)
{
    $NombreMes = 'Abril';
}
elseif($Mes == 5)
{
    $NombreMes = 'Mayo';
}
elseif($Mes == 6)
{
    $NombreMes = 'Junio';
}
elseif($Mes == 7)
{
    $NombreMes = 'Julio';
}
elseif($Mes == 8)
{
    $NombreMes = 'Agosto';
}
elseif($Mes == 9)
{
    $NombreMes = 'Septiembre';
}
elseif($Mes == 10)
{
    $NombreMes = 'Octubre';
}
elseif($Mes == 11)
{
    $NombreMes = 'Noviembre';
    $NombreMesCotizacion = 'Noviembre';
}
elseif($Mes == 12)
{
    $NombreMes = 'Diciembre';
    $NombreMesCotizacion = 'Diciembre';
}


$InvitadosAdultos = $row[C_INVITADOS_ADULTOS];
$InvitadosNinos = $row[C_INVITADOS_NINOS];
$Rancho = $row[R_NOMBRE];
$TipoEventoNombre = $row[TE_NOMBRE];

$TextoEvento = $TipoEventoNombre.' para '.$InvitadosAdultos.' Invitados Adultos y '.$InvitadosNinos.' Invitados Niños aproximadamente';

$QueryTotalCotizacion = mysqli_query($db, "SELECT SUM(R_PRECIO_UNITARIO) AS TOTAL_COTIZACION FROM(
                                        SELECT A.R_PRECIO_UNITARIO
                                        FROM Bodega.RANCHO AS A
                                        INNER JOIN Bodega.COTIZACION AS B ON A.R_CODIGO = B.C_RANCHO
                                        WHERE B.C_CODIGO = ".$_GET[Codigo]."
                                        UNION
                                        SELECT SUM(C.PE_SUBTOTAL)
                                        FROM Bodega.PLATILLO_EVENTO AS C 
                                        INNER JOIN Bodega.COTIZACION AS D ON C.C_REFERENCIA = D.C_REFERENCIA
                                        WHERE D.C_CODIGO = ".$_GET[Codigo]."
                                        UNION 
                                        SELECT SUM(E.M_SUBTOTAL)
                                        FROM Bodega.MOBILIARIO_EVENTO AS E
                                        INNER JOIN Bodega.COTIZACION AS F ON E.C_REFERENCIA = F.C_REFERENCIA
                                        WHERE F.C_CODIGO = ".$_GET[Codigo]."
                                        UNION
                                        SELECT SUM(E.MEA_SUBTOTAL)
                                        FROM Bodega.MOBILIARIO_EVENTO_ALQUILER AS E
                                        INNER JOIN Bodega.COTIZACION AS F ON E.C_REFERENCIA = F.C_REFERENCIA
                                        WHERE F.C_CODIGO = ".$_GET[Codigo]."
                                        UNION
                                        SELECT SUM(G.SEC_SUBTOTAL)
                                        FROM Bodega.SERVICIO_EVENTO_CONTRATADO AS G
                                        INNER JOIN Bodega.COTIZACION AS H ON G.C_REFERENCIA = H.C_REFERENCIA
                                        WHERE H.C_CODIGO = ".$_GET[Codigo].") AS RESULT");
$FilaTotalCotizacion = mysqli_fetch_array($QueryTotalCotizacion);

$TotalCotizacion = $FilaTotalCotizacion[TOTAL_COTIZACION];


$TextoPrecioTotal = 'El precio fijado para su evento es de <b>Q. '.number_format($TotalCotizacion, 2).'</b>';

//****************** CUSTOMIZACION **************************
//***********************************************************
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = '../../../../../img/logo.png';
        $this->Image($image_file, 10, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title

        $this->SetFont('helvetica', '', 15);
    }
}
//***********************************************************
//***********************************************************
$pdf = new MYPDF("P","mm","Letter", TRUE, 'UTF-8', FALSE);
$pdf->SetMargins(15,10,15);
// Add a page
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 20);
$pdf->Cell(0,0, "COTIZACIÓN NO. ".$_GET[Codigo],0,1,'C');
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(0,0, $CodigoUnico,0,1,'C');
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(150,7, "",0,1,'R');
$pdf->Cell(0,0, "$id_user",0,1,'R');
$pdf->Cell(0,0, date('d-m-Y H:i:s', strtotime(now)),0,1,'R');
$pdf->SetFont('Helvetica', '', 10);


$tbl1 = <<<EOD
<table cellspacing="0" cellpadding="1">
    <tr>
        <td></td>
    </tr>
    <tr>
        <td align="right"><strong>Esquipulas, $NombreMes de $Anho</strong></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td align="left"><strong>Respetable Sr(a)(ita). $NombreCliente</strong></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td align="justify">Nos es grato saludarle de Parque Chatun, deseándole toda clase de éxitos frente a las labores que a diario realiza; tengo el agrado de dirigirme a usted para informarle por este medio sobre la cotización para el evento $TextoEvento, en fecha tentativa $FechaCotizacion a partir de las $HoraInicio hasta las $HoraFinal.</td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td align="left"><strong>La realización de su evento incluye:</strong></td>
    </tr>
EOD;

$QueryMontaje = mysqli_query($db, "SELECT B.M_NOMBRE, C.TM_NOMBRE
FROM Bodega.MOBILIARIO_EVENTO AS A
INNER JOIN Bodega.MOBILIARIO AS B ON A.M_CODIGO = B.M_CODIGO
INNER JOIN Bodega.TIPO_MOBILIARIO AS C ON B.TM_CODIGO = C.TM_CODIGO
WHERE A.C_REFERENCIA = '".$ReferenciaCotizacion."'
UNION 
SELECT N.MA_NOMBRE, L.TM_NOMBRE
FROM Bodega.MOBILIARIO_EVENTO_ALQUILER AS M
INNER JOIN Bodega.MOBILIARIO_ALQUILER AS N ON M.MA_CODIGO = N.MA_CODIGO
INNER JOIN Bodega.TIPO_MOBILIARIO AS L ON N.TM_CODIGO = L.TM_CODIGO
WHERE M.C_REFERENCIA = '".$ReferenciaCotizacion."'");
$RegistrosMontaje = mysqli_num_rows($QueryMontaje);

if($RegistrosMontaje > 0)
{

$tbl1 .= <<<EOD
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td align="center"><strong>Montaje</strong></td>
    </tr>
    <tr>
        <td align="center">
            <ul>
EOD;

while($FilaMontaje = mysqli_fetch_array($QueryMontaje))
{
    $NombreMontaje = $FilaMontaje[M_NOMBRE].' '.$FilaMontaje[TM_NOMBRE];
    $tbl1 .= <<<EOD
                <li type="circle">$NombreMontaje</li>
EOD;
}

$tbl1 .= <<<EOD
                
            </ul>
        </td>
    </tr>
EOD;
}





$QueryComidaBebida = mysqli_query($db, "SELECT C.RS_NOMBRE
                                    FROM Bodega.PLATILLO_EVENTO AS A
                                    INNER JOIN Bodega.COTIZACION AS B ON A.C_REFERENCIA = B.C_REFERENCIA
                                    INNER JOIN Bodega.RECETA_SUBRECETA AS C ON A.RS_CODIGO = C.RS_CODIGO
                                    WHERE B.C_REFERENCIA = '".$ReferenciaCotizacion."'");
$RegistrosComidaBebida = mysqli_num_rows($QueryComidaBebida);

if($RegistrosComidaBebida > 0)
{
    $tbl1 .= <<<EOD
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td align="center"><strong>Comida / Bebida</strong></td>
    </tr>
    <tr>
        <td align="center">
            <ul>
EOD;

while($FilaComidaBebida = mysqli_fetch_array($QueryComidaBebida))
{
    $NombreComidaBebida = $FilaComidaBebida[RS_NOMBRE];
    $tbl1 .= <<<EOD
                <li type="circle">$NombreComidaBebida</li>
EOD;
}

$tbl1 .= <<<EOD
                
            </ul>
        </td>
    </tr>
EOD;
}


$QueryServicioContratado = mysqli_query($db, "SELECT B.SE_NOMBRE
                        FROM Bodega.SERVICIO_EVENTO_CONTRATADO AS A
                        INNER JOIN Bodega.SERVICIO_EVENTO AS B ON A.SE_CODIGO = B.SE_CODIGO
                        WHERE A.C_REFERENCIA = '' '".$ReferenciaCotizacion."'");
$RegistrosServicioContratado = mysqli_num_rows($QueryServicioContratado);

if($RegistrosServicioContratado > 0)
{
    $tbl1 .= <<<EOD
    <tr>
        <td></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
        <td align="center"><strong>Servicios Contratados</strong></td>
    </tr>
    <tr>
        <td align="center">
            <ul>
EOD;

while($FilaServicioContratado = mysqli_fetch_array($QueryServicioContratado))
{
    $NombreServicioContratado = $FilaServicioContratado[SE_NOMBRE];
    $tbl1 .= <<<EOD
                <li type="circle">$NombreServicioContratado</li>
EOD;
}

$tbl1 .= <<<EOD
                
            </ul>
        </td>
    </tr>
EOD;
}





if($row[C_RANCHO] != '' && $row[C_RANCHO] != 0)
{
$tbl1 .= <<<EOD
    <tr>
        <td></td>
    </tr>
    <tr>
        <td align="justify">$TextoRancho.</td>
    </tr>
    <tr>
        <td align="justify">$TextoPrecioTotal.</td>
    </tr>
</table>
EOD;

$pdf->writeHTML($tbl1,0,0,0,0,'J'); 

$dos = 2;
    $Contador = 2;
    $Cont = 1;

    unset($query);
    unset($result);
    unset($row);
    $w = '80';
    $h = '80';
    $x = '';

    $ValorY = $pdf->GetY();
    $ValorX = $pdf->GetX();

    $pdf->SetY($ValorY+5);
    $pdf->SetX($ValorX);

    $pdf->SetFont('helvetica', 'B', 13);
    $pdf->Cell(0, 0, "IMÁGENES ".$NombreRancho, 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(0, 0, $Fotografias, 0, 1, 'C');


    $query = "SELECT A.*
                FROM Bodega.FOTOGRAFIA_RANCHO AS A
                LEFT JOIN Bodega.RANCHO AS B ON A.R_REFERENCIA = B.R_REFERENCIA
                LEFT JOIN Bodega.COTIZACION AS C ON B.R_CODIGO = C.C_RANCHO
                WHERE C.C_CODIGO = ".$_GET[Codigo];
    $result = mysqli_query($db, $query);
    $NumeroFotos = mysqli_num_rows($result);
    if($NumeroFotos > 0)
    {

        while($row = mysqli_fetch_array($result))
        {
            if($dos == 1)
            {
                $x = $x + 85;
                $dos = 2;
                $ValorY = $pdf->GetY();
                $pdf->Image('../Mantenimiento/'.$row["FR_RUTA"], 110, '', $w, $h);
                $ValorY = $pdf->GetY();
                $y = $ValorY + 90;
                $pdf->SetY($y);
                $Cont++;
            }
            else
            {
                $dos = 1;
                $y = $ValorY = $pdf->GetY();
                $pdf->Image('../Mantenimiento/'.$row["FR_RUTA"], 10, $y, $w, $h);
                if($Cont >= $NumeroFotos)
                {
                    $ValorY = $pdf->GetY();
                    $y = $ValorY + 90;
                    $pdf->SetY($y);
                }
            }
        }
    }

$ValorY = $pdf->GetY();
$Y = 900 * ($Cont);
$pdf->SetY($Y);
$pdf->SetFont('helvetica', '', 9);


$dos = 2;
    $Contador = 2;
    $Cont = 1;

    unset($query);
    unset($result);
    unset($row);
    $w = '80';
    $h = '80';
    $x = '';

    $ValorY = $pdf->GetY();
    $ValorX = $pdf->GetX();

    $pdf->SetY($ValorY+5);
    $pdf->SetX($ValorX);

    $pdf->SetFont('helvetica', 'B', 13);
    $pdf->Cell(0, 0, "IMÁGENES MONTAJE ".$NombreMontaje, 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(0, 0, $Fotografias, 0, 1, 'C');


    $query = "SELECT A.*
FROM Bodega.FOTOGRAFIA_TIPO_MONTAJE AS A
LEFT JOIN Bodega.TIPO_MONTAJE AS B ON A.TM_REFERENCIA = B.TM_REFERENCIA
LEFT JOIN Bodega.COTIZACION AS C ON B.TM_CODIGO = C.C_TIPO_MONTAJE
WHERE C.C_CODIGO = ".$_GET[Codigo];
    $result = mysqli_query($db, $query);
    $NumeroFotos = mysqli_num_rows($result);
    if($NumeroFotos > 0)
    {

        while($row = mysqli_fetch_array($result))
        {
            if($dos == 1)
            {
                $x = $x + 85;
                $dos = 2;
                $ValorY = $pdf->GetY();
                $pdf->Image('../Mantenimiento/'.$row["FTM_RUTA"], 110, '', $w, $h);
                $ValorY = $pdf->GetY();
                $y = $ValorY + 90;
                $pdf->SetY($y);
                $Cont++;
            }
            else
            {
                $dos = 1;
                $y = $ValorY = $pdf->GetY();
                $pdf->Image('../Mantenimiento/'.$row["FTM_RUTA"], 10, $y, $w, $h);
                if($Cont >= $NumeroFotos)
                {
                    $ValorY = $pdf->GetY();
                    $y = $ValorY + 90;
                    $pdf->SetY($y);
                }
            }
        }
    }

$ValorY = $pdf->GetY();
$Y = 900 * ($Cont);
$pdf->SetY($Y);
$pdf->SetFont('helvetica', '', 9);
}
else
{
    $tbl1 .= <<<EOD
</table>
EOD;

$pdf->writeHTML($tbl1,0,0,0,0,'J'); 
}




ob_clean();
$pdf->Output();
$pdf->Output('../Files_Cotizaciones/'.$Codigo.'.pdf', 'F');
ob_flush();

if($_GET[Envio] == 1)
{
	$mail = new PHPMailer;

	$mail->isSMTP();

	$mail->addAddress($Email, ''); // Correo Destino

	$mail->Subject = utf8_decode('Cotización Evento en Chatun'); // Asunto

	$Contenido = '<h1 style="color: #5e9ca0;"><span style="color: #008000;">Buen d&iacute;a Sr(a). '.$Nombre.'!</span></h1>
	<h3 style="color: #2e6c80;">Es un gusto poder saludarle, le recordamos que el d&iacute;a '.date("d-m-Y", strtotime($Fecha)).' a las '.$HoraInicio.' tenemos reservada su degustaci&oacute;n.</h3>';

	$mail->addAttachment('../Files_Cotizaciones/'.$Codigo.'.pdf');

	$mail->msgHTML($Contenido, __DIR__); // Correo en html

	if (!$mail->send()) {

	    echo "Error de Envio: " . $mail->ErrorInfo;

	}
}
?>