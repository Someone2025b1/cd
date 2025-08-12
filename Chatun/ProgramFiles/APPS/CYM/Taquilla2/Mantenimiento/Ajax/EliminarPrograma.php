<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$idPrograma = $_POST["idPrograma"]; 
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "UPDATE Taquilla.PROGRAMAS_ACTIVOS SET PA_ESTADO = 2 WHERE PA_ID = $idPrograma");
if($insert){
    echo "1";
}
?>