<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");


    $codigo = $_POST["codigo"];
    $seleccionada = intval($_POST["seleccionada"]);
    $Hay=0;

    if($seleccionada==1){
        $Estado=3;
        
         $query = "UPDATE CompraVenta.PEDIDO_INVENTARIO_DETALLE SET PID_ESTADO = $Estado, PID_FECHA_RECI=CURRENT_DATE(), PID_HORA_RECI=CURRENT_TIMESTAMP() WHERE PID_CODIGO = '$codigo'";
        $resultado = mysqli_query($db, $query);
    }

    $query1 = "SELECT * FROM CompraVenta.PEDIDO_INVENTARIO_DETALLE WHERE PID_CODIGO = '$codigo'";
                $result1 = mysqli_query($db, $query1);
                while($rowP1 = mysqli_fetch_array($result1))
                {
                    $CodigoGeneral=$rowP1["PI_CODIGO"];
                }

    $query = "SELECT * FROM CompraVenta.PEDIDO_INVENTARIO_DETALLE WHERE PID_ESTADO = 2 AND  PI_CODIGO = '$CodigoGeneral'";
                $result = mysqli_query($db, $query);
                while($rowP = mysqli_fetch_array($result))
                {
                    $Hay=1;
                }
                

    if($Hay==0){

         $query = "UPDATE CompraVenta.PEDIDO_INVENTARIO SET PI_ESTADO = 3 WHERE PI_CODIGO = '$CodigoGeneral'";
        $resultado = mysqli_query($db, $query);
    }

    
   

    if ($resultado) {
        echo "Actualización exitosa";
        echo $codigo;
    } else {
        echo "Error al actualizar: " . mysqli_error($db);
    }

?>
