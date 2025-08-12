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
 	if ($row["id_user"]==23783 || $row["id_user"]==22045 || $row["id_user"]==53711 || $row["id_user"]==435849 || $row["id_user"]==141797 || $row["id_user"]==23118|| $row["id_user"]==31121 | $row["id_user"]==16583 | $row["id_user"]==28088 | $row["id_user"]==17461) 
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