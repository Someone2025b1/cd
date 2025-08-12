<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$nombreCompletoReferencia = $_POST["nombreCompletoReferencia"];
$edadReferencia  = $_POST["edadReferencia"];
$direccionReferencia  = $_POST["direccionReferencia"];
$trozos = explode(", ", $direccionReferencia);
$municipio= $trozos[0];
$depto =  $trozos[1];
$telefonoReferencia = $_POST["telefonoReferencia"];
$tipoRferencia = $_POST["tipoRferencia"];
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_REFERENCIACION(IR_NOMBRE_COMPLETO, IR_EDAD, IR_MUNICIPIO, IR_DEPARTAMENTO, IR_PAIS, IR_TELEFONO, TR_ID, IR_FECHA, IR_COLABORADOR, IR_ESTADO)
VALUES('$nombreCompletoReferencia', $edadReferencia, '$municipio', $depto, 73, $telefonoReferencia, $tipoRferencia, CURRENT_TIMESTAMP, $id_user, 1)");

if($insert){
    echo "1";
}
?>