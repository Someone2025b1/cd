<?php
include("../../../../../Script/conex.php");

$Caja = $_POST['Caja'];
$DepositosCoosajo = $_POST['DepositosCoosajo'];
$DepositosBancos = $_POST['DepositosBancos'];
$FondoRetiro = $_POST['FondoRetiro'];
$CuentasPorCobrar = $_POST['CuentasPorCobrar'];
$SubtotalActivoCirculante = $_POST['SubtotalActivoCirculante'];
$UsuarioID = $_POST['UsuarioID'];
$Hoy = date('Y-m-d', strtotime('now'));

//Consulta para saber si ya existe un registro con fecha hoy
$resultado = mysqli_query($db, "SELECT id FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE id = ".$UsuarioID." AND  fecha = '".$Hoy."'");
$número_filas = mysqli_num_rows($resultado);


$sql = mysqli_query($db, "DELETE FROM Estado_Patrimonial.detalle_organizaciones_civiles WHERE id = '".$ID."'");
?>