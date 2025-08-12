<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$login=$_POST["Usuario"];
$password=$_POST["Password"];
$id_user = $_SESSION["iduser"];
$salt = '**__Sup3rAdm1nCHT__**';
$password = $salt.$password;
$password = hash('sha256', $password);
 
$sql = mysqli_query($db,"SELECT C.departamento, A.id_user FROM info_bbdd.usuarios AS A   
LEFT JOIN info_colaboradores.datos_laborales AS C ON A.id_user = C.cif 
WHERE (A.login = '$login' and A.password= '$password' and A.id_user = '$id_user')"); 	

$Conteo = mysqli_num_rows($sql);
if ($Conteo>0) 
{
 	 echo "1";
} 
else
{
	echo "2";
}

  
?>