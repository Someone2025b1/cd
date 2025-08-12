<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$idEvento = $_POST["idEvento"]; 
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "UPDATE Taquilla.EVENTO SET E_ESTADO = 2 WHERE E_ID = $idEvento");
if($insert){
    echo "1";
}
?>