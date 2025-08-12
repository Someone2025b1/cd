<?php
include("../../../../../Script/conex.php");


 	$opciones = '<option disabled="disabled" value="" selected> Elige un Puesto</option>';
    $consulta = "SELECT P_CODIGO, P_NOMBRE FROM RRHH.PUESTO WHERE A_CODIGO = ".$_POST["id"]." ORDER BY P_NOMBRE";
    $result1 = mysqli_query($db, $consulta);
    while($fila = mysqli_fetch_array($result1))
    {
    	$opciones.='<option value="'.$fila["P_CODIGO"].'">'.$fila["P_NOMBRE"].'</option>';
    }

    echo $opciones;
?>
