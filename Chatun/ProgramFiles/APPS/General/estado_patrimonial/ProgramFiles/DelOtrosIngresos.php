<?php
include("../../../../../Script/conex.php");

$ID = $_POST['ID'];

$sql = mysqli_query($db, "DELETE FROM Estado_Patrimonial.otros_ingresos_detalle WHERE id = '".$ID."'");
?>