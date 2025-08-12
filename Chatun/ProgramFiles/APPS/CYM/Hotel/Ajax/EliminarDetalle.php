<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$Id        = $_POST["Id"]; 
 

$Insert = mysqli_query($db,  "DELETE FROM Taquilla.DETALLE_FAC_HOTEL where DC_Id = $Id");
$Insert1 = mysqli_query($db,  "DELETE FROM Taquilla.DETALLE_VALE_FACTURA WHERE DC_Id = $Id");
 
 
if ($Insert) {
    echo "1";
}

?>
