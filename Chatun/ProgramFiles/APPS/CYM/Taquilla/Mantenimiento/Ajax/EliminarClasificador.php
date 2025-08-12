<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$idClasificador = $_POST["idClasificador"]; 
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "UPDATE Taquilla.CLASIFICADOR_EVENTO SET CE_ESTADO = 2 WHERE CE_ID = $idClasificador");
if($insert){
    echo "1";
}
?>