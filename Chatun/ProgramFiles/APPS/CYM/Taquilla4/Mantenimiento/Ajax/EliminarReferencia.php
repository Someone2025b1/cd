<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$idTipo = $_POST["idTipo"]; 
$id_user = $_SESSION["iduser"];
$insert = mysqli_query($db, "UPDATE Taquilla.TIPO_REFERENCIA SET TR_ESTADO = 2 WHERE TR_ID = $idTipo");
if($insert){
    echo "1";
}
?>