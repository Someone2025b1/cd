<?php
include ("../../../Script/conex.php");
if(isset($_POST["iddatos"]))
	{
		$opciones = '<option value="0">..:: Elige un Departamento ::..</option>';
		$sql_departamentos = mysqli_query($db, "SELECT id_depto, nombre_depto FROM ".$base_general.".departamentos WHERE id_gerencia = ".$_POST["iddatos"]);
		while($fila = mysqli_fetch_array($sql_departamentos)) {
			$opciones.='<option value="'.$fila["id_depto"].'">'.$fila["nombre_depto"].'</option>';
		}
		echo $opciones;
	}
?>
