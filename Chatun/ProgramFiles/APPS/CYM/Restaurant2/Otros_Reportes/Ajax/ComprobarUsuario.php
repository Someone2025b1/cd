<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$login=$_POST["Usuario"];
$password=$_POST["Password"];
 
$salt = '**__Sup3rAdm1nCHT__**';
$password = $salt.$password;
$password = hash('sha256', $password);
 
$sql = mysqli_query($db,"SELECT C.departamento, A.id_user FROM info_bbdd.usuarios AS A   
LEFT JOIN info_colaboradores.datos_laborales AS C ON A.id_user = C.cif 
WHERE (A.login = '$login' and A.password= '$password')"); 	

$Conteo = mysqli_num_rows($sql);
if ($Conteo>0) 
{
 	$row=mysqli_fetch_array($sql);
 	if ($row["departamento"]==18 || $row["departamento"]==55 || $row["departamento"]==56 || $row["departamento"]==57 )  
 	{
 		echo $row["id_user"];
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