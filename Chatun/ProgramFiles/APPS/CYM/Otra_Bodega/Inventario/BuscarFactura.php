<?php
include("../../../../../Script/conex.php");

    $CodigoXplotado = explode("-", $_POST["id"]);

    $Serie = $CodigoXplotado[0];
    $Factura = $CodigoXplotado[1];
		
	$consulta = "SELECT TRA_CODIGO FROM Contabilidad.TRANSACCION WHERE TRA_SERIE = '".$Serie."' AND TRA_FACTURA = '".$Factura."' AND E_CODIGO = 2";
    $result = mysqli_query($db, $consulta);
	$numero = mysqli_num_rows($result); // obtenemos el número de filas

    echo $numero;
?>
