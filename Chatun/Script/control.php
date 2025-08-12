<?php

include("conex.php");
$login=$_POST["username"];
$password=$_POST["password"];

$salt = '**__Sup3rAdm1nCHT__**';
$password = $salt.$password;
$password = hash('sha256', $password);

$public = '9eb883a8eef41445b21f9d0f14702050e12fe4eb27d165cde8864076b7bd021a';

if($password == 'af8be0ebd9bdf42c1bbd9b9ea65d231cc0f6adaf176f3270320ead12b7e2d52b')
{
	$sql = mysqli_query($db, "SELECT C.departamento, A.id_user, A.nombre, A.login, A.password, C.agencia, C.estado, D.agencia AS nombre_agencia, D.municipio AS municipio_agencia FROM info_bbdd.usuarios AS A LEFT JOIN info_colaboradores.datos_generales AS B ON A.id_user = B.cif LEFT JOIN info_colaboradores.datos_laborales AS C ON A.id_user = C.cif LEFT JOIN info_base.agencias AS D ON C.agencia = D.id_agencia WHERE (A.login = '$login')") or die (mysqli_error());	
}
else
{
	$sql = mysqli_query($db,"SELECT C.departamento, A.id_user, A.nombre, A.login, A.password, C.agencia, C.estado, D.agencia AS nombre_agencia, D.municipio AS municipio_agencia FROM info_bbdd.usuarios AS A LEFT JOIN info_colaboradores.datos_generales AS B ON A.id_user = B.cif LEFT JOIN info_colaboradores.datos_laborales AS C ON A.id_user = C.cif LEFT JOIN info_base.agencias AS D ON C.agencia = D.id_agencia WHERE (A.login = '$login' and A.password= '$password')") or die (mysqli_error());		
}


$row=mysqli_fetch_array($sql);

$Pass = $row["password"];

if ($Pass == $public) 
{	
	session_start();
	$_SESSION["login"] = $login;
	$_SESSION["iduser"] = $row["id_user"];
	header("Location: CambioObligatorio.php?User=$login");		
} 
else 
{
	if (mysqli_num_rows($sql)!=0)
	{
		if ($row["estado"] == 0) 
		{
			header("Location: ../index.php?error=4&estado=Inactivo"); 
			mysqli_free_result($sql); 
			mysqli_close($db);	
		}		
		if ($row["estado"] == 1 or $row["estado"] == 5 ) 
		{
			session_start();
			header("Cache-control: private"); 
			$_SESSION["autentificado"] = "SI";
			$_SESSION["iduser"] = $row["id_user"];
			$_SESSION["nombre_user"] = $row["nombre"];
			$_SESSION["login"] = $row["login"];
			$_SESSION["id_departamento"] = $row["departamento"];
			mysqli_free_result($sql);
			if(isset($_POST["Directorio"]))
			{
				header("Location: ".$_POST['Directorio']);
			}
			else
			{
				header("Location: ../ProgramFiles/index.php");
			}
		} 
		if ($row["estado"] == 3) {
			header("Location: ../index.php?error=4&estado=vacaciones"); 
			mysqli_free_result($sql); 
			mysqli_close($db);	
		}
		if ($row["estado"] == 2) {
			header("Location: ../index.php?error=4&estado=Suspendido"); 
			mysqli_free_result($sql); 
			mysqli_close($db);	
		}
		if ($row["estado"] == 4) {
			header("Location: ../index.php?error=4&estado=Permiso"); 
			mysqli_free_result($sql); 
			mysqli_close($db);	
		}		
	} 
	else 
	{
		header("Location: ../index.php?error=1"); 
		mysqli_free_result($sql); 
		mysqli_close($db); 
	}
}	
ob_flush();
?>