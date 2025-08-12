<?php
include("../../../../../Script/conex.php");

$ID = $_POST['ID'];

$sql = mysqli_query($db, "DELETE FROM Estado_Patrimonial.tarjetas_credito_detalle WHERE id = '".$ID."'");
?>