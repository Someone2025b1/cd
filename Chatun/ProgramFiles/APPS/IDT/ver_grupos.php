<?php
include ("../../../Script/conex.php");
session_start();
$nombre_tabla = $base_general."/define_grupos";
$iduser = $_SESSION["iduser"];
?>

<html>
<head>
<link href="../../../Script/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Script/funciones_java.js"></script>
<script language="javascript">
function confirmar() {
	return confirm("¿Está seguro de eliminar este grupo? Esta acción ya no se puede revertir");	 
}
</script>
</head>

<body class="Pagina">
<div id="menuprincipal">

<?php
if ($_GET["centinela"] <= 1) {
?>
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14">
  <tr align="center">
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr align="center" class="Negrita">
    <td width="14%"><img src="Imagenes/Cajero General.png" width="64" height="64" alt="Definir Cajero General"></td>
    <th width="86%" colspan="3" class="Tamano24">GRUPOS ESPECIALES</th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>

<?php
$sql = mysqli_query($db, "SELECT * FROM ".$base_general.".define_grupos");
$contador = 0;
?>
<table width="45%" border="1" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Cajero_Generales">
  <tr align="center" bgcolor="#FFFF99">
    <th width="1%">#</th>
    <th width="30%">Nombre Grupo</th>
    <th width="50%">Comentario</th>
    <th width="5%">Integrantes</th>
    <th width="5%">Aplicaciones</th>
    <th width="5%">&nbsp;</th>

    </tr>
<?php
	while ($row = mysqli_fetch_row($sql)) {
		$no_integrantes = mysqli_fetch_row(mysqli_query($db, "SELECT COUNT(id_grupo) FROM ".$base_general.".define_integrantes_grupos WHERE id_grupo = ".$row[0]." GROUP BY id_grupo"));
		$no_aplicaciones = mysqli_fetch_row(mysqli_query($db, "SELECT COUNT(id_grupo) FROM ".$base_general.".define_aplicaciones_grupos WHERE id_grupo = ".$row[0]." GROUP BY id_grupo"));
?>
  <tr>
    <td><?php echo ++$contador ?></td>
    <td>&nbsp;<?php echo $row[1] ?></td>
    <td>&nbsp;<?php echo $row[3] ?></td>
    <td align="center"><?php echo $no_integrantes[0] ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo 'ver_integrantes_grupos.php?centinela=0&idgrupo='.$row[0] ?>"><img src="Imagenes/buscar.png" alt="Ver integrantes" width="16" height="16" border="0"></a></td>
    <td align="center"><?php echo $no_aplicaciones[0] ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo 'ver_aplicaciones_grupos.php?centinela=0&idgrupo='.$row[0] ?>"><img src="Imagenes/buscar.png" alt="Ver integrantes" width="16" height="16" border="0"></a></td>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=3&idgrupo='.$row[0]?>"><img src="Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=5&idgrupo='.$row[0]?>" onClick="return confirmar()"><img src="Imagenes/borrar.png" width="16" height="16" border="0"></a></td>
  </tr>
<?php
	}
?>
</table>

<table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
<?php
	$result = mysqli_query($db, "SELECT * FROM ".$base_general.".gerencias");
	while ($row = mysqli_fetch_array($result)) {
?>
<?php 
	}
?>
  <tr>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>"><img src="Imagenes/agregar.png" alt="Agregar nueva agencia" width="32" height="32" border="0"></a></td>
    </tr>
  <tr>
    <td align="center" class="Tamano10"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>">Agregar nuevo grupo</a></td>
    </tr>
  <tr>
    <td align="center" class="Tamano10">&nbsp;</td>
  </tr>
</table>

<?php
}
if ($_GET["centinela"] == '1') {
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=2' ?>" method="post" enctype="multipart/form-data" name="1" id="1">
<table width="30%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <th colspan="2">Agregar Grupo</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="40%">Nombre Grupo:</td>
    <td width="60%"><input name="nombre_grupo" type="text" id="nombre_grupo">						</td>
  </tr>
  <tr>
    <td width="40%">Icono:</td>
    <td width="60%"><input type="file" name="subir_archivo" id="subir_archivo"></td>
  </tr>
      <td>Comentario:</td>
    <td><textarea name="comentario" cols="35" rows="3" id="comentario"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar2" id="Grabar2" value="Grabar..."><?php echo '<script language="javascript"> hacer_focus("nombre_grupo") </script>' ?></td>
  </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '2') {
	$uploaddir = "Imagenes/Grupos/"; 
	$nombre_grupo = $_POST["nombre_grupo"];
	$comentario = $_POST["comentario"];	
	$datos_nuevos = $nombre_grupo." * ".$comentario;

//	Subir icono //
	$archivo_subir = $_FILES["subir_archivo"]["name"];		
	$extension = substr($archivo_subir,-3,3);
	$path = $uploaddir.$nombre_grupo.".".$extension;
	$archivo_repositorio = $nombre_grupo.".".$extension;	

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
			mysqli_query($db, "INSERT INTO ".$base_general.".define_grupos VALUES (NULL, '$nombre_grupo', '$archivo_repositorio', '$comentario', CURRENT_TIMESTAMP)") or die(mysqli_error());			
?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Texto_Centrado" id="Resultado">
  <tr>
    <td><b><font color="#009900">Se cre&oacute; exitosamente el grupo</font></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Tamano14"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0' ?>">Regresar...</a></td>
  </tr>
</table>
<?php
		} else {	 
?>
<table width="40%" align="center"> 
<tr> 
<th align="Center"><font color="#009900"><b>Error al subir archivo, pruebe nuevamente</b></font></th> 
</tr> 
</table> 
<?php 
		}
	} else { //tamaño archivo
	mysqli_query($db, "INSERT INTO ".$base_general.".define_grupos VALUES (NULL, '$nombre_grupo', NULL, '$comentario', CURRENT_TIMESTAMP)") or die(mysqli_error());
?>
<table width="40%" align="center"> 
<tr> 
<th align="Center" ><font color="#009900">Se cre&oacute; el grupo, aunque no hay ningun icono escogido</font></td> 
</tr> 
</table> 
<?php
	} //Fin del tamaño archivo
} //Fin de la centinela = 2;

