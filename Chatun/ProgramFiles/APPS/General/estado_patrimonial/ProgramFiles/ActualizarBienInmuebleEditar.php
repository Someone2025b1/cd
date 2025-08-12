<?php
include("../../../../../Script/conex.php");

$TipoInmueble = $_POST["TipoInmueble"];
$Localizacion = $_POST["Localizacion"];
$Finca        = $_POST["Finca"];
$Folio        = $_POST["Folio"];
$Libro        = $_POST["Libro"];
$Departamento = $_POST["Departamento"];
$ValorMercado = $_POST["ValorMercado"];
$ID           = $_POST["ID"];
$UsuarioID    = $_POST["UsuarioID"];


$sql = mysqli_query($db, "UPDATE Estado_Patrimonial.bienes_inmuebles_detalle SET id_tipo_inmueble = ".$TipoInmueble.", localizacion = '".$Localizacion."', finca = '".$Finca."', folio = '".$Folio."', libro = '".$Libro."', departamento = '".$Departamento."', valor_mercado = ".$ValorMercado.", fecha = CURRENT_DATE WHERE id = '".$_POST["ID"]."'");


if(!$sql)
{
	echo mysqli_error();
}
else
{
	header('Location: estado_patrimonial.php');
}

?>