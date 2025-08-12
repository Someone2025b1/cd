<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$noTarjeta 			= $_POST["noTarjeta"];
$adultosTarjeta     = $_POST["adultosTarjeta"];
$cantNinosTarjeta 	= $_POST["cantNinosTarjeta"];
$cantMenTarjeta     = $_POST["cantMenTarjeta"];
$fechaTarjeta       = $_POST["fechaTarjeta"];
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_TARJETAS_FAMILIARES(TF_NUMERO, ITF_ADULTOS, ITF_NINOS, ITF_MENORES_5, ITF_FECHA, ITF_COLABORADOR)
VALUES('$noTarjeta', $adultosTarjeta, $cantNinosTarjeta, $cantMenTarjeta, CURRENT_TIMESTAMP, $id_user)");

if($insert){
    echo "1";
}
?>