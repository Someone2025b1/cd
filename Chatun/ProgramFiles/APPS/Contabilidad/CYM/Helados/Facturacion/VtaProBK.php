<?PHP

$Contador = count($_POST["Cantidad"]);
$EligeSabor = $_POST["EligeSabor"];

echo $Contador."<br>";

for($i = 1; $i<$Contador; $i++)
{
	echo $i.' Pasada'.$EligeSabor[$i].'<br>';
}

?>