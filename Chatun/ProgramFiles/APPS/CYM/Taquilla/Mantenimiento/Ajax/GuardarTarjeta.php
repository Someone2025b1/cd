<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$numeroTarjeta = $_POST["numeroTarjeta"];
$nombreTitular = $_POST["nombreTitular"];
$ingresosDisponibles = $_POST["ingresosDisponibles"];
$fechaVigencia		 = $_POST["fechaVigencia"];
$id_user = $_SESSION["iduser"];

$insert = mysqli_query($db, "INSERT INTO Taquilla.TARJETAS_FAMILIARES(TF_NUMERO, TF_NOMBRE_TITULAR, TF_INGRESOS_DISPONIBLES, TF_VIGENCIA, TF_COLABORADOR, TF_FECHA)
VALUES('$numeroTarjeta', '$nombreTitular', $ingresosDisponibles, '$fechaVigencia', $id_user, CURRENT_TIMESTAMP)"); 
if($insert){
    echo "1";
}
?>