if ($_GET["centinela"] == '3') {
	$idgrupo = $_GET["idgrupo"];
	$sql = mysqli_query($db, "SELECT * FROM ".$base_general.".define_grupos WHERE id_grupo = '$idgrupo'");
	$row = mysqli_fetch_row($sql);
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=4&idgrupo='.$idgrupo ?>" method="post" enctype="multipart/form-data" name="2" id="2">
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <th colspan="2">Modificar Grupo</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="40%">Nombre Grupo:</td>
    <td width="60%">
      <input name="nombre_grupo2" type="text" id="nombre_grupo2" value="<?php echo $row[1] ?>"></td>
  </tr>
      <td>Comentario:</td>
    <td>
      <textarea name="comentario2" cols="35" rows="3" id="comentario2"><?php echo $row[3] ?></textarea></td>
  </tr>
  <tr>
    <td>Icono:</td>
    <td><img src="<?php echo 'Imagenes/Grupos/'.$row[2] ?>" width="64" height="64">
    </br>
      <input type="file" name="subir_archivo" id="subir_archivo">
      </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar" id="Grabar" value="Grabar...">
      <?php echo '<script language="javascript"> hacer_focus("nombre_grupo2") </script>' ?></td>
    </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '4') {
	$idgrupo = $_GET["idgrupo"];
	$nombre_grupo = $_POST["nombre_grupo2"];
	$comentario = $_POST["comentario2"];
	$subir_archivo = $_FILES["subir_archivo"]["name"];
	
	$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT * FROM ".$base_general.".define_grupos WHERE id_grupo = $idgrupo"));
	


//	Subir icono //
	$uploaddir = "Imagenes/Grupos/";
	if ($subir_archivo != "") {
		$extension = substr($subir_archivo,-3,3);
		$path = $uploaddir.$nombre_grupo.".".$extension;
		$archivo_repositorio = $nombre_grupo.".".$extension;
		if ($_FILES['subir_archivo']['size'] != 0 ) {
			unlink("Imagenes/Grupos/".$tmp[2]);	
	    	if(copy($_FILES['subir_archivo']['tmp_name'], $path)){ //Copio el archivo de la carpeta temporal a la ubicación.
			} else {
				echo "Error al copiar archivo";	
			}	
		}
	} else {
		$extension = substr($tmp[2],-3,3);
		$path = $uploaddir.$nombre_grupo.".".$extension;
		$archivo_repositorio = $nombre_grupo.".".$extension;	
		rename("Imagenes/Grupos/".$tmp[2], "Imagenes/Grupos/".$archivo_repositorio);
	}	
	
	$datos_anteriores = $tmp[0]." * ".$tmp[1]." * ".$tmp[2]." * ".$tmp[3]." * ".$tmp[4];
	$datos_nuevos = $idgrupo." * ".$nombre_grupo." * ".$nuevo_nombre_icono." * ".$comentario;
	
	mysqli_query($db, "UPDATE ".$base_general.".define_grupos SET nombre_grupo = '$nombre_grupo', comentario = '$comentario', icono = '$archivo_repositorio'  WHERE id_grupo = '$idgrupo'") or die(mysqli_error());
	
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
	$idgrupo = $_GET["idgrupo"];
	
	$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT * FROM ".$base_general.".define_grupos WHERE id_grupo = $idgrupo"));
	$datos_anteriores = $tmp[0]." * ".$tmp[1]." * ".$tmp[2]." * ".$tmp[3]." * ".$tmp[4];
	unlink("Imagenes/Grupos/".$tmp[2]);
	
	mysqli_query($db, "DELETE FROM ".$base_general.".define_grupos WHERE id_grupo = '$idgrupo'") or die(mysqli_error());
	mysqli_query($db, "DELETE FROM ".$base_general.".define_aplicaciones_grupos WHERE id_grupo = $idgrupo") or die (mysqli_error());
	mysqli_query($db, "DELETE FROM ".$base_general.".define_integrantes_grupos WHERE id_grupo = $idgrupo") or die (mysqli_error());
	mysqli_query($db, "DELETE FROM ".$base_bbdd.".define_permisos WHERE id_grupo = $idgrupo") or die (mysqli_error());
	
	
?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14 Texto_Centrado" id="Resultado">
  <tr>
    <td>Grupo Eliminado con &eacute;xito...</td>
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

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<?php
if ($_GET["centinela"] == 0) {
?>
<tr>
  <td align="center"><a href="principal.php"><img src="Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="principal.php">Cerrar</a></td>
</tr>
<?php
} else {
?>
<tr>
  <td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0'?>"><img src="Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=0'?>">Regresar</a></td>
</tr>
<?php
}
?>
</table>
</div>

</body>
</html>