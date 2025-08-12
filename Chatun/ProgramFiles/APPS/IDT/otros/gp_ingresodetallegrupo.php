<?php
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");

//recibir Variables

$base=$_GET["bases"];
$idgru=$_GET["idgru"];
$fecha_actual = date("Y-m-d");


$sql = "INSERT INTO coosajo_base_bbdd.detalle_grupo (id_detalle_gp, id_grupos, id_base) VALUES (NULL, '$idgru', '$base');"; 
$result=mysqli_query($db, $sql);



?>
<?php
header ("Location: gp_detallegrupo?gp=$idgru&s=1");
ob_flush();
?>