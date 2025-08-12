<?php
ob_start(); 
include("../../../../Script/conex.php");
 //recibe la variable

 $agencia=$_POST["agencia"];
 $enlace=$_POST["enlace"];
 $colabo=$_POST["colaborador"];
 $operador=$_POST["nom_operador"];
 $enlace_pro=$_POST["problemas_enlaces"];
 $ticket=$_POST["num_ticket"];
 $fecha_actual2 = date("Y-m-d H:i:s");
 
 echo $agencia ;
 echo $enlace;
 echo $colabo;
 echo $operador;
 echo $enlace_pro;
 echo $ticket;
 echo $fecha_actual2; 
 


$sql = "INSERT INTO coosajo_caidas_enlaces.caidas (id, id_agencia, agencia, colaborador, nombre_operador, problema, tiket, fecha_inicio, fecha_cierre, estado) VALUES (NULL, '$enlace','$agencia', '$colabo', '$operador', '$enlace_pro', '$ticket', '$fecha_actual2', '', 'a');"; 
$result=mysqli_query($db, $sql);

header ("Location: tickes_proceso.php"); 




ob_flush();

?>