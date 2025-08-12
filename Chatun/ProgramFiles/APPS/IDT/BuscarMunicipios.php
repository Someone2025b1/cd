<?php
include ("../../../Script/conex.php");

 	$opciones = '<option disabled="disabled" value="" selected> Elige un Departamento</option>';
    $consulta = "SELECT id_municipio, nombre_municipio FROM info_base.municipios_guatemala WHERE id_departamento = ".$_POST["id"];
    $result1 = mysqli_query($db, $consulta);
    while($fila = mysqli_fetch_array($result1))
    {
    	$opciones.='<option value="'.$fila["id_municipio"].'">'.$fila["nombre_municipio"].'</option>';
    }

    echo $opciones;
?>
