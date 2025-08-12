<?php
ob_start();
session_start();
include ("../../../../Script/conex.php");
$idgrupo = $_GET["idgrupo"];
$iduser = $_SESSION["iduser"];
$idaplicacion = $_GET["idaplicacion"]; 

$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT id_nivel FROM ".$base_bbdd.".define_permisos WHERE id_grupo = $idgrupo AND id_user = $iduser AND id_aplicacion = $idaplicacion" ));
$nivel = $tmp[0];
$permiso_aplicacion = $idgrupo."-".$iduser."-".$idaplicacion;
$_SESSION[$permisos_aplicacion] = $nivel;
if ($_SESSION[$permisos_aplicacion] == 10) {
	header("Location: ProgramFiles/menu.php");
} else {
	header("Location: ProgramFiles/menu.php");
}
ob_flush();
?>