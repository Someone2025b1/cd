<?php
include("../../../../../Script/conex.php");

 	
    $consulta = "SELECT parentesco, dependiente, ocupacion, cif, vive, direccion_hijo, tipo_persona, nombre_no_asociado, fecha_nacimiento_hijo  FROM Estado_Patrimonial.detalle_parentescos WHERE id = ".$_POST["IDParentesco"];
    $result1 = mysqli_query($db, $consulta);
    while($fila = mysqli_fetch_array($result1))
    {
    	$Datos = $fila["parentesco"].",.-".$fila["dependiente"].",.-".$fila["ocupacion"].",.-".$fila["cif"].",.-".$fila["vive"].",.-".$fila["direccion_hijo"].",.-".$fila["tipo_persona"].",.-".$fila["nombre_no_asociado"].",.-".$fila["fecha_nacimiento_hijo"];
    }

    echo $Datos;
?>