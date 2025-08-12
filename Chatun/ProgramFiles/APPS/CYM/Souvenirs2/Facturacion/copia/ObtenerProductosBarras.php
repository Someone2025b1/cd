<?php
include("../../../../../Script/conex.php");

	$consulta = "SELECT * FROM Bodega.PRODUCTO WHERE P_CODIGO_BARRAS = '".$_POST["service"]."'";
    $result = mysqli_query($db, $consulta);
    $Resultados = mysqli_num_rows($result);
    if($Resultados == 0)
    {
    	echo $Resultados;
    }
    else
    {
		while($row = mysqli_fetch_array($result))
		{
			echo $row["P_CODIGO"]."*/*".$row["P_NOMBRE"]."*/*".$row["P_PRECIO"];
		}
    }
?>
