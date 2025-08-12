<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$autorizadoPor = $_POST["autorizadoPor"];
$lugarProcedencia     = $_POST["lugarProcedencia"];
$cantPersonas 	 = $_POST["cantPersonas"];
$tipoEventoCortesia     = $_POST["tipoEventoCortesia"];
$fechaCortesia = $_POST["fechaCortesia"];
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "INSERT INTO Taquilla.INGRESO_CORTESIA(AE_ID, IC_LUGAR_PROCEDENCIA, IC_CANTIDAD_PERSONAS, E_ID, IC_FECHA, IC_COLABORADOR)
VALUES('$autorizadoPor', '$lugarProcedencia', $cantPersonas, $tipoEventoCortesia, CURRENT_TIMESTAMP, $id_user)");

if($insert){
    echo "1";
}
?>