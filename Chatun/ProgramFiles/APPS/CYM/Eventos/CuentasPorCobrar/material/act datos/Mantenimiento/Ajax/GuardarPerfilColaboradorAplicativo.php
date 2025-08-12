<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$Colaborador = $_POST["Colaborador"];
$NuevoPerfil = $_POST["NuevoPerfil"];

$Sql_Asignar_Perfil_Colaborador = mysqli_query($db, $portal_coosajo_db, "INSERT INTO portal_coosajo_db.PRIVILEGIO_APLICATIVO_COLABORADOR(PAC_COLABORADOR, PAC_FECHA_ASIGNACION, PAC_ESTADO, PA_CODIGO)VALUES(".$Colaborador.", CURRENT_TIMESTAMP(), 1, ".$NuevoPerfil.")");


if($Sql_Asignar_Perfil_Colaborador)
{
	echo 1;
}
else
{
	echo 0;
}

?>