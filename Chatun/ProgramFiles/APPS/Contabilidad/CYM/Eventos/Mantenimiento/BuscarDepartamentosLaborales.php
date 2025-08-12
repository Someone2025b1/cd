<?php
include ("../../../Script/conex.php");

 	$opciones = '<option disabled="disabled" value="" selected> Elige un Puesto</option>';
    $consulta = "SELECT id_puesto, nombre_puesto FROM info_base.define_puestos WHERE id_depto = ".$_POST["id"]." ORDER BY nombre_puesto";
    $result1 = mysqli_query($db, $consulta);
    while($fila = mysqli_fetch_array($result1))
    {
    	$opciones.='<option value="'.$fila["id_puesto"].'">'.$fila["nombre_puesto"].'</option>';
    }

    echo $opciones;
?>
