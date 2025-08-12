<?php
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");
    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

$CodigoPerfilEditar = $_POST["CodigoPerfilEditar"];
$NombreEditar = $_POST["NombreEditar"];
$DescripcionEditar = $_POST["DescripcionEditar"];

$Sql_Datos_Perfil = mysqli_query($db, $portal_coosajo_db, "UPDATE portal_coosajo_db.PRIVILEGIO_APLICATIVO
                                                            SET PA_NOMBRE = '".$NombreEditar."', 
                                                                PA_DESCRIPCION = '".$DescripcionEditar."'
                                                    WHERE PA_CODIGO = ".$CodigoPerfilEditar);
if($Sql_Datos_Perfil)
{
    echo 1;
}
else
{
    echo 0;
}

?>