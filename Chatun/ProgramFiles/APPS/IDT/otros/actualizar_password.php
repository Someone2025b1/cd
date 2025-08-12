<?php

include("../../../../Script/conex.php");
$agencia=$_GET["agencia"];
 $clave=$_GET["clave"];
  $id_agencia=$_GET["nu_agencia"];
/*
echo $clave;
echo $id_agencia;
*/

$sql = "UPDATE coosajo_caidas_enlaces.id_agencias SET contrasena = '$clave' WHERE id=$id_agencia ";
$result=mysqli_query($db, $sql);

header ("Location: password.php");

?>