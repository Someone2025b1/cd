<?php
include("../../../../../Script/conex.php");

	$consulta = "SELECT RES_SERIE FROM Bodega.RESOLUCION WHERE RES_SERIE = '".$_POST["id"]."'";
    $result = mysqli_query($db, $consulta);
	$numero = mysqli_num_rows($result); // obtenemos el número de filas
	if($numero == 0)
	{
		echo $numero;
	}
	else
	{
		$Query = "SELECT MAX(F_NUMERO) AS NUMERO FROM Bodega.FACTURA WHERE F_SERIE = '".$_POST["id"]."'";
		$Resul = mysqli_query($db, $Query);
		$row = mysqli_fetch_array($Resul);
		
		echo $row["NUMERO"]+1;
	}
    
?>
