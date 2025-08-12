<?php
include("../../../../../Script/conex.php");

$TipoInmueble = $_POST['TipoInmueble'];
$Localizacion = $_POST['Localizacion'];
$Finca = $_POST['Finca'];
$Folio = $_POST['Folio'];
$Libro = $_POST['Libro'];
$Departamento = $_POST['Departamento'];
$ValorMercado = $_POST['ValorMercado'];
$UsuarioID = $_POST['UsuarioID'];

$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.bienes_inmuebles_detalle (id_tipo_inmueble, localizacion, finca, folio, libro, departamento, valor_mercado, colaborador, fecha)
					VALUES (".$TipoInmueble.", '".$Localizacion."', '".$Finca."', '".$Folio."', '".$Libro."', '".$Departamento."', ".$ValorMercado.", ".$UsuarioID.", CURRENT_DATE())");
?>