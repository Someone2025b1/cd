<?php
ob_start();
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
					//el usuario que gestiona el proceso
					session_start();
				  	$user_graba=$_SESSION["cuenta_user"];
//Recibe las variables para ingreso
$inventario=$_GET["inven"];
$empleado_colabo=$_GET["empleado"];
$tipo=$_GET["tipo"];
$descripcion=$_GET["descri"];
$estado=$_GET["estado"];
$otros=$_GET["otros"];
$fecha_actual = date("Y-m-d H:i:s"); 
$vali=Otros;
$sql8 = "SELECT * FROM coosajo_base_bbdd.usuarios where id_user like '$empleado_colabo'";
	  $result_n8 = mysqli_query($db, $sql8);
	  $row8=mysqli_fetch_array($result_n8);
	  $nom=$row8["nombre"];
	  
	  if ($tipo==$vali){ echo "**paso aqui**";
		  
$sql = "INSERT INTO coosajo_inventario_idt.inventario_departamento (id, inventario, dueno_activo, nombre_activo, tipo, tipo_otros, descripcion, estado, colaborador_idt, fecha_ingreso, Fecha_salida, salida_colaborador_idt, estado_actual) VALUES (NULL, '$inventario', '$empleado_colabo', '$nom', '$tipo', '$otros', '$descripcion', '$estado', '$user_graba', '$fecha_actual', '', '', '1');";
	  $result=mysqli_query($db, $sql);
  } else { echo "**paso else**";

$sql = "INSERT INTO coosajo_inventario_idt.inventario_departamento (id, inventario, dueno_activo, nombre_activo, tipo, tipo_otros, descripcion, estado, colaborador_idt, fecha_ingreso, Fecha_salida, salida_colaborador_idt, estado_actual) VALUES (NULL, '$inventario', '$empleado_colabo', '$nom', '$tipo', '', '$descripcion', '$estado', '$user_graba', '$fecha_actual', '', '', '1');"; 
$result=mysqli_query($db, $sql);
	  }

?>

<?php
header ("Location: act_manejo_equipo.php");
ob_flush();
?>




