<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

include("../../../../../Script/conex_sql_server.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Criterio = $_POST['Criterio'];

$params = array();
$options =  array( 'Scrollable' => SQLSRV_CURSOR_KEYSET );

$nombreBD = 'chatun';

$sql =sqlsrv_query($db_sql, "SELECT SCHEMA_NAME 
        FROM information_schema.schemata 
        WHERE SCHEMA_NAME = '$nombreBD'");

$resultado = mysqli_query($sql);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    echo "La base de datos '$nombreBD' existe ✅";
} else {
    echo "La base de datos '$nombreBD' no existe ❌";
}
?>
