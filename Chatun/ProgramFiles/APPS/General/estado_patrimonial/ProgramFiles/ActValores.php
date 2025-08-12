<?php
include("../../../../../Script/conex.php");

$Usuario = $_POST['Usuario'];

$Consulta = mysqli_query($db, "SELECT SUM(valor_comercial) as TOTAL FROM Estado_Patrimonial.valor_acciones_detalle WHERE colaborador =  ".$Usuario);
while($row = mysqli_fetch_array($Consulta))
{
    if($row["TOTAL"] == '')
	{
		$Total = 0;
	}
	else
	{
    	$Total = $row["TOTAL"];
	}                    
}

echo $Total;
?>