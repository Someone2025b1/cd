<?php
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL,"es_ES");

include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
                        
$idEvento         = $_POST['idEvento'];
$start            = $_REQUEST['start'];
$fecha_inicio     = date('Y-m-d', strtotime($start)); 
$end              = $_REQUEST['end']; 
$fecha_fin        = date('Y-m-d', strtotime($end));  


$UpdateProd = ("UPDATE Agenda.EVENTO 
    SET 
    E_FECHA ='$fecha_inicio'

    WHERE E_CODIGO='".$idEvento."' ");
$result = mysqli_query($con, $UpdateProd);

?>