<?php
include("../../../../../Script/conex.php");

$ID = $_POST['ID'];

$sql = mysqli_query($db, "DELETE FROM Estado_Patrimonial.bienes_inmuebles_detalle WHERE id = '".$ID."'");
?>