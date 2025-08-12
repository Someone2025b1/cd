<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Producto = $_POST["Producto"]; 
$Cantidad = $_POST["Cantidad"];
$Precio   = $_POST["Precio"];

$sql = mysqli_query($db, "INSERT INTO Bodega.ESCALA_PRODUCTO (P_CODIGO,  Cantidad,  Precio, Colaborador, FechaCreacion)
					VALUES ('".$Producto."', '".$Cantidad."',  '".$Precio."',  $id_user, CURRENT_TIMESTAMP)");

if($sql)
{
	echo "1";
} 
?>
