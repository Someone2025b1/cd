<?php

include("conex.php");
$login=$_POST["username"];
$password=$_POST["password"];
$passwordconfimacion=$_POST["passwordconfimacion"];

if($password === $passwordconfimacion)
{
	$salt = '**__Sup3rAdm1nCHT__**';
	$password = $salt.$password;
	$password = hash('sha256', $password);

	$sql = mysqli_query ($db, "UPDATE info_bbdd.usuarios SET password = '".$password."' WHERE login = '".$login."'");

	if(!$sql)
	{
		echo 'ERROR: '.mysqli_error($sql);
	}	
	else
	{
		$sql1 = mysqli_query ($db, "SELECT C.departamento, A.id_user, A.nombre, A.login, A.password, C.agencia, C.estado, D.agencia AS nombre_agencia, D.municipio AS municipio_agencia FROM info_bbdd.usuarios AS A LEFT JOIN info_colaboradores.datos_generales AS B ON A.id_user = B.cif LEFT JOIN info_colaboradores.datos_laborales AS C ON A.id_user = C.cif LEFT JOIN info_base.agencias AS D ON C.agencia = D.id_agencia WHERE (A.login = '$login' and A.password= '$password')") or die (mysqli_error());	
		$row=mysqli_fetch_array($sql1);

		session_start();
		header("Cache-control: private"); 
		$_SESSION["autentificado"] = "SI";
		$_SESSION["iduser"] = $row["id_user"];
		$_SESSION["nombre_user"] = $row["nombre"];
		$_SESSION["login"] = $row["login"];
		$_SESSION["id_departamento"] = $row["departamento"];
		mysqli_free_result($sql1);
		header("Location: ../ProgramFiles/index.php");
	}
}



?>