<?php
error_reporting(error_reporting() & ~E_NOTICE);
	$db = mysqli_connect("10.60.58.214", "root","chatun2021");
	if (!$db) {
  	echo "Error con la base de datos, favor de comunicarse al departamento de IDT para verificar...";
 	 exit;
	}
	$db1 = mysqli_connect("10.60.58.214", "root","chatun2021");
//defino tipo de caracteres a manejar.
	mysqli_set_charset($db, 'utf8');
//defino variables globales de las tablas
	$base_asociados = 'info_asociados';
	$base_general = 'info_base';
	$base_bbdd = 'info_bbdd';
	$base_colaboradores = 'info_colaboradores';
?>
