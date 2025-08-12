<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$idEvento = $_POST["idEvento"]; 
$total = $_POST["total"];
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "UPDATE Taquilla.INGRESO_EVENTO SET IE_CANTIDAD_PERSONAS = $total + IE_CANTIDAD_PERSONAS WHERE IE_ID = $idEvento");
if($insert){
    echo "1";
}
?>