<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$CIF = $_POST["CIF"];

$QueryListaNegra = mysqli_query($db, "SELECT * FROM Taquilla.LISTA_NEGRA WHERE LN_CIF_ASOCIADO = ".$CIF);
$Registros = mysqli_fetch_array($QueryListaNegra);

echo $Registros;


?>
