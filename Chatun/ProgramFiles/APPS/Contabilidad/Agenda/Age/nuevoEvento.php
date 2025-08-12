<?php
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL,"es_ES");
//$hora = date("g:i:A");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$evento            = ucwords($_POST['evento']);
$Uid       = uniqid("R_");
$Ubicacion            = ucwords($_POST['Lugar']);
$Observaciones            = ucwords($_POST['Observaciones']);
$f_inicio          = $_POST['fecha_inicio'];
$fecha_inicio      = date('Y-m-d', strtotime($f_inicio)); 

$horaini             = $_POST['hora_inicio']; 
$horafin             = $_POST['hora_fin']; 
$Participantes             = $_POST['Participante']; 
$Contador  = count($_POST["Participante"]);
 
$color_evento      = $_POST['color_evento'];


$sqlDocumento = mysqli_query($db, "INSERT INTO Agenda.EVENTO (E_CODIGO, E_TITULO, E_FECHA,  E_COLOR, E_HORA_INICIO, E_HORA_FIN, E_UBICACION, E_OBSERVACIONES, E_ANFITRION)
														VALUES('".$Uid."', '$evento', '$fecha_inicio', '$color_evento', '$horaini', '$horafin', '$Ubicacion', '$Observaciones', '$id_user')");


for($i=1; $i<$Contador; $i++)
	{

		$Participantes1 = $Participantes[$i];
		$ProductoXplotado = explode("/", $Participantes1);
		$Prod = $ProductoXplotado[0];

		$query = mysqli_query($db,"INSERT INTO Agenda.PARTICIPANTES (E_CODIGO, E_USUARIO)
							VALUES('".$Uid."', '".$Prod."')");
	}
				

header("Location:index.php?e=1");

?>