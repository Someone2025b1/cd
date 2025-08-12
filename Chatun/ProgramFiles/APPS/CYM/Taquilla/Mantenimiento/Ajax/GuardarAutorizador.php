<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$nombreAutorizador = $_POST["nombreAutorizador"]; 
$id_user = $_SESSION["iduser"];

$insert = mysqli_query($db, "INSERT INTO Taquilla.AUTORIZADOR_EVENTOS(AE_NOMBRE, AE_ESTADO, AE_COLABORADOR, AE_FECHA)
VALUES('$nombreAutorizador', 1, $id_user, CURRENT_TIMESTAMP)"); 
if($insert){
    echo "1";
}
?>