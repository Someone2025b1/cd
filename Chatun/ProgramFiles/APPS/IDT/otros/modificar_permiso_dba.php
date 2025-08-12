<?php 
include("../../../../Script/conex.php");
$iduser= $HTTP_GET_VARS[cif]; //recibe el dato
$id_dba=$HTTP_GET_VARS[dba]; //recibe la dba
$dba=$HTTP_GET_VARS[id_base];
$nombre=$HTTP_GET_VARS[nom];
$nivel=$HTTP_GET_VARS[nivel];
?>
<?php /*echo "id del user=".$iduser ;
	echo "  -id base ".$id_dba; 
	echo " -Num base".$dba; */
	//echo "el nivel acceso ".$nivel;
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.letras_blancas {
	color: #FFF;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<form action="actualizar_modificar_permisos_dba.php" method="get">
<table width="35%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" bgcolor="#000066"><div align="center" class="letras_blancas">Modificacion del Usuarios en DBA</div></td>
    </tr>
    <tr>
      <td bgcolor="#009900">&nbsp;</td>
      <td bgcolor="#009900">&nbsp;</td>
    </tr>
    <tr>
      <td>Nombre Usuario</td>
      <td><?php echo $nombre ?></td>
    </tr>
    <tr>
      <td>DBA</td>
      <td><?php echo $id_dba  ?>
      	<?php 
		$sql4 = "SELECT * FROM coosajo_base_bbdd.bbdd where id_base = '$base' ";
		$result_n4 = mysqli_query($db, $sql4);
		$row4=mysqli_fetch_array($result_n4);
		echo $row4["nombre"];
		?></td>
    </tr>
    <tr>
      <td>Estado DBA</td>
      <td>&nbsp;<input name="estatus" type="radio" id="estatus_0" value="1" checked>
          Activo</label> &nbsp;
        
        <label>
          <input type="radio" name="estatus" value="0" id="estatus_1">
          Baja</label></td>
    </tr>
    <tr>
      <td>Nivel de Acceso</td>
      <td><select name="nivel" id="nivel">
        <option value="<?php echo $nivel ?>" selected><?php 
		if ($nivel ==1){ echo "Tiene Nivel ".$nivel; }
		if ($nivel ==2){ echo "Tiene Nivel ".$nivel; }
		if ($nivel ==3){ echo "Tiene Nivel ".$nivel; }
		if ($nivel ==4){ echo "Tiene Nivel ".$nivel; }
		if ($nivel ==5){ echo "Tiene Nivel ".$nivel; }
		if ($nivel ==0){ echo "Tiene Nivel ".$nivel; }
		?></option>
        	<option value="0">Nivel 0</option>
           <option value="1">Nivel 1</option>
           <option value="2">Nivel 2</option>
           <option value="3">Nivel 3</option>
           <option value="4">Nivel 4</option>
           <option value="5">Nivel 5</option>
      </select></td>
    </tr>
    <tr>
      <td>Comentario</td>
      <td><textarea name="coment" id="coment" cols="40" rows="2"></textarea></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="iduser" type="hidden" id="iduser" value="<?php echo $iduser ?>">
      <input name="base" type="hidden" id="base" value="<?php echo $dba  ?>">
      <span class="mainForm">
      <input name="modi2" type="hidden" id="modi2" value="modificar permiso y acceso  bd usuarios">
      </span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="modi" id="modi" value="MODIFICAR"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="javascript:history.back()"><img src="../Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="javascript:history.back()">Regresar</a></td>
</tr>
</table>
</div>


</body>
</html>