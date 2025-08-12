
<?php
require("conexion.php");



$Fecha = $_POST['BFecha'];
$idProveedor = $_POST['Proveedor'];

$Total = $_POST['Total'];

$query = "INSERT INTO compras(idProveedor, Fecha, TOTAL) VALUES

('$idProveedor', '$Fecha', '$Total')";
$result = mysqli_query ($conn, $query);

if ($query) {

 /// FIN INSERTA VENTAS



$idCompra =  mysqli_insert_id($conn);

$Producto = $_POST['Producto'];
 $Cantidad = $_POST['Cantidad'];
 $PrecioUnidad = $_POST['PrecioUnit'];
 $subtotal = $_POST['SubTotal'];
 for ($i=0; $i < count($Cantidad); $i++) { 

 $query = "INSERT INTO compraproducto(IdCompra, idProducto, Cantidad, Punitario, PrecioTotal) VALUES

 ('$idCompra','$Producto[$i]','$Cantidad[$i]','$PrecioUnidad[$i]','$subtotal[$i]')";
 $result = mysqli_query ($conn, $query);
 

}

}
if ($result) {
    echo "1";
 };


?>