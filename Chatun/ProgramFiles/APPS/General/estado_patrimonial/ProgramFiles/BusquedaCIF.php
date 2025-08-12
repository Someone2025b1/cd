<?php
include("../../../../../Script/conex.php");

 	
    $consulta = "SELECT cif, nombre FROM info_asociados.general WHERE cif = ".$_POST["id"];
    $result1 = mysqli_query($db, $consulta);
    while($fila = mysqli_fetch_array($result1))
    {
    	$cif = $fila["cif"];
    	$nombre = utf8_encode($fila["nombre"]);

    	$persona[] = array('cif'=> $cif, 'nombre'=>$nombre);
    }

    $json_string = json_encode($persona);
    echo $json_string;
?>