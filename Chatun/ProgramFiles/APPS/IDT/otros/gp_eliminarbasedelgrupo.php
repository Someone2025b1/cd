<?php 
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
$eli=$HTTP_GET_VARS["e"]; 
$idgru=$HTTP_GET_VARS["gp"];
$op=$HTTP_GET_VARS["op"];
echo "text".$eli;

$sql = "DELETE FROM coosajo_base_bbdd.detalle_grupo WHERE id_detalle_gp = '$eli' ";
$result=mysqli_query($db, $sql);
?>

<?php
if($op == 1){
header ("Location: gp_detallegrupo?gp=$idgru&s=1");}
if($op ==2){
header ("Location: gp_editargrupo.php?gp=$idgru&s=1");}
ob_flush();
?>