<?php
include("../../../../../Script/conex.php");

$DescripcionIngreso = $_POST['DescripcionIngreso'];
$MontoMensualIngreso = $_POST['MontoMensualIngreso'];
$UsuarioID = $_POST['UsuarioID'];

$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.otros_ingresos_detalle (colaborador, descripcion, monto)
					VALUES (".$UsuarioID.", '".$DescripcionIngreso."', ".$MontoMensualIngreso.")");
?>