<?php
include("../../../../../Script/conex.php");

$DescripcionEgreso = $_POST['DescripcionEgreso'];
$MontoMensualEgreso = $_POST['MontoMensualEgreso'];
$UsuarioID = $_POST['UsuarioID'];

$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.otros_egresos_detalle (colaborador, descripcion, monto)
					VALUES (".$UsuarioID.", '".$DescripcionEgreso."', ".$MontoMensualEgreso.")");
?>