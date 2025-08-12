<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/PHPMailer/PHPMailerAutoload.php");
include("../../../../../libs/PHPMailer/class.phpmailer.php");
include("../../../../../libs/PHPMailer/class.smtp.php");

$id_user = $_SESSION["iduser"];

$Query               = mysqli_query($db, "SELECT A.D_NOMBRE, A.D_FECHA, A.D_HORA, A.D_EMAIL
									FROM Bodega.DEGUSTACION AS A
									WHERE A.D_REFERENCIA = '".$_POST[Codigo]."'");
$Fila                = mysqli_fetch_array($Query);
$Nombre              = $Fila[D_NOMBRE];
$Fecha               = $Fila[D_FECHA];
$HoraInicio          = $Fila[D_HORA];
$Email  	         = $Fila[D_EMAIL];

$mail = new PHPMailer;

$mail->isSMTP();

$Fecha = date('d-m-Y');

$mail->addAddress($Email, ''); // Correo Destino

$mail->Subject = utf8_decode('Recordatorio Degustación en Chatun'); // Asunto

$Contenido = '<h1 style="color: #5e9ca0;"><span style="color: #008000;">Buen d&iacute;a Sr(a). '.$Nombre.'!</span></h1>
<h3 style="color: #2e6c80;">Es un gusto poder saludarle, le recordamos que el d&iacute;a '.date("d-m-Y", strtotime($Fecha)).' a las '.$HoraInicio.' tenemos reservada su degustaci&oacute;n.</h3>';



$mail->msgHTML($Contenido, __DIR__); // Correo en html

if (!$mail->send()) 
{
	echo "Error de Envio: " . $mail->ErrorInfo;
}
else
{
	echo 1;
}
?>
