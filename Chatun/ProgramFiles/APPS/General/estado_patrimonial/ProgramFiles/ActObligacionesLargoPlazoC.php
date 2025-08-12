<?php
include("../../../../../Script/conex.php");

$Usuario = $_POST['Usuario'];

$Consulta = mysqli_query($db, "SELECT SUM(saldo_actual) as TOTAL FROM Estado_Patrimonial.obligacioneslp_detalle WHERE entidad_financiera = 'Coosajo R.L.' AND colaborador =  ".$Usuario);
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