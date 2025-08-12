<?php
include_once 'ez_sql_core.php';
include_once 'ez_sql_mysql.php';

$db2 = new ezSQL_mysql('root', 'redhat12', 'info_asociados', 'localhost');
$var="%".$_POST['query']."%";
$buscador = $db2->get_results("SELECT * FROM general WHERE nombre LIKE '$var' LIMIT 25");

echo json_encode($buscador);
?>