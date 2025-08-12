<?php
include("../../../../../Script/conex.php");



        $ObtenerRango = mysqli_query($db,"SELECT A.P_RANGO, A.A_CODIGO
        FROM RRHH.PUESTO AS A     
        WHERE  A.P_CODIGO = ".$_POST["id"]); 
        $rowret=mysqli_fetch_array($ObtenerRango);

        $Rango=$rowret["P_RANGO"];
        $Area = $rowret["A_CODIGO"];

        $opciones="1";

        if($Rango==3){

            $opciones = '<option disabled="disabled" value="" selected> Elige un Jefe</option>';
    $consulta = "SELECT A.*, B.P_NOMBRE
    FROM RRHH.COLABORADOR AS A, RRHH.PUESTO AS B 
    WHERE A.P_CODIGO = B.P_CODIGO
    AND B.P_RANGO = 2
    ORDER BY B.P_RANGO";
    $result1 = mysqli_query($db, $consulta);
    while($fila = mysqli_fetch_array($result1))
    {
    	$opciones.='<option value="'.$fila["C_CODIGO"].'">'.$fila["C_NOMBRES"].' | '.$fila["P_NOMBRE"].'</option>';
    }

        }elseif($Rango==2){

            $opciones = '<option disabled="disabled" value="" selected> Elige un Jefe</option>';
    $consulta = "SELECT A.*, B.P_NOMBRE
    FROM RRHH.COLABORADOR AS A, RRHH.PUESTO AS B 
    WHERE A.P_CODIGO = B.P_CODIGO
    AND B.P_RANGO = 1
    ORDER BY B.P_RANGO";
    $result1 = mysqli_query($db, $consulta);
    while($fila = mysqli_fetch_array($result1))
    {
    	$opciones.='<option value="'.$fila["C_CODIGO"].'">'.$fila["C_NOMBRES"].' | '.$fila["P_NOMBRE"].'</option>';
    }

        }else{

            $opciones = '<option disabled="disabled" value="" selected> Elige un Jefe</option>';
    $consulta = "SELECT A.*, B.P_NOMBRE
    FROM RRHH.COLABORADOR AS A, RRHH.PUESTO AS B 
    WHERE A.P_CODIGO = B.P_CODIGO
    AND B.P_RANGO < ".$Rango."
    AND A.A_CODIGO =  ".$Area."
    ORDER BY B.P_RANGO";
    $result1 = mysqli_query($db, $consulta);
    while($fila = mysqli_fetch_array($result1))
    {
    	$opciones.='<option value="'.$fila["C_CODIGO"].'">'.$fila["C_NOMBRES"].' | '.$fila["P_NOMBRE"].'</option>';
    }
        }


        if($opciones=='<option disabled="disabled" value="" selected> Elige un Jefe</option>'){

            $opciones = '<option disabled="disabled" value="" selected> Elige un Jefe</option>';
            $consulta = "SELECT A.*, B.P_NOMBRE
            FROM RRHH.COLABORADOR AS A, RRHH.PUESTO AS B 
            WHERE A.P_CODIGO = B.P_CODIGO
            AND B.P_RANGO = 2
            ORDER BY B.P_RANGO";
            $result1 = mysqli_query($db, $consulta);
            while($fila = mysqli_fetch_array($result1))
            {
                $opciones.='<option value="'.$fila["C_CODIGO"].'">'.$fila["C_NOMBRES"].' | '.$fila["P_NOMBRE"].'</option>';
            }

        }

 	

    echo $opciones;
?>
