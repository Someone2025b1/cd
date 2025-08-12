<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$login=$_POST["Usuario"];
$password=$_POST["Password"];
 
$password = hash('sha256', $password);
 
$sql = mysqli_query($db,"SELECT A.login, A.password FROM info_bbdd.usuarios AS A   
LEFT JOIN info_colaboradores.datos_laborales AS C ON A.id_user = C.cif 
WHERE (A.login = '$login' and A.password= '$password')"); 	 

$Conteo = mysqli_num_rows($sql);
if ($Conteo>0) 
{
 	$row=mysqli_fetch_array($sql);
 	if ($row["login"]=='pccymdrl' || $row["password"]=='9ebb62ff28699336206499a3b9319568c79f77afde21f66785ce1d07a68dabcc') 
 	{
 		echo "1";
 	}
 	else {
 		echo "3";
 	}
} 
else
{
	echo "2";
}

  
?>