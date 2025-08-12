<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Tipo = $_POST['Tipo']; 
$Inicial = $_POST["Inicial"];
$CostoTotal = $_POST["CostoTotal"];
$Precio = ($CostoTotal / $Inicial) / 100;
$SQL_INSERT = mysqli_query($db, "INSERT INTO Pisicultura.Producto_Pisicultura (Descripcion, InventarioInicial, InventarioAc, CostoTotal, Tipo, Precio, Fecha, Usuario) 
VALUES ('$Tipo', $Inicial, $Inicial, $CostoTotal, '1', $Precio,  CURRENT_TIME, '$id_user')");

if($SQL_INSERT){

	echo '1';
}else {

	echo '2';
}

?>	