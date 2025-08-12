
<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$IdUser = $_SESSION["iduser"];
$TotalTicket = $_POST['TotalTicket'];
$RebajarTicket = $_POST['RebajarTicket'];
$CodigoTalonario = $_POST['CodigoTalonario'];

$RebajarTicket = mysqli_query($db, "INSERT INTO Taquilla.DETALLE_REBAJO_TICKET (ATT_CODIGO, ATT_TOTAL_TICKET, ATT_REBAJAR_TICKET, DRT_COLABORADOR, DRT_FECHA, DRT_HORA) values ('$CodigoTalonario', $TotalTicket, $RebajarTicket, $IdUser, CURDATE(), NOW())");

	if($RebajarTicket)
	{
		echo "1";
	}

?>
