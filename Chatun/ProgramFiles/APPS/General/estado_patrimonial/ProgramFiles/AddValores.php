<?php
include("../../../../../Script/conex.php");

$ClaseTitulo = $_POST['ClaseTitulo'];
$Institucion = $_POST['Institucion'];
$MontoInvertido = $_POST['MontoInvertido'];
$ValorComercial = $_POST['ValorComercial'];
$UsuarioID = $_POST['UsuarioID'];

$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.valor_acciones_detalle (clase_titulo, institucion, monto, valor_comercial, colaborador, fecha)
					VALUES ('".$ClaseTitulo."', '".$Institucion."', ".$MontoInvertido.", ".$ValorComercial.", ".$UsuarioID.", CURRENT_DATE())");
?>