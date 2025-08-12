<?php
include ("../../../Script/conex.php");
include ("../../../Script/seguridad.php");
include ("../../../Script/funciones.php");
$iduser = $_SESSION["iduser"];
$nombre_tabla = $base_bbdd."/aplicaciones";
$contador = 0;
?>
<html>
<head>
<meta charset="iso-8859-1" http-equiv="Content-Type" content="text/html"/>
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
    <td width="14%"><img src="Imagenes/New Database.png" width="64" height="64"></td>
    <th width="86%" colspan="3">DEFINIR APLICACIONES</th>
    </tr>
  <tr align="center" class="Negrita">
    <td colspan="4"><hr></td>
    </tr>
</table>
<?php
if ($_GET["centinela"] == '0' OR $_GET["centinela"] == '1') {
?>
<table width="65%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano12" id="Resultado">
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFF99" align="center">
    <th>#</th>
    <th>Aplicaci&oacute;n</th>
    <th>Descripci&oacute;n</th>
    <th>Fecha Creaci&oacute;n</th>
    <th>Estado</th>
    <th>Accion</th>
    </tr>
<?php
	$result = mysqli_query($db, "SELECT * FROM ".$base_bbdd.".aplicaciones");
	while ($row = mysqli_fetch_array($result)) {
?>
  <tr>
    <td align="center"><?php echo ++$contador; ?></td>
    <td><?php echo $row["nombre"] ?></td>
    <td><?php echo $row["descripcion"] ?></td>
    <td align="center"><?php echo $row["creacion"] ?></td>
    <td align="center"><?php if ($row["estado"] == 0) { echo "Inactivo"; } else { echo "Activo"; } ?></td>
    <td align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=3&idaplicacion='.$row['id_aplicacion'] ?>"><img src="Imagenes/edit.png" alt="Editar..." width="16" height="16" border="0"></a>&nbsp;&nbsp;<a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=5&idaplicacion='.$row["id_aplicacion"] ?>" onClick="return confirmar('esta aplicación')"><img src="Imagenes/borrar.png" width="16" height="16" border="0" ></a></td>
  </tr>
<?php 
	}
?>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" align="center"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>"><img src="Imagenes/agregar.png" alt="Agregar nueva agencia" width="32" height="32" border="0"></a></td>
    </tr>
  <tr>
    <td colspan="6" align="center" class="Tamano10"><a href="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>">Agregar nueva Aplicaci&oacute;n</a></td>
    </tr>
  <tr>
    <td colspan="6" align="center" class="Tamano10">&nbsp;</td>
  </tr>
</table>
<?php
}
if ($_GET["centinela"] == '1') {
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=2' ?>" method="post" enctype="multipart/form-data" name="agregar_agencia">
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <th colspan="2">Agregar Aplicaci&oacute;n</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="30%">Fecha Creaci&oacute;n:</td>
    <td width="70%"><input name="fecha_creacion" type="text" id="no_agencia4" value="<?php echo date('d-m-Y') ?>" size="8"></td>
  </tr>
  <tr>
    <td>Nombre Aplicaci&oacute;n:</td>
    <td><input name="nombre_aplicacion" type="text" id="nombre_aplicacion"></td>
  </tr>
  <tr>
    <td>Descripci&oacute;n:</td>
    <td><label for="descripcion"></label>
      <textarea name="descripcion" id="descripcion" cols="35" rows="2"></textarea>      </td>
  </tr>
  <tr>
    <td>Nombre BBDD:</td>
    <td><input name="nombre_bbdd" type="text" id="nombre_bbdd"></td>
  </tr>
  <tr>
    <td>Icono:</td>
    <td><p>
      <input type="file" name="subir_archivo" id="subir_archivo">
      </p></td>
  </tr>
  <tr>
    <td>Link:</td>
    <td><input name="link" type="text" id="link" size="40"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="Tamano10"><font color="#666666">Aplicaciones Internas: /nombre_aplicacion/index.php</br>Aplicaciones Externas: http://www.example.com/default.aspx</font></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar2" id="Grabar2" value="Grabar..."></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?php echo '<script> hacer_focus("nombre_aplicacion") </script>' ?></td>
  </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '2') {
	$fecha_creacion = date('Y-m-d', strtotime($_POST["fecha_creacion"]));
	$nombre_aplicacion = $_POST["nombre_aplicacion"];
	$descripcion = $_POST["descripcion"];
	$nombre_bbdd = $_POST["nombre_bbdd"];
	$link = $_POST["link"];
	$comentario = "Se creó una nueva aplicación con nombre: ".$nombre_aplicacion;
	$archivo_subir = $_FILES["subir_archivo"]["name"];	
	$datos_nuevos = $fecha_creacion." * ".$nombre_aplicacion." * ".$descripcion." * ".$nombre_bbdd." * ".$archivo_subir." * ".$link;
//	Subir icono //
	$uploaddir = "Imagenes/Aplicaciones/";
	$extension = substr($archivo_subir,-3,3);
	$path = $uploaddir.$nombre_aplicacion.".".$extension;
	$archivo_repositorio = $nombre_aplicacion.".".$extension;	

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
			mysqli_query($db, "INSERT INTO ".$base_bbdd.".aplicaciones VALUES (NULL, '$nombre_aplicacion', '$descripcion', '$nombre_bbdd', '$archivo_repositorio', '$link', '$fecha_creacion', 1)") or die("Error al grabar este registro... #".mysqli_error());			
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
	mysqli_query($db, "INSERT INTO ".$base_bbdd.".aplicaciones VALUES (NULL, '$nombre_aplicacion', '$descripcion', '$nombre_bbdd', NULL, '$link', '$fecha_creacion', 1)") or die("Error al grabar este registro... #".mysqli_error());	
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
	$idaplicacion = $_GET["idaplicacion"];
	$result = mysqli_query($db, "SELECT * FROM ".$base_bbdd.".aplicaciones WHERE id_aplicacion = '$idaplicacion'");
	$row = mysqli_fetch_array($result);
?>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=4&idaplicacion='.$idaplicacion ?>" method="post" enctype="multipart/form-data" name="modificar_agencia">
<table width="40%" border="0" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="Resultado">
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <th colspan="2">Modificar Aplicaci&oacute;n</th>
    </tr>
  <tr>
    <td colspan="2"><hr /></td>
    </tr>
  <tr>
    <td width="40%">Fecha Creaci&oacute;n:</td>
    <td width="60%">
      <input name="fecha_creacion" type="text" id="fecha_creacion" value="<?php echo $row['creacion'] ?>" size="8"></td>
  </tr>
  <tr>
    <td>Nombre Aplicaci&oacute;n:</td>
    <td>
      <input name="nombre_aplicacion" type="text" id="nombre_aplicacion" value="<?php echo $row['nombre'] ?>"></td>
  </tr>
<tr>
    <td>Descripci&oacute;n:</td>
    <td><textarea name="descripcion" cols="35" rows="2" id="descripcion"><?php echo $row['descripcion'] ?></textarea></td>
  </tr>
  <tr>
    <td>Nombre BBDD:</td>
    <td><input name="nombre_bbdd" type="text" id="nombre_bbdd" value="<?php echo $row['nombre_bbdd'] ?>"></td>
  </tr>
  <tr>
    <td>Icono:</td>
    <td><img src="<?php echo 'Imagenes/Aplicaciones/'.$row[4] ?>" width="64" height="64">
    </br>
      <input type="file" name="subir_archivo" id="subir_archivo">
      </td>
  </tr>
  <tr>
    <td>Link:</td>
    <td><input name="link" type="text" id="link" value="<?php echo $row['link'] ?>" size="40"></td>
  </tr>
<tr>
    <td>&nbsp;</td>
    <td class="Tamano10"><font color="#666666">Aplicaciones Internas: /nombre_aplicacion/index.php</br>
Aplicaciones Externas: http://www.example.com/default.aspx</font></td>
  </tr>
  <tr>
    <td>Estado:</td>
    <td><select name="estado">
      <option value="1" <?php if ($row['estado'] == 1) echo 'selected' ?>>Activo</option>
      <option value="0" <?php if ($row['estado'] == 0) echo 'selected' ?>>Inactivo</option>
      <?php  ?>
    
    </select></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="Grabar" id="Grabar" value="Grabar..."></td>
    </tr>
  <tr>
    <td colspan="2" align="center"><?php echo '<script> hacer_focus("nombre_aplicacion") </script>' ?></td>
  </tr>
</table>
</form>
<?php
}
if ($_GET["centinela"] == '4') {
	$idaplicacion = $_GET["idaplicacion"];
	$fecha_creacion = date('Y-m-d', strtotime($_POST["fecha_creacion"]));
	$nombre_aplicacion = $_POST["nombre_aplicacion"];
	$descripcion = $_POST["descripcion"];
	$nombre_bbdd = $_POST["nombre_bbdd"];
	$icono = $_POST["icono"];
	$link = $_POST["link"];
	$estado = $_POST["estado"];
	$archivo_subir = $_FILES["subir_archivo"]["name"];
	$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT * FROM ".$base_bbdd.".aplicaciones WHERE id_aplicacion = $idaplicacion"));
	$comentario = "Se modificó la información de la Aplicación: ".$tmp[1];
	$datos_anteriores = $tmp[0]." * ".$tmp[1]." * ".$tmp[2]." * ".$tmp[3]." * ".$tmp[4]." * ".$tmp[5]." * ".$tmp[6]." * ".$tmp[7];
	$datos_nuevos = $nombre_aplicacion." * ".$descripcion." * ".$nombre_bbdd." * ".$icono." * ".$link." * ".$estado;

//	Subir icono //
	$uploaddir = "Imagenes/Aplicaciones/";
	if ($subir_archivo != "") {
		$extension = substr($archivo_subir,-3,3);
		$path = $uploaddir.$nombre_aplicacion.".".$extension;
		$archivo_repositorio = $nombre_aplicacion.".".$extension;
		if ($_FILES['subir_archivo']['size'] != 0 ) {
			unlink("Imagenes/Aplicaciones/".$tmp[4]);	
	    	if(copy($_FILES['subir_archivo']['tmp_name'], $path)){ //Copio el archivo de la carpeta temporal a la ubicación.
			} else {
				echo "Error al copiar archivo";	
			}	
		}
	} else {
		$extension = substr($tmp[4],-3,3);
		$path = $uploaddir.$nombre_aplicacion.".".$extension;
		$archivo_repositorio = $nombre_aplicacion.".".$extension;	
		rename("Imagenes/Aplicaciones/".$tmp[4], "Imagenes/Aplicaciones/".$archivo_repositorio);
	}	
	mysqli_query($db, "UPDATE ".$base_bbdd.".aplicaciones SET icono = '$archivo_repositorio', nombre = '$nombre_aplicacion', descripcion = '$descripcion', nombre_bbdd = '$nombre_bbdd', link = '$link', creacion = '$fecha_creacion', estado = '$estado' WHERE id_aplicacion = '$idaplicacion'") or die("Error al modificar este registro... #".mysqli_error());
	
	
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
	$idaplicacion = $_GET["idaplicacion"];
	$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT * FROM ".$base_bbdd.".aplicaciones WHERE id_aplicacion = $idaplicacion"));
	unlink("Imagenes/Aplicaciones/".$tmp[4]);
	$comentario = "Se eliminó la información de la Aplicación: ".$tmp[1];
	$datos_anteriores = $tmp[0]." * ".$tmp[1]." * ".$tmp[2]." * ".$tmp[3]." * ".$tmp[4]." * ".$tmp[5]." * ".$tmp[6]." * ".$tmp[7];
		
	mysqli_query($db, "DELETE FROM ".$base_bbdd.".aplicaciones WHERE id_aplicacion = '$idaplicacion'") or die("Error al eliminar este registro... #".mysqli_error());
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