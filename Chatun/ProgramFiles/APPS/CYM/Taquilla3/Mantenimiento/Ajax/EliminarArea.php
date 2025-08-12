<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$idArea = $_POST["idArea"]; 
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "UPDATE Taquilla.AREA_UTILIZAR SET AU_ESTADO = 2 WHERE AU_ID = $idArea");
if($insert){
    echo "1";
}
?>