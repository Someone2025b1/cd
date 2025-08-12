<?php

include("../../../../Script/conex.php");
$ticket=$_GET["ticket"];
 $comentario=$_GET["comentario"];
 
 /*echo $ticket;
 echo $comentario;*/
 $fecha_actual2 = date("Y-m-d H:i:s");


$sql = "UPDATE coosajo_caidas_enlaces.caidas SET fecha_cierre = '$fecha_actual2', estado = 'c', comentarios = '$comentario' WHERE caidas.tiket = '$ticket' LIMIT 1;";
$result=mysqli_query($db, $sql);

header ("Location: tickes_proceso.php");

?>