<?php

include("../../../../Script/conex.php");
$ticket=$_GET["ticket"];
 $comentario=$_GET["comentario"];
 
 /*echo $ticket;
 echo $comentario;*/
 $fecha_actual2 = date("Y-m-d H:i:s");


$sql = "INSERT INTO `coosajo_caidas_enlaces`.`secuencia_ticket` (`id`, `nun_ticket`, `comentarios`, `fecha`) VALUES (NULL, '$ticket','$comentario','$fecha_actual2');"; 
$result=mysqli_query($db, $sql);

header ("Location: tickes_proceso.php");

?>