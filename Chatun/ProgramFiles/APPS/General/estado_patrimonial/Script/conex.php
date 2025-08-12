<?php
//conecto con la base de datos 
	// Conexion con la base de datos
		$db = mysql_connect("localhost", "admin", "redhat12");
		if (!db)
		{
		  echo "Error con la base de datos, favor intente mas tarde";
		  exit;
		}
//selecciono las BBDD's
		mysql_set_charset('latin1',$db);
		mysql_select_db("coosajo_base_bbdd", $db) or die(mysql_error());
		mysql_select_db("coosajo_base_patrimonio", $db) or die(mysql_error());
?>