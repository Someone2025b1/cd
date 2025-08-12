<?php
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");

//recibir Variables

$nombre=$_GET["nombre_gru"];
$coment=$_GET["comentario"];
$nivel=$_GET["nivel"];
$fecha_actual = date("Y-m-d");


$sql = "INSERT INTO coosajo_base_bbdd.grupos (id_grupos, nombre_grupo, comentario, fecha, nivel) VALUES (NULL, '$nombre', '$coment', '$fecha_actual', '$nivel');"; 
$result=mysqli_query($db, $sql);



?>
<?php
header ("Location: gp_detallegrupo?gp=$nombre");
ob_flush();
?>