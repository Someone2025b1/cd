<?php
$mysqli = new mysqli("localhost", "root", "redhat12", "Estado_Patrimonial");
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}	
if (!$mysqli->query("CALL cambio_periodo()")) {
    echo "Falló CALL: (" . $mysqli->errno . ") " . $mysqli->error;
}
echo "Fin";
?>