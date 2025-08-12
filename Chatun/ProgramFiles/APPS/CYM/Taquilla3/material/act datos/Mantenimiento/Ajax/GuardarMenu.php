<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$Nombre = $_POST["Nombre"];
$Icono = $_POST["Icono"];
$Orden = $_POST["Orden"];
$Departamento = $_POST["Departamento"];
$AplicativoMenu = $_POST["AplicativoMenu"];

$Sql_Datos_Menu = mysqli_query($db, $portal_coosajo_db, "INSERT INTO portal_coosajo_db.MENU_APLICATIVO(MA_NOMBRE, MA_ORDEN_MENU, MA_ESTADO, MA_ICONO_MENU, MA_DEPARTAMENTO, A_REFERENCIA)VALUES('".$Nombre."', ".$Orden.", 1, '".$Icono."', ".$Departamento.", '".$AplicativoMenu."')");

if($Sql_Datos_Menu)
{
	echo 1;
}
else
{
	echo 0;
}
?>