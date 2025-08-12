<?php
include ("../../../Script/conex.php");
include ("../../../Script/seguridad.php");
$iduser = $_SESSION["iduser"];
$nombre_tabla = $base_general."/departamentos";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="iso-8859-1"/>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../../../Script/funciones_java.js"></script>
</head>

<body class="Pagina">
<div id="menuprincipal">
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano24">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center">
    <td width="14%"><img src="Imagenes/Departamentos_peque.png" width="64" height="64"></td>
    <th width="86%" colspan="3">DEFINIR DEPARTAMENTOS</th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>
<?php
if ($_GET["centinela"] == '0' OR $_GET["centinela"] == '1') {
?>
<table width="60%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFF99" align="center">
    <th width="40%">Gerencia</th>
    <th width="40%">Departamento</th>
    <th width="20%">Accion</th>
    </tr>
<?php
	$result = mysqli_query($db, "SELECT T_departamentos.*, T_gerencias.gerencia FROM ".$base_general.".departamentos AS T_departamentos LEFT JOIN ".$base_general.".gerencias AS T_gerencias ON T_departamentos.id_gerencia = T_gerencias.id_gerencia ORDER BY gerencia ASC, nombre_depto ASC");
	while ($row = mysqli_fetch_array($result)) {
?>
  <tr>
    <td><?php echo $row["gerencia"] ?></td>
    <td><?php echo $row["nombre_depto"] ?></td>
    <td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=3&depto='.$row["id_depto"] ?>"><img src="Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a>&nbsp;&nbsp;<a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=5&depto='.$row["id_depto"] ?>" onClick="return confirmar('este Departamento')"><img src="Imagenes/borrar.png" width="16" height="16" border="0"></a></td>
  </tr>
<?php 
	}
?>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>"><img src="Imagenes/agregar.png" alt="Agregar nueva agencia" width="32" height="32" border="0"></a></td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="Tamano10"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>">Agregar nuevo departamento</a></td>
    </tr>
  <tr>
    <td colspan="3" align="center" class="Tamano10">&nbsp;</td>
  </tr>
</table>
<?php
}
if ($_GET["centinela"] == '1') {
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=2' ?>" method="post" enctype="multipart/form-data" name="agregar_agencia">
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <th colspan="2">Agregar Departamento</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="40%">Gerencia:</td>
    <td width="60%">
      <?php $result_agencia=mysqli_query($db, "SELECT * FROM ".$base_general.".gerencias"); ?>
 	<select name="gerencia" size="1" id="gerencia">
 	<option value="0" selected>- Seleccionar opci&oacute;n -</option>
 	<?php
		while ($rw0=mysqli_fetch_array($result_agencia)) {
	?>
     	<option value="<?php echo $rw0["id_gerencia"] ?>"> <?php echo $rw0["gerencia"] ?></option>
	<?php
		}
	?> </select></td>
  </tr>
  <tr>
    <td width="40%">Nombre Departamento:</td>
    <td width="60%">
      <label for="no_agencia"></label>
      <input name="nombre_departamento" type="text" id="nombre_departamento"></td>
  </tr>
  <tr>
    <td width="40%">Imagen Icono:</td>
    <td width="60%">
      <label for="no_agencia">
        <input type="file" name="subir_archivo" id="subir_archivo">
      </label></td>
  </tr>
  <tr>
    <td width="40%">Link P&aacute;gina:</td>
    <td width="60%">
      <label for="no_agencia"></label>
      <input name="link" type="text" id="link"><br />
      <font color="#666666" size="-4">Ejemplo: nombre_depto/principal.php</font></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar" id="Grabar" value="Grabar...">
      <?php echo '<script> hacer_focus("gerencia") </script>' ?></td>
    </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '2') {
	$gerencia = $_POST["gerencia"];
	$nombre_departamento = $_POST["nombre_departamento"];
//	Subir icono //
	$archivo_subir = $_FILES["subir_archivo"]["name"];	
	$link = $_POST["link"];
	$uploaddir = "Imagenes/Departamentos/";
	$extension = substr($archivo_subir,-3,3);
	$path = $uploaddir.$nombre_departamento.".".$extension;
	$archivo_repositorio = $nombre_departamento.".".$extension;	

	if ($_FILES['subir_archivo']['size'] != '0') {		
	    if(copy($_FILES['subir_archivo']['tmp_name'], $path)){ //Copio el archivo de la carpeta temporal a la ubicación.
			$theFileName = $_FILES['subir_archivo']['name']; //Obtengo el nombre original
			$theFileSize = $_FILES['subir_archivo']['size']; //Obtengo el tamaño
	        if ($theFileSize>999999){ //Hago funcion para sacar el tamaño del archivo
				$theDiv = $theFileSize / 1000000; 
   	    	 	$theFileSize = round($theDiv, 1)." Mb"; //Hacer conversion en MB
			} else { //Si fuese Kb 
	           	$theDiv = $theFileSize / 1000; 
    	       	$theFileSize = round($theDiv, 1)." Kb"; //Hacer conversion en KB 
        	} //Fin del tamaño del Archivo
		mysqli_query($db, "INSERT INTO ".$base_general.".departamentos VALUES (NULL, '$gerencia', '$nombre_departamento', '$archivo_repositorio', '$link' )") or die("Error al grabar este registro... #".mysqli_error());
?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Texto_Centrado" id="Resultado">
  <tr>
    <td><b><font color="#009900">Se cre&oacute; exitosamente el Departamento</font></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Tamano14"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>">Regresar...</a></td>
  </tr>
</table>
<?php
		} else {	 // else si no logro copiar los archivos
?>
<table width="40%" align="center"> 
<tr> 
<th align="Center"><font color="#009900"><b>Error al subir archivo, pruebe nuevamente</b></font></th> 
</tr> 
</table> 
<?php 
		}
	} else { //tamaño archivo
	mysqli_query($db, "INSERT INTO ".$base_general.".departamentos VALUES (NULL, '$gerencia', '$nombre_departamento', NULL, '$link' )") or die("Error al grabar este registro... #".mysqli_error());
?>
<table width="40%" align="center"> 
<tr> 
<th align="Center" ><font color="#009900">Se cre&oacute; el Departamento, aunque no hay ningun icono escogido</font></td> 
</tr> 
</table> 
<?php
	} //Fin del tamaño archivo
	$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT gerencia FROM ".$base_general.".gerencias WHERE id_gerencia = '$gerencia' LIMIT 1"));
	$comentario = "Se creó un nuevo Departamento: ".$nombre_departamento." de la Gerencia: ".$tmp[0];
} //Fin de la centinela = 2;

