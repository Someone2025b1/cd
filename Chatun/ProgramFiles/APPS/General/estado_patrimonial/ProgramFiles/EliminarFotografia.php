<?php
include("../../../../../Script/conex.php");

$ID = $_GET['ID'];

$sql = mysqli_query($db, "DELETE FROM Estado_Patrimonial.fotografia_colaborador WHERE FC_CODIGO = ".$ID) or die(mysqli_error());

if($sql)
{
	header('Location: informacion_base.php');
}
?>