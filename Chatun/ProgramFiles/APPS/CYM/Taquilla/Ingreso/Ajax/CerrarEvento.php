<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$idEvento = $_POST["idEvento"]; 
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "UPDATE Taquilla.INGRESO_EVENTO SET IE_ESTADO = 2 WHERE IE_ID = $idEvento");
if($insert){
    echo "1";
}
?>