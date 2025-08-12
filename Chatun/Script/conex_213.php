<?php
error_reporting(error_reporting() & ~E_NOTICE);
	$db_213 = mysql_connect("10.60.59.213", "root","redhat12")or die(mysql_error());
	if (!$db_213) {
  	echo "Error con la base de datos, favor de comunicarse al departamento de IDT para verificar...";
 	 exit;
	}
	$db1 = mysql_connect("10.60.59.213", "root","redhat12");
//defino tipo de caracteres a manejar.
	mysql_set_charset('utf8',$db_213);
//defino variables globales de las tablas
	$base_asociados = 'info_asociados';
	$base_general = 'info_base';
	$base_bbdd = 'info_bbdd';
	$base_colaboradores = 'info_colaboradores';
?>
