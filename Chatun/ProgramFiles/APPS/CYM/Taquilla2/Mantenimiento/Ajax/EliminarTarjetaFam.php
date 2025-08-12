<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$numero = $_POST["numero"]; 
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "UPDATE Taquilla.TARJETAS_FAMILIARES SET TF_ESTADO = 2 WHERE TF_NUMERO = $numero")or die(mysqli_error($Query));
if($insert){
    echo "1";
}
?>