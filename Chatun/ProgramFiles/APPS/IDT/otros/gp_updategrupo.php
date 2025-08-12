<?php
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");

//recibir Variables
$id=$_GET["id"];
$nombre=$_GET["nombre_gru"];
$coment=$_GET["comentario"];
$nivel=$_GET["nivel"];
$fecha_actual = date("Y-m-d");
$sql = "UPDATE coosajo_base_bbdd.grupos SET nombre_grupo = '$nombre', comentario = '$coment', nivel = '$nivel' WHERE id_grupos = '$id' ";
$result=mysqli_query($db, $sql);



?>
<?php
header ("Location: gp_editargrupo?gp=$id$&s=1");
ob_flush();
?>