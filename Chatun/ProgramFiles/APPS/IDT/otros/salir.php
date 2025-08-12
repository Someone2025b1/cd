<?php
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
session_start();
			$user_graba=$_SESSION["cuenta_user"];
			$fecha_actual = date("Y-m-d H:i:s");
			$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"]; 
		$sql6 = "INSERT INTO coosajo_base_bbdd.historial_conexion (id, dba, id_user, hora_fecha, in_of, ip_conexion) VALUES (NULL, '10', '$user_graba', '$fecha_actual', 's', '$ip');";
		$result_p6 = mysqli_query($db, $sql6); 
session_destroy();
?>
<?php 
header("Location: ../index.php?errorusuario=no"); 
?>