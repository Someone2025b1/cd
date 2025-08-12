<?php
include ("../../../Script/conex.php");
	
	$Usuario = $_POST["id"];
	$consulta = mysqli_query($db, "UPDATE info_bbdd.usuarios SET password = '9eb883a8eef41445b21f9d0f14702050e12fe4eb27d165cde8864076b7bd021a' WHERE id_user = '".$Usuario."'");
    
    if(!$consulta)
    {
    	echo mysqli_error();
    }
?>
