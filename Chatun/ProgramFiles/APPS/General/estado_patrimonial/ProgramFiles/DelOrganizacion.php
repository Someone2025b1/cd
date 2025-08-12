<?php
include("../../../../../Script/conex.php");

$ID = $_POST['ID'];

$sql = mysqli_query($db, "DELETE FROM Estado_Patrimonial.detalle_organizaciones_civiles WHERE id = '".$ID."'");
?>