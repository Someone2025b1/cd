<?php
include("conex.php");
$login=$_POST["user"];
$clave=$_POST["clave"];
// Sentencia SQL para buscar un usuario con esos datos 
$sql = "SELECT * FROM coosajo_base_bbdd.usuarios WHERE (login='$login' and clave='$clave') and estado= '1'";
$result = mysqli_query($db, $sql);
$row=mysqli_fetch_array($result); 
//vemos si el usuario y contraseña es váildo 
//si la ejecución de la sentencia SQL nos da algún resultado 
//es que si que existe esa combinación usuario/contraseña 
if (mysqli_num_rows($result)!=0){ 
    //usuario y contraseña válidos 
	//vefifico si tiene permiso a la base de datos
	$user=$row["id_user"];
    $sql_permiso = "SELECT * FROM coosajo_base_bbdd.permisos WHERE id_user='$user' and id_base='3'"; 
	//Ejecuto la sentencia 
	$result_p = mysqli_query($db, $sql_permiso);
	$row_p=mysqli_fetch_array($result_p); 
	//defino una sesion y guardo datos 
	if (mysqli_num_rows($result_p)!=0){ 
	    session_start(); 
    	session_register("autentificado"); 
	    $autentificado = "SI"; 
		session_register("cuenta");
		$cuenta = $row["id_user"];
		session_register("usuario");
		$usuario = $row["login"];
		session_register("nivel");
		$nivel=$row_p["permiso"];
		if ($nivel ==3){
			header("Location: ../ProgramFiles/menu.php");
		} else {
			header("Location: ../ProgramFiles/menu.php");
		}
	}else { 
    //si no existe le mando otra vez a la portada 
	header("Location: ../index.php?errorusuario=si"); 
	} 
} else {
header("Location: ../index.php?errorusuario=si"); 	
}
mysqli_free_result($result); 
mysqli_close($db); 
?>