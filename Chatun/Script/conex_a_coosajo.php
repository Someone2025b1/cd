<?php
error_reporting(error_reporting() & ~E_NOTICE);
	$dbc = mysqli_connect("10.60.59.203", "root","redhat12") or die(mysqli_error());
	if (!$dbc) {
  	echo "Error con la base de datos, favor de comunicarse al departamento de IDT para verificar...";
 	 exit;
	}
?>
