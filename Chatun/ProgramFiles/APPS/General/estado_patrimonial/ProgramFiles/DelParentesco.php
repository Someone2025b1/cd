<?php
include("../../../../../Script/conex.php");

$Usuario = $_POST['CifCol'];
$Pariente = $_POST['CifPar'];

$sql = mysqli_query($db, "DELETE FROM Estado_Patrimonial.detalle_parentescos WHERE id = '".$Pariente."' AND colaborador = '".$Usuario."'");
?>