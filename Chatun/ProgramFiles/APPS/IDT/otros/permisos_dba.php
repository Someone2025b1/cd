<?php 
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
$iduser= $HTTP_GET_VARS[cif]; //recibe el dato
$valix= $HTTP_GET_VARS[va];
echo $valix;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.letras_blanca {
	color: #FFF;
}
.letras_blanca01 {
	color: #FFF;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<?php $sql = "select * from coosajo_base_bbdd.usuarios where id_user='$iduser' "; //buscar el nombre de los usuarios
		$result_n = mysqli_query($db, $sql);
		$row3=mysqli_fetch_array($result_n);

?>
<form action="Actualizar_permisos_dba.php" method="get">
  <table width="55%" border="0" align="center" cellspacing="0">
    <tr>
      <td colspan="2" bgcolor="#000099"><div align="center" class="letras_blanca">Informaci&oacute;n Basica del Usuario y Asignaci&oacute;n de Base Datos</div></td>
    </tr>
    <tr>
      <td bgcolor="#009900">&nbsp;</td>
      <td bgcolor="#009900">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Cif </td>
      <td><?php echo $row3["id_user"] ?></td>
    </tr>
    <tr>
      <td>Nombre</td>
      <td><?php echo $row3["nombre"] ?></td>
    </tr>
    <tr>
      <td>Usuario</td>
      <td><?php echo $row3["login"] ?></td>
    </tr>
   
    <tr>
      <td>DB </td>
      <td><select name="base" id="Agencias2">
        <option value="0" selected="selected">- - SELECIONE UNA DB - -</option>
        <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql5 = "SELECT * FROM coosajo_base_bbdd.bbdd "; //Ver las dba disponibles
	  $result_n5 = mysqli_query($db, $sql5);
	  ?>
        <?php //se hace el ciclo para generar las opciones 
			while ($row5=mysqli_fetch_array($result_n5)) {//llenado de formulario
			//ciclo del las opciones
		?>
        
        <option value="<?php echo $row5["id_base"] ?>"><?php echo $row5["nombre"] ?></option>
        <?php }
	   ?>
      </select></td>
    </tr>
     <tr>
       <td>Nivel Acceso</td>
       <td><label for="nivel"></label>
         <select name="nivel" id="nivel">
           <option>- - SELECIONE UNA OPCION</option>
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
       <td><label for="coment"></label>
       <textarea name="coment" id="coment" cols="45" rows="2"></textarea></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td><input name="cif" type="hidden" id="cif" value="<?php echo $iduser ?>">
         <span class="mainForm">
         <input name="modi" type="hidden" id="modi" value="asignar bd usuarios">
       </span></td>
     </tr>
     <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Asinnar" id="Asinnar" value="ASIGNAR DB"></td>
    </tr>
  </table>
</form>
<?php $sql2 = "SELECT * FROM coosajo_base_bbdd.permisos where id_user = '$iduser' ";
		$result_n2 = mysqli_query($db, $sql2);
		
?>
<?php if ($valix==1){ echo "No se Agrego a Permisos DBA, ya tiene permiso de ingreso a la aplicacion, intente de nuevo gracias ";} ?>
<table width="75%" border="0" align="center" cellspacing="0">
  <tr>
    <td bgcolor="#000099">&nbsp;</td>
    <td bgcolor="#000099">&nbsp;</td>
    <td colspan="2" bgcolor="#000099"><div align="center" class="letras_blanca01">Base de Datos con Acceso</div></td>
    <td bgcolor="#000099">&nbsp;</td>
    <td bgcolor="#000099">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#009900">&nbsp;</td>
    <td bgcolor="#009900">&nbsp;</td>
    <td bgcolor="#009900">&nbsp;</td>
    <td bgcolor="#009900">&nbsp;</td>
    <td bgcolor="#009900">&nbsp;</td>
    <td bgcolor="#009900">&nbsp;</td>
  </tr>
  <tr>
    <td nowrap bgcolor="#0099FF"><div align="center">DBA</div></td>
    <td nowrap bgcolor="#0099FF"><div align="center">Activo</div></td>
    <td nowrap bgcolor="#0099FF"><div align="center">Nivel Acceso</div></td>
    <td nowrap bgcolor="#0099FF"><div align="center">Fecha Persmiso</div></td>
    <td nowrap bgcolor="#0099FF"><div align="center">comentario</div></td>
    <td nowrap bgcolor="#0099FF"><div align="center">Modificar</div></td>
  </tr>
  <tr>
   <?php while ($row2=mysqli_fetch_array($result_n2)) {
		
		
		
		?>
    <td nowrap><div align="center">
      <?php $base=$row2["id_base"] ?>
      <?php 
		$sql4 = "SELECT * FROM coosajo_base_bbdd.bbdd where id_base = '$base' ";
		$result_n4 = mysqli_query($db, $sql4);
		$row4=mysqli_fetch_array($result_n4);
		echo $row4["nombre"];
		?>
    </div></td>
    <td nowrap><div align="center">
      <?php $vali=$row2["activo"] ?>
      <?php if ( $vali == 1) {
			echo "si"; } else {
				echo "No"; }?>
    </div></td>
    <td nowrap><div align="center"><?php echo $row2["permiso"] ?></div></td>
    <td nowrap><div align="center"><?php echo $row2["fecha_ingreso"] ?></div></td>
    <td nowrap><div align="center"><?php echo $row2["comentario"] ?></div></td>
    <td nowrap><div align="center"><a href="modificar_permiso_dba.php?&cif=<?php echo $iduser ?>&dba=<?php echo $row4["nombre"]; ?>&id_base=<?php echo $base ?>&nom=<?php echo $row3["nombre"] ?>&nivel=<?php echo $row2["permiso"] ?>"><img src="../Imagenes/edit.png" alt="Editar" width="16" height="16" border="0"></a></div></td>
  </tr>
  <?php } ?>
</table>
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