if ($_GET["centinela"] == '3') {
	$depto = $_GET["depto"];
	$result = mysqli_query($db, "SELECT * FROM ".$base_general.".departamentos WHERE id_depto = '$depto'");
	$row = mysqli_fetch_array($result);
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=4&depto='.$depto ?>" method="post" enctype="multipart/form-data" name="modificar_agencia">
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <th colspan="2">Modificar Departamento</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="40%">Gerencia:</td>
    <td width="60%">
      <?php $result_agencia=mysqli_query($db, "SELECT * FROM ".$base_general.".gerencias"); ?>
 	<select name="gerencia" size="1" id="gerencia">
 	<option value="0" selected>- Seleccionar opci&oacute;n -</option>
 	<?php
		while ($rw0=mysqli_fetch_array($result_agencia)) {
			if ($rw0["id_gerencia"] == $row["id_gerencia"]) {
				$sel = "selected";
			} else {
				$sel = "";
			}
	?>
     	<option value="<?php echo $rw0["id_gerencia"] ?>" <?php echo $sel ?>> <?php echo $rw0["gerencia"] ?></option>
	<?php
		}
	?> </select></td>
  </tr>
  <tr>
    <td width="40%">Nombre Departamento:</td>
    <td width="60%">
      <input name="nombre_departamento" type="text" id="nombre_departamento" value="<?php echo $row['nombre_depto'] ?>"></td>
  </tr>
  <tr>
    <td width="40%">Imagen Icono:</td>
    <td width="60%"><img src="<?php echo 'Imagenes/Departamentos/'.$row["link_imagen"] ?>" width="64" height="64"></br><input type="file" name="subir_archivo" id="subir_archivo"></td>
    </tr>
  <tr>
    <td width="40%">Link P&aacute;gina:</td>
    <td width="60%">
      <label for="no_agencia"></label>
      <input name="link" type="text" id="link" value="<?php echo $row["link_pagina"]?>"><br />
      <font color="#666666" size="-4">Ejemplo: nombre_aplicacion/index.php</font></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar" id="Grabar" value="Grabar..."></td>
    </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '4') {
	$depto = $_GET["depto"];
	$gerencia = $_POST["gerencia"];
	$nombre_departamento = $_POST["nombre_departamento"];
	$archivo_subir = $_FILES["subir_archivo"]["name"];
	$link = $_POST["link"];
	$uploaddir = "Imagenes/Departamentos/";
	
	$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT * FROM ".$base_general.".departamentos WHERE id_depto = $depto LIMIT 1"));
	$comentario = "Se modificó la información del Departamento: ".$tmp[1];

	$datos_anteriores = $tmp[0]." * ".$tmp[1]." * ".$tmp[2]." * ".$tmp[3]." * ".$tmp[4];
	$datos_nuevos = $depto." * ".$gerencia." * ".$nombre_departamento." * ".$subir_archivo." * ".$link;

if ($tmp[3] == "") {
	$existe = 0;	
} else {
	$existe = 1;
}
if ($archivo_subir == "") {
	$icono = 0;	
} else {
	$icono = 1;
}
$combinacion = $existe.$icono;

switch ($combinacion) {
	case "00":	mysqli_queryquery ("UPDATE ".$base_general.".departamentos SET id_gerencia = $gerencia, nombre_depto = '$nombre_departamento', link_pagina = '$link' WHERE id_depto = $depto") or die (mysqli_error());
				break;
	case "01":	$extension = substr($archivo_subir,-3,3);
				$path = $uploaddir.$nombre_departamento.".".$extension;
				$archivo_repositorio = $nombre_departamento.".".$extension;			
				if ($_FILES['subir_archivo']['size'] != 0 ) {
					if(copy($_FILES['subir_archivo']['tmp_name'], $path)){ //Copio el archivo de la carpeta temporal a la ubicación.
					} else {
						echo "Error al copiar archivo";	
					}
				}
				mysqli_queryquery ("UPDATE ".$base_general.".departamentos SET id_gerencia = $gerencia, nombre_depto = '$nombre_departamento', link_imagen = '$archivo_repositorio', link_pagina = '$link' WHERE id_depto = $depto") or die (mysqli_error());
				break;
	case "10":	$extension = substr($tmp[3],-3,3);
				$archivo_repositorio = $nombre_departamento.".".$extension;	
				rename("Imagenes/Departamentos/".$tmp[3], "Imagenes/Departamentos/".$archivo_repositorio);
				mysqli_queryquery ("UPDATE ".$base_general.".departamentos SET id_gerencia = $gerencia, nombre_depto = '$nombre_departamento', link_imagen = '$archivo_repositorio', link_pagina = '$link' WHERE id_depto = $depto") or die (mysqli_error());
				break;
	case "11":	unlink ("Imagenes/Departamentos/".$tmp[3]);
				$extension = substr($archivo_subir,-3,3);
				$path = $uploaddir.$nombre_departamento.".".$extension;
				$archivo_repositorio = $nombre_departamento.".".$extension;			
				if ($_FILES['subir_archivo']['size'] != 0 ) {
					if(copy($_FILES['subir_archivo']['tmp_name'], $path)){ //Copio el archivo de la carpeta temporal a la ubicación.
					} else {
						echo "Error al copiar archivo";	
					}
				}
				mysqli_queryquery ("UPDATE ".$base_general.".departamentos SET id_gerencia = $gerencia, nombre_depto = '$nombre_departamento', link_imagen = '$archivo_repositorio', link_pagina = '$link' WHERE id_depto = $depto") or die (mysqli_error());	 
				break;
	default:	echo "ninguna condiciona encontrada";
				break;			
}
	$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT A.id_depto, A.id_gerencia, A.nombre_depto, B.gerencia FROM ".$base_general.".departamentos AS A JOIN ".$base_general.".gerencias AS B ON A.id_gerencia = B.id_gerencia WHERE id_depto = '$depto'"));
	$datos_anteriores = $tmp[1]." * ".$tmp[2];
	$datos_nuevos = $gerencia." * ".$nombre_departamento;
	$comentario = "Se modificó el Departamento: ".$tmp[2]." de la Gerencia: ".$tmp[3];
?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
  <tr>
    <td>Datos modificados con &eacute;xito...</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>">Regresar...</a></td>
  </tr>
</table>
<?php
}
if ($_GET["centinela"] == '5') {
	$depto = $_GET["depto"];
	$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT A.id_depto, A.id_gerencia, A.nombre_depto, B.gerencia, A.link_imagen FROM ".$base_general.".departamentos AS A JOIN ".$base_general.".gerencias AS B ON A.id_gerencia = B.id_gerencia WHERE id_depto = '$depto'"));
	$datos_anteriores = $tmp[0]." * ".$tmp[1]." * ".$tmp[2]." * ".$tmp[4]." * ".$tmp[3];
	$comentario = "Se Eliminó un Departamento: ".$tmp[2]." de la Gerencia: ".$tmp[3];
	mysqli_query($db, "DELETE FROM ".$base_general.".departamentos WHERE id_depto = '$depto'") or die("Error al eliminar este registro... #".mysqli_error());
	mysqli_query($db, "DELETE FROM ".$base_general.".define_jefe_departamento WHERE id_departamento = $depto") or die(mysqli_error());
	mysqli_query($db, "DELETE FROM ".$base_general.".jefaturas WHERE id_jefatura = $depto") or die(mysqli_error());
	unlink("Imagenes/Departamentos/".$tmp[4]);

?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
  <tr>
    <td>Datos eliminados con &eacute;xito...</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>">Regresar...</a></td>
  </tr>
</table>
<?php
}
?>
</div>
 
<div id="flotante_izquierdo">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="ver_asignaciones.php?centinela=0&tipo=2"><img src="Imagenes/jefaturas.png" alt="Regresar" width="64" height="64" border="0"></br>DEFINIR JEFES DE &Aacute;REAS</a></td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
</tr>
<tr>
  <td align="center"><a href="ver_departamentos_app.php?centinela=0"><img src="Imagenes/BBDD.png" width="64" height="64" border="0"></br>PROGRAMAS POR DEPARTAMENTO</a></td>
</tr>
</table>
</div>
 

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
<?php
if ($_GET["centinela"] == 0) {
?>
  <td align="center"><a href="principal.php"><img src="Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"><br />Cerrar</a></td>
<?php
} else {
?>
<td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"><br />Regresar</a></td>
<?php
}
?>
</tr>
</div>

</body>
</html>