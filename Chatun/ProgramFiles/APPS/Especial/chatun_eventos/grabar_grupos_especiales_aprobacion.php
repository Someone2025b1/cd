<?php 
header('Content-Type: text/html; charset=utf-8');
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/funciones.php");
//include("../../../../Script/calendario/calendario.php");
//include("Script/conex2.php");
session_start();
$iduser = $_SESSION["iduser"];
//$jefe = utf8_encode(saber_nombre_asociado($_POST["jefe"]));

$aprobacion = $_POST["aprobacion"];
$comentario = $_POST["comentario"];
$fecha_aprobacion = date('Y-m-d');
$id_solicitud = $_GET["id_solicitud"];
$costo_actividad = $_POST["costo_actividad"];
$observaciones_costo = $_POST["observaciones_costo"];
 
 if($aprobacion == '1'){
	$aprobado = "APROBADA";
}
if($aprobacion == '2'){ 
	$aprobado = "DENEGADA";
}  
  
   
   

if($_GET['accion'] == '1'){
	
	$actualizar = "UPDATE  `coosajo_educacion_cooperativa`.`solicitud_grupos_especiales` SET  `estado` =  '$aprobacion', `comentario` =  '$comentario', `fecha_resolucion` =  '$fecha_aprobacion', `costo_actividad` =  '$costo_actividad', `observaciones_costo` =  '$observaciones_costo' WHERE  `id` = '$id_solicitud' LIMIT 1";
		mysql_query($actualizar,$db) or die (mysql_error());
		
//////////////////// PARA MANDAR EL CORREO ////////		
$sql_verificar1 = "SELECT responsable_solicitud FROM coosajo_educacion_cooperativa.`solicitud_grupos_especiales` where id = '$id_solicitud'";
	$result_verificar1=mysql_query($sql_verificar1,$db);
	$array_11=mysql_fetch_array($result_verificar1);
	$cif_solicitante = $array_11["responsable_solicitud"];		  
	
$sql_verificar2 = "SELECT correo_micoope FROM info_colaboradores.datos_correos where cif = '$cif_solicitante'";
	$result_verificar2=mysql_query($sql_verificar2,$db);
	$array_2=mysql_fetch_array($result_verificar2);
	echo $correo_solicitante = $array_2["correo_micoope"]."@micoope.coosajo.com";	
				
		   
$para      = $correo_solicitante;
$titulo    = 'Solicitud de Capacitacion Parque Chatun';
$mensaje   =  "Su solicitud No. $id_solicitud fue $aprobado. $comentario ";
$cabeceras = "From: info@parquechatun.com";

mail($para, $titulo, $mensaje, $cabeceras);	
		 
		
		 
	
if(!$actualizar){	
header('Location: historial_envios.php?alerta=2');	      
} else {  
header('Location: historial_envios.php?alerta=1');	  	
}		
		
}
    

?>

